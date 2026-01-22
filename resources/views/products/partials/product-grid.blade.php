<div class="row gy-4 align-items-stretch">
    @forelse($products as $product)
        <div class="col-lg-4 filter-item cat3 d-flex">
            <div class="portfolio-card h-100 w-100">
                <div class="portfolio-card-thumb">
                    <a href="{{ route('content.show', [
                        'category' => $product->subcategory->category->slug ?? $category->slug ?? '',
                        'subcategory' => $product->subcategory->slug ?? 'general',
                        'url' => $product->url
                    ]) }}">
                        <img src="{{ asset($product->images->first()->image_url ?? '') }}"
                             loading="lazy"
                             decoding="async"
                             alt="{{ $product->product_name }}">
                    </a>

                    <h4 class="clamp-titlee">
                        <a href="{{ route('content.show', [
                            'category' => $product->subcategory->category->slug ?? $category->slug ?? '',
                            'subcategory' => $product->subcategory->slug ?? 'general',
                            'url' => $product->url
                        ]) }}">
                            {{ $product->product_name }}
                        </a>
                    </h4>
                </div>

                <div class="portfolio-card-details">
                    <div class="media-left">
                        <span class="portfolio-card-details_subtitle">{{ $product->subcategory->name ?? '' }}</span>
                        <h4 class="clamp-titlee2">
                            <a href="{{ route('content.show', [
                                'category' => $product->subcategory->category->slug ?? $category->slug ?? '',
                                'subcategory' => $product->subcategory->slug ?? 'general',
                                'url' => $product->url
                            ]) }}">
                                {{ $product->product_name }}
                            </a>
                        </h4>
                    </div>

                    <a href="{{ route('content.show', [
                        'category' => $product->subcategory->category->slug ?? $category->slug ?? '',
                        'subcategory' => $product->subcategory->slug ?? 'general',
                        'url' => $product->url
                    ]) }}" class="icon-btn">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center py-4">
            <p class="mb-0">{{ $emptyMessage ?? 'No products found in this subcategory.' }}</p>
        </div>
    @endforelse
</div>
