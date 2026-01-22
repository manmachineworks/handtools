<!doctype html>
<html class="no-js" lang="en">
@include("include/head")

<body>
    @include("include/header")

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">
                        Edit Address Form
                    </h2>
                    <form action="{{ route('address.edit', $address->id) }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="first_name">First Name (optional)</label>
                                <input type="text" class="form-control" value="{{ $address->first_name }}" id="first_name" name="first_name" placeholder="First name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" value="{{ $address->last_name }}" id="last_name" name="last_name" placeholder="Last name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country" required>
                                    <option value="India">India</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" value="{{ $address->address }}" id="address" name="address" placeholder="Address" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="apartment">Apartment, Suite, etc. (optional)</label>
                                <input type="text" class="form-control" id="apartment" value="{{ $address->apartment }}" name="apartment" placeholder="Apartment, suite, etc.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" value="{{ $address->city }}" name="city" placeholder="City" value="Delhi" required>
                            </div>
                                  <div class="col-md-4 mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" value="{{ $address->state }}" name="state" placeholder="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pin_code">PIN Code</label>
                                <input type="text" class="form-control" id="pin_code" value="{{ $address->pin_code }}" name="pin_code" placeholder="PIN code" required>
                            </div>
                          
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary">Update Address</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>


    @include("include/footer")
</body>

</html>