<?php

namespace App\Filament\Admin\Resources\FinanceEntities\Pages;

use App\Filament\Admin\Resources\FinanceEntities\FinanceEntityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFinanceEntity extends EditRecord
{
    protected static string $resource = FinanceEntityResource::class;

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
