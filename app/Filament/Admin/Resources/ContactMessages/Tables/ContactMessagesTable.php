<?php

namespace App\Filament\Admin\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('الموضوع')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'New' => 'info',
                        'Read' => 'warning',
                        'Replied' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'New' => 'جديد',
                        'Read' => 'مقروء',
                        'Replied' => 'تم الرد',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
