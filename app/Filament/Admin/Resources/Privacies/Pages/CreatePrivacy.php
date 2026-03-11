<?php

namespace App\Filament\Admin\Resources\Privacies\Pages;

use App\Filament\Admin\Resources\Privacies\PrivacyResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePrivacy extends CreateRecord
{
    protected static string $resource = PrivacyResource::class;
     public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
