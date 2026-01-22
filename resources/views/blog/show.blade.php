<!doctype html>
<html lang="zxx">
@include("layout/head")

<body>
@include("layout/header")

<!-- Breadcumb -->
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Blog Details</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="/">Home</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li class="active">Blog Details</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 d-lg-block d-none">
                <div class="breadcumb-thumb">
                    <img src="/assets/assets/img/bg/banner-2.jpg"  loading="lazy" decoding="async" alt="Banner">
                </div>            
            </div>
        </div>
    </div>
</div>



<section class="blog-area space-top space-extra-bottom">
  <div class="container">
    <div class="row gx-40">
      <div class="col-xxl-8 col-lg-7">
        <article class="blog-details-card">
          <div class="blog-thumb">
            <img src="/{{ $blog->blog_image }}" width="800" height="400" loading="lazy" decoding="async" alt="{{ $blog->blog_title }}">
            <div class="blog-meta">
              <a href="#"><i class="far fa-user"></i> By admin</a>
            </div>
            <time class="blog-date">{{ $blog->created_at->format('d-m-y') }}</time>
          </div>

          <div class="blog-content">
            <h2 class="blog-title h3">{{ $blog->blog_title }}</h2>
            <button class="btn style2 w-100 mt-3" id="popupTrigger">
              Get A Quote <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <div class="mt-3">{!! $blog->blog_detail !!}</div>
          </div>
        </article>

        {{-- Comments --}}
        <!--<div class="blog-comments mt-5">-->
        <!--  <h3 class="mb-4">-->
        <!--    Comments ({{ number_format($comments->total()) }})-->
        <!--  </h3>-->

        <!--  {{-- Display Comments --}}-->
        <!--  <div class="comments-list mb-4">-->
        <!--    @forelse($comments as $comment)-->
        <!--      <div class="comment mb-3 p-3 border rounded shadow-sm">-->
        <!--        <div class="d-flex justify-content-between align-items-center mb-2">-->
        <!--          <strong class="text-primary">{{ $comment->name }}</strong>-->
        <!--          <small class="text-muted" title="{{ $comment->created_at->toDayDateTimeString() }}">-->
        <!--            {{ $comment->created_at->diffForHumans() }}-->
        <!--          </small>-->
        <!--        </div>-->
        <!--        <p class="mb-0">{{ $comment->message }}</p>-->
        <!--      </div>-->
        <!--    @empty-->
        <!--      <p class="text-muted">No comments yet. Be the first to comment!</p>-->
        <!--    @endforelse-->
        <!--  </div>-->

        <!--  {{-- Pagination --}}-->
        <!--  @if($comments->hasPages())-->
        <!--    <div class="mb-5">-->
        <!--      {{ $comments->onEachSide(1)->links() }}-->
        <!--    </div>-->
        <!--  @endif-->

          {{-- Comment Form --}}
          <!--<div class="comment-form">-->
          <!--  <h4 class="mb-3">Leave a Comment</h4>-->

          <!--  @if(session('success'))-->
          <!--    <div class="alert alert-success">{{ session('success') }}</div>-->
          <!--  @endif-->

          <!--  <form action="{{ route('commts.store', $blog) }}" method="POST" class="row g-3" novalidate>-->
          <!--    @csrf-->

          <!--    {{-- Honeypot (bots fill it; humans don’t) --}}-->
          <!--    <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off" aria-hidden="true">-->

          <!--    <div class="col-md-6">-->
          <!--      <input type="text" name="name" placeholder="Your Name"-->
          <!--        value="{{ old('name') }}"-->
          <!--        class="form-control @error('name') is-invalid @enderror">-->
          <!--      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror-->
          <!--    </div>-->
              
          <!--     <div class="col-md-6">-->
          <!--      <input type="text" name="email" placeholder="Your Email"-->
          <!--        value="{{ old('email') }}"-->
          <!--        class="form-control @error('email') is-invalid @enderror">-->
          <!--      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror-->
          <!--    </div>-->

          <!--    <div class="col-12">-->
          <!--      <textarea name="message" placeholder="Your Comment" rows="4"-->
          <!--        class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>-->
          <!--      @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror-->
          <!--    </div>-->
              
          <!--      <div class="col-12">-->
          <!--           <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>-->
          <!--      </div>-->
          <!--       @error('captcha')-->
          <!--          <div class="text-danger">{{ $message }}</div>-->
          <!--      @enderror-->
                        
                        
          <!--    <div class="col-12">-->
          <!--      <button type="submit" class="btn btn-primary">Submit Comment</button>-->
          <!--    </div>-->
          <!--  </form>-->
          <!--</div>-->
        <!--</div>-->
      </div>

      {{-- Sidebar unchanged --}}
      <div class="col-xxl-4 col-lg-5">
        <aside class="sidebar-area">
          <div class="widget">
            <h3 class="widget_title">Recent Blogs</h3>
            <div class="recent-post-wrap">
              @foreach($recents as $recent)
                <article class="recent-post">
                  <div class="media-body">
                    <h4 class="post-title">
                      <a class="text-inherit" href="{{ route('blog_show', $recent->url) }}">
                        {{ $recent->blog_title }}
                      </a>
                    </h4>
                    <div class="recent-post-meta">
                      <time>{{ $recent->created_at->format('F d') }}</time>
                    </div>
                  </div>
                  <div class="media-img">
                    <a href="{{ route('blog_show', $recent->url) }}">
                      <img src="/{{ $recent->blog_image }}" width="120" height="80" loading="lazy" alt="{{ $recent->blog_title }}">
                    </a>
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
<!-- Popup Form -->
<div class="popup-form" id="popupForm2">
  <div class="popup-form-content">
    <div class="popup-form-blur-bg"></div>
    <div class="popup-form-header">
        <h2 class="form-title">Enquiry Now</h2>
        <button id="closePopup2" class="close-btn" aria-label="Close">&times;</button>
    </div>
    <div id="success-message2" class="alert-success-msg d-none">
        Your message has been sent successfully!
    </div>
    @include('partials.apply-form', ['route' => 'submit.apply.form'])
  </div>
</div>

@include("layout/footer")

<script defer>
document.addEventListener("DOMContentLoaded", () => {
    fetch("/get-products")
        .then(res => res.json())
        .then(data => {
            const dropdown = document.getElementById("productDropdown");
            if(dropdown){
                data.forEach(product => {
                    const option = new Option(product.product_name, product.product_name);
                    dropdown.add(option);
                });
            }
        })
        .catch(err => console.error("Error fetching products:", err));
});
</script>



</body>
</html>
