<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <div class="container-fluid position-relative d-flex p-0">
        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')

            <div class="container-fluid pt-4 px-5">
                <div class="section-panel">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="page-title mb-1">Admin Dashboard</h1>
                            <p class="text-muted">
                                Track incoming enquiries, respond faster, and keep the catalog up to date from one central panel.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="/admin/apply" class="btn btn-outline-light">
                                <i class="fas fa-tasks me-2"></i>View all enquiries
                            </a>
                        </div>
                    </div>
                </div>

                <div class="section-panel mt-4">
                    <div class="stat-grid">
                        <div class="stat-card">
                            <h4>{{ $applyForms->total() }}</h4>
                            <span>Total enquiries logged</span>
                        </div>
                        <div class="stat-card">
                            <h4>{{ $applyForms->count() }}</h4>
                            <span>Currently visible</span>
                        </div>
                        <div class="stat-card">
                            <h4>{{ now()->format('d M') }}</h4>
                            <span>Last refreshed</span>
                        </div>
                        <div class="stat-card">
                            <h4>+33%</h4>
                            <span>vs. last week</span>
                        </div>
                    </div>
                </div>

                <div class="section-panel mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 text-white">Recent Queries</h5>
                        <span class="badge bg-orange text-uppercase">Live</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover text-white mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Product Type</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
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
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-light"
                                                href="{{ route('admin.apply.detail', $form->id) }}">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3 text-muted">
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
            if (spinner) {
                spinner.classList.remove('show');
                spinner.classList.add('hide');
            }
        });
    </script>

    <!-- Footer -->
    @include('admin.include.footer')
</body>

</html>
