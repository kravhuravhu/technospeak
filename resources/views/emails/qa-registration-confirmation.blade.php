<!DOCTYPE html>
<html>
<head>
    <title>Q/A Session Registration Confirmation</title>
</head>
<body>
    <h1>Thank You for Registering!</h1>
    
    <p>Hello {{ $registration->name }},</p>
    
    <p>Your registration for the following Q/A session has been confirmed:</p>
    
    <h2>{{ $session->title }}</h2>
    <p><strong>Date & Time:</strong> {{ $session->scheduled_for->format('F j, Y g:i A') }}</p>
    <p><strong>Duration:</strong> {{ $session->duration }}</p>
    
    <p>Amount Paid: R{{ number_format($registration->amount, 2) }}</p>
    
    <p>We look forward to seeing you there!</p>
    
    <p>If you have any questions, please don't hesitate to contact us.</p>
    
    <p>Best regards,<br>
    The Training Team</p>
</body>
</html>