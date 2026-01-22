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
                        <h6 class="mb-0">Demo Enquiry Form</h6>
                        <!-- <a href="">Show All</a> -->
                    </div>

                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">S.no</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Product Type</th>
                                    <th scope="col">City</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applyForms as $form)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $form->name }}</td>
                                    <td>{{ $form->email }}</td>
                                    <td>{{ $form->mobile }}</td>
                                    <td>{{ $form->product_type }}</td>
                                    <td>{{ $form->city }}</td>
                                    <td>{{ $form->state }}</td>
                                    <td>{{ $form->created_at }}</td>
                                    <td><a class="btn btn-sm btn-primary" href="{{ route('admin.demo.detail', $form->id) }}">Detail</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $applyForms->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>