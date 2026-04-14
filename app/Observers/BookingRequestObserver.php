<?php

namespace App\Observers;

use App\Models\BookingRequest;
use App\Models\User;
use App\Notifications\AdminNewBookingNotification;
use App\Notifications\ClientBookingConfirmationNotification;
use Illuminate\Support\Facades\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class BookingRequestObserver
{
    /**
     * Handle the BookingRequest "created" event.
     */
    public function created(BookingRequest $bookingRequest): void
    {
        $admins = User::all();
        Notification::send($admins, new AdminNewBookingNotification($bookingRequest));

        // Notify Admins in Filament UI
        foreach ($admins as $admin) {
            FilamentNotification::make()
                ->title('طلب حجز جديد')
                ->body("عميل جديد: {$bookingRequest->client_name}")
                ->icon('heroicon-o-shopping-bag')
                ->iconColor('success')
                ->sendToDatabase($admin);
        }

        // 2. Notify Client via Email
        if ($bookingRequest->email) {
            $bookingRequest->notify(new ClientBookingConfirmationNotification($bookingRequest));
        }

        // 3. WhatsApp Notification (Optional/Custom)
        // You can call your WhatsApp service here or add it to a notification channel
        $whatsappService = app(\App\Services\WhatsAppService::class);
        $message = "تم استلام طلب حجز جديد للسيارة {$bookingRequest->car_name_manual} من العميل {$bookingRequest->client_name}.";
        
        // Notify Admin via WhatsApp
        // Assuming admin phone is in settings or env
        $adminPhone = config('services.whatsapp.admin_phone');
        if ($adminPhone) {
            $whatsappService->sendMessage($adminPhone, $message);
        }

        // Notify Client via WhatsApp
        if ($bookingRequest->phone) {
            $clientMessage = "عزيزي {$bookingRequest->client_name}، تم استلام طلبك لسيارة {$bookingRequest->car_name_manual} بنجاح. سنقوم بالتواصل معك قريباً. هب كار.";
            $whatsappService->sendMessage($bookingRequest->phone, $clientMessage);
        }
    }
}
