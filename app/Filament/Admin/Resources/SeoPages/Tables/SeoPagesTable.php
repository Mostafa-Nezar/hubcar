<?php

namespace App\Filament\Admin\Resources\SeoPages\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class SeoPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_name')
                    ->label('اسم الصفحة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url_path')
                    ->label('المسار')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('meta_title')
                    ->label('عنوان الـ Meta')
                    ->limit(30),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
