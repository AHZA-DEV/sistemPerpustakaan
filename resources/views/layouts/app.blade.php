<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Digital Library</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS - Ensure it loads after Bootstrap -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
    
    <style>
        /* Additional CSS to ensure proper styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }
        
        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            background-color: #ffffff;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            background-color: #ffffff;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .menu-link:hover {
            color: #7c3aed;
            background-color: rgba(124, 58, 237, 0.1);
            text-decoration: none;
        }
        
        .menu-item.active .menu-link {
            color: #7c3aed;
            background-color: rgba(124, 58, 237, 0.15);
            border-right: 3px solid #7c3aed;
        }
        
        .menu-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('layouts.navbar')

        <!-- Dashboard Content -->
        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay"></div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('template/assets/js/script.js') }}"></script>
</body>

</html>