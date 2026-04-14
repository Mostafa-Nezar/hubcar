<?php

namespace App\Notifications;

use App\Models\BookingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientBookingConfirmationNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        // Add custom whatsapp channel if needed
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $carName = $this->booking->car ? $this->booking->car->name : ($this->booking->car_name_manual ?? 'سيارة');

        return (new MailMessage)
            ->subject('هب كار - تم استلام طلب الحجز الخاص بك!')
            ->greeting('عزيزي ' . $this->booking->client_name . '،')
            ->line('نشكرك على اختيارك هب كار. لقد استلمنا طلب الحجز الخاص بك لسيارة ' . $carName . '.')
            ->line('سيقوم فريقنا بمراجعة طلبك والتواصل معك قريباً.')
            ->line('تفاصيل الطلب:')
            ->line('- السيارة: ' . $carName)
            ->line('- طريقة الدفع: ' . $this->booking->payment_type)
            ->line('- حالة الطلب: قيد المراجعة')
            ->action('زيارة موقعنا', url('/'))
            ->line('مع أطيب التحيات،')
            ->line('فريق هب كار');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => 'received',
        ];
    }
}
