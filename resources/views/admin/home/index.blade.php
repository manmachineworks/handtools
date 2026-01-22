<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.css">

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
                <div class="container">
                    <h1>Franchise Page</h1>
                    <div class="container">
                        <h2>Update Franchise Information</h2>

                        <!-- Display success message if available -->
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('home.update') }}" method="POST">
                            @csrf

                            <!-- Title 1 -->
                            <div class="form-group mb-4">
                                <label for="title_1">Title 1</label>
                                <input type="text" class="form-control" id="title_1" name="title_1" value="{{ $homepage->title_1 }}" required>
                            </div>

                            <!-- Content 1 -->
                            <div class="form-group mb-4">
                                <label for="content_1">Content 1</label>
                                <textarea class="form-control" id="content_1" name="content_1">{{ $homepage->content_1 }}</textarea>
                            </div>

                            <!-- Title 2 -->
                            <div class="form-group mb-4">
                                <label for="title_2">Title 2</label>
                                <input type="text" class="form-control" id="title_2" name="title_2" value="{{ $homepage->title_2 }}" required>
                            </div>

                            <!-- Content 2 -->
                            <div class="form-group mb-4">
                                <label for="content_2">Content 2</label>
                                <textarea class="form-control" id="content_2" name="content_2">{{ $homepage->content_2 }}</textarea>
                            </div>

                            
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Home</button>
                        </form>



                       
                    </div>
                </div>
                <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace('content_1');
                    CKEDITOR.replace('content_2');
                </script>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .catch(error => {
                            console.error(error);
                        });
                </script>
                <!-- Recent Sales End -->
                @include('admin.include.footer')
</body>

</html>