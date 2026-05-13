<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\ReservationCalendarWidget;
use App\Filament\Admin\Widgets\ReservationStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            ReservationStatsWidget::class,
            ReservationCalendarWidget::class,
        ];
    }

    public function getColumns(): array|int
    {
        return [
            'default' => 1,
            'md' => 1,
            'lg' => 1,
        ];
    }
}
