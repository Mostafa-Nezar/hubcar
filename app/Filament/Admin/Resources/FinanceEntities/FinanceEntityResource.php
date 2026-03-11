<?php

namespace App\Filament\Admin\Resources\FinanceEntities;

use App\Filament\Admin\Resources\FinanceEntities\Pages\CreateFinanceEntity;
use App\Filament\Admin\Resources\FinanceEntities\Pages\EditFinanceEntity;
use App\Filament\Admin\Resources\FinanceEntities\Pages\ListFinanceEntities;
use App\Filament\Admin\Resources\FinanceEntities\Schemas\FinanceEntityForm;
use App\Filament\Admin\Resources\FinanceEntities\Tables\FinanceEntitiesTable;
use App\Models\FinanceEntity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinanceEntityResource extends Resource
{
    protected static ?string $model = FinanceEntity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getLabel(): string
    {
        return 'الكيانات المالية';
    }

    public static function getPluralLabel(): string
    {
        return 'الكيانات المالية';
    }

    public static function getNavigationLabel(): string
    {
        return 'الكيانات المالية';
    }

   

    public static function form(Schema $schema): Schema
    {
        return FinanceEntityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinanceEntitiesTable::configure($table);
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
            'index' => ListFinanceEntities::route('/'),
            'create' => CreateFinanceEntity::route('/create'),
            'edit' => EditFinanceEntity::route('/{record}/edit'),
        ];
    }
}
