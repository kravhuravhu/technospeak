<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactMessage extends Notification
{
    use Queueable;

    public $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Form Submission')
            ->markdown('emails.contact-message', [
                'data' => [
                    'fields' => $this->fields,
                    'attachments' => []
                ],
                'type' => 'contact'
            ]);
    }
}
