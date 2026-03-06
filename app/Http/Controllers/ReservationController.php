<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class ReservationController extends Controller
{
    /**
     * Show the reservation form (customer side)
     */
    public function create()
    {
        return Inertia::render('Reservations/Create');
    }

    /**
     * Store a new reservation
     */
    public function store(StoreReservationRequest $request)
    {
        // Check if session is fully booked
        if (Reservation::isSessionFullyBooked(
            $request->reservation_date,
            $request->session,
            $request->number_of_guests
        )) {
            return back()->withErrors([
                'number_of_guests' => 'Reservations are fully booked.',
            ])->withInput();
        }

        // Create the reservation
        $reservation = Reservation::create(
            $request->validated()
        );

        // Send confirmation email if provided
        if ($request->email) {
            Mail::to($request->email)->send(
                new ReservationConfirmation($reservation)
            );
        }

        return redirect('/')->with('reservation_success', 'Your reservation has been created successfully!');
    }

    /**
     * Show admin dashboard with calendar view
     */
    public function dashboard(Request $request)
    {
        // Get the month and year from query params (defaults to current month)
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Get all reservations for the month
        $reservations = Reservation::whereBetween('reservation_date', [
            "$year-$month-01",
            now()->setDate($year, $month, 1)->endOfMonth(),
        ])->get()->toArray();

        // Get reservation counts by date and session for capacity display
        $capacityData = [];
        $reservation = Reservation::whereBetween('reservation_date', [
            "$year-$month-01",
            now()->setDate($year, $month, 1)->endOfMonth(),
        ])->select('reservation_date', 'session')
            ->selectRaw('COALESCE(SUM(number_of_guests), 0) as total_guests')
            ->where('status', '!=', 'cancelled')
            ->groupBy('reservation_date', 'session')
            ->get();

        foreach ($reservation as $item) {
            $key = $item->reservation_date . '-' . $item->session;
            $capacityData[$key] = [
                'date' => $item->reservation_date,
                'session' => $item->session,
                'total_guests' => $item->total_guests,
                'remaining' => max(0, 55 - $item->total_guests),
                'is_booked' => $item->total_guests >= 55,
            ];
        }

        return Inertia::render('Reservations/AdminDashboard', [
            'reservations' => $reservations,
            'capacityData' => $capacityData,
            'month' => $month,
            'year' => $year,
        ]);
    }

    /**
     * Show a specific reservation
     */
    public function show(Reservation $reservation)
    {
        return Inertia::render('Reservations/Show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Update reservation status (for admin)
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('admin'); // This will need a policy

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation,
        ]);
    }

    /**
     * Delete a reservation (for admin)
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('admin'); // This will need a policy

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully',
        ]);
    }

    /**
     * Get reservations for a specific date and session (AJAX endpoint)
     */
    public function getByDateSession(Request $request)
    {
        $reservations = Reservation::getByDateAndSession(
            $request->date,
            $request->session
        );

        $totalGuests = Reservation::getTotalGuestsForSession(
            $request->date,
            $request->session
        );

        return response()->json([
            'reservations' => $reservations,
            'total_guests' => $totalGuests,
            'remaining_capacity' => max(0, 55 - $totalGuests),
            'is_fully_booked' => $totalGuests >= 55,
        ]);
    }
}
