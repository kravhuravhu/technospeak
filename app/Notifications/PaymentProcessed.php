<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentProcessed extends Notification
{
    use Queueable;

    public $payment;
    public $status;
    public $subject;

    public function __construct(Payment $payment, $status = 'success')
    {
        $this->payment = $payment;
        $this->status = $status;
        $this->subject = $status === 'success' 
            ? 'Payment Confirmation - ' . config('app.name')
            : 'Payment Failed - ' . config('app.name');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $actionUrl = route('dashboard');
        $displayableActionUrl = str_replace(['http://', 'https://'], '', $actionUrl);

        $pstatus = $this->status === 'success' 
            ? 'Payment Successful!'
            : 'Payment Failed';

        $introLines = $this->getIntroLines();
        $outroLines = $this->getOutroLines();
        $actionText = $this->status === 'success' ? '' : 'Try Again';

        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('emails.payment-notification', [
                'pstatus' => $pstatus,
                'introLines' => $introLines,
                'actionText' => $actionText,
                'actionUrl' => $actionUrl,
                'displayableActionUrl' => $displayableActionUrl,
                'outroLines' => $outroLines,
                'salutation' => 'Best regards,',
                'status' => $this->status,
                'payment' => $this->payment
            ])
            ->bcc('admin@technospeak.co.za');
    }

    public function toDatabase($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'status' => $this->status,
            'transaction_id' => $this->payment->transaction_id,
            'message' => $this->status === 'success' 
                ? 'Your payment of R' . number_format($this->payment->amount, 2) . ' was successful.'
                : 'Your payment of R' . number_format($this->payment->amount, 2) . ' failed.'
        ];
    }

    protected function getIntroLines()
    {
        if ($this->status === 'success') {
            return [
                'Your payment of R' . number_format($this->payment->amount, 2) . ' has been successfully processed.',
                'Payment Method: ' . ucwords(str_replace('_', ' ', $this->payment->payment_method)),
                'Payment For: ' . $this->payment->payment_for
            ];
        }

        return [
            'We were unable to process your payment of R' . number_format($this->payment->amount, 2),
            'Please try again or contact support if the problem persists.',
            'Transaction ID: ' . ($this->payment->transaction_id ?? 'N/A')
        ];
    }

    protected function getOutroLines()
    {
        if ($this->status === 'success') {
            return [
                'Thank you for your payment. Your transaction has been completed.',
                '********************************************',
                'You will receive an invite 24hours before the session.',
                '********************************************'
            ];
        }

        return [
            'If you believe this is an error, please contact our support team.',
            'No funds have been deducted from your account. Support: admin@technospeak.co.za | info@technospeak.co.za'
        ];
    }
}