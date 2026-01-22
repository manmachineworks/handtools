<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.css">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')

            <!-- Page Content -->
            <div class="container-fluid pt-4 px-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Update Home Page Information</h4>
                            </div>
                            <div class="card-body p-4">
                                <!-- Success message -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> 
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('home_content.store') }}" method="POST">
                                    @csrf

                                    <!-- Title -->
                                    <div class="mb-4">
                                        <label for="title_1" class="form-label fw-semibold">Title</label>
                                        <input type="text" class="form-control shadow-sm" id="title_1" name="title_1"
                                            value="{{ $page->title }}" placeholder="Enter page title" required>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-4">
                                        <label for="content_1" class="form-label fw-semibold">Content</label>
                                        <textarea class="form-control shadow-sm" id="content_1" name="content_1" rows="6"
                                            placeholder="Enter page content">{{ $page->content }}</textarea>
                                    </div>

                                    <!-- Submit -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="bi bi-save me-1"></i> Update Content
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.include.footer')
        </div>
        <!-- Content End -->
    </div>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content_1');
    </script>
</body>

</html>
