<?php

namespace App\Filament\Admin\Resources\Privacies\Pages;

use App\Filament\Admin\Resources\Privacies\PrivacyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrivacies extends ListRecords
{
    protected static string $resource = PrivacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
