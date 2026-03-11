<?php

namespace App\Filament\Admin\Resources\Terms;

use App\Filament\Admin\Resources\Terms\Pages\CreateTerm;
use App\Filament\Admin\Resources\Terms\Pages\EditTerm;
use App\Filament\Admin\Resources\Terms\Pages\ListTerms;
use App\Filament\Admin\Resources\Terms\Schemas\TermForm;
use App\Filament\Admin\Resources\Terms\Tables\TermsTable;
use App\Models\Term;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الواجهة الأمامية';

    public static function getNavigationLabel(): string
    {
        return __('الشروط والأحكام');
    }

    public static function getModelLabel(): string
    {
        return __('شرط أو حكم');
    }

    public static function getPluralModelLabel(): string
    {
        return __('الشروط والأحكام');
    }

    public static function form(Schema $schema): Schema
    {
        return TermForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TermsTable::configure($table);
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
            'index' => ListTerms::route('/'),
            'create' => CreateTerm::route('/create'),
            'edit' => EditTerm::route('/{record}/edit'),
        ];
    }
}
