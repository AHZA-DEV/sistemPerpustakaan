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
            <ul>
                <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="bi bi-house-door"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <i class="bi bi-people"></i>
                        <span>Kelola Anggota</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.buku.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.buku.index') }}" class="menu-link">
                        <i class="bi bi-book"></i>
                        <span>Kelola Buku</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.peminjaman.index') }}" class="menu-link">
                        <i class="bi bi-journal-arrow-up"></i>
                        <span>Kelola Peminjaman</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kategori.index') }}" class="menu-link">
                        <i class="bi bi-tags"></i>
                        <span>Kelola Kategori</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.author.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.author.index') }}" class="menu-link">
                        <i class="bi bi-person"></i>
                        <span>Kelola Author</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.penerbit.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.penerbit.index') }}" class="menu-link">
                            <i class="bi bi-building"></i>
                            <span>Kelola Penerbit</span>
                        </a>
                    </li>
                <li class="menu-item {{ Request::routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}" class="menu-link">
                        <i class="bi bi-graph-up"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="menu-link">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <span class="text-danger">Logout</span>
                </button>
            </form>
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
            <ul>
                <li class="menu-item {{ Request::is('user/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}" class="menu-link">
                        <i class="bi bi-house-door"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.buku.*') ? 'active' : '' }}">
                    <a href="{{ route('user.buku.index') }}" class="menu-link">
                        <i class="bi bi-book"></i>
                        <span>Semua Buku</span>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.loans.*') ? 'active' : '' }}">
                    <a href="{{ route('user.loans.index') }}" class="menu-link">
                        <i class="bi bi-journal-text"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="menu-link">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <span class="text-danger">Logout</span>
                </button>
            </form>
        </div>
    @endif
</nav>