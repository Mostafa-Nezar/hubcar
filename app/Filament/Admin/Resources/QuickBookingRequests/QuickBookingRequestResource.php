<?php

namespace App\Filament\Admin\Resources\QuickBookingRequests;

use App\Filament\Admin\Resources\QuickBookingRequests\Pages\CreateQuickBookingRequest;
use App\Filament\Admin\Resources\QuickBookingRequests\Pages\EditQuickBookingRequest;
use App\Filament\Admin\Resources\QuickBookingRequests\Pages\ListQuickBookingRequests;
use App\Filament\Admin\Resources\QuickBookingRequests\Schemas\QuickBookingRequestForm;
use App\Filament\Admin\Resources\QuickBookingRequests\Tables\QuickBookingRequestsTable;
use App\Models\QuickBookingRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuickBookingRequestResource extends Resource
{
    protected static ?string $model = QuickBookingRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    protected static ?string $navigationLabel = 'الطلبات السريعة';
    protected static ?string $modelLabel = 'طلب سريع';
    protected static ?string $pluralModelLabel = 'الطلبات السريعة';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QuickBookingRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuickBookingRequestsTable::configure($table);
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
            'index' => ListQuickBookingRequests::route('/'),
            'create' => CreateQuickBookingRequest::route('/create'),
            'edit' => EditQuickBookingRequest::route('/{record}/edit'),
        ];
    }
}
