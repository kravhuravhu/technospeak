@component('mail::message')
# Hello {{ $data['firstName'] ?? 'User' }},

Your **{{ $type }} submission** has been received. Our team will review it and get back to you via email soon.

---

<div style="margin-top:20px; margin-bottom:10px; font-size:16px; font-weight:bold;">📋 Submission Details</div>

<table style="width:100%; border-collapse: collapse; border:1px solid #ddd;">
    @foreach($data as $key => $value)
        @if(!in_array($key, ['_token', 'fileUpload', 'attachments']))
            <tr>
                <td style="padding:8px; border:1px solid #ddd; background-color:#f7f7f7; font-weight:bold; width:30%; text-align:left;">
                    {{ ucwords(str_replace('_', ' ', $key)) }}
                </td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">
                    {{ is_array($value) ? implode(', ', $value) : ($value ?: '-') }}
                </td>
            </tr>
        @endif
    @endforeach
</table>

@if(!empty($data['attachments']))
<div style="margin-top:20px;">
    <strong>📎 Attachments:</strong>
    <ul>
        @foreach($data['attachments'] as $attachment)
            <li>{{ $attachment['original_name'] }}</li>
        @endforeach
    </ul>
</div>
@endif

---

Thanks,<br>
**{{ config('app.name') }} Team**

@component('mail::button', ['url' => config('app.url')])
Visit Our Website
@endcomponent
@endcomponent