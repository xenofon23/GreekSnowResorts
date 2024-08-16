
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
<h1>Thank you for your booking!</h1>
<p>Dear {{ $user->name }},</p>
<p>Your booking for the snow resort has been confirmed. Below are the details:</p>
<ul>
    <li>Booking ID: {{ $booking->id }}</li>
</ul>
<p>Attached is your order ticket.</p>
</body>
</html>
