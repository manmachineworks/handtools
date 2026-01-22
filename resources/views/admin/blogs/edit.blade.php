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
                    <h1>Edit Blog</h1>
                 
                    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-4">
                            <label for="blog_title">Title</label>
                            <input type="text" class="form-control" id="blog_title" name="blog_title" value="{{ $blog->blog_title }}" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" id="url" name="url" value="{{ $blog->url }}" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $blog->meta_title }}" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="meta_keyword">Meta Keyword</label>
                            <textarea class="form-control" id="meta_keyword" name="meta_keyword" required>{{ $blog->meta_keyword }}</textarea>
                        </div>
                        <div class="form-group mt-4">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" required>{{ $blog->meta_description }}</textarea>
                        </div>
                        <div class="form-group mt-4">
                            <label for="meta_canonical">Blog Meta Canonical</label>
                            <input type="text" class="form-control" id="meta_canonical" name="meta_canonical" value="{{ $blog->meta_canonical }}">
                        </div>
                        <div class="form-group mt-4">
                            <label for="meta_alternate">Blog Meta Alternate</label>
                            <input type="text" class="form-control" id="meta_alternate" name="meta_alternate" value="{{ $blog->meta_alternate }}">
                        </div>
                        <div class="form-group mt-4">
                            <label for="blog_image">Blog Image</label>
                            <input type="file" class="form-control" id="blog_image" name="blog_image">
                            @if ($blog->blog_image)
                            <img src="/{{ $blog->blog_image }}" height="200px" />
                            @endif
                        </div>
                        <div class="form-group mt-4">
                            <label for="blog_image_2">Blog Image 2</label>
                            <input type="file" class="form-control" id="blog_image_2" name="blog_image_2">
                            @if ($blog->blog_image_2)
                            <img src="/{{ $blog->blog_image_2 }}" height="200px" />
                            @endif
                        </div>
                        <div class="form-group mt-4">
                            <label for="blog_detail">Blog Detail</label>
                            <textarea class="form-control" id="editor" name="blog_detail">{{ $blog->blog_detail }}</textarea>
                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
            <!-- Recent Sales End -->
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
            @include('admin.include.footer')
</body>

</html>