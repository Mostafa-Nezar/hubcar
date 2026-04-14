<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class RecentNotificationsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'التنبيهات الأخيرة للنظام';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                DatabaseNotification::query()
                    ->where('notifiable_id', Auth::id())
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('data.message')
                    ->label('الرسالة')
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('الوقت')
                    ->since()
                    ->description(fn ($record) => $record->created_at->format('Y-m-d H:i')),
                Tables\Columns\IconColumn::make('read_at')
                    ->label('مقروء')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-chat-bubble-left-ellipsis')
            ])
            ->actions([
                Action::make('markAsRead')
                    ->label('تحديد كمقروء')
                    ->icon('heroicon-m-check')
                    ->action(fn ($record) => $record->markAsRead())
                    ->visible(fn ($record) => $record->unread()),
                Action::make('viewBooking')
                    ->label('عرض الطلب')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => isset($record->data['booking_id']) ? "/admin/booking-requests/{$record->data['booking_id']}" : null)
                    ->visible(fn ($record) => isset($record->data['booking_id'])),
            ]);
    }
}
