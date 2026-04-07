<?php

namespace App\Filament\Admin\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->default(null),
                FileUpload::make('image')
                    ->label('الصورة')
                    ->disk('public')
                    ->directory('banners')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                        '3:4',
                    ])
                    ->required(),
                TextInput::make('link')
                    ->label('الرابط')
                    ->default(null),
                Toggle::make('is_active')
                    ->label('التفعيل')
                    ->default(true)
                    ->required(),
            ]);
    }
}
