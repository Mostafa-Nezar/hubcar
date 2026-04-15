<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الطلبات', \App\Models\BookingRequest::count() + \App\Models\QuickBookingRequest::count())
                ->description('إجمالي طلبات الحجز والسعر السريع')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
            Stat::make('طلبات جديدة', \App\Models\BookingRequest::where('status', 'New')->count() + \App\Models\QuickBookingRequest::where('status', 'New')->count())
                ->description('بحاجة إلى مراجعة')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('warning'),
            Stat::make('إجمالي السيارات', \App\Models\Car::count())
                ->description('السيارات المتاحة في المعرض')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),
            Stat::make('رسائل التواصل', \App\Models\ContactMessage::count())
                ->description('رسائل العملاء من صفحة اتصل بنا')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }
}
