<?php

namespace App\Observers;

use App\Models\QuickBookingRequest;
use App\Models\User;
use App\Notifications\AdminNewBookingNotification;
use App\Notifications\ClientBookingConfirmationNotification;
use Illuminate\Support\Facades\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class QuickBookingRequestObserver
{
    /**
     * Handle the QuickBookingRequest "created" event.
     */
    public function created(QuickBookingRequest $quickBookingRequest): void
    {
        // 1. Notify Admins
        $admins = User::all();
        Notification::send($admins, new AdminNewBookingNotification($quickBookingRequest));

        // Notify Admins in Filament UI
        foreach ($admins as $admin) {
            FilamentNotification::make()
                ->title('طلب حجز سريع جديد')
                ->body("عميل جديد: {$quickBookingRequest->client_name}")
                ->icon('heroicon-o-bolt')
                ->iconColor('warning')
                ->sendToDatabase($admin);
        }

        // 2. Notify Client via Email
        if ($quickBookingRequest->email) {
            $quickBookingRequest->notify(new ClientBookingConfirmationNotification($quickBookingRequest));
        }

        // 3. WhatsApp Notification
        $whatsappService = app(\App\Services\WhatsAppService::class);
        $message = "طلب حجز سريع جديد! السيارة {$quickBookingRequest->car_name_manual} كاش من العميل {$quickBookingRequest->client_name}.";
        
        $adminPhone = config('services.whatsapp.admin_phone');
        if ($adminPhone) {
            $whatsappService->sendMessage($adminPhone, $message);
        }

        if ($quickBookingRequest->phone) {
            $clientMessage = "عزيزي {$quickBookingRequest->client_name}، تم استلام طلب الحجز السريع لسيارة {$quickBookingRequest->car_name_manual} بنجاح. هب كار.";
            $whatsappService->sendMessage($quickBookingRequest->phone, $clientMessage);
        }
    }
}
