<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

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
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Add Product') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.store_product') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 form-group mt-4">
                                            <label for="product_name">{{ __('Product Name') }}</label>
                                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                                            @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5 form-group mt-4">
                                            <label for="code">{{ __('Code') }}</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                                            @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="variant">{{ __('Variant') }}</label>
                                            <input type="text" class="form-control @error('variant') is-invalid @enderror" id="variant" name="variant" value="{{ old('variant') }}">
                                            @error('variant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="mrp">{{ __('MRP') }}</label>
                                            <input type="number" class="form-control @error('mrp') is-invalid @enderror" id="mrp" name="mrp" value="{{ old('mrp') }}" required>
                                            @error('mrp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="sale_price">{{ __('Sale Price') }}</label>
                                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" required>
                                            @error('sale_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="sku_code">{{ __('SKU Code') }}</label>
                                            <input type="text" class="form-control @error('sku_code') is-invalid @enderror" id="sku_code" name="sku_code" value="{{ old('sku_code') }}" required>
                                            @error('sku_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="meta_key">{{ __('meta_key') }}</label>
                                            <input type="text" class="form-control @error('meta_key') is-invalid @enderror" id="meta_key" name="meta_key" value="{{ old('meta_key') }}" required>
                                            @error('meta_key')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="meta_desc">{{ __('meta_desc') }}</label>
                                            <input type="text" class="form-control @error('meta_desc') is-invalid @enderror" id="meta_desc" name="meta_desc" value="{{ old('meta_desc') }}" required>
                                            @error('meta_desc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="title">{{ __('title') }}</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="url">{{ __('url') }}</label>
                                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url') }}" required>
                                            @error('url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="category">{{ __('Category') }}</label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" id="category" name="category_id">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="subcategory">{{ __('Subcategory') }}</label>
                                            <select class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory" name="subcategory_id">
                                                <option value="">{{ __('Select Subcategory') }}</option>
                                                <!-- Options will be populated dynamically via JavaScript -->
                                            </select>
                                            @error('subcategory_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-10 mt-4" id="image-wrapper">
                                            <label for="images">{{ __('Product Images') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]">
                                                <button type="button" class="btn btn-success add-image-btn">Add More Images</button>
                                            </div>
                                            @error('images')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-10 mt-4">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">
                                        {{ __('Add Product') }}
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Recent Sales End -->
            @include('admin.include.footer')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#category').on('change', function() {
                        var categoryId = $(this).val();
                        if (categoryId) {
                            $.ajax({
                                url: '/admin/get-subcategories/' + categoryId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                                    $.each(data, function(key, value) {
                                        $('#subcategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching subcategories:', error);
                                }
                            });
                        } else {
                            $('#subcategory').empty();
                        }
                    });
                });
            </script>


            <script>
                $(document).ready(function() {
                    let imageIndex = 1;
                    $('.add-image-btn').on('click', function() {
                        imageIndex++;
                        const imageInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="images[]" id="image_${imageIndex}">
                <button type="button" class="btn btn-danger remove-image-btn">Remove</button>
            </div>`;
                        $('#image-wrapper').append(imageInput);
                    });

                    $(document).on('click', '.remove-image-btn', function() {
                        $(this).closest('.input-group').remove();
                    });
                });
            </script>

</body>

</html>