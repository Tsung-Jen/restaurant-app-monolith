<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class ReservationCalendarWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.reservation-calendar-widget';

    protected int | string | array $columnSpan = 'full';

    public ?Carbon $focusedDate = null;

    public array $calendarDays = [];

    public string $monthYear = '';

    public function mount(): void
    {
        $this->focusedDate = $this->focusedDate ?? now();
        $this->buildCalendar();
    }

    public function buildCalendar(): void
    {
        $year = $this->focusedDate->year;
        $month = $this->focusedDate->month;

        $firstDay = Carbon::createFromDate($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();

        $this->monthYear = $firstDay->format('F Y');
        $this->calendarDays = [];

        // Get all reservations for this month
        $reservations = Reservation::whereBetween('reservation_date', [$firstDay, $lastDay])
            ->where('status', '!=', 'cancelled')
            ->get();

        // Build calendar grid
        $startOfWeek = $firstDay->copy()->startOfWeek();
        $endOfWeek = $lastDay->copy()->endOfWeek();

        $currentDate = $startOfWeek->copy();

        while ($currentDate <= $endOfWeek) {
            $week = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $currentDate->copy();
                $isCurrentMonth = $date->month === $month;

                // Calculate capacity for this day
                $dayReservations = $reservations->filter(fn($r) => $r->reservation_date == $date->toDateString());
                
                $lunchTotal = $dayReservations
                    ->filter(fn($r) => $r->session === 'lunch')
                    ->sum('number_of_guests');

                $dinnerTotal = $dayReservations
                    ->filter(fn($r) => $r->session === 'dinner')
                    ->sum('number_of_guests');

                $week[] = [
                    'date' => $isCurrentMonth ? $date->toDateString() : null,
                    'day' => $date->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'lunchTotal' => $lunchTotal,
                    'dinnerTotal' => $dinnerTotal,
                    'reservationCount' => $dayReservations->count(),
                ];

                $currentDate->addDay();
            }

            $this->calendarDays[] = $week;
        }
    }

    public function previousMonth(): void
    {
        $this->focusedDate = $this->focusedDate->copy()->subMonth();
        $this->buildCalendar();
    }

    public function nextMonth(): void
    {
        $this->focusedDate = $this->focusedDate->copy()->addMonth();
        $this->buildCalendar();
    }

    public function goToToday(): void
    {
        $this->focusedDate = now();
        $this->buildCalendar();
    }
}
