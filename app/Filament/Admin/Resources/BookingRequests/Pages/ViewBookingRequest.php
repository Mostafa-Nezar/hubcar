<?php

namespace App\Filament\Admin\Resources\BookingRequests\Pages;

use App\Filament\Admin\Resources\BookingRequests\BookingRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookingRequest extends ViewRecord
{
    protected static string $resource = BookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
