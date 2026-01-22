<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <div class="sidebar-brand px-4 py-3 d-flex align-items-center justify-content-between border-bottom border-white/10">
        <div class="d-flex align-items-center gap-3">
            <img src="/assets/new_assets/images/svg/logo.png" alt="Gurunanak Logo" class="sidebar-logo">
            <div class="sidebar-brand-text">
                <strong>Gurunanak</strong>
                <small>Hand Tools</small>
            </div>
        </div>
        <span class="badge bg-orange text-uppercase small">Admin</span>
    </div>

    <nav class="sidebar-nav px-3">
        <a href="/admin/dashboard" class="sidebar-link rounded-3 d-flex align-items-center gap-2 py-2 mb-2">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>

        @php
            $menu = [
                ['label' => 'Products', 'icon' => 'fa-laptop', 'links' => [
                    ['href' => '/admin/add_product', 'label' => 'Add Product'],
                    ['href' => '/admin/products', 'label' => 'Show Products'],
                ]],
                ['label' => 'Brands', 'icon' => 'fa-tags', 'links' => [
                    ['href' => '/admin/brands/create', 'label' => 'Add Brand'],
                    ['href' => '/admin/brands', 'label' => 'Show Brands'],
                ]],
                ['label' => 'Blogs', 'icon' => 'fa-newspaper', 'links' => [
                    ['href' => '/admin/blogs/create', 'label' => 'Create Blogs'],
                    ['href' => '/admin/blogs_show', 'label' => 'Show Blogs'],
                ]],
                ['label' => 'Categories', 'icon' => 'fa-layer-group', 'links' => [
                    ['href' => '/admin/categories/create', 'label' => 'Create Categories'],
                    ['href' => '/admin/categories', 'label' => 'Show Categories'],
                ]],
                ['label' => 'SubCategories', 'icon' => 'fa-th-list', 'links' => [
                    ['href' => '/admin/subcategories/create', 'label' => 'Create Sub Categories'],
                    ['href' => '/admin/subcategories', 'label' => 'Show Sub Categories'],
                ]],
            ];
        @endphp

        @foreach ($menu as $index => $group)
            <div class="sidebar-group mb-2">
                <button class="sidebar-toggle btn btn-link w-100 text-start rounded-3 d-flex align-items-center justify-content-between text-white"
                    type="button" data-target="menu-{{ $index }}">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fas {{ $group['icon'] }}"></i>
                        {{ $group['label'] }}
                    </span>
                    <i class="fas fa-chevron-down rotate-icon"></i>
                </button>
                <div class="sidebar-collapse rounded-3 mt-1" id="menu-{{ $index }}">
                    @foreach ($group['links'] as $link)
                        <a href="{{ $link['href'] }}" class="sidebar-link submenu-link px-3 py-2 d-flex align-items-center gap-2">
                            <i class="fas fa-circle-notch fs-6"></i>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        <a href="/admin/metas" class="sidebar-link mt-1 rounded-3 d-flex align-items-center gap-2 py-2">
            <i class="fas fa-file-alt"></i>
            Pages Meta
        </a>

        <a href="/admin/home/content" class="sidebar-link mt-1 rounded-3 d-flex align-items-center gap-2 py-2">
            <i class="fas fa-home"></i>
            Home Content
        </a>

        <div class="sidebar-group mt-2">
            <button class="sidebar-toggle btn btn-link w-100 text-start rounded-3 d-flex align-items-center justify-content-between text-white"
                type="button" data-target="forms">
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-envelope-open-text"></i>
                    Forms
                </span>
                <i class="fas fa-chevron-down rotate-icon"></i>
            </button>
            <div class="sidebar-collapse rounded-3 mt-1" id="forms">
                <a href="/admin/apply" class="sidebar-link submenu-link px-3 py-2 d-flex align-items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Apply Form
                </a>
                <a href="/admin/contact" class="sidebar-link submenu-link px-3 py-2 d-flex align-items-center gap-2">
                    <i class="fas fa-headset"></i>
                    Contact Form
                </a>
            </div>
        </div>
    </nav>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sidebar-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const target = this.getAttribute('data-target');
                const section = document.getElementById(target);
                if (!section) {
                    return;
                }
                section.classList.toggle('open');
                this.classList.toggle('active');
            });
        });
    });
</script>
<!-- Sidebar End -->
