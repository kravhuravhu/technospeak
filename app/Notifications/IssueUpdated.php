<?php

namespace App\Notifications;

use App\Models\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssueUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $issue;
    public $changes;

    public function __construct(Issue $issue, array $changes)
    {
        $this->issue = $issue;
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Update on your issue: {$this->issue->title}")
            ->line("Your issue (#{$this->issue->id}) has been updated:")
            ->line("Status: " . (isset($this->changes['status']) ? $this->changes['status'] : 'No change'))
            ->line("Assigned To: " . (isset($this->changes['assigned_to']) ? $this->changes['assigned_to'] : 'No change'))
            ->action('View Issue', url("/issues/{$this->issue->id}"))
            ->line('Thank you for using our support system!');
    }
}