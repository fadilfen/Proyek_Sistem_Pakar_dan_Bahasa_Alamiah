<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-logo">
            <h2>🏥 Admin Panel</h2>
        </div>
        <ul class="admin-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.gejala.index') }}" class="{{ request()->routeIs('admin.gejala.*') ? 'active' : '' }}">
                    🔍 Kelola Gejala
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penyakit.index') }}" class="{{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
                    🦠 Kelola Penyakit
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rules.index') }}" class="{{ request()->routeIs('admin.rules.*') ? 'active' : '' }}">
                    📋 Kelola Rules
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    🚪 Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <div class="admin-header">
            <h1>@yield('title')</h1>
            <div class="admin-user">
                <span>👤 {{ session('username') }}</span>
                <a href="{{ route('logout') }}" class="btn-logout-admin">Logout</a>
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>
