<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RelawanCare') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-hands-helping me-2"></i>
                <strong>RelawanCare</strong>
                <small class="d-block" style="font-size: 0.7rem; margin-top: -2px;">Monitoring Relawan</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Master Data Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('volunteers.*', 'beneficiaries.*', 'administrative-regions.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-1"></i>
                            Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('volunteers.*') ? 'active' : '' }}" href="{{ route('volunteers.index') }}">
                                <i class="fas fa-users me-2"></i>Relawan
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('beneficiaries.*') ? 'active' : '' }}" href="{{ route('beneficiaries.index') }}">
                                <i class="fas fa-user-friends me-2"></i>Penerima Bantuan
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('administrative-regions.*') ? 'active' : '' }}" href="{{ route('administrative-regions.index') }}">
                                <i class="fas fa-map-marked-alt me-2"></i>Wilayah Administrasi
                            </a></li>
                        </ul>
                    </li>

                    <!-- Aid Management Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('aid-types.*', 'aid-sessions.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-gift me-1"></i>
                            Manajemen Bantuan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('aid-types.*') ? 'active' : '' }}" href="{{ route('aid-types.index') }}">
                                <i class="fas fa-tags me-2"></i>Jenis Bantuan
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('aid-sessions.*') ? 'active' : '' }}" href="{{ route('aid-sessions.index') }}">
                                <i class="fas fa-calendar-alt me-2"></i>Sesi Bantuan
                            </a></li>
                        </ul>
                    </li>

                    <!-- Activities Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('activities.*', 'reports.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Aktivitas & Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('activities.*') ? 'active' : '' }}" href="{{ route('activities.index') }}">
                                <i class="fas fa-tasks me-2"></i>Aktivitas Relawan
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('reports.summary') ? 'active' : '' }}" href="{{ route('reports.summary') }}">
                                <i class="fas fa-chart-bar me-2"></i>Laporan Ringkasan
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('reports.distribution') ? 'active' : '' }}" href="{{ route('reports.distribution') }}">
                                <i class="fas fa-chart-pie me-2"></i>Laporan Distribusi
                            </a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('reports.volunteers') ? 'active' : '' }}" href="{{ route('reports.volunteers') }}">
                                <i class="fas fa-user-chart me-2"></i>Laporan Relawan
                            </a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid mt-4">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>