<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Email - Technospeak</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/auth_register.css" type="text/css"/>
    <link rel="icon" href="@secureAsset('/images/icon.png')" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f1f1f1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verify-box {
            background: #fff;
            padding: 60px;
            border-radius: 25px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .verify-box i {
            font-size: 60px;
            color: #38b6ff;
            margin-bottom: 20px;
        }

        .verify-box h2 {
            font-size: 2.2em;
            margin-bottom: 20px;
            color: #111;
        }

        .verify-box p {
            font-size: 1.1em;
            color: #444;
            margin-bottom: 30px;
        }

        .verify-box form button {
            background-color: #38b6ff;
            color: white;
            padding: 15px 40px;
            font-size: 1em;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .verify-box form button:hover {
            background-color: #28a5ed;
        }

        .status-message {
            color: green;
            font-size: 1em;
            margin-top: 20px;
        }

        .logout-link {
            display: block;
            margin-top: 30px;
            color: #888;
            font-size: 0.95em;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="verify-box">
        <i class="fa-solid fa-envelope-circle-check"></i>
        <h2>Email Verification Required</h2>
        <p>We've sent a verification link to your email. Please check your inbox and click the link to activate your account.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="status-message">
                A new verification link has been sent to your email.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Resend Verification Email</button>
        </form>

        <a class="logout-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Not your email? Log out
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>
