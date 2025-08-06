<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PremiumAccessGranted extends Notification
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Premium Access Activated')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for subscribing to our premium service.')
            ->line('You now have access to all our courses.')
            ->line('Amount paid: $' . number_format($this->payment->amount, 2))
            ->action('Browse Courses', url('/courses'))
            ->line('Thank you for using our application!');
    }
}