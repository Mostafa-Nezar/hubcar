<?php

namespace App\Filament\Admin\Resources\ContactMessages\Pages;

use App\Filament\Admin\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    // أضف هذا السطر لربط التصميم
    protected string $view = 'filament.custom-view-contact';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
