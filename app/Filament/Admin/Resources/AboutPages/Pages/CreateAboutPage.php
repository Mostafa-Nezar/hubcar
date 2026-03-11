<?php

namespace App\Filament\Admin\Resources\AboutPages\Pages;

use App\Filament\Admin\Resources\AboutPages\AboutPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutPage extends CreateRecord
{
    protected static string $resource = AboutPageResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
