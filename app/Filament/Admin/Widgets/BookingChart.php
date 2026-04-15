<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;

class BookingChart extends ChartWidget
{
    protected ?string $heading = 'رسم بياني للحجوزات';

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($m = 1; $m <= 12; $m++) {
            $month = now()->startOfYear()->addMonths($m - 1);
            $labels[] = $month->translatedFormat('M');
            
            $count = \App\Models\BookingRequest::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count() 
                + \App\Models\QuickBookingRequest::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();
                
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'الطلبات',
                    'data' => $data,
                    'fill' => 'start',
                    'tension' => 0.4,
                    'borderColor' => '#c19b76',
                    'backgroundColor' => 'rgba(193, 155, 118, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
