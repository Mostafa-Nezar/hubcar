<?php

namespace App\Filament\Admin\Resources\QuickBookingRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class QuickBookingRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_name')
                    ->label('الاسم الكامل')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('رقم الجوال')
                    ->required()
                    ->maxLength(20),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->maxLength(255)
                    ->nullable(),
                Select::make('city')
                    ->label('المدينة')
                    ->options(config('saudi-cities', []))
                    ->required()
                    ->searchable(),
                Select::make('car_id')
                    ->label('السيارة')
                    ->relationship('car', 'name')
                    ->required()
                    ->searchable(),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'New' => 'جديد',
                        'Contacted' => 'تم التواصل',
                        'Interested' => 'مهتم',
                        'Not Interested' => 'غير مهتم',
                        'Completed' => 'مكتمل',
                    ])
                    ->default('New')
                    ->required(),
                Textarea::make('client_notes')
                    ->label('ملاحظات العميل')
                    ->maxLength(1000),
                Textarea::make('internal_notes')
                    ->label('ملاحظات داخلية')
                    ->maxLength(1000),
                DateTimePicker::make('last_status_update')
                    ->label('آخر تحديث للحالة'),
            ]);
    }
}
