<?php

namespace App\Filament\Admin\Resources\SeoPages;

use App\Filament\Admin\Resources\SeoPages\Pages\CreateSeoPage;
use App\Filament\Admin\Resources\SeoPages\Pages\EditSeoPage;
use App\Filament\Admin\Resources\SeoPages\Pages\ListSeoPages;
use App\Filament\Admin\Resources\SeoPages\Schemas\SeoPageForm;
use App\Filament\Admin\Resources\SeoPages\Tables\SeoPagesTable;
use App\Models\SeoPage;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class SeoPageResource extends Resource
{
    protected static ?string $model = SeoPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static ?string $recordTitleAttribute = 'url_path';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الواجهة الأمامية';

    public static function getNavigationLabel(): string
    {
        return 'إدارة الـ SEO للمواقع';
    }

    public static function getModelLabel(): string
    {
        return 'صفحة SEO';
    }

    public static function getPluralModelLabel(): string
    {
        return 'إدارة الـ SEO للمواقع';
    }

    public static function form(Schema $schema): Schema
    {
        return SeoPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoPagesTable::configure($table);
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
            'index' => ListSeoPages::route('/'),
            'create' => CreateSeoPage::route('/create'),
            'edit' => EditSeoPage::route('/{record}/edit'),
        ];
    }
}
