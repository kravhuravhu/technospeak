<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Payment Confirmation' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:Roboto,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0;">
                <img src="@secureAsset('images/default-no-logo.png')"
                     alt="{{ config('app.name') }} Logo"
                     width="150"
                     style="display:block;border:none;outline:none;text-decoration:none;">
            </td>
        </tr>
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                       style="background-color:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:40px;">
                            <!-- Greeting -->
                            <h1 style="margin:0 0 10px;font-size:24px;color:#111;">
                                {{ $greeting ?? 'Hello!' }}
                            </h1>

                            <!-- Status Line -->
                            <p style="margin:0 0 20px;font-size:14px;color:#38b6ff;text-transform:uppercase;letter-spacing:1px;">
                                {{ $pstatus ?? 'Payment Confirmation' }}
                            </p>

                            <!-- Intro -->
                            @foreach ($introLines as $line)
                                <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;">
                                    {{ $line }}
                                </p>
                            @endforeach

                            <!-- Receipt Details -->
                            <h2 style="font-size:18px;color:#111;margin-bottom:15px;">Receipt Details</h2>

                            <table style="width:100%;margin:20px 0;border-collapse:collapse;">
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Customer</td>
                                    <td style="padding:10px;border:1px solid #ddd;">{{ $payment->client->name }} ({{ $payment->client->email }})</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Receipt Number</td>
                                    <td style="padding:10px;border:1px solid #ddd;">#{{ $payment->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Processed At</td>
                                    <td style="padding:10px;border:1px solid #ddd;">{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Amount</td>
                                    <td style="padding:10px;border:1px solid #ddd;">R{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                @if($payment->payable)
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Service</td>
                                    <td style="padding:10px;border:1px solid #ddd;">
                                        <strong>{{ $payment->detailed_service_name['title'] ?? 'N/A' }}</strong><br>
                                        <span style="font-size: 14px;">
                                            {{ $payment->detailed_service_name['type'] ?? '' }}
                                            @if(isset($payment->detailed_service_name['category']) && $payment->detailed_service_name['category'])
                                                • Category: {{ $payment->detailed_service_name['category'] }}
                                            @endif
                                            @if(isset($payment->detailed_service_name['date']) && $payment->detailed_service_name['date'])
                                                • Scheduled for: {{ $payment->detailed_service_name['date'] }}
                                            @endif
                                            @if(isset($payment->detailed_service_name['duration']) && $payment->detailed_service_name['duration'])
                                                • Duration: {{ $payment->detailed_service_name['duration'] }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Status</td>
                                    <td style="padding:10px;border:1px solid #ddd;">
                                        <span style="color: {{ $status === 'success' ? '#38a169' : '#e53e3e' }};font-weight:bold;">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- Outro -->
                            @foreach ($outroLines as $line)
                                <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;text-align:center;">
                                    {{ $line }}
                                </p>
                            @endforeach

                            <!-- Salutation -->
                            <p style="margin:30px 0 0;font-size:16px;line-height:1.5;color:#333;">
                                {{ $salutation ?? __('Regards,') }}<br>
                                @if(isset($payment->detailed_service_name['instructor']) && $payment->detailed_service_name['instructor'])
                                    {{ $payment->detailed_service_name['instructor'] }} <br><br>
                                @endif
                                Support: admin@technospeak.co.za
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding:20px;font-size:12px;color:#999;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>