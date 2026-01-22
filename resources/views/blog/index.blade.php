<!doctype html>
<html class="no-js" lang="en">


@include("layout/head")


<body>
    <!--********************************
   		Code Start From Here 
	******************************** -->
<style>
    /* Pagination Wrapper */
.pagination-wrapper {
  text-align: center;
  margin-top: 40px;
}

/* Pagination List */
.custom-pagination {
  list-style: none;
  padding: 0;
  display: inline-flex;
  gap: 8px;
}

/* Pagination Items */
.custom-pagination li {
  display: inline;
}

/* Links */
.custom-pagination a,
.custom-pagination span {
  display: inline-block;
  padding: 10px 15px;
  border-radius: 8px;
  border: 1px solid #ddd;
  background: #fff;
  color: #333;
  text-decoration: none;
  transition: all 0.3s ease;
  min-width: 40px;
}

/* Hover */
.custom-pagination a:hover {
  background-color: #f0f0f0;
  border-color: #bbb;
}

/* Active */
.custom-pagination .active span {
  background-color: red;
  color: white;
  border-color: red;
  cursor: default;
}

/* Disabled */
.custom-pagination .disabled span {
  color: #ccc;
  background: #f9f9f9;
  cursor: not-allowed;
}
  .blog-single-card .blog-date {
    position: absolute;
    right: 0;
    top: 0;
    -webkit-transform: translate(100%, -50%);
    transform: translate(0%, -50%) !important;
}
    .blog-single-card .blog-content {
        margin: 0;
    }
    </style>
    @include("layout/header")


    <!--==============================
    Breadcumb
    ============================== -->
   
    
      <section class="section-one">
        <div class="page-img-header" id="about-bg">
            <div class="container">
                <h1 class="img-header-text fade_down">Blogs</h1>
                <div class="breadcrumb-group fade_up">
                    <a href="index.html">HOME / </a>
                    <a href="about.html"> Blogs</a>
                </div>
            </div>
        </div>
    </section>

    <!--==============================
    Blog Area  
    ==============================-->
    <section class="blog-area space-top ">
        <div class="container">
            <div class="row gx-40">
                <div class="col-xxl-8 col-lg-7">
                   

                @foreach ($recentsone as $blogone)
                    <div class="blog-single-card">
                        <div class="blog-thumb">
                            <a href="{{ route('blog_show', $blogone->url) }}"><img src="/{{ $blogone->blog_image }}" loading="lazy" decoding="async" alt="{{ $blogone->blog_title }}"></a>
                        </div>

                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href=""><i class="fas fa-user"></i>By admin</a>
                                <!-- <a href=""><i class="fas fa-comments"></i>Comments (05)</a> -->
                            </div>
                            <h3 class="blog-title"><a href="{{ route('blog_show', $blogone->url) }}">{{ $blogone->blog_title }}</a></h3>
                            <p class="blog-text">{{ Str::limit(strip_tags($blogone->blog_detail), 100) }} </p>
                            <a href="{{ route('blog_show', $blogone->url) }}" class="btn style-border2"> READ MORE <i class="fas fa-arrow-right"></i></a>
                            <div class="blog-date">
                                <a href="#"><span>{{ \Carbon\Carbon::parse($blogone->date)->format('d') }}</span>{{ \Carbon\Carbon::parse($blogone->date)->format('F') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach


                </div>

                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        


                        <div class="widget">
                            <h3 class="widget_title">Recent Blogs</h3>
                            <div class="recent-post-wrap">

                              @foreach($recents as $recent)
                                <div class="recent-post">                                    
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('blog_show', $recent->url) }}">{{ $recent->blog_title }}</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="">{{ $recent->created_at->format('F d') }}</a>
                                        </div>
                                    </div>
                                    <div class="media-img">
                                        <a href="{{ route('blog_show', $recent->url) }}"><img src="/{{ $recent->blog_image }}" loading="lazy" decoding="async" alt="Blog Image"></a>
                                    </div>
                                </div>
                                @endforeach

                                
                            </div>
                        </div>

                         
                    </aside>
                </div>
            </div>
        </div>
    </section>    
    
 
    
     <section class="blog-area space-extra-bottom">
        <div class="container">
           
    <div class="row">
    @foreach ($blogs as $index => $blog)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="blog-single-card">
                <div class="blog-thumb">
                     <a href="{{ route('blog_show', $blog->url) }}"><img src="/{{ $blog->blog_image }}" loading="lazy" decoding="async" alt="{{ $blog->blog_title }}"></a>
                </div>

                <div class="blog-content">
                    <div class="blog-meta">
                        <a href=""><i class="fas fa-user"></i>By admin</a>
                    </div>
                    <h5 >
                        <a href="{{ route('blog_show', $blog->url) }}">{{ $blog->blog_title }}</a>
                    </h5>
                    <p class="blog-text">{{ Str::limit(strip_tags($blog->blog_detail), 50) }}</p>
                    <a href="{{ route('blog_show', $blog->url) }}" class="btn style-border2">
                        READ MORE <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="blog-date">
                        <a href="{{ route('blog_show', $blog->url) }}">
                            <span>{{ \Carbon\Carbon::parse($blog->date)->format('d') }}</span>{{ \Carbon\Carbon::parse($blog->date)->format('F') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
     <div class="pagination-wrapper">
                  <ul class="uk-pagination custom-pagination">
                    {{-- Previous Page Link --}}
                    @if ($blogs->onFirstPage())
                      <li class="disabled"><span>&laquo;</span></li>
                    @else
                      <li><a href="{{ $blogs->previousPageUrl() }}">&laquo;</a></li>
                    @endif
                
                    {{-- First Page --}}
                    @if ($blogs->currentPage() > 2)
                      <li><a href="{{ $blogs->url(1) }}">1</a></li>
                    @endif
                
                    {{-- Dots Before --}}
                    @if ($blogs->currentPage() > 3)
                      <li class="disabled"><span>...</span></li>
                    @endif
                
                    {{-- Current, Previous and Next Pages --}}
                    @for ($i = max(1, $blogs->currentPage() - 1); $i <= min($blogs->lastPage(), $blogs->currentPage() + 1); $i++)
                      @if ($i == $blogs->currentPage())
                        <li class="active"><span>{{ $i }}</span></li>
                      @else
                        <li><a href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
                      @endif
                    @endfor
                
                    {{-- Dots After --}}
                    @if ($blogs->currentPage() < $blogs->lastPage() - 2)
                      <li class="disabled"><span>...</span></li>
                    @endif
                
                    {{-- Last Page --}}
                    @if ($blogs->currentPage() < $blogs->lastPage() - 1)
                      <li><a href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a></li>
                    @endif
                
                    {{-- Next Page Link --}}
                    @if ($blogs->hasMorePages())
                      <li><a href="{{ $blogs->nextPageUrl() }}">Next &rarr;</a></li>
                    @else
                      <li class="disabled"><span>Next &rarr;</span></li>
                    @endif
                  </ul>
                </div>
                
                
    </div>
     </div>
    </section>  

    @include("layout/footer")

</body>

</html>