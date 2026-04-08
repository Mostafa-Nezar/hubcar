<?php

namespace App\Filament\Admin\Resources\SeoPages\Pages;

use App\Filament\Admin\Resources\SeoPages\SeoPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoPages extends ListRecords
{
    protected static string $resource = SeoPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
