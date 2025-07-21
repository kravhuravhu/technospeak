<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Issue;

class IssueConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public $issue;

    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Issue Received #{$this->issue->id}")
            ->markdown('emails.issue_confirmation', [
                'issue' => $this->issue
            ]);
    }
}