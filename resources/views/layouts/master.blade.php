<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <meta name="description" content="@yield('meta-description', config('app.name', 'Laravel'))"/>
        <link rel="canonical" href="@yield('canonical', config('app.name', 'Laravel'))"/>
        <meta property="og:title" content="@yield('og-title', config('app.name', 'Laravel'))">
        <meta property="og:description" content="@yield('og-description', config('app.name', 'Laravel'))">
        <meta property="og:url" content="@yield('og-url', config('app.name', 'Laravel'))">
        <meta property="og:image" content="@yield('og-image', config('app.name', 'Laravel'))">
        <meta property="og:image:alt" content="@yield('og-image-alt', config('app.name', 'Laravel'))">
        <meta name="twitter:title" content="@yield('og-title', config('app.name', 'Laravel'))">
        <meta name="twitter:description" content="@yield('og-description', config('app.name', 'Laravel'))">
        <meta name="twitter:image" content="@yield('og-image', config('app.name', 'Laravel'))">
        <meta name="twitter:image:alt" content="@yield('og-image-alt', config('app.name', 'Laravel'))">
        <meta name="twitter:card" content="summary_large_image">
        <link href="https://cdn.jsdelivr.net/npm/floating-ui@5.2.8/dist/style.min.css" rel="stylesheet">
        <!-- bootstrap styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap/css/bootstrap.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}"/>
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/magnific-popup/magnific-popup.css') }}" />
        <!-- font awesome styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/fontawesome/css/all.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- custom styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/assets/fonts/font-styles.css') }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.res.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/datatables.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />

        <link rel="icon" type="image/x-icon" href="{{ asset('new-assets/assets/images/favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('new-assets/assets/images/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('new-assets/assets/images/android-chrome-192x192.png') }}">
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-NRZQHZTZ');</script>
        @yield("css")
  </head>
  <body class="body_padding">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NRZQHZTZ"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- header main starts -->
    <header id="headerMain" class="header_main genarel_header_main">
      <nav class="navbar_main">
        <div class="container-fluid container-fluid-tool-page header_home_page">
          <a href="{{ route('index') }}" class="navbar-brand" style="margin-left:65px;">
            <img
              src="/new-assets/assets/images/webQA_logo.png"
              alt="WebQA"
              width="78"
              height="16"
              class="img-fluid"
            />
          </a>

          <ul class="genarel_header_items" style="gap:30px;margin-left: -704px;">
            <li><a href="{{ route('tools-landing') }}">Tools</a></li>
            
            <li>
              <div class="dropdown">
                <a
                  class="dropdown-toggle"
                  href="https://webqa.co/features"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <span>Features</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="https://webqa.co/features/webpage-audit">Webpage audit</a></li>
                    <li><a class="dropdown-item" href="https://webqa.co/features/website-tracker">Website tracker</a></li>
                    <li><a class="dropdown-item" href="https://webqa.co/features/settings">Settings</a></li>
                    <li><a class="dropdown-item" href="https://webqa.co/features/reports">Reports</a></li>
                </ul>
              </div>
            </li>
            <li><a href="https://webqa.co/aboutus">About us</a></li>
          </ul>
          <div class="login_area">
                @if(!Auth::user())
                <a type="button" class="header_login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                <a type="button" class="btn btn_primary rounded-pill" data-bs-toggle="modal" data-bs-target="#registerModal">Free Signup</a>
                @else
                <a href="{{route('dashboard')}}" class="btn btn_primary rounded-pill">Dashboard</a>
                @endif
          </div>
       
          
          <button id="header_menuBtn" class="header_menu_btn ms-3" type="button">
            <span></span><span></span><span></span>
          </button>
        </div>
      </nav>
    </header>
    <!-- header main ends -->

    @yield("content")





  @include("components.master-footer")




    @include("components.login-modal")
    @include("components.register-modal")
    @include("components.custom-modal")

    @yield("modals")

    <!-- jQuery -->
    <script src="{{ asset('new-assets/vendor/jQurey/jquery-3.6.1.min.js') }}"></script>
    <!-- bootstrap scripts -->
    <script src="{{ asset('new-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.7.0"></script>
    <script src="{{ asset('new-assets/vendor/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('new-assets/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('new-assets/vendor/datatables/datatables.min.js') }}"></script>

    <!-- custom scripts -->
    <script src="{{ asset('new-assets/js/functions.js') }}"></script>
    <script src="{{ asset('new-assets/js/main.js') }}"></script>
    <script src="{{ asset('new-assets/js/register.js') }}"></script>
      


    @yield("js")

  </body>
</html>