<?php

namespace App\Filament\Admin\Resources\QuickBookingRequests\Pages;

use App\Filament\Admin\Resources\QuickBookingRequests\QuickBookingRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuickBookingRequests extends ListRecords
{
    protected static string $resource = QuickBookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
