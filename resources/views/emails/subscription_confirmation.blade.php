@component('mail::message')
# Subscription Confirmation

Thank you for subscribing to TechnoSpeak Premium!

**Plan:** {{ $payment->payable->name }}  
**Amount:** R{{ number_format($payment->amount, 2) }}  
**Subscription Period:** {{ now()->format('F j, Y') }} to {{ now()->addQuarter()->format('F j, Y') }}

You now have access to:
- Full video library
- Downloadable resources
- Monthly tech newsletters
- Exclusive cheat sheets and guides

@component('mail::button', ['url' => route('dashboard')])
Access Your Dashboard
@endcomponent

Thanks,  
The TechnoSpeak Team
@endcomponent