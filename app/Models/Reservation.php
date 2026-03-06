<?php

namespace App\Models;

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
     */
    public static function getByDateAndSession($date, $session)
    {
        return self::where('reservation_date', $date)
            ->where('session', $session)
            ->where('status', '!=', 'cancelled')
            ->get();
    }

    /**
     * Get total guests for a date and session
     */
    public static function getTotalGuestsForSession($date, $session)
    {
        return self::where('reservation_date', $date)
            ->where('session', $session)
            ->where('status', '!=', 'cancelled')
            ->sum('number_of_guests');
    }

    /**
     * Check if a session is fully booked
     */
    public static function isSessionFullyBooked($date, $session, $requiredGuests)
    {
        $maxCapacity = 55;
        $currentTotal = self::getTotalGuestsForSession($date, $session);
        
        return ($currentTotal + $requiredGuests) > $maxCapacity;
    }

    /**
     * Get remaining capacity for a session
     */
    public static function getRemainingCapacity($date, $session)
    {
        $maxCapacity = 55;
        $currentTotal = self::getTotalGuestsForSession($date, $session);
        
        return max(0, $maxCapacity - $currentTotal);
    }
}
