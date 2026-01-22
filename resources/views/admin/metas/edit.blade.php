<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
  
    <style>
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 0.6rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            background-color: #fff;
        }

        button[type="submit"] {
            margin-top: 1rem;
            padding: 0.5rem 1.5rem;
            border: none;
            background-color: #0d6efd;
            color: white;
            border-radius: 0.3rem;
        }

        
    </style>
</head>

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

            <!-- Meta Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="bg-secondary rounded p-4">
                            <h2 class="mb-4 text-center">Edit Home Page Meta</h2>

                            <form method="POST" action="{{ isset($metas) ? route('admin.metas.update', $metas) : route('admin.metas.store') }}">
                                @csrf
                                @if(isset($metas)) @method('PUT') @endif

                                <div class="form-group">
                                    <label for="page_slug">Page Slug</label>
                                    <input type="text" name="page_slug" id="page_slug" value="{{ old('page_slug', $metas->page_slug ?? '') }}" placeholder="Page Slug">
                                </div>

                                <div class="form-group">
                                    <label for="title">Meta Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $metas->title ?? '') }}" placeholder="Meta Title">
                                </div>

                                <div class="form-group">
                                    <label for="keyword">Meta Keywords</label>
                                    <textarea name="keyword" id="keyword">{{ old('keyword', $metas->keyword ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="description">Meta Description</label>
                                    <textarea name="description" id="description">{{ old('description', $metas->description ?? '') }}</textarea>
                                </div>

                                <button type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Meta Form End -->
        </div>
    </div>

    @include('admin.include.footer')

   
</body>

</html>
