<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Account Deletion</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; }
        p { margin: 15px 0; }
        .delete-btn { background: #e74c3c; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        .delete-btn:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Account Deletion</h2>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">Yes, delete my account</button>
        </form>
    </div>
</body>
</html>
