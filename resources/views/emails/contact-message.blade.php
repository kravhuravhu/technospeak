@component('mail::message')
# Hello Admin,

You have received a **new message** from the contact form.

---

<div style="margin-top:20px; margin-bottom:10px; font-size:16px; font-weight:bold;">📋 Submission Details</div>

<table style="width:100%; border-collapse: collapse; border:1px solid #ddd;">
@foreach($data['fields'] as $key => $value)
<tr>
    <td style="padding:8px; border:1px solid #ddd; background-color:#f7f7f7; font-weight:bold; width:30%; text-align:left;">
        {{ ucwords(str_replace('_',' ',$key)) }}
    </td>
    <td style="padding:8px; border:1px solid #ddd; text-align:left;">
        {{ $value }}
    </td>
</tr>
@endforeach
</table>

---
Regards,<br>
**{{ $data['fields']['Full Name'] ?? 'Website User' }}**

@component('mail::button', ['url' => config('app.url')])
Visit Our Website
@endcomponent
@endcomponent
