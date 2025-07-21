<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Issue;
use App\Models\Admin;

class NewIssueSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $issue;

    /**
     * Create a new notification instance.
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Issue Submitted: #' . $this->issue->id)
            ->markdown('emails.admin.new_issue_submitted', [
                'issue' => $this->issue,
                'admin' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'issue_id' => $this->issue->id,
            'title' => $this->issue->title,
            'client_name' => $this->issue->client->name,
            'urgency' => $this->issue->urgency,
            'url' => route('content-manager.issues.show', $this->issue)
        ];
    }
}