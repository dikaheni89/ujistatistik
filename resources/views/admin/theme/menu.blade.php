<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ asset('theme/assets/img/90x90.jpg') }}" alt="avatar">
                <h6 class="">{{ auth()->user()->name }}</h6>
                <p class="">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"
                    aria-expanded="{{ request()->segment(2) == 'dashboard' ? 'true' : '' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ request()->segment(2) == 'organisations' ? 'active' : '' }}">
                <a href="{{ route('admin.organisations.index') }}"
                    aria-expanded="{{ request()->segment(2) == 'organisations' ? 'true' : '' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-pocket">
                            <path d="M4 3h16a2 2 0 0 1 2 2v6a10 10 0 0 1-10 10A10 10 0 0 1 2 11V5a2 2 0 0 1 2-2z">
                            </path>
                            <polyline points="8 10 12 14 16 10"></polyline>
                        </svg>
                        <span>Organisasi</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ request()->segment(2) == 'users' ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"
                    aria-expanded="{{ request()->segment(2) == 'users' ? 'true' : '' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>User</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ request()->segment(2) == 'groups' ? 'active' : '' }}">
                <a href="{{ route('admin.groups.index') }}"
                    aria-expanded="{{ request()->segment(2) == 'groups' ? 'true' : '' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-archive">
                            <polyline points="21 8 21 21 3 21 3 8"></polyline>
                            <rect x="1" y="3" width="22" height="5"></rect>
                            <line x1="10" y1="12" x2="14" y2="12"></line>
                        </svg>
                        <span>Group</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ request()->segment(2) == 'datasets' ? 'active' : '' }}">
                <a href="{{ route('admin.datasets.index') }}"
                    aria-expanded="{{ request()->segment(2) == 'datasets' ? 'true' : '' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-database">
                            <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                        </svg>
                        <span>Dataset</span>
                    </div>
                </a>
            </li>

        </ul>
    </nav>

</div>
