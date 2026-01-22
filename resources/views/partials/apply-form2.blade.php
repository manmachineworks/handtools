 <form action="{{ route('submit.apply.form') }}" method="POST" id="quoteForm2">
            @csrf
            <div class="form-group">
                <label for="name">Full Name <span class="reqfil">*</span></label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address <span class="reqfil">*</span></label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Phone Number <span class="reqfil">*</span></label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter your phone number" required>
            </div>
           
             <div class="form-group">
                <label for="product">Product <span class="reqfil">*</span></label>
                <select name="product_type" id="productDropdown" required>
                    <option value="">-- Select Product --</option>
                </select>
            </div>
            <div class="form-group">
                <label for="city">City <span class="reqfil">*</span></label>
                <input type="text" id="city" name="city" placeholder="Enter your City" required>
            </div>
            <div class="form-group">
                <label for="state">State <span class="reqfil">*</span></label>
                <input type="text" id="state" name="state" placeholder="Enter your State" required>
            </div>
            
              <div class="col-12">
                     <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                </div>
                 @error('captcha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            <button type="submit" class="btn-submit">Submit</button>
        </form>