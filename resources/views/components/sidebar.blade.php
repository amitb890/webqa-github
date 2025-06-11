<div class="sidebar">
    <a class="sidebar-logo" href="{{ route('index') }}">
        <img src="{{ asset('images/logo-dashboard.png') }}" alt="Logo">
    </a>
    <div class="d-flex justify-content-center">
    <a href="#" class="add-project-button">
        <div class="icon-plus"></div>
    </a>
    </div>
    <div class="sidebar-menu">
    <a class="sidebar-link" href="{{ route('dashboard') }}">
        <div class="icon-home-active"></div>
    </a>
    <!-- <a class="sidebar-link" href="#">
        <div class="icon-project"></div>
    </a> -->
    <a class="sidebar-link" href="#">
        <div class="icon-profile"></div>
    </a>
    <a class="sidebar-link" href="#">
        <div class="icon-qa"></div>
    </a>
    <a class="sidebar-link" href="#">
        <div class="icon-settings"></div>
    </a>
    <a class="sidebar-link" href="{{ route('url-discovery') }}">
        <div class="icon-project"></div>
    </a>
    <a class="sidebar-link drop-bottom" href="#">
        <div class="icon-logout"></div>
    </a>
    </div>
</div>