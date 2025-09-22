<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CertificateIssuedNotification extends Notification
{
    use Queueable;

    public $userFullname;
    public $courseName;
    public $certificateUrl;

    public function __construct($userFullname, $courseName, $certificateUrl)
    {
        $this->userFullname = $userFullname;
        $this->courseName = $courseName;
        $this->certificateUrl = $certificateUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('🎉 Your Certificate for ' . $this->courseName . ' is Ready!')
            ->markdown('emails.certificate-issued', [
                'userFullname' => $this->userFullname,
                'courseName' => $this->courseName,
                'certificateUrl' => $this->certificateUrl
            ]);
    }
}
