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

                <div class="container bg-light p-4">
                    <h1>Add More Variants for Product: {{ $product->product_name }}</h1>
                    <form action="{{ route('products.addMoreVariants', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-10 mt-4" id="variants-wrapper">
                            <label for="variants my-1">{{ __('Product Variants') }}</label>
                            <div class="variant-group">
                                <div class="row">
                                    <div class="col-md-12 text-center my-4"> Product Variant : 1</div>
                                </div>
                                <div class="row variant-input">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control variant-input-field" name="variants[0][name]" placeholder="Variant Variation (1 Liter, Black, Blue)" required>
                                        <lable class="text-white">(1 Liter, Black, 15cm)</lable>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="variants[0][mrp]" placeholder="MRP" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="variants[0][sale_price]" placeholder="Sale Price" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="variants[0][sku_code]" placeholder="SKU Code" required>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <!-- <input type="text" class="form-control" name="variants[0][v_name]" placeholder="Variant Type" required> -->
                                        <textarea type="text" class="form-control" name="variants[0][v_name]" row="4" placeholder="Variant Type" required></textarea>
                                        <lable class="text-white">(color, liter, size, description)(brack line to use _ )</lable>
                                    </div>
                                    
                                    <div class="col-md-3 mt-4">
                                        <input type="text" class="form-control" name="variants[0][stock]" placeholder="Stock" required>

                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control variant-image" name="variants[0][images][0]" accept="image/*">
                                            <button type="button" class="btn btn-success add-variant-image-btn" data-variant-index="0">Add More Images</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right mt-4">
                                        <button type="button" class="btn btn-danger remove-variant-btn">Remove Variant</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success add-variant-btn mt-3">Add More Variants</button>
                           
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger mx-4 my-4">Add Variant</button>
                        </div>
                    </form>
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
                    <input type="text" class="form-control" name="variants[${variantIndex}][stock]" placeholder="Varaint Stock" required>
                  </div>
                <div class="col-md-6 mt-4">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control variant-image" name="variants[${variantIndex}][images][0]" accept="image/*">
                        <button type="button" class="btn btn-success add-variant-image-btn" data-variant-index="${variantIndex}">Add More Images</button>
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                    <button type="button" class="btn btn-danger remove-variant-btn">Remove Variant</button>
                </div>
            </div>
        </div>`;
                        $('#variants-wrapper').append(variantInputGroup); // Correctly append to the container
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
                        $(this).closest('.variant-input').find('.col-md-6.mt-4').append(imageInput);
                    });

                    // Remove image input for variants
                    $(document).on('click', '.remove-image-btn', function() {
                        $(this).closest('.input-group').remove();
                    });

                    // Remove entire variant
                    $(document).on('click', '.remove-variant-btn', function() {
                        $(this).closest('.variant-group').remove();
                    });

                });
            </script>


</body>

</html>