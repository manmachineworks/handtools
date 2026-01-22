<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->

        <!-- Spinner End -->

        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')
            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">

                    <div class="container">
                        <h1>Create Coupon</h1>

                        <form action="{{ route('coupons.store') }}" method="POST">
                            @csrf
                            <div class="form-group m-4">
                                <label for="coupon_code">Coupon Code</label>
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" required>
                            </div>

                            <div class="form-group m-4">
                                <label for="discount_percentage">Discount Percentage</label>
                                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" min="1" max="100" required>
                            </div>

                            <button type="submit" class="btn btn-success">Create Coupon</button>
                        </form>

                    </div>
                </div>
            </div>


            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>