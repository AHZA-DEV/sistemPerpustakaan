
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Hamburger Menu (for mobile) -->
        <button class="btn sidebar-toggle d-lg-none me-3" type="button" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <!-- Search Bar -->
        <div class="search-box mx-auto">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search now" style="max-width: 400px;">
            </div>
        </div>

        <!-- Right Side Items -->
        <div class="navbar-nav flex-row ms-auto">
            <!-- Theme Toggle -->
            <button class="btn btn-link nav-link me-2" id="themeToggle" title="Toggle Theme">
                <i class="bi bi-sun theme-icon"></i>
            </button>

            <!-- Notifications -->
            <div class="nav-item dropdown me-2">
                <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        1
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Notifications</h6></li>
                    <li><a class="dropdown-item" href="#">New book added</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">View all</a></li>
                </ul>
            </div>

            <!-- User Profile -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                    <img src="https://via.placeholder.com/32x32/7c3aed/ffffff?text=A" alt="Admin" class="rounded-circle me-1" width="32" height="32">
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ Session::get('user_name', 'Admin') }}</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
