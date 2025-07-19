<?php

namespace App\Mail;

use App\Models\Issue;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class IssueConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $issue;

    public function __construct(Client $client, Issue $issue)
    {
        $this->client = $client;
        $this->issue = $issue;
    }

    public function build()
    {
        return $this->subject("Support Request Confirmation #{$this->issue->id}")
               ->html('');

        // return $this->subject("Support Request Confirmation #{$this->issue->id}")
        //            ->view('emails.issue_confirmation');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Issue Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
