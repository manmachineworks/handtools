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
                    <div class="col-md-8">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="container">
                                <h1>Create Subcategory</h1>
                                <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class=" form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <label for="name">Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" required>
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" >
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keyword">Meta Keyword</label>
                                            <textarea class="form-control" id="meta_keyword" name="meta_keyword" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="subcat_image">Category Image</label>
                                            <input type="file" class="form-control" id="subcat_image" name="subcat_image">
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="subcat_text">Categorey text</label>
                                            <textarea class="form-control" id="editor" name="subcat_text"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Create</button>
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