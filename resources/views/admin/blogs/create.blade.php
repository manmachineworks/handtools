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
                    <h1>Create Blog</h1>
                    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="blog_title">Title</label>
                            <input type="text" class="form-control" id="blog_title" name="blog_title" required>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" id="url" name="url" required>
                        </div>
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" required>
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword">Meta Keyword</label>
                            <textarea class="form-control" id="meta_keyword" name="meta_keyword" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_canonical">Meta Canonical</label>
                            <input type="text" class="form-control" id="meta_canonical" name="meta_canonical" required>
                        </div>
                        <div class="form-group">
                            <label for="meta_alternate">Meta Alternate</label>
                            <input type="text" class="form-control" id="meta_alternate" name="meta_alternate" required>
                        </div>
                        <div class="form-group">
                            <label for="blog_image">Blog Image</label>
                            <input type="file" class="form-control" id="blog_image" name="blog_image">
                        </div>
                        <div class="form-group">
                            <label for="blog_image_2">Blog Image 2</label>
                            <input type="file" class="form-control" id="blog_image_2" name="blog_image_2">
                        </div>


                        <div class="form-group mt-4">
                            <label for="blog_detail">Blog Detail</label>
                            <textarea class="form-control" id="editor" name="blog_detail"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
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
            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>