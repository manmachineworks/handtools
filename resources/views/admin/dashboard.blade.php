

<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>

<style>
    #spinner {
    z-index: 1051;
    transition: opacity 0.5s ease;
}
#spinner.hide {
    opacity: 0;
    visibility: hidden;
}

.table thead th {
    vertical-align: middle;
    text-align: center;
}

.table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.05);
    transition: background-color 0.3s;
}

</style>
   <!-- Spinner Start -->
<div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Main Container -->
<div class="container-fluid position-relative d-flex p-0">
    @include('admin.include.sidebar')

    <!-- Content Start -->
    <div class="content">
        @include('admin.include.navbar')

        <!-- Dashboard Card -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary text-center text-white rounded shadow-sm p-4 mb-4">
                <h2 class="mb-0">Admin Dashboard</h2>
            </div>

            <!-- Recent Query Table -->
            <div class="bg-dark rounded p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-white mb-0">Recent Queries</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-white mb-0 align-middle">
                        <thead class="sticky-top bg-primary text-white">
                            <tr>
                                <th>S.no</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Product Type</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Date</th>
                                <th>Action</th>
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
                                <td>{{ $form->created_at->format('d M Y') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-light" href="{{ route('admin.apply.detail', $form->id) }}">
                                        Detail
                                    </a>
                                </td>
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
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        const spinner = document.getElementById('spinner');
        spinner.classList.remove('show');
        spinner.classList.add('hide');
    });
</script>

            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>