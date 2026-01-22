<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <div class="sidebar-header text-center py-4">
            <a href="/"><img src="/assets/new_assets/images/svg/logo.png" alt="Gurunanak Hand Tool"
                    class="logo-img"></a>
        </div>

        <div class="navbar-nav w-100">
            <a href="/admin/dashboard" class="nav-item nav-link active"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Products</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/add_product" class="dropdown-item">Add Product</a>
                    <a href="/admin/products" class="dropdown-item">Show Products</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-tags me-2"></i>Brands</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/brands/create" class="dropdown-item">Add Brand</a>
                    <a href="/admin/brands" class="dropdown-item">Show Brands</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Blogs</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/blogs/create" class="dropdown-item">Create Blogs</a>
                    <a href="/admin/blogs_show" class="dropdown-item">Show Blogs</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Categories</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/categories/create" class="dropdown-item">Create Categories</a>
                    <a href="/admin/categories/" class="dropdown-item">Show Categories</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>SubCategories</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/subcategories/create" class="dropdown-item">Create Sub Categories</a>
                    <a href="/admin/subcategories" class="dropdown-item">Show Sub Categories</a>
                </div>
            </div>

            <div class="nav-item">
                <a href="/admin/metas" class="nav-item nav-link"><i class="fa fa-laptop me-2"></i>Pages Meta</a>
            </div>

            <div class="nav-item dropdown">
                <a href="/admin/home/content" class="nav-link"><i class="fa fa-laptop me-2"></i>Home Content</a>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Forms</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="/admin/apply" class="dropdown-item">Apply Form</a>
                    <a href="/admin/contact" class="dropdown-item">Contact Form</a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->

<script>
    document.querySelectorAll('.dropdown > a').forEach(drop => {
        drop.addEventListener('click', function (e) {
            e.preventDefault();
            this.parentElement.classList.toggle('active');
        });
    });
</script>