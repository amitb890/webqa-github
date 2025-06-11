<header id="headerMain" class="header_main">
    <nav class="navbar_main">
        <div class="container-fluid">
            <a href="./index.html" class="navbar-brand">
                <img src="/new-assets/assets/images/webQA_logo.png" alt="WebQA" width="78" height="16"
                    class="img-fluid" />
            </a>
            <form class="search_box">
                <input id="urlValue" type="text" class="form-control" name="search"
                    placeholder="Enter a url to run a test..." value="http://mymona.co.in/test/1.html" />
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>

            <div class="user_control">
                <div class="dropdown">
                    <a class="dropdown-toggle p-2" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="icon">
                            @if ($activeProjectFavicon == 'default' || $activeProjectFavicon == '')
                                <img id="activeFavicon" src="/new-assets/assets/images/amazon.png" height="18"
                                    width="18" alt="icon">
                            @else
                                <img id="activeFavicon" src="{{ $activeProjectFavicon }}" height="18" width="18"
                                    alt="icon">
                            @endif
                        </span>
                        <span class="d-sm-inline" id="activeProject" data-favicon="{{ $activeProjectFavicon }}"
                            data-name="{{ $activeProjectName }}"
                            data-val="{{ $activeProject }}">{{ $activeProjectName }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end header-dropdown dropdown-menu-projects">
                        <div class="header-dropdown-list">
                            @foreach ($userProjects as $project)
                                @php
                                    $newVal = 'project-' . $project->id;
                                @endphp

                                @if ($newVal != $activeProject)
                                    <?php
                                    $faviVal = $project->favicon == 'default' ? '/new-assets/assets/images/amazon.png' : $project->favicon;
                                    ?>

                                    <li><a class="dropdown-item select-project" href="#"
                                            data-favicon="{{ $faviVal }}" data-val="project-{{ $project->id }}"
                                            data-name="{{ $project->name }}">
                                            @if ($project->favicon == 'default')
                                                <img src="/new-assets/assets/images/amazon.png" alt="icon">
                                            @else
                                                <img src="{{ $project->favicon }}" alt="icon">
                                            @endif
                                            {{ $project->name }}
                                        </a></li>
                                @endif
                            @endforeach
                        </div>
                        <div class="drop-header-but">
                            <button><a class="{{ \Request::route()->getName() === 'projects.index' ? 'active' : '' }}"
                                    href="{{ route('projects.index') }}">My Projects</a></button>
                            <button><a class="{{ \Request::route()->getName() === 'projects.create' ? 'active' : '' }}"
                                    href="{{ route('projects.create') }}">Create a new Project</a></button>
                        </div>
                    </ul>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle btn btn-outline-gray rounded-pill p-1 pe-2" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        $words = [auth()->user()->name];
                        $initials = implode(
                            '/',
                            array_map(function ($name) {
                                preg_match_all('/\b\w/', $name, $matches);
                                return implode('', $matches[0]);
                            }, $words),
                        );
                        ?>
                        <span class="profile_icon text-uppercase">{{ $initials }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                        <div class="user-dropdown-list">
                            <li><a class="dropdown-item {{ \Request::route()->getName() === 'profile.index' ? 'active' : '' }}"
                                    href="{{ route('profile.index') }}"><img
                                        src="/new-assets/assets/images/user-pro.png" alt="icon">My Profile
                                </a></li>
                            <li><a class="dropdown-item"
                                    onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"
                                    href="{{ route('logout') }}"><img src="/new-assets/assets/images/logout.png"
                                        alt="icon">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf</form>
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
