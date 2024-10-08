
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
<h1>Thank you for your booking!</h1>
<p>Dear {{ $booking->user->name }},</p>
<p>Your booking for the snow resort has been confirmed. Below are the details:</p>
<ul>
    <li>Booking ID: {{ $booking->id }}</li>
    <li>Snow Resort: {{ $booking->snow_resort->name }}</li>
    <li>Order Time: {{ $booking->order_time }}</li>
    <li>Cost: ${{ $booking->cost }}</li>
</ul>
<p>Attached is your order ticket.</p>
</body>
</html>
