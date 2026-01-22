<div class="mini_cart_wrapper">
    <a href="javascript:void(0)">
        <i class="icon-shopping-bag2"></i>
        <span class="cart_price">
            INR
            @if (session()->has('coupon_code'))
            {{ number_format($discountedTotal, 2) }}
            @else
            {{ number_format($cartTotal, 2) }}
            @endif
            <i class="ion-ios-arrow-down"></i>
        </span>

        <span class="cart_count">{{ $cartCount }}</span>
    </a>
    <!--mini cart-->
    <div class="mini_cart">
        <div class="mini_cart_inner">
            <div class="cart_close">
                <div class="cart_text">
                    <h3>Cart</h3>
                </div>
                <div class="mini_cart_close">
                    <a href="javascript:void(0)"><i class="icon-x"></i></a>
                </div>
            </div>

            @forelse($cart as $item)
            <div class="cart_item">
                <div class="cart_img">
                    <a href="{{ route('product.show', $item->product ? $item->product->url : '#') }}">
                        <img src="{{ asset(($item->variant && $item->variant->variantImages->isNotEmpty()) ? $item->variant->variantImages->first()->image_url : ($item->product ? $item->product->images->first()->image_url : 'default-image.jpg')) }}" alt="{{ $item->product ? $item->product->product_name : 'No Product' }}">
                    </a>
                </div>
                <div class="cart_info">
                    <a href="{{ route('product.show', $item->product ? $item->product->url : '#') }}">{{ $item->product ? $item->product->product_name : 'No Product' }}</a>

                    <p>Qty: {{ $item->quantity }} X
                        @if (session()->has('coupon_code') && isset($item->variant))
                        <span>INR {{ number_format(($item->variant->sale_price * (1 - session('discount_percentage') / 100)), 2) }}</span>
                        @else
                        <span>INR {{ number_format($item->variant ? $item->variant->sale_price : $item->product->sale_price, 2) }}</span>
                        @endif
                    </p>
                </div>
                <div class="cart_remove">
                    <a href="{{ $item->id ? route('cart.delete', $item->id) : '#' }}"><i class="ion-android-close"></i></a>
                </div>
            </div>

            @empty
            <p>Your cart is empty.</p>
            @endforelse
            @if (session()->has('coupon_code'))
            <h4 class="text-danger m-4">Total Amount INR: {{ number_format($cartTotal, 2) }}</h4>
            <h4 class="text-danger m-4">Coupon Applied Total INR: {{ number_format($discountedTotal, 2) }}</h4>
            @else
            <h4 class="text-danger m-4">Total Amount INR: {{ number_format($cartTotal, 2) }}</h4>
            @endif

            <!-- <div class="mini_cart_table">
                <div class="cart_total">
                    <span>Sub total:</span>
                    <span class="price">INR {{ number_format($cartTotal, 2) }}</span>
                </div>
    
            </div> -->
        </div>
        <div class="mini_cart_footer">
            <div class="cart_button">
                <a href="{{ route('cart.index') }}">View cart</a>
            </div>
            <div class="cart_button">
                <a class="active" href="{{ route('checkout.index') }}">Checkout</a>
            </div>
        </div>
    </div>
    <!--mini cart end-->
</div>