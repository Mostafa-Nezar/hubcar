<?php

namespace App\Filament\Admin\Resources\ContactMessages;

use App\Filament\Admin\Resources\ContactMessages\Pages\CreateContactMessage;
use App\Filament\Admin\Resources\ContactMessages\Pages\EditContactMessage;
use App\Filament\Admin\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Admin\Resources\ContactMessages\Pages\ViewContactMessage;
use App\Filament\Admin\Resources\ContactMessages\Schemas\ContactMessageForm;
use App\Filament\Admin\Resources\ContactMessages\Schemas\ContactMessageInfolist;
use App\Filament\Admin\Resources\ContactMessages\Tables\ContactMessagesTable;
use App\Models\ContactMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('رسائل التواصل');
    }

    public static function getModelLabel(): string
    {
        return __('رسالة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('رسائل التواصل');
    }

    public static function form(Schema $schema): Schema
    {
        return ContactMessageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactMessageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactMessagesTable::configure($table);
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
            'index' => ListContactMessages::route('/'),
            'create' => CreateContactMessage::route('/create'),
            'view' => ViewContactMessage::route('/{record}'),
            'edit' => EditContactMessage::route('/{record}/edit'),
        ];
    }
}
