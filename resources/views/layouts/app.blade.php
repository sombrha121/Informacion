<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Médico')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ecf0f1;
            overflow-x: hidden;
        }

        /* Solucionar problemas con flechas flotantes o elementos grandes no deseados */
        body > *:not(.container-fluid) {
            display: none !important;
        }

        body > svg {
            display: none !important;
        }

        .container-fluid {
            display: block !important;
        }

        /* Limpiar pseudoelementos problemáticos */
        .pagination::before,
        .pagination::after {
            content: none !important;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #34495e 100%);
            color: white;
            padding: 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--secondary-color);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .brand-logo i {
            color: var(--secondary-color);
        }

        .main-content {
            padding: 30px;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-md-2.sidebar {
                min-height: auto;
            }
            
            .col-md-10.main-content {
                padding: 15px;
            }
            
            .sidebar .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        .stat-card {
            border-left: 4px solid var(--secondary-color);
        }

        .table {
            background: white;
        }

        .badge {
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        /* Estilos para paginación */
        .pagination {
            margin-top: 20px;
        }

        .pagination .page-link {
            color: var(--secondary-color);
            border-color: #ddd;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .pagination .page-link:hover {
            color: var(--secondary-color);
        }

        /* Ocultar elementos no deseados */
        .hidden-element,
        [style*="display:none"],
        .d-none {
            display: none !important;
        }

        /* Asegurar que los iconos dentro de la navegación sean visibles */
        .sidebar .bi,
        .btn .bi,
        .nav-link .bi {
            display: inline !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar px-0">
                <div class="brand-logo">
                    <i class="bi bi-heart-pulse-fill"></i> Sistema Médico
                </div>
                <nav class="nav flex-column mt-4">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}" href="{{ route('pacientes.index') }}">
                        <i class="bi bi-people-fill"></i> Pacientes
                    </a>
                    <a class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}" href="{{ route('consultas.index') }}">
                        <i class="bi bi-clipboard2-pulse"></i> Consultas
                    </a>
                    <a class="nav-link {{ request()->routeIs('examenes.*') ? 'active' : '' }}" href="{{ route('examenes.index') }}">
                        <i class="bi bi-clipboard-data"></i> Exámenes
                    </a>
                    <a class="nav-link {{ request()->routeIs('tratamientos.*') ? 'active' : '' }}" href="{{ route('tratamientos.index') }}">
                        <i class="bi bi-capsule"></i> Tratamientos
                    </a>
                    <a class="nav-link {{ request()->routeIs('compras.*') ? 'active' : '' }}" href="{{ route('compras.index') }}">
                        <i class="bi bi-cart-fill"></i> Compras
                    </a>
                    <a class="nav-link {{ request()->routeIs('personal.*') ? 'active' : '' }}" href="{{ route('personal.index') }}">
                        <i class="bi bi-person-badge"></i> Personal
                    </a>
                    <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}" href="{{ route('reportes.index') }}">
                        <i class="bi bi-graph-up"></i> Reportes
                    </a>
                    <a class="nav-link {{ request()->routeIs('ia.*') ? 'active' : '' }}" href="{{ route('ia.index') }}">
                        <i class="bi bi-robot"></i> Asistente IA
                    </a>
                    <hr style="border-color: rgba(255,255,255,0.2)">
                    <form method="POST" action="{{ route('logout') }}" class="px-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="bi bi-person-circle"></i> 
                                {{ auth()->user()->name ?? 'Usuario' }}
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> 
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>
