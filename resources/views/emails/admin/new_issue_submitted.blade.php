<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Issue Submitted</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:Roboto,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0;">
                <img src="{{ asset('images/default-no-logo.png') }}"
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
                            <h1 style="margin:0 0 10px;font-size:24px;color:#111;">
                                New Issue Submitted
                            </h1>
                            
                            <p style="margin:0 0 20px;font-size:14px;color:#38b6ff;text-transform:uppercase;letter-spacing:1px;">
                                Requires Your Attention
                            </p>

                            <h2 style="font-size:18px;color:#111;margin-bottom:15px;">Issue Details</h2>

                            <table style="width:100%;margin:20px 0;border-collapse:collapse;">
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Reference Number</td>
                                    <td style="padding:10px;border:1px solid #ddd;">#{{ $issue->id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Client</td>
                                    <td style="padding:10px;border:1px solid #ddd;">{{ $issue->client->name }} {{ $issue->client->surname }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Title</td>
                                    <td style="padding:10px;border:1px solid #ddd;">{{ $issue->title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Urgency</td>
                                    <td style="padding:10px;border:1px solid #ddd;">
                                        <span style="color: {{ $issue->urgency === 'high' ? '#e53e3e' : ($issue->urgency === 'medium' ? '#dd6b20' : '#38a169') }}">
                                            {{ ucfirst($issue->urgency) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;border:1px solid #ddd;font-weight:bold;background:#f9f9f9;">Submitted At</td>
                                    <td style="padding:10px;border:1px solid #ddd;">{{ $issue->created_at->format('F j, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>

                            <div style="margin:30px 0;text-align:center;">
                                <a href="{{ route('content-manager.issues.show', $issue) }}" 
                                   style="display:inline-block;padding:12px 24px;background-color:#38b6ff;color:#ffffff;text-decoration:none;border-radius:4px;font-weight:bold;">
                                    View Issue in Dashboard
                                </a>
                            </div>

                            <p style="margin:30px 0 0;font-size:16px;line-height:1.5;color:#333;">
                                Best regards,<br>TechnoSpeak Support Team
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding:20px;font-size:12px;color:#999;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>