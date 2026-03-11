<?php

namespace App\Filament\Admin\Resources\AboutPages\Pages;

use App\Filament\Admin\Resources\AboutPages\AboutPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
     public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
