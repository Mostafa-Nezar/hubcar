<?php

namespace App\Filament\Admin\Resources\Privacies\Pages;

use App\Filament\Admin\Resources\Privacies\PrivacyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPrivacy extends EditRecord
{
    protected static string $resource = PrivacyResource::class;

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
