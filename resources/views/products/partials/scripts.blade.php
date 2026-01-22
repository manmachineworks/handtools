<script>
document.addEventListener('DOMContentLoaded', function () {
    const accordion = document.getElementById('categoryAccordion');
    const productGrid = document.getElementById('productGrid');
    const pagination = document.getElementById('productPagination');
    const loader = document.getElementById('productLoading');

    const openBtn = document.getElementById('openFilter');
    const closeBtn = document.getElementById('closeFilter');
    const panel = document.getElementById('filterPanel');
    const backdrop = document.getElementById('filterBackdrop');

    function openOffcanvas(){
        if(!panel || !backdrop) return;
        panel.classList.add('show');
        backdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeOffcanvas(){
        if(!panel || !backdrop) return;
        panel.classList.remove('show');
        backdrop.classList.remove('show');
        document.body.style.overflow = '';
    }

    openBtn?.addEventListener('click', openOffcanvas);
    closeBtn?.addEventListener('click', closeOffcanvas);
    backdrop?.addEventListener('click', closeOffcanvas);
    document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeOffcanvas(); });

    if (accordion) {
        accordion.addEventListener('click', function (e) {
            const toggle = e.target.closest('.category-toggle');
            if (!toggle) return;

            const group = toggle.closest('.category-group');
            const list = group?.querySelector('.subcategory-list');
            if (!group || !list) return;

            const isOpen = group.classList.contains('is-open');
            group.classList.toggle('is-open', !isOpen);
            list.classList.toggle('show', !isOpen);
            toggle.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        });
    }

    function setActiveLink(link) {
        document.querySelectorAll('.subcategory-list li').forEach(li => li.classList.remove('active'));
        const parentLi = link.closest('li');
        if (parentLi) parentLi.classList.add('active');
    }

    function fetchProducts(url) {
        if (!productGrid) return;
        loader?.classList.add('show');

        fetch(url, { headers: {'X-Requested-With': 'XMLHttpRequest'} })
            .then(res => res.json())
            .then(data => {
                productGrid.innerHTML = data.html || '';
                if (pagination) pagination.innerHTML = data.pagination || '';
            })
            .catch(() => {
                productGrid.innerHTML = '<div class="text-center py-4"><p class="mb-0">Unable to load products right now.</p></div>';
                if (pagination) pagination.innerHTML = '';
            })
            .finally(() => loader?.classList.remove('show'));
    }

    document.addEventListener('click', function (e) {
        const catLink = e.target.closest('.ajax-category-link[data-ajax="true"]');
        if (catLink) {
            e.preventDefault();
            const url = catLink.getAttribute('href');
            setActiveLink(catLink);
            fetchProducts(url);
            window.history.replaceState({}, '', url);
            closeOffcanvas();
            return;
        }

        const link = e.target.closest('.subcategory-link[data-ajax="true"]');
        if (link) {
            e.preventDefault();
            const url = link.getAttribute('href');
            setActiveLink(link);
            fetchProducts(url);
            window.history.replaceState({}, '', url);
            closeOffcanvas();
            return;
        }

        const pageLink = e.target.closest('#productPagination a');
        if (pageLink) {
            e.preventDefault();
            fetchProducts(pageLink.href);
            window.history.replaceState({}, '', pageLink.href);
        }
    });
});
</script>
