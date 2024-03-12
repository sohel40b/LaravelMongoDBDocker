<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Notification</title>
</head>

<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #333333;">Password Reset Notification</h2>
        <p style="color: #666666;">Hi {{ $user->name }},</p>
        <p style="color: #666666;">You are receiving this email because we received a password reset request for your
            account.</p>
        <p style="color: #666666;">Please click the button below to reset your password:</p>
        <p style="text-align: center;">
            <a href="{{ $resetUrl }}"
                style="background-color: #007bff; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block;">Reset
                Password</a>
        </p>
        <p style="color: #666666;">If you did not request a password reset, no further action is required.</p>
        <p style="color: #666666;">Thank you!</p>
    </div>
</body>

</html>
