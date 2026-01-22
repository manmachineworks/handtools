<!DOCTYPE html>
<html>

<head>
    <title>Payment Successful</title>
</head>

<body>
    <h1>Payment Successful</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Thank you for your purchase! Your payment has been successfully processed.</p>
    <p>Order Details:</p>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>Transaction ID: {{ $order->transaction_id }}</li>
        <li>Amount: {{ $order->amount }}</li>
        <!-- Add more order details as needed -->
    </ul>
    <p>We appreciate your business and hope you enjoy your purchase.</p>
</body>

</html>