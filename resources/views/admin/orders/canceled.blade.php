<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')
            <!-- Recent Sales Start -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="mb-4">Orders</h1>
                    </div>
                </div>
                <div class="accordion" id="ordersAccordion">
                    @foreach($paginatedOrders as $transaction)
                    @php
                    $productNames = $transaction->map(function($order) {
                    $productName = $order->product->product_name;
                    if ($order->variant_id && $order->variant) {
                    $productName .= ' (' . $order->variant->variant . ')';
                    }
                    return $productName;
                    })->unique();

                    $totalAmount = $transaction->sum('amount');
                    @endphp
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card bg-secondary text-white">
                                <div class="card-header" id="heading{{ $transaction->first()->transaction_id }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $transaction->first()->transaction_id }}" aria-expanded="true" aria-controls="collapse{{ $transaction->first()->transaction_id }}">
                                            Transaction ID: {{ $transaction->first()->transaction_id }}
                                        </button>
                                    </h2>
                                    <p class="mb-0">Products: {{ $productNames->implode(', ') }}</p>
                                    <p class="mb-0">Total Amount: {{ $totalAmount }}</p>
                                </div>
                                <div id="collapse{{ $transaction->first()->transaction_id }}" class="collapse" aria-labelledby="heading{{ $transaction->first()->transaction_id }}" data-bs-parent="#ordersAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($transaction as $order)
                                            <div class="col-md-4 mb-3">
                                                <div class="card bg-secondary text-white">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Order #{{ $order->id }}</h5>
                                                        <p class="card-text">User: {{ $order->user->name }}</p>
                                                          <p class="card-text">Phone: {{ $order->user->phone }}</p>
                                                        <p class="card-text">Amount: {{ $order->amount }}</p>
                                                        <p class="card-text">Status: {{ $order->status }}</p>
                                                        <p class="card-text">Payment Method: {{ $order->payment_method }}</p>
                                                        <h5 class="card-title mt-4">Address:</h5>
                                                        <p class="card-text">{{ $order->address->address }}</p>
                                                        <h5 class="card-title mt-4">Product Details</h5>
                                                        <p class="card-text">Product Name: <a target="_blank" class="text-white" href="/product/{{ $order->product->url }}">{{ $order->product->product_name }}</a></p>
                                                        @if($order->variant_id && $order->variant)
                                                        <h5 class="card-title mt-4">Variant Details</h5>
                                                        <p class="card-text">Variant Name: {{ $order->variant->variant }}</p>
                                                        @endif
                                                        <p class="card-text">Delivery Time: {{ $order->delivery_time }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        






        </div>
        <!-- Recent Sales End -->
        @include('admin.include.footer')
</body>

</html>