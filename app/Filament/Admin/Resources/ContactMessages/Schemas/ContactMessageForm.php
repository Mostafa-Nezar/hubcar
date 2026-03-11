<?php

namespace App\Filament\Admin\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required(),
                TextInput::make('subject')
                    ->label('الموضوع')
                    ->required(),
                \Filament\Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'New' => 'جديد',
                        'Read' => 'مقروء',
                        'Replied' => 'تم الرد',
                    ])
                    ->required()
                    ->default('New'),
                Textarea::make('message')
                    ->label('الرسالة')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
