<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;

class BookingChart extends ChartWidget
{
    protected ?string $heading = 'Booking Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
