<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Reservation;
use App\Services\ReservationService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $service = app(ReservationService::class);
        $today = now()->toDateString();
        
        return [
            Stat::make('Total Reservations', Reservation::count())
                ->description('Total active reservations')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make('Pending Reservations', Reservation::where('status', 'pending')->count())
                ->description('Awaiting confirmation')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Confirmed Reservations', Reservation::where('status', 'confirmed')->count())
                ->description('Ready to serve')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Today\'s Capacity', $service->calculateCapacityPercentage($today) . '%')
                ->description('Combined lunch and dinner')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info'),
        ];
    }
}
