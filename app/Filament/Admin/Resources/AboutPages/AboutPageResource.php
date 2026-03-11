<?php

namespace App\Filament\Admin\Resources\AboutPages;

use App\Filament\Admin\Resources\AboutPages\Pages\CreateAboutPage;
use App\Filament\Admin\Resources\AboutPages\Pages\EditAboutPage;
use App\Filament\Admin\Resources\AboutPages\Pages\ListAboutPages;
use App\Filament\Admin\Resources\AboutPages\Schemas\AboutPageForm;
use App\Filament\Admin\Resources\AboutPages\Tables\AboutPagesTable;
use App\Models\AboutPage;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الواجهة الأمامية';

    public static function getNavigationLabel(): string
    {
        return __('من نحن');
    }

    public static function getModelLabel(): string
    {
        return __('محتوى صفحة من نحن');
    }

    public static function getPluralModelLabel(): string
    {
        return __('محتوى من نحن');
    }

    public static function form(Schema $schema): Schema
    {
        return AboutPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutPagesTable::configure($table);
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
            'index' => ListAboutPages::route('/'),
            'create' => CreateAboutPage::route('/create'),
            'edit' => EditAboutPage::route('/{record}/edit'),
        ];
    }
}
