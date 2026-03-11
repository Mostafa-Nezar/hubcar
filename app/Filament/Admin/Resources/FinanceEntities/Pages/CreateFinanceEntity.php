<?php

namespace App\Filament\Admin\Resources\FinanceEntities\Pages;

use App\Filament\Admin\Resources\FinanceEntities\FinanceEntityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFinanceEntity extends CreateRecord
{
    protected static string $resource = FinanceEntityResource::class;
     public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
