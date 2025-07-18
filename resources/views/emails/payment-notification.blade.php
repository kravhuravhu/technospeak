@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/default-no-logo.png') }}" 
                 alt="{{ config('app.name') }} Logo" 
                 width="150" 
                 style="display:block;border:none;outline:none;text-decoration:none;">
        @endcomponent
    @endslot

    <!-- Greeting -->
    <h1 style="margin:0 0 20px;font-size:24px;color:#111;">
        {{ $greeting }}
    </h1>

    <!-- Intro Lines -->
    @foreach ($introLines as $line)
        <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;">
            {{ $line }}
        </p>
    @endforeach

    <!-- Payment Details Table -->
    <table style="width:100%;margin:20px 0;border-collapse:collapse;">
        <tr>
            <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Amount</td>
            <td style="padding:10px;border:1px solid #ddd;">R{{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Date</td>
            <td style="padding:10px;border:1px solid #ddd;">{{ $payment->created_at->format('M d, Y h:i A') }}</td>
        </tr>
        <tr>
            <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Status</td>
            <td style="padding:10px;border:1px solid #ddd;">
                <span style="color: {{ $status === 'success' ? '#38a169' : '#e53e3e' }};font-weight:bold;">
                    {{ ucfirst($payment->status) }}
                </span>
            </td>
        </tr>
        @if($payment->payable)
        <tr>
            <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Service</td>
            <td style="padding:10px;border:1px solid #ddd;">{{ $payment->payment_for }}</td>
        </tr>
        @endif
    </table>

    <!-- Action Button -->
    @isset($actionText)
        @component('mail::button', ['url' => $actionUrl, 'color' => $status === 'success' ? 'primary' : 'error'])
            {{ $actionText }}
        @endcomponent
    @endisset

    <!-- Outro Lines -->
    @foreach ($outroLines as $line)
        <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;">
            {{ $line }}
        </p>
    @endforeach

    <!-- Subcopy -->
    @isset($actionText)
        @component('mail::subcopy')
            If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
            into your web browser: <br>
            <a href="{{ $actionUrl }}" style="color:#38b6ff;word-break:break-all;">
                {{ $displayableActionUrl }}
            </a>
        @endcomponent
    @endisset

    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent