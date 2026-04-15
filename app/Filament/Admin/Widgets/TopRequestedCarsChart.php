<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BookingRequest;
use App\Models\QuickBookingRequest;
use App\Models\Car;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopRequestedCarsChart extends ChartWidget
{
    protected ?string $heading = 'السيارات الأكثر طلباً';
    protected static ?int $sort = 5;
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get car IDs and counts from both tables
        $bookings = BookingRequest::select('car_id', DB::raw('count(*) as total'))
            ->whereNotNull('car_id')
            ->groupBy('car_id')
            ->pluck('total', 'car_id')
            ->toArray();

        $quickBookings = QuickBookingRequest::select('car_id', DB::raw('count(*) as total'))
            ->whereNotNull('car_id')
            ->groupBy('car_id')
            ->pluck('total', 'car_id')
            ->toArray();

        // Merge results
        $combined = [];
        foreach ($bookings as $id => $count) {
            $combined[$id] = ($combined[$id] ?? 0) + $count;
        }
        foreach ($quickBookings as $id => $count) {
            $combined[$id] = ($combined[$id] ?? 0) + $count;
        }

        // Sort and take top 5
        arsort($combined);
        $top5 = array_slice($combined, 0, 5, true);

        $carNames = [];
        $counts = [];

        foreach ($top5 as $id => $count) {
            $car = Car::find($id);
            $carNames[] = $car ? $car->name : 'غير معروف (#' . $id . ')';
            $counts[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد الطلبات',
                    'data' => $counts,
                    'backgroundColor' => '#c19b76',
                ],
            ],
            'labels' => $carNames,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
