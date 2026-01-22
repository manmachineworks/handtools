<style>
.pagination-wrapper { text-align:center; margin-top:30px; }

.loading-overlay{
    position:absolute; inset:0; background:rgba(255,255,255,.7);
    display:flex; align-items:center; justify-content:center;
    opacity:0; pointer-events:none; transition:opacity .2s ease; z-index:5;
}
.loading-overlay.show{ opacity:1; pointer-events:all; }

.sidebar-sticky{ position: sticky; top: 110px; }
@media (max-width: 991px){ .sidebar-sticky{ position: static; top: auto; } }

.widget-card{
    background:#fff;
    border:1px solid #eee;
    border-radius:14px;
    padding:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}
.widget-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    margin-bottom:12px;
}
.widget_title{ font-size:16px; font-weight:900; color:#111; margin:0; }
.widget-sub{ font-size:12px; color:#777; }

.modern-search .search-input-wrap{ position:relative; }
.modern-search input{
    width:100%; height:44px; border-radius:12px; border:1px solid #e7e7e7;
    padding:10px 46px 10px 12px; outline:none; transition:.2s ease;
}
.modern-search input:focus{
    border-color:#ff5906; box-shadow:0 0 0 4px rgba(255,89,6,.12);
}
.modern-search button{
    position:absolute; right:6px; top:50%; transform:translateY(-50%);
    width:36px; height:36px; border:none; border-radius:10px;
    background:#ff5906; color:#fff; display:flex; align-items:center; justify-content:center;
}
.clear-search{ display:inline-block; margin-top:10px; font-size:13px; color:#666; text-decoration:underline; }

.modern-accordion{ max-height:520px; overflow:auto; padding-right:6px; }
.modern-accordion::-webkit-scrollbar{ width:6px; }
.modern-accordion::-webkit-scrollbar-thumb{ background:#e6e6e6; border-radius:10px; }

.category-group{
    border:1px solid #f0f0f0; border-radius:12px; margin-bottom:10px; overflow:hidden;
}
.category-toggle{
    width:100%; background:#fff; border:none; padding:12px 12px; font-weight:900; color:#111;
    display:flex; align-items:center; justify-content:space-between; cursor:pointer;
}
.category-toggle:focus{ outline:2px solid #ff5906; outline-offset:2px; }
.category-toggle .chev{
    width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center;
    background:#f7f7f7; transition:.2s ease;
}
.category-group.is-open .category-toggle .chev{ background:rgba(255,89,6,.10); color:#ff5906; }
.category-group.is-open .category-toggle i{ transform:rotate(180deg); }

.subcategory-list{
    list-style:none; margin:0; padding:6px 6px 10px; display:none; background:#fff;
}
.subcategory-list.show{ display:block; }
.subcategory-list li a{
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    padding:10px 10px; border-radius:10px; color:#444; text-decoration:none; font-size:13px;
    transition:.15s ease;
}
.subcategory-list li a:hover{ background:#f7f7f7; }
.subcategory-list li.active > a{
    background:rgba(231,9,46,.08); color:#e7092e; font-weight:900;
}
.pill{ font-size:11px; padding:4px 8px; border-radius:999px; background:#f2f2f2; color:#666; }

.clamp-titlee{
    padding:16px 20px; border-radius:10px; font-size:18px; line-height:1.4;
    background:#f9f9f9; margin-bottom:10px; display:-webkit-box;
    -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; height:calc(1.9em * 2);
}
.clamp-titlee a{
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
    overflow:hidden; text-overflow:ellipsis; color:inherit; text-decoration:none; font-weight:700;
}
.clamp-titlee a:hover{ text-decoration:underline; }
@media (max-width:576px){ .clamp-titlee{ font-size:14px; padding:12px 16px; } }

.clamp-titlee2{ font-size:18px; line-height:1.4; }
.clamp-titlee2 a{
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
    overflow:hidden; text-overflow:ellipsis; color:inherit; text-decoration:none; font-weight:700;
}
.clamp-titlee2 a:hover{ text-decoration:underline; color:#ff5906; transition:all ease .4s; }
@media (max-width:576px){ .clamp-titlee2{ font-size:14px; padding:12px 16px; } }

.mobile-filter-bar{
    display:none; margin: 0 0 14px; gap:10px; align-items:center; justify-content:space-between;
}
@media (max-width: 991px){ .mobile-filter-bar{ display:flex; } }
.btn-filter{
    display:inline-flex; align-items:center; gap:8px;
    border:none; border-radius:12px; padding:10px 14px;
    background:#111; color:#fff; font-weight:800;
}
.btn-filter:focus{ outline:2px solid #ff5906; outline-offset:2px; }
.text-muted-sm{ font-size:12px; color:#777; }

.offcanvas-backdrop{
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    opacity:0; pointer-events:none; transition:.2s ease; z-index:9998;
}
.offcanvas-backdrop.show{ opacity:1; pointer-events:all; }

.sidebar-offcanvas{
    position:fixed; top:0; left:0; height:100vh; width:min(92vw, 380px);
    background:#fff; transform:translateX(-102%); transition:.25s ease;
    z-index:9999; padding:16px 14px; overflow:auto;
    box-shadow:0 20px 60px rgba(0,0,0,.25);
}
.sidebar-offcanvas.show{ transform:translateX(0); }

.offcanvas-head{
    display:flex; align-items:center; justify-content:space-between;
    padding-bottom:10px; margin-bottom:12px; border-bottom:1px solid #eee;
}
.offcanvas-title{ font-size:16px; font-weight:900; margin:0; color:#111; }
.offcanvas-close{
    width:40px; height:40px; border:none; border-radius:12px;
    background:#f3f3f3; display:flex; align-items:center; justify-content:center;
}
.offcanvas-close:hover{ background:#eaeaea; }

.sidebar-shop .widget_categories li a {
    border-bottom: 1px solid #E1E1E1;
    padding: 7px !important;
    margin: 8px !important;
}
.widget_nav_menu a span, .widget_meta a span, .widget_pages a span, .widget_archive a span, .wp-block-page-list a span, .widget_categories a span {
    margin-left: 5px;
}


/* ===========================
   Equal height cards
=========================== */
.row.align-items-stretch { align-items: stretch; }

.portfolio-card{
  height: 100%;
  display: flex;
  flex-direction: column;
}

/* push bottom section to bottom so all cards look equal */
.portfolio-card-details{
  margin-top: auto;
}

/* ===========================
   1:1 square image + overflow hidden
=========================== */
.portfolio-card-thumb{
  position: relative;
}

/* Make the <a> act like a square image box */
.portfolio-card-thumb > a{
  display: block;
  width: 100%;
  aspect-ratio: 1 / 1;   /* ✅ 1:1 */
  overflow: hidden;      /* ✅ overflow hidden */
}

/* Make image fill the square */
.portfolio-card-thumb > a > img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}

/* Optional: keep titles consistent height */
.clamp-titlee,
.clamp-titlee2{
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.clamp-titlee{ -webkit-line-clamp: 2; min-height: 2.7em; }
.clamp-titlee2{ -webkit-line-clamp: 2; min-height: 2.7em; }

</style>
