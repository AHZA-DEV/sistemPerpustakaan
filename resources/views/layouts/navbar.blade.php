
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        

        
        <div class="navbar-nav flex-row align-items-center">
            <button class="btn btn-link me-3" id="themeToggle" title="Toggle Theme">
                <i class="bi bi-sun theme-icon"></i>
            </button>
            
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>{{ Session::get('user_name') }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ Session::get('user_type') === 'admin' ? route('admin.profile') : route('user.profile') }}">
                            <i class="bi bi-person me-2"></i>Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
