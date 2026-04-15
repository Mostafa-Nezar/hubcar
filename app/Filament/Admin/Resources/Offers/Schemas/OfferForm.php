<?php

namespace App\Filament\Admin\Resources\Offers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('تفاصيل العرض')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم العرض')
                                    ->required()
                                    ->placeholder('مثال: عرض رمضان، عروض الصيف'),
                                TextInput::make('badge_text')
                                    ->label('نص الشعار (Badge)')
                                    ->required()
                                    ->placeholder('مثال: عرض خاص، خصم 20%'),
                                \Filament\Forms\Components\ColorPicker::make('color')
                                    ->label('لون الشعار')
                                    ->required()
                                    ->default('#c19b76'),
                                DateTimePicker::make('expires_at')
                                    ->label('تاريخ الانتهاء (للعد التنازلي)')
                                    ->helperText('اتركه فارغاً إذا كان عرضاً دائماً')
                                    ->native(false),
                                Toggle::make('is_active')
                                    ->label('تفعيل العرض')
                                    ->default(true)
                                    ->required(),
                            ]),
                        Textarea::make('description')
                            ->label('وصف إضافي')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
