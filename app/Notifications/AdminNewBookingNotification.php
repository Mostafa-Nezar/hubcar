<?php

namespace App\Notifications;

use App\Models\BookingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class AdminNewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $carName = $this->booking->car ? $this->booking->car->name : ($this->booking->car_name_manual ?? 'سيارة');
        
        return (new MailMessage)
            ->subject('طلب حجز جديد - ' . $carName)
            ->greeting('مرحباً أدمن،')
            ->line('تم استلام طلب حجز جديد على هب كار.')
            ->line('اسم العميل: ' . $this->booking->client_name)
            ->line('الجوال: ' . $this->booking->phone)
            ->line('السيارة: ' . $carName)
            ->line('نوع الدفع: ' . $this->booking->payment_type)
            ->action('عرض الطلب', url('/admin/booking-requests/' . $this->booking->id))
            ->line('شكراً لاستخدامك تطبيقنا!');
    }

    public function toArray($notifiable)
    {
        $carName = $this->booking->car ? $this->booking->car->name : ($this->booking->car_name_manual ?? 'سيارة');

        return [
            'booking_id' => $this->booking->id,
            'client_name' => $this->booking->client_name,
            'car_name' => $carName,
            'message' => 'طلب حجز جديد من ' . $this->booking->client_name,
        ];
    }
}
