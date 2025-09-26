
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="search-box me-auto">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-0" placeholder="Search now">
            </div>
        </div>
        
        <div class="navbar-nav flex-row align-items-center">
            <button class="btn btn-link me-3" id="themeToggle" title="Toggle Theme">
                <i class="bi bi-sun theme-icon"></i>
            </button>
            
            <div class="position-relative me-3">
                <button class="btn btn-link position-relative">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        1
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>{{ Session::get('user_name') }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
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
