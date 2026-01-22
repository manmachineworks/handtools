@if (session()->has('coupon_code'))
<h3 class="text-danger m-4">Coupon Applied Total INR: {{ number_format($discountedTotal, 2) }}</h3>
@else
<h3 class="text-danger m-4">Total Amount INR: {{ number_format($cartTotal, 2) }}</h3>
@endif

