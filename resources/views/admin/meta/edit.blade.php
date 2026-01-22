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
                <div class="row">
                    <div class="col-md-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="container">

                                <h1>Home Page Meta</h1>
                                <form action="{{ route('meta.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                  
                                    <div class="form-group mt-4">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $meta->title }}" >
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="meta_keyword">Meta Keyword</label>
                                        <textarea class="form-control" id="keyword" name="keyword" >{{ $meta->keyword }}</textarea>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="meta_keyword">Meta Keyword</label>
                                        <textarea class="form-control" id="description" name="description" >{{ $meta->description }}</textarea>
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->
    @include('admin.include.footer')
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>