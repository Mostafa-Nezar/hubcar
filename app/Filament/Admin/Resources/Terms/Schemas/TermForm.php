<?php

namespace App\Filament\Admin\Resources\Terms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TermForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->required(),
                Textarea::make('content')
                    ->label('المحتوى')
                    ->required()
                    ->rows(10)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true)
                    ->required(),
            ]);
    }
}
