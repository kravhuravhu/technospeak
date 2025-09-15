<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProblemFeedbackNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     * @param string $type
     */
    public function __construct(array $data, string $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject(ucfirst($this->type) . ' Submission Received')
            ->markdown('emails.problem_feedback', [
                'data' => $this->data,
                'type' => $this->type,
            ])
            ->bcc(config('mail.bcc'));

        // Attach files if any
        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                $mail->attachData($attachment['content'], $attachment['original_name'], [
                    'mime' => $attachment['mime_type']
                ]);
            }
        }

        return $mail;
    }
}
