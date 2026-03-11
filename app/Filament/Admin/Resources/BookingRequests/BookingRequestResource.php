<?php

namespace App\Filament\Admin\Resources\BookingRequests;

use App\Filament\Admin\Resources\BookingRequests\Pages\CreateBookingRequest;
use App\Filament\Admin\Resources\BookingRequests\Pages\EditBookingRequest;
use App\Filament\Admin\Resources\BookingRequests\Pages\ListBookingRequests;
use App\Filament\Admin\Resources\BookingRequests\Pages\ViewBookingRequest;
use App\Filament\Admin\Resources\BookingRequests\Schemas\BookingRequestForm;
use App\Filament\Admin\Resources\BookingRequests\Schemas\BookingRequestInfolist;
use App\Filament\Admin\Resources\BookingRequests\Tables\BookingRequestsTable;
use App\Models\BookingRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookingRequestResource extends Resource
{
    protected static ?string $model = BookingRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'client_name';
    
    public static function getNavigationLabel(): string
    {
        return __('طلبات الحجز');
    }

    public static function getModelLabel(): string
    {
        return __('طلبات الحجز');
    }

    public static function getPluralModelLabel(): string
    {
        return __('طلبات الحجز');
    } 

    public static function form(Schema $schema): Schema
    {
        return BookingRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingRequests::route('/'),
            'create' => CreateBookingRequest::route('/create'),
            'view' => ViewBookingRequest::route('/{record}'),
            'edit' => EditBookingRequest::route('/{record}/edit'),
        ];
    }
}
