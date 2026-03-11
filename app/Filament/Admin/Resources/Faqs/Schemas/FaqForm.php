<?php

namespace App\Filament\Admin\Resources\Faqs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('السؤال')
                    ->required(),
                Textarea::make('answer')
                    ->label('الإجابة')
                    ->required()
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
