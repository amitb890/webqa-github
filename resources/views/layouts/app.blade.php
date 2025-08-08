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
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.css') }}"/>
        <!-- font awesome styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/fontawesome/css/all.min.css') }}" />
        <!-- custom styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/assets/fonts/font-styles.css') }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.css') }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.res.css') }}" />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/datatables.min.css') }}" />
        <!-- nice select -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
  <body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NRZQHZTZ"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      
   <!-- header main starts -->
   <header id="headerMain" class="header_main">
      <nav class="navbar_main">
        <div class="container-fluid ">
          <a href="{{route('index')}}" class="navbar-brand">
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
              <a href="#" id="startTest" class="btn btn_primary rounded-pill">Test Now</a>
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
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <span class="icon">
                  @if($activeProjectFavicon == "default" || $activeProjectFavicon == "")
                  <img id="activeFavicon" src="/new-assets/assets/images/amazon.png" alt="icon">                          
                  @else
                  <img id="activeFavicon" src="{{$activeProjectFavicon}}" alt="icon">
                  @endif
                </span>
                <span class="d-sm-inline" id="activeProject" data-favicon="{{ $activeProjectFavicon }}" data-name="{{$activeProjectName}}" data-val="{{$activeProject}}">{{$activeProjectName}}</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end header-dropdown dropdown-menu-projects" style="padding-top: 0px">
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
                class="dropdown-toggle btn btn-outline-gray rounded-pill p-1 pe-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
               <?php
                  $words = array(auth()->user()->name); 
                  $initials = implode('/', array_map(function ($name) { 
                      preg_match_all('/\b\w/', $name, $matches);
                      return implode('', $matches[0]);
                  }, $words));
               ?>
                <span class="profile_icon text-uppercase">{{ $initials }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                <div class="user-dropdown-list">
                  <li><a class="dropdown-item {{\Request::route()->getName() === 'profile.index' ? 'active' : '' }}" href="{{ route('profile.index') }}"><img src="/new-assets/assets/images/user-pro.png" alt="icon">My Profile
                    </a></li>
                  <li><a class="dropdown-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" 
                        href="{{ route('logout') }}"><img src="/new-assets/assets/images/logout.png" alt="icon">Logout</a>
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
        <aside class="sidebar_menu">
          <ul class="sidebar_menu__top">
            <li class="sidebar_menu__item">
              <a href="{{ route('dashboard') }}" class="sidebar_menu__item_link">
                <svg
                  width="18"
                  height="17"
                  viewBox="0 0 18 17"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M15.3 0H2.7C1.98392 0 1.29716 0.284464 0.790812 0.790812C0.284464 1.29716 0 1.98392 0 2.7V9.9C0 10.6161 0.284464 11.3028 0.790812 11.8092C1.29716 12.3155 1.98392 12.6 2.7 12.6H8.1V14.4H4.5C4.2613 14.4 4.03239 14.4948 3.8636 14.6636C3.69482 14.8324 3.6 15.0613 3.6 15.3C3.6 15.5387 3.69482 15.7676 3.8636 15.9364C4.03239 16.1052 4.2613 16.2 4.5 16.2H13.5C13.7387 16.2 13.9676 16.1052 14.1364 15.9364C14.3052 15.7676 14.4 15.5387 14.4 15.3C14.4 15.0613 14.3052 14.8324 14.1364 14.6636C13.9676 14.4948 13.7387 14.4 13.5 14.4H9.9V12.6H15.3C16.0161 12.6 16.7028 12.3155 17.2092 11.8092C17.7155 11.3028 18 10.6161 18 9.9V2.7C18 1.98392 17.7155 1.29716 17.2092 0.790812C16.7028 0.284464 16.0161 0 15.3 0ZM16.2 9.9C16.2 10.1387 16.1052 10.3676 15.9364 10.5364C15.7676 10.7052 15.5387 10.8 15.3 10.8H2.7C2.46131 10.8 2.23239 10.7052 2.0636 10.5364C1.89482 10.3676 1.8 10.1387 1.8 9.9V2.7C1.8 2.46131 1.89482 2.23239 2.0636 2.0636C2.23239 1.89482 2.46131 1.8 2.7 1.8H15.3C15.5387 1.8 15.7676 1.89482 15.9364 2.0636C16.1052 2.23239 16.2 2.46131 16.2 2.7V9.9Z"
                    fill="#ACBFD9"
                  />
                </svg>
              
              <span class="side_content">Dashboard</span>
            </a>
            </li>
       
            <li class="sidebar_menu__item">
              <a href="" id="sidebarSettingsLink" class="sidebar_menu__item_link">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M16.2369 9.59392C16.0926 9.4297 16.0131 9.21859 16.0131 9C16.0131 8.78141 16.0926 8.5703 16.2369 8.40608L17.3887 7.11026C17.5157 6.96868 17.5945 6.79053 17.6139 6.60138C17.6333 6.41223 17.5923 6.2218 17.4967 6.0574L15.697 2.94382C15.6024 2.77961 15.4584 2.64945 15.2855 2.57189C15.1126 2.49433 14.9196 2.47333 14.7341 2.51188L13.0423 2.85384C12.8271 2.89832 12.603 2.86246 12.4123 2.75305C12.2217 2.64363 12.0777 2.46822 12.0075 2.25992L11.4585 0.613141C11.3982 0.434406 11.2832 0.279164 11.1298 0.169359C10.9764 0.0595529 10.7923 0.000736816 10.6037 0.0012238H7.00415C6.80792 -0.00901865 6.61373 0.0452515 6.45124 0.155745C6.28875 0.266239 6.16689 0.426883 6.10428 0.613141L5.60034 2.25992C5.53015 2.46822 5.38615 2.64363 5.1955 2.75305C5.00485 2.86246 4.78075 2.89832 4.56548 2.85384L2.82872 2.51188C2.65284 2.48703 2.47354 2.51478 2.3134 2.59165C2.15327 2.66851 2.01946 2.79105 1.92884 2.94382L0.129088 6.0574C0.0311457 6.21996 -0.0128925 6.40933 0.00326975 6.59843C0.019432 6.78753 0.094967 6.96667 0.219076 7.11026L1.36192 8.40608C1.50619 8.5703 1.58575 8.78141 1.58575 9C1.58575 9.21859 1.50619 9.4297 1.36192 9.59392L0.219076 10.8897C0.094967 11.0333 0.019432 11.2125 0.00326975 11.4016C-0.0128925 11.5907 0.0311457 11.78 0.129088 11.9426L1.92884 15.0562C2.02342 15.2204 2.16742 15.3505 2.34031 15.4281C2.51321 15.5057 2.70618 15.5267 2.89171 15.4881L4.58348 15.1462C4.79875 15.1017 5.02285 15.1375 5.2135 15.247C5.40415 15.3564 5.54815 15.5318 5.61834 15.7401L6.16727 17.3869C6.22988 17.5731 6.35174 17.7338 6.51423 17.8443C6.67672 17.9547 6.87091 18.009 7.06714 17.9988H10.6667C10.8553 17.9993 11.0393 17.9404 11.1927 17.8306C11.3462 17.7208 11.4612 17.5656 11.5215 17.3869L12.0705 15.7401C12.1407 15.5318 12.2847 15.3564 12.4753 15.247C12.666 15.1375 12.8901 15.1017 13.1053 15.1462L14.7971 15.4881C14.9826 15.5267 15.1756 15.5057 15.3485 15.4281C15.5214 15.3505 15.6654 15.2204 15.76 15.0562L17.5597 11.9426C17.6553 11.7782 17.6963 11.5878 17.6769 11.3986C17.6575 11.2095 17.5787 11.0313 17.4517 10.8897L16.2369 9.59392ZM14.8961 10.7998L15.616 11.6096L14.4641 13.6074L13.4023 13.3914C12.7542 13.2589 12.08 13.369 11.5077 13.7008C10.9354 14.0325 10.5048 14.5629 10.2977 15.1912L9.95575 16.199H7.65206L7.32811 15.1732C7.12101 14.5449 6.69044 14.0146 6.11814 13.6828C5.54584 13.351 4.87164 13.2409 4.22353 13.3734L3.16168 13.5894L1.99184 11.6006L2.71174 10.7908C3.15444 10.2958 3.39918 9.65505 3.39918 8.991C3.39918 8.32695 3.15444 7.6862 2.71174 7.19125L1.99184 6.38136L3.14368 4.40163L4.20553 4.6176C4.85364 4.75008 5.52784 4.63999 6.10014 4.30822C6.67244 3.97645 7.10301 3.4461 7.31011 2.81784L7.65206 1.80098H9.95575L10.2977 2.82684C10.5048 3.4551 10.9354 3.98545 11.5077 4.31722C12.08 4.64898 12.7542 4.75908 13.4023 4.62659L14.4641 4.41062L15.616 6.40835L14.8961 7.21824C14.4583 7.71206 14.2166 8.3491 14.2166 9.009C14.2166 9.6689 14.4583 10.3059 14.8961 10.7998ZM8.80391 5.40049C8.09199 5.40049 7.39606 5.6116 6.80413 6.00712C6.21219 6.40264 5.75083 6.9648 5.47839 7.62253C5.20596 8.28025 5.13467 9.00399 5.27356 9.70223C5.41245 10.4005 5.75527 11.0418 6.25867 11.5452C6.76207 12.0486 7.40344 12.3915 8.10168 12.5303C8.79992 12.6692 9.52366 12.598 10.1814 12.3255C10.8391 12.0531 11.4013 11.5917 11.7968 10.9998C12.1923 10.4078 12.4034 9.71192 12.4034 9C12.4034 8.04535 12.0242 7.1298 11.3491 6.45476C10.6741 5.77972 9.75856 5.40049 8.80391 5.40049ZM8.80391 10.7998C8.44795 10.7998 8.09999 10.6942 7.80402 10.4964C7.50805 10.2987 7.27737 10.0176 7.14115 9.68874C7.00493 9.35987 6.96929 8.998 7.03873 8.64888C7.10818 8.29977 7.27959 7.97908 7.53129 7.72738C7.78299 7.47568 8.10368 7.30427 8.45279 7.23483C8.80191 7.16538 9.16378 7.20102 9.49264 7.33724C9.82151 7.47346 10.1026 7.70414 10.3004 8.00011C10.4981 8.29608 10.6037 8.64404 10.6037 9C10.6037 9.47732 10.414 9.9351 10.0765 10.2726C9.73901 10.6101 9.28123 10.7998 8.80391 10.7998Z"
                    fill="#ACBFD9"
                  />
                </svg>
              
              <span class="side_content button_allignment">Settings
              
              </span>
            </a>
            </li>

            <li class="sidebar_menu__item collapsed">
              <a href="#" id="sidebarSettingsLink"
              data-bs-toggle="collapse"
              data-bs-target=".settingsCollapse" aria-expanded="false"
              aria-controls="settingsCollapse"
              class="sidebar_menu__item_link">
              
                <svg fill="rgb(172, 191, 217)"  version="1.1"
                 id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink" 
                  viewBox="0 0 606.816 606.816"
                  width="18"
                  height="18"
                   xml:space="preserve" stroke="rgb(172, 191, 217)"><g id="SVGRepo_bgCarrier"
                    stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M477.884,79.917h-50.825c-11.908-7.781-24.874-13.455-36.857-17.557c-5.595-14.695-14.537-27.921-26.047-38.28 C347.263,8.875,325.688,0.5,303.408,0.5c-22.281,0-43.854,8.374-60.747,23.581c-11.509,10.36-20.452,23.586-26.046,38.28 c-11.984,4.102-24.949,9.776-36.857,17.557h-50.825c-32.058,0-58.14,26.082-58.14,58.14v410.118 c0,32.059,26.082,58.141,58.14,58.141h348.951c32.058,0,58.14-26.082,58.14-58.141V138.057 C536.023,105.999,509.941,79.917,477.884,79.917z M253.876,87.36c0.491-2.551,1.149-5.034,1.947-7.442 c7.067-21.335,25.7-36.578,47.585-36.578c21.885,0,40.518,15.243,47.585,36.578c0.798,2.409,1.456,4.891,1.947,7.442 c1.117,5.81,5.572,10.378,11.294,11.885c20.769,5.473,37.699,13.664,48.5,23.512c1.703,1.553,3.259,3.146,4.648,4.777 c6.852,8.046,1.201,20.417-9.367,20.417H198.801c-10.568,0-16.218-12.37-9.367-20.417c1.389-1.632,2.945-3.224,4.648-4.777 c10.801-9.849,27.732-18.04,48.5-23.512C248.304,97.737,252.758,93.169,253.876,87.36z M493.184,548.176 c0,8.451-6.851,15.301-15.3,15.301h-348.95c-8.45,0-15.3-6.85-15.3-15.301V138.057c0-8.45,6.85-15.3,15.3-15.3h16.175 c-0.507,2.123-0.894,4.28-1.147,6.468c-1.164,10.078,0.478,20.292,4.75,29.538c4.262,9.227,10.955,17.082,19.354,22.717 c9.08,6.091,19.708,9.311,30.735,9.311h209.215c11.027,0,21.655-3.22,30.734-9.312c8.4-5.635,15.094-13.491,19.355-22.717 c4.271-9.246,5.913-19.46,4.75-29.538c-0.253-2.187-0.641-4.344-1.147-6.467h16.175c8.45,0,15.3,6.85,15.3,15.3V548.176 L493.184,548.176z"></path> <path d="M477.884,606.816H128.933c-32.334,0-58.64-26.306-58.64-58.641V138.058c0-32.334,26.306-58.64,58.64-58.64h50.676 c10.493-6.839,22.812-12.71,36.622-17.454c5.656-14.751,14.676-27.976,26.096-38.255C259.312,8.42,281.004,0,303.408,0 s44.097,8.42,61.081,23.709c11.419,10.278,20.439,23.502,26.096,38.255c13.813,4.746,26.133,10.617,36.622,17.454h50.677 c32.334,0,58.64,26.306,58.64,58.64v410.119C536.523,580.511,510.218,606.816,477.884,606.816z M128.933,80.418 c-31.783,0-57.64,25.857-57.64,57.64v410.118c0,31.783,25.857,57.641,57.64,57.641h348.951c31.782,0,57.64-25.857,57.64-57.641 V138.057c0-31.783-25.857-57.64-57.64-57.64H426.91l-0.125-0.082c-10.503-6.863-22.865-12.751-36.746-17.502l-0.222-0.076 l-0.083-0.219c-5.595-14.693-14.556-27.863-25.915-38.086C347.02,9.329,325.565,1,303.408,1s-43.612,8.329-60.412,23.452 c-11.359,10.225-20.32,23.395-25.914,38.086l-0.083,0.219l-0.222,0.076c-13.877,4.749-26.24,10.638-36.746,17.502l-0.125,0.082 H128.933z M477.884,563.977h-348.95c-8.712,0-15.8-7.088-15.8-15.801V138.057c0-8.712,7.088-15.8,15.8-15.8h16.809l-0.147,0.616 c-0.509,2.132-0.892,4.289-1.137,6.409c-1.153,9.987,0.474,20.108,4.708,29.27c4.223,9.144,10.855,16.928,19.179,22.512 c8.997,6.036,19.528,9.226,30.457,9.226h209.215c10.928,0,21.46-3.19,30.456-9.227c8.324-5.584,14.957-13.369,19.18-22.512 c4.232-9.162,5.86-19.283,4.707-29.271c-0.245-2.118-0.627-4.274-1.137-6.408l-0.147-0.616h16.809c8.712,0,15.8,7.088,15.8,15.8 v410.119C493.684,556.889,486.596,563.977,477.884,563.977z M128.934,123.257c-8.161,0-14.8,6.639-14.8,14.8v410.119 c0,8.161,6.639,14.801,14.8,14.801h348.95c8.161,0,14.8-6.64,14.8-14.801V138.057c0-8.161-6.639-14.8-14.8-14.8h-15.545 c0.447,1.971,0.788,3.956,1.015,5.909c1.174,10.171-0.483,20.478-4.793,29.805c-4.301,9.31-11.054,17.236-19.531,22.923 c-9.161,6.147-19.886,9.396-31.013,9.396H198.802c-11.127,0-21.852-3.249-31.014-9.396c-8.477-5.687-15.23-13.613-19.53-22.923 c-4.31-9.329-5.967-19.635-4.792-29.804c0.226-1.956,0.567-3.941,1.014-5.911H128.934z M408.016,148.451H198.801 c-5.066,0-9.531-2.852-11.652-7.444c-2.135-4.622-1.406-9.909,1.904-13.797c1.375-1.614,2.953-3.237,4.692-4.822 c10.89-9.929,27.733-18.099,48.71-23.626c5.579-1.471,9.87-5.983,10.931-11.496c0.482-2.502,1.143-5.027,1.963-7.505 c7.315-22.083,26.629-36.92,48.06-36.92s40.744,14.837,48.06,36.92c0.821,2.48,1.482,5.006,1.964,7.505 c1.061,5.514,5.351,10.026,10.93,11.497c20.979,5.528,37.822,13.698,48.71,23.626c1.736,1.583,3.314,3.205,4.692,4.822 c3.311,3.888,4.04,9.174,1.905,13.796C417.548,145.598,413.082,148.451,408.016,148.451z M303.408,43.84 c-20.999,0-39.931,14.562-47.11,36.235c-0.807,2.437-1.457,4.92-1.93,7.38c-1.134,5.888-5.709,10.706-11.658,12.274 c-20.821,5.486-37.52,13.577-48.291,23.398c-1.708,1.557-3.257,3.149-4.604,4.731c-3.055,3.587-3.728,8.465-1.758,12.729 c1.956,4.233,6.073,6.863,10.745,6.863h209.215c4.672,0,8.79-2.63,10.745-6.864c1.97-4.264,1.296-9.142-1.759-12.729 c-1.35-1.585-2.899-3.177-4.604-4.731c-10.769-9.82-27.468-17.911-48.29-23.398c-5.949-1.567-10.525-6.385-11.658-12.274 c-0.473-2.457-1.122-4.939-1.931-7.379C343.339,58.401,324.407,43.84,303.408,43.84z"></path> </g> <g> <path d="M303.408,109.265c11.941,0,21.622-9.68,21.622-21.622c0-2.723-0.509-5.326-1.427-7.726 c-3.111-8.125-10.978-13.896-20.196-13.896c-9.218,0-17.084,5.771-20.194,13.896c-0.918,2.399-1.427,5.003-1.427,7.726 C281.787,99.585,291.467,109.265,303.408,109.265z"></path> <path d="M303.408,109.765c-12.197,0-22.121-9.924-22.123-22.122c0-2.713,0.491-5.373,1.46-7.904 c3.255-8.504,11.558-14.217,20.661-14.217c9.103,0,17.406,5.713,20.663,14.217c0.969,2.532,1.46,5.191,1.46,7.904 C325.53,99.841,315.606,109.765,303.408,109.765z M303.407,66.521c-8.691,0-16.619,5.455-19.728,13.575 c-0.925,2.417-1.394,4.956-1.394,7.547c0.001,11.646,9.477,21.122,21.123,21.122c11.646,0,21.122-9.475,21.122-21.122 c0-2.59-0.469-5.129-1.394-7.547C320.027,71.977,312.099,66.521,303.407,66.521z"></path> </g> <g> <path d="M187.724,278.191H296.66c11.83,0,21.42-9.59,21.42-21.42c0-11.83-9.591-21.42-21.42-21.42H187.724 c-11.83,0-21.42,9.59-21.42,21.42C166.304,268.601,175.894,278.191,187.724,278.191z"></path> <path d="M296.66,278.691H187.724c-12.087,0-21.92-9.833-21.92-21.92s9.833-21.92,21.92-21.92H296.66 c12.087,0,21.92,9.833,21.92,21.92S308.747,278.691,296.66,278.691z M187.724,235.851c-11.535,0-20.92,9.385-20.92,20.92 c0,11.535,9.385,20.92,20.92,20.92H296.66c11.536,0,20.92-9.385,20.92-20.92c0-11.536-9.385-20.92-20.92-20.92H187.724z"></path> </g> <g> <path d="M419.094,350.871h-231.37c-11.83,0-21.42,9.59-21.42,21.42s9.59,21.42,21.42,21.42h231.37 c11.83,0,21.42-9.59,21.42-21.42S430.924,350.871,419.094,350.871z"></path> <path d="M419.094,394.211h-231.37c-12.087,0-21.92-9.833-21.92-21.92s9.833-21.92,21.92-21.92h231.37 c12.087,0,21.92,9.833,21.92,21.92S431.181,394.211,419.094,394.211z M187.724,351.371c-11.535,0-20.92,9.385-20.92,20.92 s9.385,20.92,20.92,20.92h231.37c11.535,0,20.92-9.385,20.92-20.92s-9.385-20.92-20.92-20.92H187.724z"></path> </g> <g> <path d="M352.891,466.855H187.724c-11.83,0-21.42,9.59-21.42,21.42s9.59,21.42,21.42,21.42h165.167 c11.83,0,21.42-9.59,21.42-21.42S364.721,466.855,352.891,466.855z"></path> <path d="M352.891,510.195H187.724c-12.087,0-21.92-9.833-21.92-21.92s9.833-21.92,21.92-21.92h165.167 c12.087,0,21.92,9.833,21.92,21.92S364.978,510.195,352.891,510.195z M187.724,467.355c-11.535,0-20.92,9.385-20.92,20.92 s9.385,20.92,20.92,20.92h165.167c11.535,0,20.92-9.385,20.92-20.92s-9.385-20.92-20.92-20.92H187.724z"></path> </g> </g> </g> </g></svg>
              
              <span class="side_content button_allignment">Reports
                <button class="showhide-btn collapsed buttonPosition" type="button" data-bs-toggle="collapse"
                data-bs-target=".settingsCollapse" aria-expanded="false"
                aria-controls="settingsCollapse" >
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
              </button>

              </span>
            </a>
            </li>
          
          </ul>
          <ul  class="sidebar_menu__top collapse hide settingsCollapse sidebarPedding" id="metaTagsUl">
            <li class="sidebar_menu__item" class="sidebar_menu__item_link">
              <a type="button" href="{{route('tracker')}}" class="sidebar_menu__item_link">
                <span class="side_content">Website Tracker</span>
              </a>
              
            </li>
            <li class="sidebar_menu__item collapsed" data-bs-toggle="collapse"
            data-bs-target="#settingsCollapseMetaTitles" aria-expanded="false"
            aria-controls="settingsCollapseMetaTitles">
              <span class="side_content">Meta Tags
                <button class="showhide-btn collapsed buttonPosition" type="button" data-bs-toggle="collapse"
                data-bs-target="#settingsCollapseMetaTitles" aria-expanded="false"
                aria-controls="settingsCollapseMetaTitles">
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
                </button>

              </span>
            </li>
           <span id="settingsCollapseMetaTitles" class="collapse hide"> 
           </span>
          </ul>
          
          <ul  class="sidebar_menu__top collapse hide settingsCollapse sidebarPedding" id="imagesUl">
            <span id="settingsCollapseImages"> 
          
          </ul>

          <ul  class="sidebar_menu__top collapse hide settingsCollapse sidebarPedding" id="performanceUl">
            <li class="sidebar_menu__item collapsed" data-bs-toggle="collapse"
            data-bs-target="#settingsCollapsePerformance" aria-expanded="false"
            aria-controls="settingsCollapsePerformance">
              <span class="side_content">Performance
                <button class="showhide-btn collapsed buttonPosition" type="button" data-bs-toggle="collapse"
                data-bs-target="#settingsCollapsePerformance" aria-expanded="false"
                aria-controls="settingsCollapsePerformance">
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
                </button>

              </span>
            </li>
           <span id="settingsCollapsePerformance" class="collapse hide"> 
           </span>
          </ul>

          <ul  class="sidebar_menu__top collapse hide settingsCollapse sidebarPedding" id="codingUl">
            <li class="sidebar_menu__item collapsed" data-bs-toggle="collapse"
            data-bs-target="#settingsCollapsePractices" aria-expanded="false"
            aria-controls="settingsCollapsePractices">
              <span class="side_content">Best Practices
                <button class="showhide-btn collapsed buttonPosition" type="button" data-bs-toggle="collapse"
                data-bs-target="#settingsCollapsePractices" aria-expanded="false"
                aria-controls="settingsCollapsePractices">
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
                </button>

              </span>
            </li>
           <span id="settingsCollapsePractices" class="collapse hide"> 
           </span>
          </ul>

          <ul  class="sidebar_menu__top collapse hide settingsCollapse sidebarPedding" id="securityUl">
            <li class="sidebar_menu__item collapsed" data-bs-toggle="collapse"
            data-bs-target="#settingsCollapseSecurity" aria-expanded="false"
            aria-controls="settingsCollapseSecurity">
              <span class="side_content">Security
                <button class="showhide-btn collapsed buttonPosition" type="button" data-bs-toggle="collapse"
                data-bs-target="#settingsCollapseSecurity" aria-expanded="false"
                aria-controls="settingsCollapseSecurity">
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
                </button>

              </span>
            </li>
           <span id="settingsCollapseSecurity" class="collapse hide"> 
           </span>
          </ul>
          
          <ul class="sidebar_menu__bottom">

          <li class="sidebar_menu__item" data-bs-toggle="offcanvas" data-bs-target="#analysis_sidebar" aria-controls="analysis_sidebar" class="sidebar_menu__item_link">
              <a type="button" >
                <svg
                  width="13"
                  height="18"
                  viewBox="0 0 13 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.6101 6.48901C12.6101 6.42601 12.6101 6.36301 12.6101 6.30001C12.6101 6.23701 12.6101 6.20101 12.6101 6.15601C12.6101 6.11101 12.6101 5.94001 12.6101 5.83201C12.6101 5.72401 12.6101 5.59801 12.6101 5.49001C12.6101 5.38201 12.6101 5.27401 12.5651 5.16601C12.5201 5.05801 12.5201 4.95001 12.4931 4.83301L12.3491 4.50001C12.3491 4.40102 12.2861 4.29302 12.2411 4.18502C12.1961 4.07702 12.1691 3.97802 12.1241 3.87902C12.0791 3.78002 12.0431 3.68102 11.9891 3.58202C11.9435 3.47739 11.8924 3.37524 11.8361 3.27602C11.7998 3.18638 11.7577 3.0992 11.7101 3.01502C11.6554 2.91871 11.5953 2.82557 11.5301 2.73602L11.3411 2.46602L11.1251 2.20502C11.0531 2.12402 10.9811 2.03402 10.9001 1.95302L10.8101 1.84502L10.6661 1.71002L10.5401 1.59302L10.4501 1.52102C10.3511 1.43102 10.2431 1.35002 10.1351 1.26902L9.91007 1.13402C9.77459 1.03566 9.63333 0.945495 9.48707 0.864019L9.37907 0.801019C8.4425 0.273248 7.38511 -0.00272716 6.31007 2.03153e-05H6.06707H5.66208H5.59908H5.50008C5.19659 0.0410567 4.896 0.101176 4.60008 0.18002C3.62177 0.460453 2.72596 0.973716 1.9893 1.6759C1.25264 2.37807 0.697056 3.24827 0.370082 4.21202L0.316082 4.35602C0.227225 4.6511 0.158073 4.95176 0.109082 5.25601C0.104867 5.28285 0.104867 5.31018 0.109082 5.33701C0.109082 5.39101 0.109082 5.43601 0.109082 5.48101C0.109082 5.67001 0.109082 5.85001 0.0640822 6.03901C0.04315 6.09505 0.025126 6.15212 0.0100823 6.21001C0.00564641 6.23985 0.00564641 6.27018 0.0100823 6.30001C-0.00336076 6.5158 -0.00336076 6.73222 0.0100823 6.94801C0.00574724 6.9899 0.00574724 7.03212 0.0100823 7.07401C0.0328468 7.27358 0.0658908 7.47185 0.109082 7.66801C0.12585 7.75005 0.146878 7.83116 0.172082 7.91101C0.213533 8.07881 0.264618 8.24409 0.325082 8.40601C0.325082 8.47801 0.325082 8.55001 0.397082 8.62201C0.486185 8.84679 0.58836 9.06616 0.703081 9.27901C0.704794 9.29998 0.704794 9.32104 0.703081 9.34201C0.8113 9.53824 0.931528 9.7276 1.06308 9.90901L1.18008 10.071C1.30608 10.233 1.43208 10.395 1.57608 10.548L1.66608 10.647L1.76508 10.755C1.92708 10.908 2.08908 11.061 2.26008 11.196C2.37008 11.2835 2.45939 11.3942 2.52163 11.5202C2.58386 11.6463 2.61748 11.7845 2.62008 11.925V14.4C2.62008 15.3548 2.99936 16.2705 3.67449 16.9456C4.34962 17.6207 5.2653 18 6.22007 18C7.17485 18 8.09053 17.6207 8.76566 16.9456C9.44079 16.2705 9.82007 15.3548 9.82007 14.4V11.916C9.82069 11.7808 9.85176 11.6475 9.91097 11.526C9.97018 11.4045 10.056 11.2978 10.1621 11.214C10.3864 11.0895 10.6028 10.9512 10.8101 10.8C11.8778 9.72875 12.5178 8.30466 12.6101 6.79501C12.6101 6.79501 12.6101 6.79501 12.6101 6.75001V6.48901ZM7.21007 10.71V8.86501C7.7943 8.70797 8.32574 8.39718 8.74907 7.96501C8.91855 7.79554 9.01375 7.56568 9.01375 7.32601C9.01375 7.08634 8.91855 6.85649 8.74907 6.68701C8.5796 6.51754 8.34974 6.42233 8.11007 6.42233C7.8704 6.42233 7.64055 6.51754 7.47107 6.68701C7.16025 6.98939 6.74372 7.15857 6.31007 7.15857C5.87643 7.15857 5.4599 6.98939 5.14908 6.68701C4.9796 6.51754 4.74975 6.42233 4.51008 6.42233C4.27041 6.42233 4.04055 6.51754 3.87108 6.68701C3.7016 6.85649 3.6064 7.08634 3.6064 7.32601C3.6064 7.56568 3.7016 7.79554 3.87108 7.96501C4.29441 8.39718 4.82585 8.70797 5.41008 8.86501V10.71C4.60867 10.5427 3.86809 10.16 3.26808 9.60301L3.07908 9.42301C2.9082 9.2468 2.7517 9.0572 2.61108 8.85601L2.50308 8.67601C2.39298 8.5039 2.29667 8.32333 2.21508 8.13601L2.13408 7.96501C2.0432 7.73416 1.97097 7.4964 1.91808 7.25401C1.91381 7.19109 1.91381 7.12794 1.91808 7.06501C1.86863 6.85147 1.83256 6.63505 1.81008 6.41701C1.80556 6.3601 1.80556 6.30292 1.81008 6.24601C1.81131 5.98938 1.8354 5.73337 1.88208 5.48101C1.89478 5.40484 1.91283 5.32966 1.93608 5.25601C1.98057 5.06346 2.03769 4.87405 2.10708 4.68901C2.10708 4.59901 2.17908 4.51801 2.22408 4.42802C2.28953 4.27469 2.3678 4.12717 2.45808 3.98702C2.51582 3.88767 2.57892 3.79153 2.64708 3.69902C2.73305 3.57414 2.82939 3.45672 2.93508 3.34802C3.01124 3.25091 3.09235 3.15779 3.17808 3.06902C3.35429 2.89814 3.54389 2.74164 3.74508 2.60102L4.06008 2.41202C4.19508 2.34002 4.33008 2.25902 4.46508 2.19602L4.77108 2.07902C4.93319 2.0216 5.09846 1.97352 5.26608 1.93502L5.55408 1.87202C5.80395 1.82934 6.05664 1.80527 6.31007 1.80002C6.61203 1.79675 6.91355 1.82389 7.21007 1.88102L7.39907 1.93502C7.60968 1.98551 7.81705 2.04862 8.02007 2.12402C8.11007 2.12402 8.19107 2.21402 8.28107 2.25902C8.4464 2.33046 8.60588 2.41472 8.75807 2.51102C8.84492 2.57012 8.92901 2.63319 9.01007 2.70002C9.16398 2.80426 9.30853 2.92171 9.44207 3.05102L9.55907 3.16802C9.61797 3.22342 9.67216 3.28363 9.72107 3.34802L9.91007 3.60002L10.0451 3.78902L10.1801 3.98702L10.2971 4.19402L10.4051 4.40101L10.5041 4.61701L10.5851 4.84201C10.6144 4.91519 10.6385 4.99039 10.6571 5.06701C10.6571 5.13901 10.7021 5.21101 10.7201 5.29201C10.7394 5.36912 10.7544 5.44724 10.7651 5.52601C10.7694 5.60395 10.7694 5.68207 10.7651 5.76001C10.7695 5.84095 10.7695 5.92207 10.7651 6.00301C10.7697 6.08094 10.7697 6.15908 10.7651 6.23701C10.7696 6.31495 10.7696 6.39308 10.7651 6.47101C10.7292 7.65504 10.228 8.7772 9.37007 9.59401C8.76451 10.1549 8.0179 10.5406 7.21007 10.71ZM8.11007 13.5H6.31007C6.07138 13.5 5.84246 13.5948 5.67368 13.7636C5.5049 13.9324 5.41008 14.1613 5.41008 14.4C5.41008 14.6387 5.5049 14.8676 5.67368 15.0364C5.84246 15.2052 6.07138 15.3 6.31007 15.3H7.85807C7.65764 15.6379 7.35218 15.9009 6.98829 16.0489C6.6244 16.197 6.22208 16.2219 5.8427 16.1199C5.46332 16.0179 5.12772 15.7946 4.88711 15.4841C4.6465 15.1736 4.51409 14.7928 4.51008 14.4V12.339C5.68453 12.6892 6.93562 12.6892 8.11007 12.339V13.5Z"
                    fill="#ACBFD9"
                  />
                </svg>
              </a>
              <span class="side_content">Feature Request</span>
            </li>
        
            <li class="sidebar_menu__item sidebar_menu__item_link">
              <a href="" class="">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8.361 11.961C8.3223 12.0038 8.28623 12.0488 8.253 12.096C8.21894 12.1462 8.1917 12.2006 8.172 12.258C8.14605 12.309 8.12785 12.3636 8.118 12.42C8.11358 12.4799 8.11358 12.5401 8.118 12.6C8.11496 12.7181 8.13962 12.8352 8.19 12.942C8.23042 13.0537 8.29491 13.1551 8.3789 13.2391C8.46289 13.3231 8.56432 13.3876 8.676 13.428C8.78373 13.4756 8.90022 13.5002 9.018 13.5002C9.13579 13.5002 9.25227 13.4756 9.36 13.428C9.47169 13.3876 9.57312 13.3231 9.6571 13.2391C9.74109 13.1551 9.80558 13.0537 9.846 12.942C9.88597 12.8326 9.90431 12.7164 9.9 12.6C9.90069 12.4816 9.87798 12.3641 9.83319 12.2545C9.78841 12.1448 9.72241 12.0451 9.639 11.961C9.55534 11.8766 9.45579 11.8097 9.34612 11.764C9.23645 11.7183 9.11881 11.6948 9 11.6948C8.88119 11.6948 8.76356 11.7183 8.65388 11.764C8.54421 11.8097 8.44467 11.8766 8.361 11.961ZM9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389956 7.20038 -0.17433 9.00998 0.172936 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89471 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 0 9 0ZM9 16.2C7.57598 16.2 6.18393 15.7777 4.9999 14.9866C3.81586 14.1954 2.89302 13.0709 2.34807 11.7553C1.80312 10.4397 1.66054 8.99201 1.93835 7.59535C2.21616 6.19868 2.9019 4.91577 3.90883 3.90883C4.91577 2.90189 6.19869 2.21616 7.59535 1.93835C8.99201 1.66053 10.4397 1.80312 11.7553 2.34807C13.0709 2.89302 14.1954 3.81586 14.9866 4.99989C15.7777 6.18393 16.2 7.57597 16.2 9C16.2 10.9096 15.4414 12.7409 14.0912 14.0912C12.7409 15.4414 10.9096 16.2 9 16.2ZM9 4.5C8.52576 4.49969 8.0598 4.62431 7.64902 4.8613C7.23824 5.09829 6.89712 5.43929 6.66 5.85C6.59488 5.95243 6.55116 6.06698 6.53146 6.18676C6.51176 6.30653 6.51649 6.42905 6.54537 6.54695C6.57425 6.66484 6.62667 6.77568 6.6995 6.87279C6.77232 6.9699 6.86404 7.05127 6.96913 7.11202C7.07421 7.17276 7.19051 7.21162 7.311 7.22626C7.4315 7.2409 7.55371 7.23101 7.67029 7.19719C7.78686 7.16337 7.89539 7.10632 7.98934 7.02947C8.0833 6.95261 8.16074 6.85755 8.217 6.75C8.2963 6.61265 8.41047 6.4987 8.54797 6.41968C8.68547 6.34066 8.84141 6.29937 9 6.3C9.2387 6.3 9.46762 6.39482 9.6364 6.5636C9.80518 6.73238 9.9 6.9613 9.9 7.2C9.9 7.43869 9.80518 7.66761 9.6364 7.83639C9.46762 8.00518 9.2387 8.1 9 8.1C8.76131 8.1 8.53239 8.19482 8.36361 8.3636C8.19482 8.53238 8.1 8.7613 8.1 9V9.9C8.1 10.1387 8.19482 10.3676 8.36361 10.5364C8.53239 10.7052 8.76131 10.8 9 10.8C9.2387 10.8 9.46762 10.7052 9.6364 10.5364C9.80518 10.3676 9.9 10.1387 9.9 9.9V9.738C10.4952 9.52202 10.9956 9.1037 11.3137 8.55618C11.6318 8.00866 11.7473 7.36676 11.6401 6.7427C11.5328 6.11864 11.2097 5.55211 10.7271 5.14216C10.2445 4.73221 9.63319 4.50491 9 4.5Z"
                    fill="#ACBFD9"
                  />
                </svg>
              </a>
              <span class="side_content">Help</span>
            </li>
            <li class="sidebar_menu__item expand_btn sidebar_menu__item_link collaps_sidebar">
              <a href="#" class=" ">
                <svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g filter="url(#filter0_b_1068_1629)">
                    <rect
                      x="1"
                      y="1"
                      width="18"
                      height="18"
                      rx="9"
                      stroke="#ACBFD9"
                      stroke-width="2"
                    />
                  </g>
                  <path
                    d="M8.3 7.7L10.6 10L8.3 12.3C7.9 12.7 7.9 13.3 8.3 13.7C8.7 14.1 9.3 14.1 9.7 13.7L12.7 10.7C12.9 10.5 13 10.3 13 10C13 9.7 12.9 9.5 12.7 9.3L9.7 6.3C9.3 5.9 8.7 5.9 8.3 6.3C7.9 6.7 7.9 7.3 8.3 7.7Z"
                    fill="#ACBFD9"
                  />
                  <defs>
                    <filter
                      id="filter0_b_1068_1629"
                      x="-50"
                      y="-50"
                      width="120"
                      height="120"
                      filterUnits="userSpaceOnUse"
                      color-interpolation-filters="sRGB"
                    >
                      <feFlood flood-opacity="0" result="BackgroundImageFix" />
                      <feGaussianBlur
                        in="BackgroundImageFix"
                        stdDeviation="25"
                      />
                      <feComposite
                        in2="SourceAlpha"
                        operator="in"
                        result="effect1_backgroundBlur_1068_1629"
                      />
                      <feBlend
                        mode="normal"
                        in="SourceGraphic"
                        in2="effect1_backgroundBlur_1068_1629"
                        result="shape"
                      />
                    </filter>
                  </defs>
                </svg>
              </a>
              <span class="side_content">Collapse</span>
            </li>
          </ul>
        </aside>

        <!-- setting menu area start -->
        <div class="setting-menu-area d-sm-none">
          <div class="menu-title">
            <h3>Settings</h3>
          </div>
          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading1">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapse1"
                  aria-expanded="false"
                  aria-controls="flush-collapse1"
                >
                  Website QA
                </button>
              </h2>
              <div
                id="flush-collapse1"
                class="accordion-collapse collapse"
                aria-labelledby="flush-heading1"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <div
                    class="nav flex-column nav-pills me-3"
                    id="v-pills-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <button
                      class="nav-link active"
                      id="v-pills-meta-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-meta"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-meta"
                      aria-selected="true"
                    >
                      Meta tags
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-images-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-images"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-images"
                      aria-selected="false"
                    >
                      Images
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-performance-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-performance"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-performance"
                      aria-selected="false"
                    >
                      Performance
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-onpage-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-onpage"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-onpage"
                      aria-selected="false"
                    >
                      On Page Elements
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-coding-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-coding"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-coding"
                      aria-selected="false"
                    >
                      Best Practices
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-html-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-html"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-html"
                      aria-selected="false"
                    >
                      HTML Practices
                    </button>

                    <button
                      class="nav-link"
                      id="v-pills-other-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-other"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-other"
                      aria-selected="false"
                    >
                      Others
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading2">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapse2"
                  aria-expanded="false"
                  aria-controls="flush-collapse2"
                >
                  Page Speed
                </button>
              </h2>
              <div
                id="flush-collapse2"
                class="accordion-collapse collapse"
                aria-labelledby="flush-heading2"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <div
                    class="nav flex-column nav-pills me-3"
                    id="v-pills-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <button
                      class="nav-link active"
                      id="v-pills-pageitem1-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-pageitem1"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-pageitem1"
                      aria-selected="true"
                    >
                      Page Item1
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-pageitem2-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-pageitem2"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-pageitem2"
                      aria-selected="false"
                    >
                      Page Item2
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-pageitem3-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-pageitem3"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-pageitem3"
                      aria-selected="false"
                    >
                      Page Item3
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading3">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapse3"
                  aria-expanded="false"
                  aria-controls="flush-collapse3"
                >
                  Website Tracker
                </button>
              </h2>
              <div
                id="flush-collapse3"
                class="accordion-collapse collapse"
                aria-labelledby="flush-heading3"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <div
                    class="nav flex-column nav-pills me-3"
                    id="v-pills-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <button
                      class="nav-link active"
                      id="v-pills-webitem1-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-webitem1"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-webitem1"
                      aria-selected="true"
                    >
                      Website Item1
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-webitem2-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-webitem2"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-webitem2"
                      aria-selected="false"
                    >
                      Website Item2
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-webitem3-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-webitem3"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-webitem3"
                      aria-selected="false"
                    >
                      Website Item3
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading4">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapse4"
                  aria-expanded="false"
                  aria-controls="flush-collapse4"
                >
                  Alerts
                </button>
              </h2>
              <div
                id="flush-collapse4"
                class="accordion-collapse collapse"
                aria-labelledby="flush-heading4"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <div
                    class="nav flex-column nav-pills me-3"
                    id="v-pills-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <button
                      class="nav-link active"
                      id="v-pills-alertsitem1-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-alertsitem1"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-alertsitem1"
                      aria-selected="true"
                    >
                      Alerts Item1
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-alertsitem2-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-alertsitem2"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-alertsitem2"
                      aria-selected="false"
                    >
                      Alerts Item2
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-alertsitem3-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-alertsitem3"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-alertsitem3"
                      aria-selected="false"
                    >
                      Alerts Item3
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading5">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapse5"
                  aria-expanded="false"
                  aria-controls="flush-collapse5"
                >
                  SEO Audit
                </button>
              </h2>
              <div
                id="flush-collapse5"
                class="accordion-collapse collapse"
                aria-labelledby="flush-heading5"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <div
                    class="nav flex-column nav-pills me-3"
                    id="v-pills-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <button
                      class="nav-link active"
                      id="v-pills-seoitem1-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-seoitem1"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-seoitem1"
                      aria-selected="true"
                    >
                      SEO Item1
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-seoitem2-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-seoitem2"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-seoitem2"
                      aria-selected="false"
                    >
                      SEO Item2
                    </button>
                    <button
                      class="nav-link"
                      id="v-pills-seoitem3-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#v-pills-seoitem3"
                      type="button"
                      role="tab"
                      aria-controls="v-pills-seoitem3"
                      aria-selected="false"
                    >
                      SEO Item3
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="my-profile">
              <a href="#">
                <span>My Profile</span>
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8.9922 0C7.24482 0.00331996 5.53612 0.514712 4.07422 1.47189C2.61232 2.42906 1.46032 3.7907 0.758536 5.39096C0.0567519 6.99122 -0.164526 8.76103 0.121655 10.4848C0.407836 12.2086 1.18912 13.812 2.37036 15.0996C3.21401 16.0141 4.23793 16.7439 5.37761 17.2431C6.51728 17.7423 7.748 18 8.9922 18C10.2364 18 11.4671 17.7423 12.6068 17.2431C13.7465 16.7439 14.7704 16.0141 15.614 15.0996C16.7953 13.812 17.5766 12.2086 17.8627 10.4848C18.1489 8.76103 17.9276 6.99122 17.2259 5.39096C16.5241 3.7907 15.3721 2.42906 13.9102 1.47189C12.4483 0.514712 10.7396 0.00331996 8.9922 0ZM8.9922 16.2168C7.12589 16.2139 5.33344 15.4873 3.99203 14.1897C4.39929 13.1982 5.0921 12.3502 5.98242 11.7534C6.87273 11.1567 7.92037 10.838 8.9922 10.838C10.064 10.838 11.1117 11.1567 12.002 11.7534C12.8923 12.3502 13.5851 13.1982 13.9924 14.1897C12.651 15.4873 10.8585 16.2139 8.9922 16.2168ZM7.19034 7.20745C7.19034 6.85107 7.29601 6.5027 7.49401 6.20639C7.692 5.91007 7.97341 5.67912 8.30266 5.54275C8.6319 5.40637 8.9942 5.37068 9.34373 5.44021C9.69325 5.50973 10.0143 5.68135 10.2663 5.93334C10.5183 6.18534 10.6899 6.5064 10.7594 6.85592C10.829 7.20545 10.7933 7.56774 10.6569 7.89699C10.5205 8.22624 10.2896 8.50765 9.99326 8.70564C9.69695 8.90363 9.34857 9.00931 8.9922 9.00931C8.51432 9.00931 8.05601 8.81947 7.71809 8.48156C7.38018 8.14364 7.19034 7.68533 7.19034 7.20745ZM15.2176 12.613C14.4127 11.2362 13.1738 10.1652 11.695 9.56789C12.1537 9.04774 12.4526 8.40628 12.5558 7.72047C12.659 7.03467 12.5621 6.33365 12.2768 5.70154C11.9914 5.06943 11.5297 4.53309 10.9471 4.15687C10.3645 3.78064 9.68573 3.58052 8.9922 3.58052C8.29867 3.58052 7.61987 3.78064 7.03726 4.15687C6.45465 4.53309 5.99297 5.06943 5.70763 5.70154C5.42229 6.33365 5.3254 7.03467 5.42859 7.72047C5.53179 8.40628 5.83068 9.04774 6.28941 9.56789C4.81062 10.1652 3.57172 11.2362 2.76677 12.613C2.12525 11.5203 1.7863 10.2764 1.78475 9.00931C1.78475 7.09778 2.5441 5.26453 3.89576 3.91288C5.24742 2.56122 7.08066 1.80186 8.9922 1.80186C10.9037 1.80186 12.737 2.56122 14.0886 3.91288C15.4403 5.26453 16.1996 7.09778 16.1996 9.00931C16.1981 10.2764 15.8591 11.5203 15.2176 12.613Z"
                    fill="#222222"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>
        <!-- setting menu area end -->
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
                              <input class="form-check-input input-check-all" type="checkbox" id="" checked>
                              <label class="form-check-label" for="element_all">
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
                                    <input class="form-check-input input-check-all" type="checkbox" id="metaTagsCheckAll" checked>
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
              <li><a href="#">FAQ’s</a></li>
              <li><a href="#">How It Works</a></li>
              <li><a href="#">Help</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </footer>
    <!-- footer -->

    <!-- jQuery -->
    <script src="{{ asset('new-assets/vendor/jQurey/jquery-3.6.1.min.js') }}"></script>
    <!-- bootstrap scripts -->
    <script src="{{ asset('new-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('new-assets/vendor/fontawesome/js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('new-assets/vendor/luxon/luxon.min.js') }}"></script>
    <script src="{{ asset('new-assets/vendor/datatables/datatables.min.js') }}"></script>


    <!-- custom scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('new-assets/js/functions.js') }}"></script>
    <script src="{{ asset('new-assets/js/main.js') }}"></script>
    <script src="{{ asset('new-assets/js/app.js') }}"></script>

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
    </script>

    @yield("js")
    <div id="backgroundBackdrop" style="display: none;"></div>

  </body>
</html>