<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class GenericSubmissionNotification extends Notification
{
    use Queueable;

    public $data;
    public $type;

    public function __construct(array $data, string $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $subject = ucfirst($this->type) . " Submission Received";

        $mailMessage = (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($subject)
            ->markdown('emails.generic-submission', [
                'data' => $this->data,
                'type' => $this->type
            ])
            ->bcc(config('mail.bcc'));

        $mailMessage->withSymfonyMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Priority', '1');
            $headers->addTextHeader('Importance', 'High');
            $headers->addTextHeader('X-Mailer', 'Laravel');
        });

        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                if (isset($attachment['content'])) {
                    $mailMessage->attachData(
                        $attachment['content'],
                        $attachment['original_name'],
                        ['mime' => $attachment['mime_type']]
                    );
                }
            }
        }

        return $mailMessage;
    }
}