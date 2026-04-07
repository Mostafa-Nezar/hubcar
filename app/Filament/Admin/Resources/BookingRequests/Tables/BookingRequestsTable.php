<?php

namespace App\Filament\Admin\Resources\BookingRequests\Tables;

use App\Filament\Exports\BookingRequestExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(),

                SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'New' => 'جديد',
                        'Contacted' => 'تم التواصل',
                        'Interested' => 'مهتم',
                        'Not Interested' => 'غير مهتم',
                        'Completed' => 'مكتمل',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),

                TextColumn::make('payment_type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'finance' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'كاش (نقدي)',
                        'finance' => 'تمويل (أقساط)',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('client_name')
                    ->label('اسم العميل')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('phone')
                    ->label('الجوال')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope')
                    ->toggleable(),

                TextColumn::make('car_name_manual')
                    ->label('السيارة المطلوبة')
                    ->searchable()
                    ->description(fn ($record) => ($record->brand_name ? $record->brand_name . ' - ' : '') . 'موديل: ' . ($record->model_year ?? 'غير محدد'))
                    ->sortable(),

                TextColumn::make('car_price')
                    ->label('السعر')
                    ->money('SAR')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('request_date')
                    ->label('تاريخ الطلب')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('request_date', 'desc')
            ->filters([
                SelectFilter::make('payment_type')
                    ->label('نوع الطلب')
                    ->options([
                        'cash' => 'كاش',
                        'finance' => 'تمويل',
                    ]),
                SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options([
                        'New' => 'جديد',
                        'Contacted' => 'تم التواصل',
                        'Interested' => 'مهتم',
                        'Not Interested' => 'غير مهتم',
                        'Completed' => 'مكتمل',
                    ]),
            ])
            ->actions([
                ViewAction::make()->label(''),
                EditAction::make()->label(''),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(BookingRequestExporter::class)
                    ->label('تصدير إكسل')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->columnMapping(false),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(fn ($record) => \App\Filament\Admin\Resources\BookingRequests\BookingRequestResource::getUrl('view', ['record' => $record]));
    }
}
