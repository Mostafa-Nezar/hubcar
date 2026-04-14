<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BookingRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    public static function canView(): bool
    {
        return false;
    }
    
    protected static ?string $heading = 'أحدث طلبات الحجز';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                BookingRequest::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('اسم العميل'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الجوال'),
                Tables\Columns\TextColumn::make('car_name_manual')
                    ->label('السيارة'),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('الدفع'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'New' => 'info',
                        'Completed' => 'success',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (BookingRequest $record): string => "/admin/booking-requests/{$record->id}")
                    ->icon('heroicon-m-eye'),
            ]);
    }
}
