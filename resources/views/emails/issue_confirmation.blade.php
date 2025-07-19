<!DOCTYPE html>
<html>
<head>
    <title>Issue Confirmation</title>
</head>
<body>
    <h2>Hello {{ $issue->client->name }},</h2>
    
    <p>We've received your support request (Reference #{{ $issue->id }}).</p>
    
    <h3>Issue Details:</h3>
    <ul>
        <li><strong>Title:</strong> {{ $issue->title }}</li>
        <li><strong>Description:</strong> {{ $issue->description }}</li>
        <li><strong>Urgency:</strong> {{ ucfirst($issue->urgency) }}</li>
        <li><strong>Submitted:</strong> {{ $issue->created_at->format('F j, Y \a\t g:i a') }}</li>
    </ul>
    
    <p>Our team will review your request and respond within 24-48 hours.</p>
    
    <p>Thank you,<br>
    TechnoSpeak Support Team</p>
</body>
</html>