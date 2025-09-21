@component('mail::message')
# 🎉 Congratulations, {{ $userFullname }}!

You've successfully completed the course:

**{{ $courseName }}**

Your certificate of completion is now available.

@php
    $fullCertificateUrl = rtrim(config('app.url'), '/') . $certificateUrl;
@endphp

@component('mail::button', ['url' => $fullCertificateUrl])
🎓 View Certificate
@endcomponent

We’re proud of your achievement. Keep learning and growing!

Thanks,<br>
**{{ config('app.name') }} Team**
@endcomponent
