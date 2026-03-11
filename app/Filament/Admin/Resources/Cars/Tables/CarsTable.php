<?php

namespace App\Filament\Admin\Resources\Cars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image')
                    ->label('الصورة')
                    ->circular(),
                TextColumn::make('name')
                    ->label('اسم السيارة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand.name')
                    ->label('الشركة')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('السعر')
                    
                    ->sortable(),
                TextColumn::make('model_year')
                    ->label('الموديل')
                    ->sortable(),
                TextColumn::make('availability_status')
                    ->label('التوفر')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'sold' => 'danger',
                        'reserved' => 'warning',
                        default => 'gray',
                    }),
                ToggleColumn::make('is_featured')
                    ->label('مميزة'),
                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('brand_id')
                    ->label('الشركة المصنعة')
                    ->relationship('brand', 'name'),
                SelectFilter::make('availability_status')
                    ->label('حالة التوفر')
                    ->options([
                        'available' => 'متوفرة',
                        'sold' => 'مباعة',
                        'reserved' => 'محجوزة',
                    ]),
            ])
            ->recordActions([
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
