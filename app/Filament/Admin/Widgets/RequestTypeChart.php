<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BookingRequest;
use App\Models\QuickBookingRequest;
use Filament\Widgets\ChartWidget;

class RequestTypeChart extends ChartWidget
{
    protected ?string $heading = 'الطلبات حسب النوع (كاش / تقسيط)';
    protected static ?int $sort = 4;
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $cashBookings = BookingRequest::where('payment_type', 'cash')->count();
        $financeBookings = BookingRequest::where('payment_type', 'finance')->count();
        
        // Quick bookings are always cash in storeQuickBooking method
        $quickBookings = QuickBookingRequest::count();

        return [
            'datasets' => [
                [
                    'label' => 'نوع الدفع',
                    'data' => [$cashBookings + $quickBookings, $financeBookings],
                    'backgroundColor' => ['#c19b76', '#1a1a1a'],
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => ['كاش', 'تقسيط'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
