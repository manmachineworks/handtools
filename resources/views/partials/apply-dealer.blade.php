 
{{-- resources/views/partials/footer.blade.php --}}
@php
  $states   = config('states.india', []);
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
  maxlength="100"
/>
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
  inputmode="numeric"
  pattern="^\d{10}$"
  minlength="10"
  maxlength="10"
/>
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
          rows="1"
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

   