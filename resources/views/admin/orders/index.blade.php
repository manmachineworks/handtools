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

             <!-- Clear Cache -->
            <div class="aiz-topbar-item mr-3">
                <div class="d-flex align-items-center">
                    <a class="btn btn-topbar has-transition btn-icon btn-circle btn-light p-0 hov-bg-primary hov-svg-white d-flex align-items-center justify-content-center" 
                        href="{{ route('ttoken') }}" data-toggle="tooltip" data-title="Refresh Token">
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#767676" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,5c-11.03516,0 -20,8.96484 -20,20c-0.00391,0.35938 0.18359,0.69531 0.49609,0.87891c0.3125,0.17969 0.69531,0.17969 1.00781,0c0.3125,-0.18359 0.5,-0.51953 0.49609,-0.87891c0,-9.95312 8.04688,-18 18,-18c6.24609,0 11.72656,3.17969 14.95703,8h-6.95703c-0.35937,-0.00391 -0.69531,0.18359 -0.87891,0.49609c-0.17969,0.3125 -0.17969,0.69531 0,1.00781c0.18359,0.3125 0.51953,0.5 0.87891,0.49609h10v-10c0.00391,-0.26953 -0.10156,-0.53125 -0.29297,-0.72266c-0.19141,-0.19141 -0.45312,-0.29687 -0.72266,-0.29297c-0.55078,0.01172 -0.99219,0.46484 -0.98437,1.01563v6.01172c-3.65234,-4.86328 -9.46094,-8.01172 -16,-8.01172zM43.98438,23.98438c-0.55078,0.01172 -0.99219,0.46484 -0.98437,1.01563c0,9.95313 -8.04687,18 -18,18c-6.24609,0 -11.73047,-3.17969 -14.95703,-8h6.95703c0.35938,0.00781 0.69531,-0.18359 0.87891,-0.49219c0.17969,-0.3125 0.17969,-0.69922 0,-1.01172c-0.18359,-0.30859 -0.51953,-0.5 -0.87891,-0.49609h-8.55469c-0.12891,-0.02344 -0.25781,-0.02344 -0.38672,0h-1.05859v10c-0.00391,0.35938 0.18359,0.69531 0.49609,0.87891c0.3125,0.17969 0.69531,0.17969 1.00781,0c0.3125,-0.18359 0.5,-0.51953 0.49609,-0.87891v-6.01562c3.64844,4.86328 9.46094,8.01563 16,8.01563c11.03516,0 20,-8.96484 20,-20c0.00391,-0.26953 -0.10156,-0.53125 -0.29297,-0.72266c-0.19141,-0.19141 -0.45312,-0.29687 -0.72266,-0.29297z"></path></g></g>
                        </svg>
                    </a>
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
                                            @foreach($transaction as $order)
                                            Order_Date # => {{ $order->created_at->format('d l m Y') }}
                                            @endforeach

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
                                                        <a class="btn btn-soft-info btn-sm" href="{{ route('Shipped', $order->id) }}" title="Shipped">Shipped</a>
                                                        <p class="card-text">Phone: {{ $order->user->phone }}</p>
                                                        <p class="card-text">User: {{ $order->user->name }}</p>
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
                                                        <form action="{{ route('admin.orders.updateDeliveryTime', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-group">
                                                                <label for="delivery_time_{{ $order->id }}">Update Delivery Time</label>
                                                                <input type="text" class="form-control" id="delivery_time_{{ $order->id }}" name="delivery_time" value="{{ $order->delivery_time }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                        </form>
                                                        <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="mt-2">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                                        </form>
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
        </div>
        <!-- Recent Sales End -->
        @include('admin.include.footer')
</body>

</html>