<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class ReservationController extends Controller
{
    public function __construct(private ReservationService $reservationService)
    {
    }

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
        if ($this->reservationService->isSessionFullyBooked(
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

        // Redirect with flash message - using absolute path
        return redirect()->route('landing')->with('reservation_success', 'Your reservation has been created successfully!');
    }

    /**
     * Get reservations for a specific date and session (AJAX endpoint)
     */
    public function getByDateSession(Request $request)
    {
        $reservations = $this->reservationService->getByDateAndSession(
            $request->date,
            $request->session
        );

        $totalGuests = $this->reservationService->getTotalGuestsForSession(
            $request->date,
            $request->session
        );

        return response()->json([
            'reservations' => $reservations,
            'total_guests' => $totalGuests,
            'remaining_capacity' => $this->reservationService->getRemainingCapacity($request->date, $request->session),
            'is_fully_booked' => $this->reservationService->isSessionFullyBooked($request->date, $request->session, 0),
        ]);
    }
}
