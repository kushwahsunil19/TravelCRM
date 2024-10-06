<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #666666;
        }
        .reset-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .reset-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <h1>Reset Your Password</h1>
        <p>
            You requested a password reset. You can reset your password by clicking the button below.
        </p>
        <a href="{{ route('reset.password.get', $token) }}" class="reset-btn">Reset Password</a>
        <p>If you didn't request a password reset, no further action is required.</p>
        <p>Thank you,<br>The {{ config('app.name') }} Team</p>
    </div>

</body>
</html>
