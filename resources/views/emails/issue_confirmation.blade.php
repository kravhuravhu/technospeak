<!DOCTYPE html>
<html>
<head>
    <title>Your Issue Has Been Received</title>
</head>
<body>
    <h2>Hello {{ $client->name }} {{ $client->surname }},</h2>
    
    <p>We've received your technical issue and our team is working on it.</p>
    
    <h3>Issue Details:</h3>
    <p><strong>Title:</strong> {{ $issue->title }}</p>
    <p><strong>Description:</strong> {{ $issue->description }}</p>
    <p><strong>Urgency:</strong> {{ ucfirst($issue->urgency) }}</p>
    <p><strong>Submitted:</strong> {{ $issue->created_at->format('F j, Y \a\t g:i a') }}</p>
    
    <p>Our typical response time is 24-48 hours. You'll receive another email when we have an update.</p>
    
    <p>Thank you,<br>
    TechnoSpeak Support Team</p>
</body>
</html>