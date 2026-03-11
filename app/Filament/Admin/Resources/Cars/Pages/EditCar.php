<?php

namespace App\Filament\Admin\Resources\Cars\Pages;

use App\Filament\Admin\Resources\Cars\CarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

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
