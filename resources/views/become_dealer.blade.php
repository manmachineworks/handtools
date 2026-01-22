<!doctype html>
<html class="no-js" lang="en">
@include('layout/head')

<body>
@include('layout/header')


  <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper">
        <!-- bg animated image/ -->   
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Become A Dealer</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="/">Home</a></li>
                            <li class="active">Become A Dealer</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="breadcumb-thumb">
                        <img src="/assets/assets/img/bg/banner-2.jpg" loading="lazy" decoding="async" alt="img">
                    </div>            
                </div>
            </div>
        </div>
    </div>

  
   <style>
.alert-success-msg {
    background-color: #d4edda;
    color: #155724;
    padding: 15px 20px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    font-weight: 500;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}


.form-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

.popup-form-content {
    width: 100%;
    max-width: 600px;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 10;
}

.popup-form-header {
    text-align: center;
    margin-bottom: 20px;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 8px;
    color: #444;
}
.form-group input {
    height: 44px; /* Ensures same height as inputs */
    line-height: 1.2;
}

.form-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg fill='gray' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 20px;
    padding: 10px 40px 10px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    color: #333;
    cursor: pointer;
    width: 100%;
    height: 44px; /* Ensures same height as inputs */
    line-height: 1.2;
    transition: border-color 0.2s ease;
}

.form-group select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.form-group input,
.form-group select,
.form-group textarea {
    
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    outline: none;
}

textarea {
    resize: vertical;
}

.btn-submit {
    background-color: #007bff;
    color: #fff;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .popup-form-content {
        padding: 20px;
    }
}

</style>

<!-- Dealer Form Section -->
<div class="space-top space-bottom py-5" style="background-color:#0d0d0d;">
    <div class="container form-wrapper"> <!-- Flex centered container -->
        <div class="popup-form-content">
            <div class="popup-form-blur-bg"></div>
            <div class="popup-form-header">
                <h2 class="form-title">Become A Dealer</h2>
            </div>
            
{{-- resources/views/partials/footer.blade.php --}}
@php
  $states   = config('states.india', []);
  $recaptcha = config('services.recaptcha_v3', ['enabled' => false, 'site_key' => null]);
@endphp
 <form action="{{ route('dealer.submit_dealer') }}" method="POST" id="quoteForm3" novalidate>
      @csrf

      {{-- Honeypot: must remain empty (present + prohibited on server) --}}
      <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-10000px;" aria-hidden="true">
      {{-- Time trap: unix time at render (validated on server for elapsed seconds) --}}
      <input type="hidden" name="form_start" value="{{ time() }}">

      <div class="form-group">
        <label for="dealer-name">Name <span class="reqfil" aria-hidden="true">*</span></label>
        <input
          type="text"
          id="dealer-name"
          name="name"
          value="{{ old('name') }}"
          placeholder="Enter dealer name"
          required
          maxlength="100"
          autocomplete="name"
        >
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label for="dealer-email">Email Address <span class="reqfil" aria-hidden="true">*</span></label>
        <input
          type="email"
          id="dealer-email"
          name="email"
          value="{{ old('email') }}"
          placeholder="Enter your email"
          required
          autocomplete="email"
          inputmode="email"
        >
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label for="dealer-phone">Phone Number <span class="reqfil" aria-hidden="true">*</span></label>
        <input
          type="tel"
          id="dealer-phone"
          name="phone"
          value="{{ old('phone') }}"
          placeholder="Enter your phone number"
          required
          autocomplete="tel"
          inputmode="tel"
          pattern="^\+?\d{7,20}$"
        >
        @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label for="dealer-address">Address <span class="reqfil" aria-hidden="true">*</span></label>
        <input
          type="text"
          id="dealer-address"
          name="address"
          value="{{ old('address') }}"
          placeholder="Full Address"
          required
          maxlength="255"
          autocomplete="street-address"
        >
        @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label for="dealer-state">State <span class="reqfil" aria-hidden="true">*</span></label>
        <select id="dealer-state" name="state" required>
          <option value="">Select state</option>
          @foreach($states as $s)
            <option value="{{ $s }}" @selected(old('state') === $s)>{{ $s }}</option>
          @endforeach
        </select>
        @error('state')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label for="dealer-message">Message <span class="reqfil" aria-hidden="true">*</span></label>
        <textarea
          id="dealer-message"
          name="message"
          rows="3"
          placeholder="Message here..."
          required
          maxlength="2000"
        >{{ old('message') }}</textarea>
        @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-12 form-check mt-1">
        <input class="form-check-input" type="checkbox" value="1" id="consent" name="consent" required @checked(old('consent'))>
        <label class="form-check-label" for="consent" style="color:#ffffff;">I agree to the Privacy Policy.</label>
        @error('consent')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <input type="hidden" name="captcha_token" id="captcha_token">
      @error('captcha_token')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

      <button type="submit" class="btn-submit" id="dealer-submit-btn" aria-label="Submit dealer form">Submit</button>
    </form>

    @if($recaptcha['enabled'] && $recaptcha['site_key'])
      <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['site_key'] }}"></script>
      <script>
        (function () {
          const form = document.getElementById('quoteForm3');
          const submitBtn = document.getElementById('dealer-submit-btn');
          const tokenField = document.getElementById('captcha_token');
          let submitting = false;

          // prevent double-submit
          form.addEventListener('submit', function (e) {
            if (submitting) { e.preventDefault(); return; }
            if (!tokenField.value) {
              e.preventDefault();
              submitBtn.disabled = true;
              grecaptcha.ready(function () {
                grecaptcha.execute('{{ $recaptcha['site_key'] }}', { action: 'dealer_submit' })
                  .then(function (token) {
                    tokenField.value = token;
                    submitting = true;
                    form.submit();
                  })
                  .catch(function () {
                    // proceed; server will decide
                    submitting = true;
                    form.submit();
                  });
              });
            }
          });

          // close button UX for popup
          document.getElementById('closePopup3')?.addEventListener('click', () => {
            const dialog = document.getElementById('popupForm3');
            dialog?.setAttribute('aria-hidden', 'true');
            dialog?.classList.remove('is-open');
          });
        })();
      </script>
    @endif
        </div>
    </div>
</div>


 <!--==============================
    About Area  
    ==============================-->
    <div class=" space-top" style="background-color:#0d0d0d;">
        <div class="container">
            <div class="row">
                
                <div class="col-xxl-12 col-xl-12">
                    <div class="about-content-wrap">
                        <div class="title-area mb-30">
                            <span class="sub-title">Join Menzerna India’s Dealer Network</span> 
                            <h2 class="sec-title text-white">Premium Products, Professional Support <img class="title-bg-shape" src="assets/assets/img/bg/title-bg-shape.png" loading="lazy" decoding="async" alt="img"></h2>
                            <p class="sec-text text-white" style="text-align: justify;">If you’re passionate about the car care and detailing industry, becoming an authorized dealer for Menzerna India is a great opportunity to grow your business. Menzerna is a globally trusted name in polishing compounds and paint correction products, known for its German-engineered quality and high-performance results. By joining hands with Menzerna India, you not only represent a premium brand but also get access to a wide range of professional-grade products designed for both detailing experts and automotive workshops.<br><br>

As a dealer, you will benefit from strong brand recognition, consistent product demand, and exclusive dealer support. Whether you run a detailing studio, auto workshop, or car care retail store, Menzerna products can enhance your offerings and help you cater to a broad customer base. From heavy cutting compounds to finishing polishes, the product range covers every step of the paint correction process.<br><br>

Menzerna India also provides complete guidance and training to its dealers to help them understand product usage and benefits. Our team ensures timely delivery, marketing support, and technical know-how so that you can serve your customers better and grow confidently in a competitive market.<br><br>

If you’re looking to expand your business with high-quality, in-demand detailing products, becoming a Menzerna India dealer is the right step forward. Simply fill out the enquiry form on this page with your business details, and our team will get in touch with you for the next steps. Start your journey with Menzerna India and build a strong presence in the car care industry with a brand that professionals trust.</p>
                            
                          

                            
                        </div>
                         
              
                    </div>                    
                </div>

            </div>
        </div>
    </div> 


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('dealerForm');
    const successMessage = document.getElementById('success-message3');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (response.ok) return response.json();
            return response.json().then(err => Promise.reject(err));
        })
        .then(data => {
            form.reset();
            successMessage.style.display = 'block';
            successMessage.innerText = 'Your message has been sent successfully!';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            console.error('Submission error:', error);
        });
    });
});
</script>




@include('layout/footer')
</body>
</html>
