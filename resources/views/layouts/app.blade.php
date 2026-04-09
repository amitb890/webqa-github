<?php
$activeProject = "";
$activeProjectName = "";
$activeProjectFavicon = "";
if(isset($_COOKIE["activeProject"])){
  $state = false;
  $activeProject = "project-" . $_COOKIE["activeProject"];
  $activeProjectName = $_COOKIE["activeProjectName"];
  $activeProjectFavicon = $_COOKIE["activeProjectFavicon"];

  foreach($userProjects as $pr){
    $prVal = "project-" . $pr->id;

        // Count the occurrences of "project-"
    $countActive = substr_count($activeProject, "project-");

    // If "project-" appears twice, remove one occurrence
    if ($countActive == 2) {
        $activeProject = preg_replace('/project-/', '', $activeProject, 1); // Replace only the first occurrence
    }
    if($prVal === $activeProject){
      $state = true;
    }
  }

  if(!$state){
    $project = $userProjects->first();
    $activeProject = "project-" . $project->id;
    $activeProjectName = $project->name;
    $activeProjectFavicon = $project->favicon;
  }

}else{
  $project = $userProjects->first();
  $activeProject = "project-" . $project->id;
  $activeProjectName = $project->name;
  $activeProjectFavicon = $project->favicon;
}

// Normalize favicon URL to current host if it was saved with a local host (127.0.0.1 / localhost)
if (!empty($activeProjectFavicon)) {
    $origin = request()->getSchemeAndHttpHost(); // e.g. https://webqa.co

    $replacements = [
        'http://127.0.0.1:8000',
        'https://127.0.0.1:8000',
        'http://localhost:8000',
        'https://localhost:8000',
    ];

    foreach ($replacements as $localHost) {
        if (strpos($activeProjectFavicon, $localHost) === 0) {
            $path = parse_url($activeProjectFavicon, PHP_URL_PATH) ?? '';
            $activeProjectFavicon = rtrim($origin, '/') . $path;
            break;
        }
    }
}



?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- OG and Twitter Tags -->
        <!-- Open Graph (OG) Meta Tags -->
        <meta property="og:title" content="This is the twitter title for homepage">
        <meta property="og:type" content="webisite">
        <meta property="og:url" content="https://webqa.co/">
        <meta property="og:image" content="{{ asset('new-assets/meta-tags/Open Graph Image-Home-1.5.png') }}">
        <meta property="og:image:alt" content="">
        <meta property="og:description" content="This is the description title for homepage">


        <!-- Twitter Meta Tags -->
        <meta name="twitter:title" content="This is the twitter title for homepage">
        <meta name="twitter:description" content="This is the twitter description for homepage">
        <meta name="twitter:image" content="{{ asset('new-assets/meta-tags/Open Graph Image-Home-1.5.png') }}">
        <meta name="twitter:image:alt" content="This is twitter image alt">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">


        <!-- bootstrap styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap/css/bootstrap.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}"/>
        <!-- font awesome styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/fontawesome/css/all.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- custom styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/assets/fonts/font-styles.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.res.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/datatables.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- nice select -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbNiXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" type="image/x-icon" href="{{ asset('new-assets/assets/images/favicon.ico') }}{{ \App\Http\Helpers::getCacheBuster() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('new-assets/assets/images/apple-icon-180x180.png') }}{{ \App\Http\Helpers::getCacheBuster() }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('new-assets/assets/images/android-chrome-192x192.png') }}{{ \App\Http\Helpers::getCacheBuster() }}">
        
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-NRZQHZTZ');</script>
        @yield("css")
  </head>
  <body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NRZQHZTZ"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      
   <!-- header main starts -->
   <header id="headerMain" class="header_main">
      <nav class="navbar_main">
        <div class="container-fluid main-header-container container-fluid-dash">
          <a href="{{route('index')}}" class="navbar-brand navbar-brand-dash">
            <img
              src="/new-assets/assets/images/webQA_logo.png"
              alt="WebQA"
              width="78"
              height="16"
              class="img-fluid"
            />
          </a>

          <form class="search_box {{\Request::route()->getName() === 'dashboard' ? 'd-none' : '' }}" id="urlSearchForm">
            <input type="hidden" id="login_user_id" value="{{ auth()->user()->id }}">
            <input
              id="urlValue"
              type="text"
              class="form-control"
              name="search"
              placeholder="Enter a url to run a test..."
              value=""
            />

           

            <div id="validationPopup" class="validationPopup">
              <span class="validationPopupText">Please enter a valid URL</span>
            </div>

            <div class="search_utils">
              <div class="customize_test">
                <span>
                  Customize Test
                </span>                
              </div>
              <a href="#" id="startTest" class="btn_primary rounded-pill search_utils_btn">Test Now</a>
            </div>
          </form>

          <button class="search_box_icon ms-auto me-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-search"
            >
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </button>
 <div class="user_control">
            <div class="dropdown project-toggle-container {{\Request::route()->getName() === 'dashboard' ? 'd-none' : '' }}">
              <a
                class="dropdown-toggle p-2"
                href="#"
                {{-- role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false" --}}
              >
                <span class="icon">
                  @if($activeProjectFavicon == "default" || $activeProjectFavicon == "")
                  <img id="activeFavicon" src="/new-assets/assets/images/updated-header-profile-dropdown/header-globe.svg" alt="icon">                          
                  @else
                  <img id="activeFavicon" src="{{$activeProjectFavicon}}" alt="icon">
                  @endif
                </span>
                <span class="d-sm-inline" id="activeProject" data-favicon="{{ $activeProjectFavicon }}" data-name="{{$activeProjectName}}" data-val="{{$activeProject}}">{{$activeProjectName}}</span>
                <span class="user_control-arrow">
                  <img src="/new-assets/assets/images/updated-header-profile-dropdown/header-arrow.svg" alt="">
                </span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end header-dropdown dropdown-menu-projects header-dropdown-imran" style="padding-top: 0px">
                <div class="header-dropdown-list">
                    @foreach($userProjects as $project)
                      @php
                          $newVal = "project-" . $project->id;
                      @endphp

                      @if($newVal != $activeProject)
                          <?php
                          $faviVal = $project->favicon == "default" ? "/new-assets/assets/images/amazon.png" : $project->favicon;
                          ?>
                          
                        <li><a class="dropdown-item select-project" href="#" data-favicon="{{ $faviVal }}" data-val="project-{{ $project->id }}" data-name="{{ $project->name }}">
                          @if($project->favicon == "default")
                          <img src="/new-assets/assets/images/amazon.png" alt="icon">                          
                          @else
                          <img src="{{$project->favicon}}" alt="icon">
                          @endif
                          {{ $project->name }}
                        </a></li>
                      @endif

                      @endforeach
                </div>
                <div class="drop-header-but">
                  <button><a class="{{\Request::route()->getName() === 'projects.index' ? 'active' : '' }}" href="{{ route('projects.index') }}">My Projects</a></button>
                  <button><a class="{{\Request::route()->getName() === 'projects.create' ? 'active' : '' }}" href="{{ route('projects.create') }}">Create a new Project</a></button>
                </div>
              </ul>
            </div>
            <div class="dropdown">
              <a
                class="dropdown-toggle-two-2 dropdown-toggle"
                href="#"
                {{-- role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false" --}}
              >
               <?php
                  $words = array(auth()->user()->name); 
                  $initials = implode('/', array_map(function ($name) { 
                      preg_match_all('/\b\w/', $name, $matches);
                      return implode('', $matches[0]);
                  }, $words));
               ?>
                <span class="profile_icon text-uppercase">{{ $initials }}</span>
                <span class="profile_icon_arrow">

                  <img src="/new-assets/assets/images/updated-header-profile-dropdown/header-arrow.svg" alt="">

                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end user-dropdown user-dropdown-imran">
                <div class="user-dropdown-list">

                  <li>

                    <a class="dropdown-item {{\Request::route()->getName() === 'profile.index' ? 'active' : '' }}" href="{{ route('profile.index') }}">



                      <svg width="23" height="23" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">

<path d="M0.296939 10.32C0.277273 4.83522 4.79211 0.308428 10.2921 0.3C15.7922 0.291572 20.263 4.77061 20.2967 10.306C20.3304 15.7439 15.8015 20.2829 10.3258 20.2997C4.82957 20.3232 0.316605 15.831 0.296939 10.32ZM8.05204 12.1573C5.64619 10.2844 6.00206 7.44698 7.45362 5.98987C8.20741 5.23885 9.22783 4.8167 10.2919 4.81565C11.356 4.81459 12.3772 5.23473 13.1325 5.98425C14.6019 7.45541 14.9362 10.2872 12.5435 12.1554C14.6169 12.9252 16.0562 14.3383 16.8813 16.3863C20.0654 13.0423 20.2199 7.33929 16.4646 3.76673C12.7841 0.26535 6.93855 0.523812 3.52035 4.41008C0.178009 8.20925 0.913155 13.5873 3.72451 16.3667C4.543 14.3333 5.98551 12.9315 8.05204 12.1611V12.1573ZM10.2912 12.8128C9.06017 12.8087 7.85797 13.1853 6.84924 13.8909C5.84051 14.5964 5.07457 15.5966 4.65631 16.7543C4.543 17.0653 4.57109 17.2432 4.84361 17.4576C7.96963 19.8924 12.6352 19.8924 15.7519 17.4492C16.0019 17.2535 16.0534 17.0905 15.9457 16.789C15.5312 15.6226 14.7643 14.614 13.7513 13.9026C12.7382 13.1913 11.5291 12.8124 10.2912 12.8185V12.8128ZM13.2936 8.7861C13.2906 8.19407 13.1124 7.61618 12.7813 7.12536C12.4502 6.63454 11.9811 6.25279 11.4333 6.02828C10.8854 5.80376 10.2834 5.74655 9.70304 5.86387C9.12272 5.98118 8.59014 6.26776 8.17253 6.68743C7.75492 7.10711 7.47099 7.64108 7.35657 8.22196C7.24215 8.80284 7.30236 9.40459 7.52962 9.95128C7.75687 10.498 8.14097 10.9651 8.63346 11.2937C9.12595 11.6223 9.70475 11.7977 10.2968 11.7977C11.0919 11.795 11.8536 11.4775 12.4152 10.9147C12.9768 10.3519 13.2926 9.58959 13.2936 8.79453V8.7861Z" fill="#444444" stroke="#444444" stroke-width="0.6"/>

</svg>

                      My account

                    </a>

                  </li>

                  <li>

                    <a class="dropdown-item" onclick="event.preventDefault();

                                        document.getElementById('logout-form').submit();" 

                        href="{{ route('logout') }}">

                        <svg width="21" height="21" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

<path d="M0 16.7946V3.20538C0 2.3553 0.338174 1.54037 0.939274 0.939274C1.54037 0.338174 2.3553 0 3.20538 0H7.08837L7.21674 0.00617132C7.85429 0.0706729 8.35226 0.609323 8.35226 1.26389C8.35226 1.91845 7.85429 2.4571 7.21674 2.5216L7.08837 2.52777H3.20538C3.0257 2.52777 2.85354 2.59944 2.72649 2.72649C2.59944 2.85354 2.52777 3.0257 2.52777 3.20538V16.7946C2.52777 16.9743 2.59944 17.1465 2.72649 17.2735C2.85354 17.4006 3.0257 17.4722 3.20538 17.4722H7.08837C7.78621 17.4725 8.35226 18.0382 8.35226 18.7361C8.35226 19.434 7.78621 19.9998 7.08837 20H3.20538C2.3553 20 1.54037 19.6618 0.939274 19.0607C0.338174 18.4596 0 17.6447 0 16.7946ZM12.9894 4.25327C13.483 3.75969 14.283 3.75969 14.7766 4.25327L19.6297 9.10639C19.8667 9.34342 20 9.6648 20 10C20 10.3352 19.8667 10.6566 19.6297 10.8936L14.7766 15.7467C14.283 16.2403 13.483 16.2403 12.9894 15.7467C12.4958 15.2532 12.4958 14.4531 12.9894 13.9595L15.685 11.2639H7.08837C6.39035 11.2639 5.82449 10.698 5.82449 10C5.82449 9.30198 6.39035 8.73611 7.08837 8.73611H15.685L12.9894 6.04048C12.4958 5.54691 12.4958 4.74685 12.9894 4.25327Z" fill="#444444" stroke="#444444" stroke-width="0.1"/>

</svg>

                        Log out

                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                  </li>

                </div>

              </ul>

            </div>

          </div>



          <button id="menuBtn" class="menu-btn ms-3" type="button">

            <span></span><span></span><span></span>

          </button>

        </div>

      </nav>

    </header>

    <!-- header main ends -->

    <!-- mobile menu starts -->
    <aside
      class="offcanvas offcanvas-start"
      tabindex="-1"
      id="offcanvasMobileMenu"
      aria-labelledby="offcanvasMobileMenuLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body">
        <div class="user_control">
          <div class="dropdown">
            <a
              class="dropdown-toggle p-2"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <span class="icon">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z"
                    stroke="#6E6E6E"
                    stroke-width="1.3"
                    stroke-miterlimit="10"
                  />
                  <path
                    d="M1.45572 6.33333H16.5445"
                    stroke="#6E6E6E"
                    stroke-width="1.3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M1.45572 11.6667H16.5443"
                    stroke="#6E6E6E"
                    stroke-width="1.3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M8.99999 16.7852C10.8409 16.7852 12.3333 13.2996 12.3333 8.99993C12.3333 4.70026 10.8409 1.21468 8.99999 1.21468C7.15904 1.21468 5.66666 4.70026 5.66666 8.99993C5.66666 13.2996 7.15904 16.7852 8.99999 16.7852Z"
                    stroke="#6E6E6E"
                    stroke-width="1.3"
                    stroke-miterlimit="10"
                  />
                </svg>
              </span>
              Sohanlalso
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
            </ul>
          </div>
          <div class="dropdown">
            <a
              class="dropdown-toggle btn btn-outline-gray rounded-pill p-1 pe-2"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <span class="profile_icon">JD</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
            </ul>
          </div>
        </div>
      </div>
    </aside>
    <!-- mobile menu ends -->

        <!-- main sections starts -->
        <main class="main-sections">
    <section class="sidebar">
        <aside class="main-sidebar-menu">
          <div class="main-sidebar-top">
            <div class="msbt-items">
              <a href="{{ route('dashboard') }}" >
                <img src="{{asset('new-assets/assets/images/new-sidebar/Group-1083.svg')}}" alt="">
                <p class="hidden-left">Dashboard</p>
              </a>
            </div>
            <div class="msbt-items">
              <a href="" id="sidebarSettingsLink">
                <img src="{{asset('new-assets/assets/images/new-sidebar/Settings.svg')}}" alt="">
                <p class="hidden-left">Settings</p>
              </a>
            </div>
            <div class="msbt-items">
              <a id="reportsItem">
                <img src="{{asset('new-assets/assets/images/new-sidebar/Group-932.svg')}}" alt="">
              <p class="hidden-left">Reports</p>
              </a>
            </div>
          </div>
          <div class="main-sidebar-lower">
            <div class="msbl-items" data-bs-toggle="offcanvas" data-bs-target="#analysis_sidebar" aria-controls="analysis_sidebar">
              <a type="button">
                <img src="{{asset('new-assets/assets/images/new-sidebar/Group-1083 (2).svg')}}" alt="">
                <p class="hidden-left">Feature Request</p>
              </a>
            </div>
            <div class="msbl-items">
              <a href="">
                <img src="{{asset('new-assets/assets/images/new-sidebar/Vector.svg')}}" alt="">
                <p class="hidden-left">Help</p>
              </a>
            </div>
          </div>
          <span id="sidebar-pin">
            <img src="{{asset('new-assets/assets/images/new-sidebar/Layer_1.svg')}}" alt="">
          </span>
        </aside>
        <aside class="sub-sidebar">
          <div class="sub-sidebar-top">
            <div class="ssbt-search">
              <span class="ssbt-search-icon">
                <img src="{{asset('new-assets/assets/images/new-sidebar/Search.svg')}}" alt="search">
              </span>
              <input type="search" placeholder="Search">
            </div>
            <div class="ssbt-search-results"></div>
            <div class="ssbt-header">
              <p><a href="{{route('tracker')}}">Website tracker</a></p>
            </div>
          </div>
          <div class="sub-sidebar-lower" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <div class="ssbl-item">
              <div class="ssbl-item-top nav-link" id="v-pills-meta-tab"
                {{-- data-bs-toggle="pill"
                data-bs-target="#v-pills-meta"
                type="button"
                role="tab"
                aria-controls="v-pills-meta"
                aria-selected="true" --}}
                >
                <p>SEO</p>
                <img src="{{asset('new-assets/assets/images/new-sidebar/plus.svg')}}" alt="">
              </div>
              <ul id="ssbl-item-top-seo" class="ssbl-item-top-seo">
                <li data-report-setting="meta_title"><a href="/reports/meta-title"><p>Meta Title</p></a></li>
                <li data-report-setting="meta_desc"><a href="/reports/description"><p>Meta Description</p></a></li>
                <li data-report-setting="robots_meta"><a href="/reports/robots-meta"><p>Robots Meta</p></a></li>
                <li data-report-setting="canonical_url"><a href="/reports/canonical"><p>Canonical</p></a></li>
                <li data-report-setting="url_slug"><a href="/reports/url-slug"><p>URL Slug</p></a></li>
                <li data-report-setting="images"><a href="/reports/images"><p>Images</p></a></li>
                <li data-report-setting="robot_text_test"><a href="/reports/robotstxt"><p>Robots.txt</p></a></li>
                <li data-report-setting="h1_heading_tag"><a href="/reports/headings"><p>Headings</p></a></li>
                <li data-report-setting="http_status_code"><a href="/reports/http-status-code"><p>HTTP Status code</p></a></li>
                <li data-report-setting="xml_sitemap"><a href="/reports/xml-sitemap"><p>XML Sitemap</p></a></li>
                <li data-report-setting="html_sitemap"><a href="/reports/html-sitemap"><p>HTML Sitemap</p></a></li>
                <li data-report-setting="open_graph_tags"><a href="/reports/og-tags"><p>Open Graph Tags</p></a></li>
                <li data-report-setting="twitter_tags"><a href="/reports/twitter-tags"><p>Twitter Tags</p></a></li>
                <li data-report-setting="doctype"><a href="/reports/doctype"><p>Doctype</p></a></li>
                <li data-report-setting="meta_viewport"><a href="/reports/meta-viewport"><p>Viewport</p></a></li>
                <li data-report-setting="favicon"><a href="/reports/favicon"><p>Favicon</p></a></li>
              </ul>
            </div>
            <div class="ssbl-item">
              <div class="ssbl-item-top nav-link" id="v-pills-performance-tab"
                {{-- data-bs-toggle="pill"
                data-bs-target="#v-pills-performance"
                type="button"
                role="tab"
                aria-controls="v-pills-performance"
                aria-selected="false" --}}
                >
                <p>Performance</p>
                <img src="{{asset('new-assets/assets/images/new-sidebar/plus.svg')}}" alt="">
              </div>
              <ul id="ssbl-item-top-perfor" class="ssbl-item-top-perfor">
                <li data-report-setting="google_overall"><a href="/reports/google-page-speed-insights"><p>Overall Score</p></a></li>
                <li data-report-setting="google_lighthouse"><a href="/reports/google-page-speed-lighthouse"><p>Lighthouse Score</p></a></li>
                <li data-report-setting="core_web_vitals"><a href="/reports/google-page-speed-core-web-vitals"><p>Core Web Vitals</p></a></li>
                <li data-report-setting="mobile_friendly"><a href="/reports/mobile-friendly"><p>Mobile Friendliness</p></a></li>
              </ul>
            </div>
            <div class="ssbl-item">
              <div class="ssbl-item-top nav-link" id="v-pills-coding-tab"
                {{-- data-bs-toggle="pill"
                data-bs-target="#v-pills-coding"
                type="button"
                role="tab"
                aria-controls="v-pills-coding"
                aria-selected="false" --}}
                >
                <p>Best Practices</p>
                <img src="{{asset('new-assets/assets/images/new-sidebar/plus.svg')}}" alt="">
              </div>
              <ul id="ssbl-item-top-bestPrac" class="ssbl-item-top-bestPrac">
                <li data-report-setting="gzip_compression"><a href="/reports/gzip-compression"><p>Gzip Compression</p></a></li>
                <li data-report-setting="html_compression"><a href="/reports/html-compression"><p>HTML Compression</p></a></li>
                <li data-report-setting="css_compression"><a href="/reports/css-compression"><p>CSS Compression</p></a></li>
                <li data-report-setting="js_compression"><a href="/reports/js-compression"><p>JS Compression</p></a></li>
                <li data-report-setting="css_caching_enable"><a href="/reports/css-caching"><p>CSS caching</p></a></li>
                <li data-report-setting="js_caching_enable"><a href="/reports/js-caching"><p>JS caching</p></a></li>
                <li data-report-setting="page_size"><a href="/reports/page-size"><p>Page size</p></a></li>
                <li data-report-setting="nested_tables"><a href="/reports/nested-tables"><p>Nested Tables</p></a></li>
                <li data-report-setting="frameset"><a href="/reports/frameset"><p>Frameset</p></a></li>
                <li data-report-setting="broken_links"><a href="/reports/broken-links"><p>Broken links</p></a></li>
              </ul>
            </div>
            <div class="ssbl-item">
              <div class="ssbl-item-top nav-link" id="v-pills-security-tab"
                {{-- data-bs-toggle="pill"
                data-bs-target="#v-pills-security"
                type="button"
                role="tab"
                aria-controls="v-pills-security"
                aria-selected="false" --}}
                >
                <p>Security</p>
                <img src="{{asset('new-assets/assets/images/new-sidebar/plus.svg')}}" alt="">
              </div>
              <ul id="ssbl-item-top-security" class="ssbl-item-top-security">
                <li data-report-setting="is_safe_browsing"><a href="/reports/safe-browsing"><p>Safe browsing</p></a></li>
                <li data-report-setting="cross_origin_links"><a href="/reports/unsafe-cross-origin-links"><p>Unsafe cross origin links</p></a></li>
                <li data-report-setting="protocol_relative_resource"><a href="/reports/protocol-relative-resource"><p>Protocol relative resource links</p></a></li>
                <li data-report-setting="content_security_policy_header"><a href="/reports/content-security-policy-header"><p>Content Security Policy Header</p></a></li>
                <li data-report-setting="x_frame_options_header"><a href="/reports/x-frame-options-header"><p>X Frame Option Header</p></a></li>
                <li data-report-setting="hsts_header"><a href="/reports/hsts-header"><p>HSTS Header</p></a></li>
                <li data-report-setting="bad_content_type"><a href="/reports/bad-content-type"><p>Bad content Type</p></a></li>
                <li data-report-setting="ssl_certificate_enable"><a href="/reports/ssl-certificate"><p>SSL Certificate</p></a></li>
                <li data-report-setting="folder_browsing_enable"><a href="/reports/directory-browsing"><p>Directory Browsing</p></a></li>
              </ul>
            </div>
          </div>
        </aside>
      </section>
      <div class="inner_content {{\Request::route()->getName() === 'settings.index' ? 'setting-inner-content' : '' }}">
        <div class="container-fluid">
       
    


        <!-- MODAL CUSTOMIZER -->
          <div class="modal fade" id="modalCustomizer" aria-hidden="true" aria-labelledby="modalCustomizerLabel" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                      <div class="modal-body">


                        <div class="element-main-area">
                          <div class="element-cls">
                            <div class="form-check">
                              <input class="form-check-input input-check-all" id="input-check-all-imran" type="checkbox" id="" checked>
                              <label class="form-check-label" id="form-check-label-imran" for="element_all">
                                Select All
                              </label>
                            </div>
                            <span>
                            <button type="button" class="btn-close" aria-label="Close"></button>
                            </span>
                          </div>
                          <div class="element-main-single">
                            <div class="single-element-content" id="accordianMetaTags">
                              <div class="element-check-title">
                                <div class="form-check">
                                    <input class="form-check-input input-check-all"  type="checkbox" id="metaTagsCheckAll" checked>
                                    <label class="form-check-label" for="metaTagsCheckAll">
                                    SEO
                                    </label>
                                </div>
                              </div>
                              <div class="inner-element-content"></div>
                            </div>


                            <div class="single-element-content" id="accordianPerformance">
                              <div class="element-check-title over_check_title">
                                <div class="form-check">
                                    <input class="form-check-input input-check-all" type="checkbox" id="performanceCheckAll" checked>
                                    <label class="form-check-label" for="performanceCheckAll">
                                    Performance
                                    </label>
                                </div>
                              </div>
                              <div class="inner-element-content"></div>
                            </div>

                            <div class="single-element-content" id="accordianCBP">
                              <div class="element-check-title over_check_title2">
                                <div class="form-check">
                                    <input class="form-check-input input-check-all" type="checkbox" id="CBPCheckAll" checked>
                                    <label class="form-check-label" for="CBPCheckAll">
                                      Best Practices
                                    </label>
                                </div>
                              </div>
                              <div class="inner-element-content"></div>
                            </div>

                            <div class="single-element-content" id="accordianSecurity">
                              <div class="element-check-title over_check_title2">
                                <div class="form-check">
                                    <input class="form-check-input input-check-all" type="checkbox" id="securityCheckAll" checked>
                                    <label class="form-check-label" for="securityCheckAll">
                                    Security
                                    </label>
                                </div>
                              </div>
                              <div class="inner-element-content"></div>
                            </div>

                          </div>
                        </div>

                        
                      </div>
                  </div>
              </div>
          </div>
          <!-- CUSTOMIZER END -->





          <div class="analysis-content-body-switch-project" style="display: none; padding-left: 1000px">
          </div>
          <div class="analysis-content-body-message" style="display: none">
          </div>
          
          @include("components.loader")
          @include("components.modal-idea")

          @yield("content")

          </div>
          <!-- Setting area end  -->
      </div>
    </main>
    <!-- main sections ends -->


    <!-- footer -->
    <footer class="footer-area">
      <div class="footer-items">
        <div class="footer-logo">
          <a href="#"><img src="/new-assets/assets/images/webQA_logo_faded.png" alt="footer-logo"></a>
        </div>
        <div class="footer-menu">
          <nav>
            <ul>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">FAQ's</a></li>
              <li><a href="#">How It Works</a></li>
              <li><a href="https://webqa.co/public/support/">Help and Support</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </footer>
    <!-- footer -->

    <!-- jQuery -->
    <script src="{{ asset('new-assets/vendor/jQurey/jquery-3.6.1.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <!-- bootstrap scripts -->
    <script src="{{ asset('new-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/vendor/fontawesome/js/all.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('new-assets/vendor/luxon/luxon.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/vendor/datatables/datatables.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>


    <!-- custom scripts -->
    <script src="{{ asset('js/app.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/js/functions.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/js/main.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>

    <script src="{{ asset('new-assets/js/pdf-images.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/js/imran.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>


  @php
  $defaultReportSettings = [
      'meta_title' => 1,
      'meta_desc' => 1,
      'robots_meta' => 1,
      'canonical_url' => 1,
      'url_slug' => 1,
      'open_graph_tags' => 1,
      'twitter_tags' => 1,
      'favicon' => 1,
      'xml_sitemap' => 1,
      'html_sitemap' => 1,
      'meta_viewport' => 1,
      'frameset' => 1,
      'doctype' => 1,
      'http_status_code' => 1,
      'page_size' => 1,
      'hsts_header' => 1,
      'content_security_policy_header' => 1,
      'nested_tables' => 1,
      'x_frame_options_header' => 1,
      'ssl_certificate_enable' => 1,
      'bad_content_type' => 1,
      'folder_browsing_enable' => 1,
      'css_caching_enable' => 1,
      'js_caching_enable' => 1,
      'mobile_friendly' => 1,
      'is_safe_browsing' => 1,
      'cross_origin_links' => 1,
      'protocol_relative_resource' => 1,
      'h1_heading_tag' => 1,
      'robot_text_test' => 1,
      'broken_links' => 1,
      'images' => 1,
      'html_compression' => 1,
      'css_compression' => 1,
      'js_compression' => 1,
      'gzip_compression' => 1,
      'google_overall' => 1,
      'google_lighthouse' => 1,
      'core_web_vitals' => 1,
  ];
  @endphp

  @auth
  <script>
      let plusIcon = "{{ asset('new-assets/assets/images/new-sidebar/plus.svg') }}";
      let minusIcon = "{{ asset('new-assets/assets/images/new-sidebar/minus-sign.svg') }}";
      
      // Get report settings from database
      var userSettings = @json(\App\Models\ReportSettings::where('user_id', auth()->id())->first());
      console.log('Database query result:', userSettings);
      console.log('User ID:', {{ auth()->id() }});
      
      window.reportSettings = userSettings || @json($defaultReportSettings);
      
      // Debug: Log final settings
      console.log('Final window.reportSettings:', window.reportSettings);
      console.log('Meta Title value:', window.reportSettings.meta_title, 'Type:', typeof window.reportSettings.meta_title);
      
      // Verify settings are set
      if (typeof window.reportSettings === 'undefined') {
          console.error('ERROR: window.reportSettings is undefined!');
      } else {
          console.log('Success: window.reportSettings is defined');
      }
  </script>
  @else
  <script>
      // User not authenticated - use default settings
      console.warn('User not authenticated - using default report settings');
      window.reportSettings = @json($defaultReportSettings);
      
      // Verify settings are set
      if (typeof window.reportSettings === 'undefined') {
          console.error('ERROR: window.reportSettings is undefined!');
      } else {
          console.log('Success: window.reportSettings is defined (default)');
      }
  </script>
  @endauth
  

    <script src="{{ asset('new-assets/js/app.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>

    <!-- Project selection session update script -->
    <script>
        $(document).ready(function() {
            // Handle project selection from dropdown
            $('.select-project').on('click', function(e) {
                e.preventDefault();
                
                const projectVal = $(this).data('val');
                const projectName = $(this).data('name');
                const projectFavicon = $(this).data('favicon');
                
                // Extract project ID from the data-val (format: "project-{id}")
                const projectId = projectVal.split('-')[1];
                
                // Update the active project display
                $('#activeProject').text(projectName);
                $('#activeProject').attr('data-val', projectVal);
                $('#activeProject').attr('data-name', projectName);
                $('#activeProject').attr('data-favicon', projectFavicon);
                $('#activeFavicon').attr('src', projectFavicon);
                
                // Update cookies
                setCookie('activeProject', projectId, 7);
                setCookie('activeProjectName', projectName, 7);
                setCookie('activeProjectFavicon', projectFavicon, 7);
                
                // Update session via AJAX
                $.ajax({
                    url: '/set-active-project',
                    method: 'POST',
                    data: {
                        project_id: projectId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 1) {
                            console.log('Active project updated in session');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating active project in session:', error);
                    }
                });
            });
        });
        
        // Helper function to set cookies (if not already defined)
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
        document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector(".ssbt-search input");
        const searchResults = document.querySelector(".ssbt-search-results");
        const subSidebarLower = document.querySelector(".sub-sidebar-lower");
        const ssbtHeader = document.querySelector(".ssbt-header");
        const subSidebarTop = document.querySelector(".sub-sidebar-top");

        if (!searchInput) {
          console.warn("❌ Search input not found in DOM");
          return;
        }

        console.log("✅ Search input detected:", searchInput);

        // Normalize text
        const normalize = (text) => text.toLowerCase().trim();

        searchInput.addEventListener("input", function () {
          console.log("Typing works ✅");
          const query = normalize(this.value);
          searchResults.innerHTML = "";

          if (query === "") {
            subSidebarLower.style.display = "";
            ssbtHeader.style.display = "";
            subSidebarTop.classList.remove("search-active");
            searchResults.style.display = "none";
            return;
          }

          subSidebarLower.style.display = "none";
          ssbtHeader.style.display = "none";
          subSidebarTop.classList.add("search-active");
          searchResults.style.display = "block";

          const allLists = document.querySelectorAll(
            ".ssbl-item-top-seo, .ssbl-item-top-perfor, .ssbl-item-top-bestPrac, .ssbl-item-top-security"
          );

          allLists.forEach((ul) => {
            const parentTitle = ul.closest(".ssbl-item").querySelector(".ssbl-item-top p").textContent.trim();
            const matchingItems = [];

            ul.querySelectorAll("li").forEach((li) => {
              const text = li.textContent.trim();
              if (normalize(text).includes(query)) {
                matchingItems.push(li.cloneNode(true));
              }
            });

            if (matchingItems.length > 0) {
              const parentDiv = document.createElement("div");
              parentDiv.classList.add("search-parent-block");

              const parentHeading = document.createElement("h4");
              parentHeading.textContent = parentTitle;
              parentHeading.classList.add("search-parent-title");
              parentDiv.appendChild(parentHeading);

              const resultList = document.createElement("ul");
              matchingItems.forEach((li) => resultList.appendChild(li));
              parentDiv.appendChild(resultList);

              searchResults.appendChild(parentDiv);
            }
          });
        });

        // Close search when clicking outside
        document.addEventListener("click", (e) => {
          const isInsideSearch = e.target.closest(".ssbt-search, .ssbt-search-results");
          if (!isInsideSearch) {
            searchResults.style.display = "none";
            subSidebarLower.style.display = "";
            ssbtHeader.style.display = "";
          }
        });
      });


      document.addEventListener("DOMContentLoaded", function () {
      const searchInput = document.querySelector(".ssbt-search input");
      const searchResults = document.querySelector(".ssbt-search-results");
      const subSidebarLower = document.querySelector(".sub-sidebar-lower");
      const ssbtHeader = document.querySelector(".ssbt-header");
      const subSidebarTop = document.querySelector(".sub-sidebar-top");

      // Normalize text helper
      const normalize = (text) => text.toLowerCase().trim();

      // Typing / Searching handler
     searchInput.addEventListener("input", function () {
    const query = normalize(this.value);
    searchResults.innerHTML = ""; // clear previous results

    if (query === "") {
      // Reset state when input is empty
      subSidebarLower.style.display = "";
      ssbtHeader.style.display = "";
      subSidebarTop.classList.remove("search-active");
      searchResults.style.display = "none";
      return;
    }

    // Hide normal sidebar sections
    subSidebarLower.style.display = "none";
    ssbtHeader.style.display = "none";
    subSidebarTop.classList.add("search-active");
    searchResults.style.display = "block";

    // Collect all ULs in sub-sidebar-lower
    const allLists = document.querySelectorAll(
      ".ssbl-item-top-seo, .ssbl-item-top-perfor, .ssbl-item-top-bestPrac, .ssbl-item-top-security"
    );

    allLists.forEach((ul) => {
      const parent = ul.closest(".ssbl-item");
      if (!parent) return;

      const parentTitle = parent.querySelector(".ssbl-item-top p")?.textContent?.trim() || "";
      const matchingItems = [];

      ul.querySelectorAll("li").forEach((li) => {
        const text = li.textContent.trim();
        if (normalize(text).includes(query)) {
          matchingItems.push(li.cloneNode(true));
        }
      });

      if (matchingItems.length > 0) {
        const parentDiv = document.createElement("div");
        parentDiv.classList.add("search-parent-block");

        const parentHeading = document.createElement("h4");
        parentHeading.textContent = parentTitle;
        parentHeading.classList.add("search-parent-title");
        parentDiv.appendChild(parentHeading);

        const resultList = document.createElement("ul");
        matchingItems.forEach((li) => resultList.appendChild(li));
        parentDiv.appendChild(resultList);

        searchResults.appendChild(parentDiv);
      }
    });
  });

    document.addEventListener("click", (e) => {
    const isInsideSearch = e.target.closest(".ssbt-search, .ssbt-search-results");
    const isInsideSubSidebar = e.target.closest(".sub-sidebar");

    // If clicked outside of search input/results
    if (!isInsideSearch) {
      // Reset visuals
      searchResults.style.display = "none";
      subSidebarLower.style.display = "";
      ssbtHeader.style.display = "";

      // ✅ Always restore the ::after line when clicking outside
      subSidebarTop.classList.remove("search-active");

      // 🔥 Force a reflow so ::after repaints correctly
      void subSidebarTop.offsetHeight;

      // Add a quick "refresh" class to retrigger CSS rendering
      subSidebarTop.classList.add("force-refresh");
      setTimeout(() => {
        subSidebarTop.classList.remove("force-refresh");
      }, 50);
    }

    // If clicked *inside* sub-sidebar while typing
    if (isInsideSubSidebar && searchInput.value.trim() !== "") {
      searchResults.style.display = "none";
    }
  });

});
</script>

    @yield("js")
    <div id="backgroundBackdrop" style="display: none;"></div>

  </body>
</html>