<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class AdminNewUserRegistrationNotification extends Notification
{
    use Queueable;

    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تسجيل عميل جديد - ' . $this->customer->name)
            ->greeting('مرحباً أدمن،')
            ->line('قام عميل جديد بالتسجيل في الموقع.')
            ->line('الاسم: ' . $this->customer->name)
            ->line('البريد الإلكتروني: ' . $this->customer->email)
            ->action('عرض العملاء', url('/admin/customers'))
            ->line('شكراً لك!');
    }

    public function toArray($notifiable): array
    {
        return [
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'message' => 'تسجيل عميل جديد: ' . $this->customer->name,
            'type' => 'registration',
        ];
    }
}
