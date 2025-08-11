<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:Roboto,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0;">
                <!-- Logo / Banner -->
                <img src="@secureAsset('images/default-no-logo.png')">
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
                            @if (! empty($greeting))
                                <h1 style="margin:0 0 20px;font-size:24px;color:#111;">
                                    {{ $greeting }}
                                </h1>
                            @else
                                <h1 style="margin:0 0 20px;font-size:24px;color:#111;">
                                    @if ($level === 'error')
                                        @lang('Oops!')
                                    @else
                                        @lang('Hello!')
                                    @endif
                                </h1>
                            @endif

                            <!-- Intro Lines -->
                            @foreach ($introLines as $line)
                                <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;">
                                    {{ $line }}
                                </p>
                            @endforeach

                            <!-- Action Button -->
                            @isset($actionText)
                                <table cellpadding="0" cellspacing="0" role="presentation"
                                       style="margin:30px 0;width:100%;text-align:center;">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ $actionUrl }}"
                                               style="
                                                    background-color:#38b6ff;
                                                    color:#ffffff;
                                                    padding:12px 25px;
                                                    font-size:16px;
                                                    text-decoration:none;
                                                    border-radius:30px;
                                                    display:inline-block;
                                               ">
                                               {{ $actionText }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endisset

                            <!-- Outro Lines -->
                            @foreach ($outroLines as $line)
                                <p style="margin:0 0 15px;font-size:16px;line-height:1.5;color:#333;">
                                    {{ $line }}
                                </p>
                            @endforeach

                            <!-- Salutation -->
                            <p style="margin:30px 0 0;font-size:16px;line-height:1.5;color:#333;">
                                @if (! empty($salutation))
                                    {{ $salutation }}
                                @else
                                    @lang('Regards,')<br>{{ config('app.name') }}
                                @endif
                            </p>

                            <!-- Subcopy -->
                            @isset($actionText)
                                <p style="margin:30px 0 0;font-size:14px;line-height:1.4;color:#666;">
                                    @lang(
                                        "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                                        'into your web browser:',
                                        ['actionText' => $actionText]
                                    )<br>
                                    <a href="{{ $actionUrl }}"
                                       style="color:#38b6ff;word-break:break-all;">
                                        {{ $displayableActionUrl }}
                                    </a>
                                </p>
                            @endisset
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
