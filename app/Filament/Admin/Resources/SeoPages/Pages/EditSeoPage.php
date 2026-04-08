<?php

namespace App\Filament\Admin\Resources\SeoPages\Pages;

use App\Filament\Admin\Resources\SeoPages\SeoPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoPage extends EditRecord
{
    protected static string $resource = SeoPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
