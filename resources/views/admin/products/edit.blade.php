<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.css">

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
            <!-- Recent Sales Start -->
            <div class="container bg-white mb-4">
                <h1>Edit Product</h1>
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-5 form-group mt-4">
                            <label for="product_name">{{ __('Product Name') }}</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                id="product_name" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}" required>
                            @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Product Code -->
                        <div class="col-md-5 form-group mt-4">
                            <label for="code">{{ __('Product Code') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code', $product->code) }}" required>

                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- MRP -->
                        <div class="col-md-5 form-group mt-4">
                            <label for="mrp">{{ __('MRP') }}</label>
                            <input type="number" step="0.01" class="form-control @error('mrp') is-invalid @enderror"
                                id="mrp" name="mrp" value="{{ old('mrp', $product->mrp) }}" required>
                            @error('mrp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <!-- Sale Price -->
                        <div class="col-md-5 form-group mt-4">
                            <label for="sale_price">{{ __('Sale Price') }}</label>
                            <input type="number" step="0.01"
                                class="form-control @error('sale_price') is-invalid @enderror" id="sale_price"
                                name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" required>
                            @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- SKU Code -->
                        <div class="col-md-5 form-group mt-4">
                            <label for="sku_code">{{ __('SKU Code') }}</label>
                            <input type="text" class="form-control @error('sku_code') is-invalid @enderror"
                                id="sku_code" name="sku_code" value="{{ old('sku_code', $product->sku_code) }}"
                                required>
                            @error('sku_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="form-group col-md-5 mt-4">
                            <label for="stock">{{ __('stock') }}</label>
                            <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock"
                                name="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="meta_key">{{ __('meta_key') }}</label>
                            <input type="text" class="form-control @error('meta_key') is-invalid @enderror"
                                id="meta_key" name="meta_key" value="{{ old('meta_key', $product->meta_key) }}"
                                required>
                            @error('meta_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="meta_desc">{{ __('meta_desc') }}</label>
                            <input type="text" class="form-control @error('meta_desc') is-invalid @enderror"
                                id="meta_desc" name="meta_desc" value="{{ old('meta_desc', $product->meta_desc) }}"
                                required>
                            @error('meta_desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="title">{{ __('title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $product->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="length">{{ __('length') }}</label>
                            <input type="text" class="form-control @error('length') is-invalid @enderror" id="length"
                                name="length" value="{{ old('length', $product->length) }}" required>
                            @error('length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 mt-4">
                            <label for="breadth">{{ __('breadth') }}</label>
                            <input type="text" class="form-control @error('breadth') is-invalid @enderror" id="breadth"
                                name="breadth" value="{{ old('breadth', $product->breadth) }}" required>
                            @error('breadth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 mt-4">
                            <label for="height">{{ __('height') }}</label>
                            <input type="text" class="form-control @error('height') is-invalid @enderror" id="height"
                                name="height" value="{{ old('height', $product->height) }}" required>
                            @error('height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="weight">{{ __('weight') }}</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight', $product->weight) }}" required>
                            @error('weight')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="url">{{ __('url') }}</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="url"
                                name="url" value="{{ old('url', $product->url) }}" required>
                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="container">
                                    <a href="{{ route('products.add_Variants', $product->id) }}"
                                        class="btn btn-success mt-3" target="_blank">Add Product Variants</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container">
                                    <a href="{{ route('products.editVariants', $product->id) }}"
                                        class="btn btn-success mt-3" target="_blank">Edit Product Variants</a>
                                </div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="form-group col-md-5 mt-4">
                            <label for="category">{{ __('Category') }}</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category"
                                name="category_id" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div class="form-group col-md-5 mt-4">
                            <label for="subcategory">{{ __('Subcategory') }}</label>
                            <select class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory"
                                name="subcategory_id" required>
                                <option value="">{{ __('Select Subcategory') }}</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->id == $product->subcategory_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mt-4">
                            <label for="brand_id">{{ __('Brand') }}</label>
                            <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id"
                                name="brand_id" required>
                                <option value="">{{ __('Select Brand') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                        {{ $brand->name }} {{ $brand->status ? '' : '(Inactive)' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-md-10 form-group mt-4">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="editor"
                                name="description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Display Existing Images -->

                        <h3>Existing Images</h3>
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-3">
                                    <img src="{{ asset('/' . $image->image_url) }}" class="img-fluid" alt="Product Image">
                                    <button type="button" class="btn btn-danger mt-2 delete-image"
                                        data-id="{{ $image->id }}">Delete</button>
                                    <input hidden type="file" class="form-control mt-2 update-image"
                                        name="update_images[{{ $image->id }}]">
                                </div>
                            @endforeach
                        </div>

                        <!-- Add New Images Section -->
                        <div class="form-group col-md-12 mt-4" id="image-wrapper">
                            <label for="images">{{ __('Product Images') }}</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control @error('images') is-invalid @enderror"
                                    id="images" name="new_images[]">
                                <button type="button" class="btn btn-success add-image-btn">Add More Images</button>
                            </div>
                            @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 mt-4">
                            <div class="form-check">
                                <input type="hidden" name="today_hot_deals" value="0">
                                <input type="checkbox" class="form-check-input" id="today_hot_deals"
                                    name="today_hot_deals" value="1" {{ $product->today_hot_deals ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="today_hot_deals">{{ __('today_hot_deals') }}</label>
                                @error('today_hot_deals')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4 mt-4">
                            <div class="form-check">
                                <input type="hidden" name="best_seller" value="0">
                                <input type="checkbox" class="form-check-input" id="best_seller" name="best_seller"
                                    value="1" {{ $product->best_seller ? 'checked' : '' }}>
                                <label class="form-check-label" for="best_seller">{{ __('best_seller') }}</label>
                                @error('best_seller')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4 mt-4">
                            <div class="form-check">
                                <input type="hidden" name="featured_products" value="0">
                                <input type="checkbox" class="form-check-input" id="featured_products"
                                    name="featured_products" value="1" {{ $product->featured_products ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="featured_products">{{ __('featured_products') }}</label>
                                @error('featured_products')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <button type="submit" class="btn btn-primary my-4">
                        {{ __('Update Product') }}
                    </button>
                </form>
            </div>


            <!-- Recent Sales End -->
            @include('admin.include.footer')

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#category').on('change', function () {
                        var categoryId = $(this).val();
                        if (categoryId) {
                            $.ajax({
                                url: '/admin/get-subcategories/' + categoryId,
                                type: 'GET',
                                dataType: 'json',
                                success: function (data) {
                                    $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                                    $.each(data, function (key, value) {
                                        $('#subcategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error fetching subcategories:', error);
                                }
                            });
                        } else {
                            $('#subcategory').empty();
                        }
                    });

                    // Pre-select the subcategory if the category is already selected
                    var selectedCategoryId = $('#category').val();
                    var selectedSubcategoryId = "{{ $product->subcategory_id }}";
                    if (selectedCategoryId) {
                        $.ajax({
                            url: '/admin/get-subcategories/' + selectedCategoryId,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                                $.each(data, function (key, value) {
                                    $('#subcategory').append('<option value="' + value.id + '"' + (value.id == selectedSubcategoryId ? ' selected' : '') + '>' + value.name + '</option>');
                                });
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching subcategories:', error);
                            }
                        });
                    }
                });
            </script>

            <script>
                $(document).ready(function () {
                    let imageIndex = 1;
                    $('.add-image-btn').on('click', function () {
                        imageIndex++;
                        const imageInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="new_images[]" id="image_${imageIndex}">
                <button type="button" class="btn btn-danger remove-image-btn">Remove</button>
            </div>`;
                        $('#image-wrapper').append(imageInput);
                    });

                    $(document).on('click', '.remove-image-btn', function () {
                        $(this).closest('.input-group').remove();
                    });

                    // Handle image deletion
                    $('.delete-image').on('click', function () {
                        var imageId = $(this).data('id');
                        var deleteUrl = "{{ route('images.destroy', ':id') }}".replace(':id', imageId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (result) {
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error('Error deleting image:', error);
                            }
                        });
                    });
                });
            </script>

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