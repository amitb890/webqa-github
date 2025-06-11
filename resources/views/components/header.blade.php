<div class="content-header">
    <button class="button-toggle">
        <div class="icon-toggle"></div>
    </button>
    <div class="content-header-right d-flex align-items-center">
                <select id="project" class="form-control me-2" class="form-control custom-input">
                    @foreach($userProjects as $project)
                    <option value="project-{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle rounded-ten" type="button" id="dropdown_menu_button2" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->email }}
            </button>
            <ul class="dropdown-menu dropdown-menu dropdown-menu-custom" aria-labelledby="dropdown_menu_button2">
            <li><a class="dropdown-item {{\Request::route()->getName() === 'projects.index' ? 'active' : '' }}" href="{{ route('projects.index') }}">My Projects</a></li>
                <li><a class="dropdown-item {{\Request::route()->getName() === 'profile.index' ? 'active' : '' }}" href="{{ route('profile.index') }}">My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>