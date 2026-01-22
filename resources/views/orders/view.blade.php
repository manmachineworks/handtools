<!doctype html>
<html class="no-js" lang="en">
@include("include/head")
<style>
    body {
        background-color: #f8f9fa;
    }

    .mt_top {
        margin-top: 30px;
    }

    .receipt {
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .receipt h1 {
        margin-bottom: 20px;
        font-size: 28px;
    }

    .receipt h2 {
        margin-top: 30px;
        font-size: 22px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .receipt p {
        margin: 10px 0;
        font-size: 16px;
    }

    .receipt hr {
        margin: 30px 0;
    }

    .text-center a.btn {
        padding: 10px 20px;
        font-size: 16px;
    }
</style>

<body>
    @include("include/header")
    <div class="container mt_top">
        <div class="receipt">
            <h1 class="text-center">Order Receipt
                @if($order->order_status == 'canceled'){
                <span class="text-danger">Order Canceled : Refund Initiated
                </span>
                }
                @endif
            </h1>

            <div class="details">
                <h2>Order Details</h2>
                <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                <p><strong>Status:</strong> {{ $order->status }}</p>
                <p><strong>Amount:</strong> INR{{ number_format($order->amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p><strong>Ordered At:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Estimated Delivery Time:</strong> {{ $order->delivery_time }}</p>
                <hr>
            </div>

            <div class="details">
                <h2>Product Details</h2>
                <p><strong>Product Name:</strong> <a href="{{ route('product.show', $order->product->url) }}">{{ $order->product->product_name }}</a></p>
                @if($order->variant)
                <p><strong>Variant:</strong> {{ $order->variant->name }}</p>
                @endif
                <hr>
            </div>

            <div class="details">
                <h2>Shipping Address</h2>
                <p>{{ $order->address->apartment }}</p>
                <p>{{ $order->address->address }}</p>
                <p>{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pin_code }}</p>
                <p>{{ $order->address->country }}</p>
            </div>

            <div class="text-center mt-5">
                <a href="/dashboard" class="btn btn-primary">Back to Orders</a>
            </div>
        </div>
    </div>

    @include("include/footer")
</body>

</html>