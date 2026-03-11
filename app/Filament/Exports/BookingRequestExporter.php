<?php

namespace App\Filament\Exports;

use App\Models\BookingRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class BookingRequestExporter extends Exporter
{
    protected static ?string $model = BookingRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('status')
                ->label('الحالة')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'New' => 'جديد',
                    'Contacted' => 'تم التواصل',
                    'Interested' => 'مهتم',
                    'Not Interested' => 'غير مهتم',
                    'Completed' => 'مكتمل',
                    default => $state,
                }),
            ExportColumn::make('client_name')
                ->label('اسم العميل'),
            ExportColumn::make('phone')
                ->label('رقم الجوال'),
            ExportColumn::make('city')
                ->label('المدينة'),
            ExportColumn::make('payment_type')
                ->label('نوع الدفع')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'cash' => 'كاش',
                    'finance' => 'تمويل',
                    default => $state,
                }),
            ExportColumn::make('car_name_manual')
                ->label('اسم السيارة'),
            ExportColumn::make('brand_name')
                ->label('الماركة'),
            ExportColumn::make('car_type')
                ->label('النوع'),
            ExportColumn::make('car_category')
                ->label('الفئة'),
            ExportColumn::make('model_year')
                ->label('الموديل (السنة)'),
            ExportColumn::make('car_price')
                ->label('السعر نقداً'),
            ExportColumn::make('bank_name')
                ->label('البنك'),
            ExportColumn::make('work_sector')
                ->label('قطاع العمل')
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'govt' => 'حكومي',
                    'private' => 'خاص',
                    'military' => 'عسكري',
                    'retired' => 'متقاعد',
                    default => $state ?? '---',
                }),
            ExportColumn::make('monthly_salary')
                ->label('الراتب الشهري'),
            ExportColumn::make('request_date')
                ->label('تاريخ الطلب')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i A')),
            ExportColumn::make('client_notes')
                ->label('ملاحظات العميل'),
            ExportColumn::make('internal_notes')
                ->label('ملاحظات داخلية'),
            ExportColumn::make('updater.name')
                ->label('الموظف المسؤول'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your booking request export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
