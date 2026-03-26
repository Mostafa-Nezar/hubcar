<?php

namespace App\Filament\Admin\Resources\FinanceEntities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FinanceEntityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم الجهة')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->label('الشعار')
                    ->image()
                    ->directory('banks'),
                Textarea::make('description')
                    ->label('وصف الخدمة')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }
}
