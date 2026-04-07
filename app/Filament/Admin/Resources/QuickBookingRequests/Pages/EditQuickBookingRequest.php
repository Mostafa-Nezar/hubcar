<?php

namespace App\Filament\Admin\Resources\QuickBookingRequests\Pages;

use App\Filament\Admin\Resources\QuickBookingRequests\QuickBookingRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuickBookingRequest extends EditRecord
{
    protected static string $resource = QuickBookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
