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
                                            <h2>Reset Your Password for {{ $email }}</h2>
                                            <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <input type="hidden" name="email" value="{{ $email }}">

                                                <label for="password">New Password</label>
                                                <input type="password" name="password" id="password" required>
                                                @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" required>
                                                @error('password_confirmation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <button type="submit" class="m-4">Reset Password</button>

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