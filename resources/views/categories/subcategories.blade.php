<!DOCTYPE html>
<html lang="en">
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
                        <h1 class="breadcumb-title">{{ $category->name }}</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="/">Home</a></li>
                            <li class="active">{{ $category->name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="breadcumb-thumb">
                        <img src="{{ asset( $subcategory->subcat_image) }}" alt="{{ $category->name }}">
                    </div>            
                </div>
            </div>
        </div>
    </div>
    
    <style>
.pagination-wrapper {
    text-align: center;
    margin-top: 30px;
}

.pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a,
.pagination li span {
    display: block;
    padding: 8px 12px;
    color: #333;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li.active span,
.pagination li a:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination li.disabled span {
    color: #999;
    background-color: #e9ecef;
}
    .productt {
      background-color: #ffffff;
      color: #333;
      padding: 20px 40px;
      font-size: 2.5rem;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) ;
      border-radius: 10px;
      transition: all 0.3s ease-in-out;
    }

    @media (max-width: 768px) {
      .productt {
        font-size: 2rem;
        padding: 15px 30px;
      }
    }

    @media (max-width: 480px) {
      .productt {
        font-size: 1.5rem;
        padding: 10px 20px;
      }
    }
  
  .clamp-titlee {
  padding: 16px 20px;
  border-radius: 10px;
  font-size: 18px;
  line-height: 1.4;
  background-color: #f9f9f9;
  margin-bottom: 10px;

  display: -webkit-box;
  -webkit-line-clamp: 2; /* Show only 2 lines */
  -webkit-box-orient: vertical;
  overflow: hidden;
  height: calc(2.2em * 2); /* 2 lines of text */
}


  .clamp-titlee a {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    color: inherit;
    text-decoration: none;
    font-weight: 700;
  }

  .clamp-titlee a:hover {
    text-decoration: underline;
  }

  @media (max-width: 576px) {
    .clamp-titlee {
      font-size: 14px;
      padding: 12px 16px;
    }
  }
  
  
  
  
  .clamp-titlee2 {
    font-size: 18px;
    line-height: 1.4;
  }

  .clamp-titlee2 a {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    color: inherit;
    text-decoration: none;
    font-weight: 700;
  }

  .clamp-titlee2 a:hover {
    text-decoration: underline;
    
        color: #ff5906;
    text-decoration: none;
    outline: 0;
    -webkit-transition: all ease 0.4s;
    transition: all ease 0.4s;
  }

  @media (max-width: 576px) {
    .clamp-titlee2 {
      font-size: 14px;
      padding: 12px 16px;
    }
  }
</style>
    
     <section class="shop-section space-top space-extra-bottom">
    <div class="container">
        <div class="row flex-row-reverse">
            <!-- Product Listing Section -->
            <div class="col-xl-9 col-lg-8">
          
                <!-- Product Grid -->
                <div class="row gy-4">
                     @foreach($products as $product)  
                     
                    <div class="col-lg-4 filter-item cat3">
                    <div class="portfolio-card">
                        <div class="portfolio-card-thumb">
                            <a href="{{ route('content.show', $product->url) }}"><img src="{{ asset($product->images->first()->image_url) }}" alt="img"></a>
                            <h4 class="clamp-titlee"><a href="{{ route('content.show', $product->url) }}">{{ $product->product_name }}</a></h4>
                        </div>
                        
                        <div class="portfolio-card-details">
                            <div class="media-left">
                                <span class="portfolio-card-details_subtitle">{{ $subcategory->name }}</span>
                                <h4 class="clamp-titlee2"><a href="{{ route('content.show', $product->url) }}">{{ $product->product_name }}</a></h4>
                            </div>
                            <a href="{{ route('content.show', $product->url) }}" class="icon-btn">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                    @endforeach
                </div>
               
                 <div class="pagination-wrapper">
                         {{ $products->appends(request()->query())->links() }}
                </div>


            </div>

            <!-- Sidebar Section -->
            <div class="col-xl-3 col-lg-4 sidebar-widget-area">
                <aside class="sidebar-area sidebar-shop">
                    <div class="widget widget_search mb-4">
                        <h3 class="widget_title">Product Search</h3>
                        <form class="search-form" method="GET" action="{{ route('search.products') }}">
                            <input type="text" name="q" placeholder="Search..">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <div class="widget widget_categories">
                        <h3 class="widget_title">Product Categories</h3>
                        <ul class="category-list">
                            <li><a href="/car-care">Car Care</a></li>
                            <li><a href="/car-care/heavy-cut">Heavy Cut</a></li>
                            <li><a href="/car-care/medium-cut">Medium Cut</a></li>
                            <li><a href="/car-care/finish">Finish</a></li>
                            <li><a href="/car-care/protection">Protection</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
    
    
    

        @include('layout/footer')
  
  
</body>

 <!-- <script src="/assets/js/libs.js"></script>
    <script src="/assets/js/main.js"></script> -->
<!-- Mirrored from pro-theme.com/html/antek/page-rental.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 11:57:32 GMT -->

</html>

