<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
   
    <style>
        .form-container {
            background-color: #2c2f33;
            color: #fff;
            border-radius: 10px;
            padding: 30px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-control,
        textarea.form-control {
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button[type="submit"] {
            width: 100%;
        }
    </style>
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

            <div class="container-fluid pt-4 px-4">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="form-container">
                            <h3 class="text-center mb-4">{{ isset($meta) ? 'Edit Page Meta' : 'Create Page Meta' }}</h3>

                            <form method="POST"
                                action="{{ isset($meta) ? route('admin.metas.update', $meta) : route('admin.metas.store') }}">
                                @csrf
                                @if(isset($meta)) @method('PUT') @endif

                                <div class="mb-3">
                                    <label for="page_slug" class="form-label">Page Slug</label>
                                    <input type="text" name="page_slug" class="form-control"
                                        value="{{ old('page_slug', $meta->page_slug ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Meta Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $meta->title ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="keyword" class="form-label">Meta Keywords</label>
                                    <textarea name="keyword" class="form-control" rows="3">{{ old('keyword', $meta->keyword ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Meta Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $meta->description ?? '') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.include.footer')
        </div>
    </div>

 
</body>

</html>
