<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.css">
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    @include('admin.include.sidebar')

    <div class="content">
        @include('admin.include.navbar')

        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-secondary text-white rounded p-4">
                        <h2>Create Brand</h2>
                        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
                                @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="image">Logo/Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('brands.index') }}" class="btn btn-light ms-2">Cancel</a>
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
