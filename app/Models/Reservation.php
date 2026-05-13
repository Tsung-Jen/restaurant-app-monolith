<?php

namespace App\Models;

use App\Services\ReservationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'phone_number',
        'email',
        'reservation_date',
        'session',
        'reservation_time',
        'number_of_guests',
        'notes',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime:H:i', // handles both H:i and H:i:s
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get reservations by date and session
     * @deprecated Use ReservationService::getByDateAndSession() instead
     */
    public static function getByDateAndSession($date, $session)
    {
        return app(ReservationService::class)->getByDateAndSession($date, $session);
    }

    /**
     * Get total guests for a date and session
     * @deprecated Use ReservationService::getTotalGuestsForSession() instead
     */
    public static function getTotalGuestsForSession($date, $session)
    {
        return app(ReservationService::class)->getTotalGuestsForSession($date, $session);
    }

    /**
     * Check if a session is fully booked
     * @deprecated Use ReservationService::isSessionFullyBooked() instead
     */
    public static function isSessionFullyBooked($date, $session, $requiredGuests)
    {
        return app(ReservationService::class)->isSessionFullyBooked($date, $session, $requiredGuests);
    }

    /**
     * Get remaining capacity for a session
     * @deprecated Use ReservationService::getRemainingCapacity() instead
     */
    public static function getRemainingCapacity($date, $session)
    {
        return app(ReservationService::class)->getRemainingCapacity($date, $session);
    }
}
