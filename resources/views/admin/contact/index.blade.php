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
                        <h6 class="mb-0">Contact Enquiry Form</h6>
                        <!-- <a href="">Show All</a> -->
                    </div>

                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contact as $query)
                                <tr>


                                    <td>{{ $query->name }}</td>
                                    <td>{{ $query->email }}</td>
                                    <td>{{ $query->subject }}</td>
                                    <td>{{ $query->message }}</td>

                                    <td>{{ $query->created_at }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>