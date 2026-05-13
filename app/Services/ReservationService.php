<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationService
{
    /**
     * Maximum capacity per session (lunch or dinner)
     */
    const MAX_CAPACITY_PER_SESSION = 55;

    /**
     * Get total guests for a specific date and session
     */
    public function getTotalGuestsForSession(string $date, string $session): int
    {
        return Reservation::where('reservation_date', $date)
            ->where('session', $session)
            ->where('status', '!=', 'cancelled')
            ->sum('number_of_guests');
    }

    /**
     * Get remaining capacity for a session
     */
    public function getRemainingCapacity(string $date, string $session): int
    {
        $currentTotal = $this->getTotalGuestsForSession($date, $session);
        return max(0, self::MAX_CAPACITY_PER_SESSION - $currentTotal);
    }

    /**
     * Check if a session is fully booked
     */
    public function isSessionFullyBooked(string $date, string $session, int $requiredGuests): bool
    {
        $currentTotal = $this->getTotalGuestsForSession($date, $session);
        return ($currentTotal + $requiredGuests) > self::MAX_CAPACITY_PER_SESSION;
    }

    /**
     * Get reservations for a specific date and session
     */
    public function getByDateAndSession(string $date, string $session)
    {
        return Reservation::where('reservation_date', $date)
            ->where('session', $session)
            ->where('status', '!=', 'cancelled')
            ->get();
    }

    /**
     * Calculate capacity usage percentage for a given date
     */
    public function calculateCapacityPercentage(string $date): int
    {
        $maxCapacityPerSession = self::MAX_CAPACITY_PER_SESSION;

        $lunchGuests = $this->getTotalGuestsForSession($date, 'lunch');
        $dinnerGuests = $this->getTotalGuestsForSession($date, 'dinner');

        $totalCapacity = $maxCapacityPerSession * 2;
        $totalGuests = $lunchGuests + $dinnerGuests;

        return round(($totalGuests / $totalCapacity) * 100);
    }

    /**
     * Get capacity stats for a given date
     */
    public function getCapacityStats(string $date): array
    {
        $lunchGuests = $this->getTotalGuestsForSession($date, 'lunch');
        $dinnerGuests = $this->getTotalGuestsForSession($date, 'dinner');

        return [
            'lunch' => [
                'total' => $lunchGuests,
                'capacity' => self::MAX_CAPACITY_PER_SESSION,
                'remaining' => $this->getRemainingCapacity($date, 'lunch'),
                'is_fully_booked' => $this->isSessionFullyBooked($date, 'lunch', 0),
            ],
            'dinner' => [
                'total' => $dinnerGuests,
                'capacity' => self::MAX_CAPACITY_PER_SESSION,
                'remaining' => $this->getRemainingCapacity($date, 'dinner'),
                'is_fully_booked' => $this->isSessionFullyBooked($date, 'dinner', 0),
            ],
        ];
    }
}
