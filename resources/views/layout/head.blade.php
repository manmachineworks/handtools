<head>
  @php
    $meta = $meta ?? (object) [];
    $title = $meta->title ?? 'Gurunanak Hand Tools | Industrial-Grade Tools for Workshops & Industries';
    $keywords = $meta->keyword ?? 'Gurunanak Hand Tools, industrial tools India, spanners, pliers, wrenches, sockets, cutters, hammers, tool trolleys, non-sparking tools, insulated tools, stainless steel tools, welding machines, workshops India';
    $description = $meta->description ?? 'Gurunanak Hand Tools delivers industrial-grade tools for workshops and industries across India. 25+ years of experience, strength and reliability, precision performance, and a full range from spanners to welding machines.';
    $canonicalUrl = $meta->canonical ?? url()->current();
    $ogImage = $meta->image ?? asset('assets/img/banner/Advanced-Polishing-img.avif');
  @endphp
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge">
  <meta http-equiv="Content-Language" content="en-IN">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  <title>{{ $title }}</title>
  <meta name="keywords" content="{{ $keywords }}">
  <meta name="description" content="{{ $description }}">

  {{-- Favicon --}}
  <link rel="shortcut icon" href="/assets/new_assets/images/svg/favicon.png">
  <link rel="icon" type="image/x-icon" href="/assets/new_assets/images/svg/favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/new_assets/images/svg/favicon32x32.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/new_assets/images/svg/favicon192x192.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/new_assets/images/svg/favicon180x180.png">
  <!--<link rel="manifest" href="{{ asset('site.webmanifest') }}">-->

  {{-- Theme / verification --}}
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <!-- <meta name="google-site-verification" content="f2yyhKhjrvQ3wnWE5OLcihWc_xrpkhJHwo1KzejNWTs"> -->

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ $title }}">
  <meta property="og:description"
    content="{{ $description }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ $canonicalUrl }}">
  <meta property="og:image" content="{{ $ogImage }}">
  <meta property="og:site_name" content="Gurunanak Hand Tools">

  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $title }}">
  <meta name="twitter:description" content="{{ $description }}">
  <meta name="twitter:image" content="{{ $ogImage }}">
  <meta name="twitter:site" content="@">


  <link rel="stylesheet" href="/assets/assets/css/style.css">

  <!-- ===============================
 Bootstrap (framework overrides base)
 =============================== -->

  <link rel="stylesheet" href="/assets/new_assets/css/bootstrap.min.css">

  <!-- ===============================
 Vendor / Plugin Styles
 =============================== -->

  <link rel="preload" href="/assets/assets/css/fontawesome.min.css" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="/assets/assets/css/fontawesome.min.css">
  </noscript>

  <link rel="stylesheet" href="/assets/new_assets/css/slick.css">
  <link rel="stylesheet" href="/assets/new_assets/css/magnific-popup.min.css">

  <!-- ===============================
 Theme / Layout Styles
 =============================== -->

  <link rel="stylesheet" href="/assets/new_assets/css/style.css">
  <link rel="stylesheet" href="/assets/new_assets/css/media_query.css">

  <!-- ===============================
 Custom Overrides (highest priority)
 =============================== -->

  <link rel="stylesheet" href="/assets/custom/style.css">
  <link rel="stylesheet" href="/assets/new_assets/css/swap.css">

  {{-- Hero logo preload to help LCP/CLS --}}
  <link rel="preload" as="image" href="/assets/new_assets/images/svg/logo.png">


  <style>
    svg {
      height: 20px !important;
    }
  </style>

  @stack('head')
</head>
