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
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Demo Enquiry Form Details</h6>
                        <!-- <a href="">Show All</a> -->
                    </div>

                    <div class="container">
                        <h1>Application Form Details</h1>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-secondary">{{ $applyForm->name }}</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Email:</strong> {{ $applyForm->email }}</p>
                                <p><strong>Mobile:</strong> {{ $applyForm->mobile }}</p>
                                <p><strong>Product_type:</strong> {{ $applyForm->product_type }}</p>
                                <p><strong>City:</strong> {{ $applyForm->city }}</p>
                                <p><strong>State:</strong> {{ $applyForm->state }}</p>
                                <p><strong>Date:</strong> {{ $applyForm->created_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>