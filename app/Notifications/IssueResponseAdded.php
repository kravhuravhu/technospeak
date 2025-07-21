<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Issue;
use App\Models\IssueResponse;
use App\Notifications\IssueResponseAdded;

class IssueResponseAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $issue;
    public $response;

    
    /**
     * Create a new notification instance.
     */
    public function __construct(Issue $issue, IssueResponse $response)
    {
        $this->issue = $issue;
        $this->response = $response;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Update on Your Issue #{$this->issue->id}")
            ->line("You have received a new response regarding your issue:")
            ->line($this->response->content)
            ->action('View Issue', route('issues.show', $this->issue));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'issue_id' => $this->issue->id,
            'response_id' => $this->response->id,
            'message' => 'New response on your issue'
        ];
    }
}