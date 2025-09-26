<nav class="sidebar" id="sidebar">

    @if(Session::get('user_type') === 'admin')
        <!-- Sidebar Admin -->
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <i class="bi bi-shield-check text-primary me-2"></i>
                <span class="fw-bold">Admin Panel</span>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link" data-title="Beranda">
                        <i class="bi bi-house-door"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Kelola Anggota">
                        <i class="bi bi-people"></i>
                        <span>Kelola Anggota</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.books.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Kelola Buku">
                        <i class="bi bi-book"></i>
                        <span>Kelola Buku</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.loans.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Kelola Peminjaman">
                        <i class="bi bi-journal-arrow-up"></i>
                        <span>Kelola Peminjaman</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Kelola Kategori">
                        <i class="bi bi-tags"></i>
                        <span>Kelola Kategori</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Laporan">
                        <i class="bi bi-graph-up"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" data-title="Pengaturan">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    @elseif(Session::get('user_type') === 'anggota')
        <!-- Sidebar User -->
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-check text-primary me-2"></i>
                <span class="fw-bold">User Panel</span>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="menu-item {{ Request::is('user/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}" class="menu-link">
                        <i class="bi bi-house-door"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.books.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <i class="bi bi-book"></i>
                        <span>Semua Buku</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.loans.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <i class="bi bi-journal-text"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                </li>
            </ul> 
        </div>
    @endif

    <!-- Logout Section -->
    <div class="sidebar-footer">
        <div class="menu-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                @csrf
                <button type="submit" class="menu-link btn btn-link text-start w-100 p-0 border-0" style="text-decoration: none; background: none;">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <span class="text-danger">Logout</span>
                </button>
            </form>
        </div>
    </div>
    
</nav>