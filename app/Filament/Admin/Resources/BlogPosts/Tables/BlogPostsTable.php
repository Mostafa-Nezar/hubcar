<?php

namespace App\Filament\Admin\Resources\BlogPosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('الرابط المختصر')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('الصورة'),
                TextColumn::make('meta_title')
                    ->label('عنوان الميتا')
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->label('وصف الميتا')
                    ->searchable(),
                TextColumn::make('meta_keywords')
                    ->label('الكلمات المفتاحية')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->label('تم النشر')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->label('المستخدم')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
