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
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Add Product') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.store_product') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 form-group mt-4">
                                            <label for="product_name">{{ __('Product Name') }}</label>
                                            <input type="text"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                id="product_name" name="product_name" value="{{ old('product_name') }}"
                                                required>
                                            @error('product_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5 form-group mt-4">
                                            <label for="code">{{ __('Code') }}</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                id="code" name="code" value="{{ old('code') }}" required>
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- <div class="form-group col-md-5 mt-4">
                                            <label for="variant">{{ __('Variant') }}</label>
                                            <input type="text" class="form-control @error('variant') is-invalid @enderror" id="variant" name="variant" value="{{ old('variant') }}">
                                            @error('variant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div> -->

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="mrp">{{ __('MRP') }}</label>
                                            <input type="number" class="form-control @error('mrp') is-invalid @enderror"
                                                id="mrp" name="mrp" value="{{ old('mrp') }}" required>
                                            @error('mrp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="sale_price">{{ __('Sale Price') }}</label>
                                            <input type="number"
                                                class="form-control @error('sale_price') is-invalid @enderror"
                                                id="sale_price" name="sale_price" value="{{ old('sale_price') }}"
                                                required>
                                            @error('sale_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="sku_code">{{ __('SKU Code') }}</label>
                                            <input type="text"
                                                class="form-control @error('sku_code') is-invalid @enderror"
                                                id="sku_code" name="sku_code" value="{{ old('sku_code') }}" required>
                                            @error('sku_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="stock">{{ __('stock') }}</label>
                                            <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                                id="stock" name="stock" value="{{ old('stock') }}" required>
                                            @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="meta_key">{{ __('meta_key') }}</label>
                                            <input type="text"
                                                class="form-control @error('meta_key') is-invalid @enderror"
                                                id="meta_key" name="meta_key" value="{{ old('meta_key') }}" required>
                                            @error('meta_key')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="meta_desc">{{ __('meta_desc') }}</label>
                                            <input type="text"
                                                class="form-control @error('meta_desc') is-invalid @enderror"
                                                id="meta_desc" name="meta_desc" value="{{ old('meta_desc') }}" required>
                                            @error('meta_desc')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="title">{{ __('title') }}</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="length">{{ __('length') }}</label>
                                            <input type="text"
                                                class="form-control @error('length') is-invalid @enderror" id="length"
                                                name="length" value="{{ old('length') }}" required>
                                            @error('length')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-5 mt-4">
                                            <label for="breadth">{{ __('breadth') }}</label>
                                            <input type="text"
                                                class="form-control @error('breadth') is-invalid @enderror" id="breadth"
                                                name="breadth" value="{{ old('breadth') }}" required>
                                            @error('breadth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-5 mt-4">
                                            <label for="height">{{ __('height') }}</label>
                                            <input type="text"
                                                class="form-control @error('height') is-invalid @enderror" id="height"
                                                name="height" value="{{ old('height') }}" required>
                                            @error('height')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="weight">{{ __('weight') }}</label>
                                            <input type="text"
                                                class="form-control @error('weight') is-invalid @enderror" id="weight"
                                                name="weight" value="{{ old('weight') }}" required>
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-5 mt-4">
                                            <label for="url">{{ __('url') }}</label>
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                id="url" name="url" value="{{ old('url') }}" required>
                                            @error('url')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-10 mt-4" id="variants-wrapper">
                                            <label for="variants my-1">{{ __('Product Variants') }}</label>
                                            <div class="variant-group">
                                                <div class="row">
                                                    <div class="col-md-12 text-center my-4"> Product Variant : 1</div>
                                                </div>
                                                <div class="row variant-input">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control variant-input-field"
                                                            name="variants[0][name]" placeholder="Variant Name"
                                                            required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="variants[0][mrp]"
                                                            placeholder="MRP" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control"
                                                            name="variants[0][sale_price]" placeholder="Sale Price"
                                                            required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control"
                                                            name="variants[0][sku_code]" placeholder="SKU Code"
                                                            required>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <input type="text" class="form-control"
                                                            name="variants[0][v_name]" placeholder="Variant Type"
                                                            required>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <input type="text" class="form-control"
                                                            name="variants[0][stock]" placeholder="Variant Stock"
                                                            required>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control variant-image"
                                                                name="variants[0][images][0]" accept="image/*">
                                                            <button type="button"
                                                                class="btn btn-success add-variant-image-btn"
                                                                data-variant-index="0">Add More Images</button>
                                                            <button type="button"
                                                                class="btn btn-danger remove-variant-btn ml-4">Remove
                                                                Variant</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success add-variant-btn mt-3">Add More
                                                Variants</button>
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="category">{{ __('Category') }}</label>
                                            <select class="form-control @error('category_id') is-invalid @enderror"
                                                id="category" name="category_id">
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
                                            <select class="form-control @error('subcategory_id') is-invalid @enderror"
                                                id="subcategory" name="subcategory_id">
                                                <option value="">{{ __('Select Subcategory') }}</option>
                                                <!-- Options will be populated dynamically via JavaScript -->
                                            </select>
                                            @error('subcategory_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-5 mt-4">
                                            <label for="brand_id">{{ __('Brand') }}</label>
                                            <select class="form-control @error('brand_id') is-invalid @enderror"
                                                id="brand_id" name="brand_id" required>
                                                <option value="">{{ __('Select Brand') }}</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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

                                        <div class="form-group col-md-10 mt-4" id="image-wrapper">
                                            <label for="images">{{ __('Product Images') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="file"
                                                    class="form-control @error('images') is-invalid @enderror"
                                                    id="images" name="images[]">
                                                <button type="button" class="btn btn-success add-image-btn"
                                                    id="add-image-btn">Add More Images</button>
                                            </div>
                                            @error('images')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-10 mt-4">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="editor" name="description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4 mt-4">
                                            <div class="form-check">
                                                <input type="hidden" name="today_hot_deals" value="0">
                                                <input type="checkbox" class="form-check-input" id="today_hot_deals"
                                                    name="today_hot_deals" value="1">
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
                                                <input type="checkbox" class="form-check-input" id="best_seller"
                                                    name="best_seller" value="1">
                                                <label class="form-check-label"
                                                    for="best_seller">{{ __('best_seller') }}</label>
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
                                                    name="featured_products" value="1">
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


            <script>
                $(document).ready(function () {
                    let variantIndex = 1;

                    // Add more variants
                    $('.add-variant-btn').on('click', function () {
                        const variantInputGroup = `
                <div class="variant-group">
                    <div class="row">
                        <div class="col-md-12 text-center my-4">Product Variant : ${variantIndex + 1}</div>
                    </div>
                    <div class="row variant-input">
                        <div class="col-md-3">
                            <input type="text" class="form-control variant-input-field" name="variants[${variantIndex}][name]" placeholder="Variant Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="variants[${variantIndex}][mrp]" placeholder="MRP" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="variants[${variantIndex}][sale_price]" placeholder="Sale Price" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="variants[${variantIndex}][sku_code]" placeholder="SKU Code" required>
                        </div>
                        <div class="col-md-3 mt-4">
                            <input type="text" class="form-control" name="variants[${variantIndex}][v_name]" placeholder="Variant Type" required>
                        </div>
                        <div class="col-md-3 mt-4">
                            <input type="text" class="form-control" name="variants[${variantIndex}][stock]" placeholder="Variant Stock" required>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control variant-image" name="variants[${variantIndex}][images][0]" accept="image/*">
                                <button type="button" class="btn btn-success add-variant-image-btn" data-variant-index="${variantIndex}">Add More Images</button>
                                <button type="button" class="btn btn-danger remove-variant-btn">Remove Variant</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                        $('#variants-wrapper').append(variantInputGroup);
                        variantIndex++;
                    });

                    // Add more images for variants
                    $(document).on('click', '.add-variant-image-btn', function () {
                        let variantIndex = $(this).data('variant-index');
                        let imageIndex = $(this).closest('.variant-input').find('.variant-image').length;

                        const imageInput = `
                <div class="input-group mb-3">
                    <input type="file" class="form-control variant-image" name="variants[${variantIndex}][images][${imageIndex}]" accept="image/*">
                    <button type="button" class="btn btn-danger remove-image-btn">Remove</button>
                </div>`;
                        $(this).closest('.variant-input').find('.col-md-12.mt-4').append(imageInput);
                    });

                    // Remove image input for variants
                    $(document).on('click', '.remove-image-btn', function () {
                        $(this).closest('.input-group').remove();
                    });

                    // Remove variant group
                    $(document).on('click', '.remove-variant-btn', function () {
                        $(this).closest('.variant-group').remove();
                        variantIndex--;
                    });


                });

                $(document).ready(function () {
                    let imageIndex = 1;

                    // Add more images
                    $('#add-image-btn').on('click', function () {
                        const imageInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="images[]" id="image_${imageIndex}">
                <button type="button" class="btn btn-danger remove-image-btn">Remove</button>
            </div>`;
                        $('#image-wrapper').append(imageInput);
                        imageIndex++;
                    });

                    // Remove image input
                    $(document).on('click', '.remove-image-btn', function () {
                        $(this).closest('.input-group').remove();
                    });
                });
            </script>
</body>