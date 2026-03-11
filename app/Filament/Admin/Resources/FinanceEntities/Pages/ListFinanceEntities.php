<?php

namespace App\Filament\Admin\Resources\FinanceEntities\Pages;

use App\Filament\Admin\Resources\FinanceEntities\FinanceEntityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFinanceEntities extends ListRecords
{
    protected static string $resource = FinanceEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
