
@php
  /** @var string|null $id */
  $formId   = $id ?? 'quoteForm';
  $states    = config('states.india', []);
  $products  = config('products.types', []);
  $categoryOptions = $categories ?? \App\Models\Category::select('name','slug')->orderBy('name')->get();
@endphp

<form action="{{ route($route) }}" method="POST" id="{{ $formId }}" novalidate>
  @csrf

  {{-- Honeypot --}}
  <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-10000px;" aria-hidden="true">
  {{-- Timing trap --}}
  <input type="hidden" name="form_start" value="{{ time() }}">

  {{-- Inline fallback banners (used on non-JS) --}}
  @if(session('success'))
    <div class="alert alert-success" role="alert" style="background:#28a745;color:#fff;padding:.75rem 1rem;border-radius:.375rem;margin-bottom:10px;">
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger" role="alert" style="background:#6b0000;color:#fff;padding:.75rem 1rem;border-radius:.375rem;margin-bottom:10px;">
      Please fix the errors below.
    </div>
  @endif

   <div class="form-group">
    <label for="af-name">Full Name <span class="reqfil">*</span></label>
    <input type="text" id="af-name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required maxlength="100" autocomplete="name">
    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <div class="form-group">
    <label for="af-email">Email Address <span class="reqfil">*</span></label>
   <input
  type="email"
  id="af-email"
  name="email"
  value="{{ old('email') }}"
  placeholder="Enter your email"
  required
  maxlength="100"
  autocomplete="email"
  inputmode="email"
/>
    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <div class="form-group">
    <label for="af-mobile">Phone Number <span class="reqfil">*</span></label>
    <input
  type="tel"
  id="af-mobile"
  name="mobile"
  value="{{ old('mobile') }}"
  placeholder="Enter your phone number"
  required
  inputmode="numeric"
  autocomplete="tel"
  pattern="^\d{10}$"
  minlength="10"
  maxlength="10"
/>
    @error('mobile')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <div class="form-group">
    <label for="{{ $formId }}_productDropdown">Category <span class="reqfil">*</span></label>
    <select name="product_type" id="{{ $formId }}_productDropdown" class="product-dropdown" required>
      <option value="">-- Select Category --</option>
      @forelse($categoryOptions as $cat)
        <option value="{{ $cat->slug ?? $cat->name }}" @selected(old('product_type')==($cat->slug ?? $cat->name))>{{ $cat->name }}</option>
      @empty
        <option value="" disabled>No categories available</option>
      @endforelse
    </select>
    @error('product_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <div class="form-group">
    <label for="af-city">City <span class="reqfil">*</span></label>
    <input type="text" id="af-city" name="city" value="{{ old('city') }}" placeholder="Enter your City" required maxlength="50" autocomplete="address-level2">
    @error('city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <div class="form-group">
    <label for="af-state">State <span class="reqfil">*</span></label>
    <select id="af-state" name="state" required>
      <option value="">Select state</option>
      @foreach($states as $s)
        <option value="{{ $s }}" @selected(old('state')===$s)>{{ $s }}</option>
      @endforeach
    </select>
    @error('state')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>

  <input type="hidden" name="captcha_token" id="captcha_token_{{ $formId }}">
  <button type="submit" class="btn-submit" id="apply-submit-btn-{{ $formId }}" aria-live="polite">Submit</button>
</form>
