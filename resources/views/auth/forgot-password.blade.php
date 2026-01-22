<!doctype html>
<html class="no-js" lang="en">
@include("include/head")

<body>
    @include("include/header")

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="login_page_bg">
                        <div class="container">
                            <div class="customer_login">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <div class="account_form login">
                                            <h2>Send Forgot Password Link</h2>
                                            <form action="{{ route('password.email') }}" method="POST">
                                                @csrf
                                                <!-- General error handling -->
                                                @if ($errors->has('error'))
                                                <div class="alert alert-danger">{{ $errors->first('error') }}</div>
                                                @endif

                                                <label for="email">Email Address</label>
                                                <input type="email" name="email" id="email" required>

                                                <!-- Specific error handling for email field -->
                                                @error('email')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror

                                                <button type="submit" class="m-4">Send Password Reset Link</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    @include("include/footer")
</body>

</html>