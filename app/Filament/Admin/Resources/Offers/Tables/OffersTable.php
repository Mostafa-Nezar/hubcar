<?php

namespace App\Filament\Admin\Resources\Offers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم العرض')
                    ->searchable(),
                TextColumn::make('badge_text')
                    ->label('نص الشعار')
                    ->badge()
                    ->color(fn ($record) => $record->is_active ? 'primary' : 'gray')
                    ->searchable(),
                \Filament\Tables\Columns\ColorColumn::make('color')
                    ->label('اللون'),
                TextColumn::make('expires_at')
                    ->label('ينتهي في')
                    ->dateTime()
                    ->sortable(),
                \Filament\Tables\Columns\ToggleColumn::make('is_active')
                    ->label('نشط'),
                TextColumn::make('cars_count')
                    ->label('عدد السيارات')
                    ->counts('cars')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
