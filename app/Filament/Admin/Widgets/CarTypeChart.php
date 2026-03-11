<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;

class CarTypeChart extends ChartWidget
{
    protected ?string $heading = 'توزيع جالة السيارات (جديدة / مستعملة)';
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $newCount = Car::where('condition', 'new')->count();
        $usedCount = Car::where('condition', 'used')->count();

        return [
            'datasets' => [
                [
                    'label' => 'حالة السيارات',
                    'data' => [$newCount, $usedCount],
                    'backgroundColor' => ['#c19b76', '#1a1a1a'],
                ],
            ],
            'labels' => ['جديدة', 'مستعملة'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
