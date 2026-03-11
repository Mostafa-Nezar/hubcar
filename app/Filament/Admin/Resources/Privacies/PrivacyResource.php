<?php

namespace App\Filament\Admin\Resources\Privacies;

use App\Filament\Admin\Resources\Privacies\Pages\CreatePrivacy;
use App\Filament\Admin\Resources\Privacies\Pages\EditPrivacy;
use App\Filament\Admin\Resources\Privacies\Pages\ListPrivacies;
use App\Filament\Admin\Resources\Privacies\Schemas\PrivacyForm;
use App\Filament\Admin\Resources\Privacies\Tables\PrivaciesTable;
use App\Models\Privacy;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrivacyResource extends Resource
{
    protected static ?string $model = Privacy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الواجهة الأمامية';

    public static function getNavigationLabel(): string
    {
        return __('سياسة الخصوصية');
    }

    public static function getModelLabel(): string
    {
        return __('بند خصوصية');
    }

    public static function getPluralModelLabel(): string
    {
        return __('سياسة الخصوصية');
    }

    public static function form(Schema $schema): Schema
    {
        return PrivacyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrivaciesTable::configure($table);
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
            'index' => ListPrivacies::route('/'),
            'create' => CreatePrivacy::route('/create'),
            'edit' => EditPrivacy::route('/{record}/edit'),
        ];
    }
}
