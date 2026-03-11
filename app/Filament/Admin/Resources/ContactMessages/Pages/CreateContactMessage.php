<?php

namespace App\Filament\Admin\Resources\ContactMessages\Pages;

use App\Filament\Admin\Resources\ContactMessages\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactMessage extends CreateRecord
{
    protected static string $resource = ContactMessageResource::class;
     public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
