<?php

namespace App\Filament\Admin\Resources\BookingRequests\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات العميل')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('client_name')
                                    ->label('اسم العميل')
                                    ->content(fn ($record) => $record->client_name),
                                Placeholder::make('phone')
                                    ->label('رقم الجوال')
                                    ->content(fn ($record) => $record->phone),
                                Placeholder::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->content(fn ($record) => $record->email ?? '---'),
                                Placeholder::make('city')
                                    ->label('المدينة')
                                    ->content(fn ($record) => $record->city ?? '---'),
                            ]),
                    ]),

                Section::make('معلومات السيارة')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('car_name_manual')
                                    ->label('اسم السيارة')
                                    ->content(fn ($record) => $record->car_name_manual),
                                Placeholder::make('brand_name')
                                    ->label('الماركة')
                                    ->content(fn ($record) => $record->brand_name ?? '---'),
                                Placeholder::make('car_type')
                                    ->label('النوع')
                                    ->content(fn ($record) => $record->car_type ?? '---'),
                                Placeholder::make('car_category')
                                    ->label('الفئة')
                                    ->content(fn ($record) => $record->car_category ?? '---'),
                                Placeholder::make('model_year')
                                    ->label('سنة الصنع')
                                    ->content(fn ($record) => $record->model_year),
                                Placeholder::make('car_price')
                                    ->label('السعر عند الطلب')
                                    ->content(fn ($record) => $record->car_price ? number_format($record->car_price).' ر.س' : '---'),
                            ]),
                    ]),

                Section::make('تفاصيل الطلب والتمويل')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('payment_type')
                                    ->label('نوع الدفع')
                                    ->content(fn ($record) => $record->payment_type === 'cash' ? 'كاش' : 'تمويل'),
                                Placeholder::make('bank_name')
                                    ->label('اسم البنك')
                                    ->content(fn ($record) => $record->bank_name ?? '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance'),
                                Placeholder::make('work_sector')
                                    ->label('قطاع العمل')
                                    ->content(fn ($record) => $record->work_sector ?? '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance'),
                                Placeholder::make('monthly_salary')
                                    ->label('الراتب الشهري')
                                    ->content(fn ($record) => $record->monthly_salary ? number_format($record->monthly_salary).' ر.س' : '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance'),
                                
                                Placeholder::make('monthly_installment')
                                    ->label('القسط المختار')
                                    ->content(fn ($record) => $record->monthly_installment ? number_format($record->monthly_installment).' ر.س' : '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance' && $record->monthly_installment),
                                
                                Placeholder::make('down_payment')
                                    ->label('الدفعة المقدمة')
                                    ->content(fn ($record) => $record->down_payment ? number_format($record->down_payment).' ر.س' : '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance' && $record->down_payment),
                                
                                Placeholder::make('finance_period')
                                    ->label('مدة التمويل')
                                    ->content(fn ($record) => $record->finance_period ? $record->finance_period.' شهر' : '---')
                                    ->visible(fn ($record) => $record->payment_type === 'finance' && $record->finance_period),

                                Placeholder::make('request_date')
                                    ->label('تاريخ الطلب')
                                    ->content(fn ($record) => $record->request_date?->format('d/m/Y H:i A')),
                            ]),
                    ]),

                Section::make('ملاحظات')
                    ->schema([
                        Placeholder::make('client_notes')
                            ->label('ملاحظات العميل')
                            ->content(fn ($record) => $record->client_notes ?? '---'),
                        Placeholder::make('internal_notes')
                            ->label('ملاحظات داخلية')
                            ->content(fn ($record) => $record->internal_notes ?? '---'),
                    ]),
            ]);
    }
}
