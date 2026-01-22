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
            <div class="container m-4">

                <div class="container">
                    <h1>Edit Variants for Product: {{ $product->product_name }}</h1>
                    <div class="row">
                        <div class="col-md-12">
                            @if($variants->isEmpty())
                            <p>No variants available for this product.</p>
                            @else
                            @foreach($variants as $variant)
                            <div class="variant-group bg-light p-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 text-center my-4">
                                        <h2>Product Variant: {{ $loop->iteration }}</h2>
                                    </div>
                                </div>
                                <div class="row variant-input">
                                    <form action="{{ route('products.updateVariants', $product->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control variant-input-field" name="variants[{{ $variant->id }}][name]" value="{{ $variant->variant }}" placeholder="Variant Name" required>
                                                <lable class="text-white">Variant Name(1 Liter, Black, 15cm)</lable>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="variants[{{ $variant->id }}][mrp]" value="{{ $variant->mrp }}" placeholder="MRP" required>
                                                <lable class="text-white">MRP</lable>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="variants[{{ $variant->id }}][sale_price]" value="{{ $variant->sale_price }}" placeholder="Sale Price" required>
                                                <lable class="text-white">Sale Price</lable>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="variants[{{ $variant->id }}][sku_code]" value="{{ $variant->sku_code }}" placeholder="SKU Code" required>
                                                <lable class="text-white">SKU Code</lable>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <input type="text" class="form-control" name="variants[{{ $variant->id }}][v_name]" value="{{ $variant->varaint_name }}" placeholder="Varaint Name" required>
                                                <lable class="text-white">Variant Type</lable>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <input type="text" class="form-control" name="variants[{{ $variant->id }}][stock]" value="{{ $variant->stock }}" placeholder="Varaint Stock" required>
                                                <lable class="text-white">Stock</lable>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mt-4 text-center">Update Variants</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-5 mt-4 d-flex mx-4 my-4">
                                            @foreach($variant->variantImages as $image)
                                            <div class="input-group mx-4 my-4">
                                                <form action="{{ route('products.deleteVariantImage', $image->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <img src="{{ asset($image->image_url) }}" class="img-fluid" alt="Variant Image">
                                                    <button type="submit" class="btn btn-danger remove-image-btn mt-4">Remove</button>
                                                </form>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('products.updateVariantImages', $variant->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="variant-images">Update Images for Variant {{ $loop->iteration }}</label>
                                                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Update Images</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <form action="{{ route('products.deleteVariant', $variant->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mt-2">Delete Variant</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>


                </div>
            </div>




            <!-- Recent Sales End -->
            @include('admin.include.footer')

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




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
                $(document).ready(function() {
                    let variantIndex = 1;

                    // Add more variants
                    $('.add-variant-btn').on('click', function() {
                        const variantInputGroup = `
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
                    <input type="text" class="form-control" name="variants[${variantIndex}][v_name]" placeholder="SKU Code" required>
                </div>
                 <div class="col-md-3 mt-4">
                    <input type="text" class="form-control" name="variants[${variantIndex}][stock]" placeholder="Varaint Stock" required>
                  </div>
                <div class="col-md-6 mt-4">
                    <div class="input-group mx-4 my-4">
                        <input type="file" class="form-control variant-image" name="variants[${variantIndex}][images][0]" accept="image/*">
                        <button type="button" class="btn btn-success add-variant-image-btn" data-variant-index="${variantIndex}">Add More Images</button>
                    </div>
                </div>
            </div>`;
                        $('#variants-wrapper .variant-group').append(variantInputGroup);
                        variantIndex++;
                    });

                    // Add more images for variants
                    $(document).on('click', '.add-variant-image-btn', function() {
                        let variantIndex = $(this).data('variant-index');
                        let imageIndex = $(this).closest('.variant-input').find('.variant-image').length;

                        const imageInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control variant-image" name="variants[${variantIndex}][images][${imageIndex}]" accept="image/*">
                <button type="button" class="btn btn-danger remove-image-btn">Remove</button>
            </div>`;
                        $(this).closest('.variant-input').find('.mt-4').append(imageInput);
                    });

         

                });
            </script>
</body>

</html>