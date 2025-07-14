<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TrainingSession;

class QaSessionRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $session;

    public function __construct($registration, TrainingSession $session)
    {
        $this->registration = $registration;
        $this->session = $session;
    }

    public function build()
    {
        return $this->subject('Your Q/A Session Registration Confirmation')
                    ->view('emails.qa-registration-confirmation');
    }
}