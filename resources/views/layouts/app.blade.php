<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Seguimiento')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --unad-blue: #075b7a;
            --sidebar-black: #000000;
            --sidebar-active: #1f2937;
            --sidebar-hover: #111827;
        }

        body {
            background: #f5f7fb;
        }

        .main-navbar {
            background-color: var(--unad-blue) !important;
        }

        .navbar-logo {
            display: block;
            width: auto;
            height: 42px;
            max-width: 145px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .app-sidebar {
            width: 280px;
            min-height: calc(100vh - 56px);
            background: var(--sidebar-black);
        }

        .app-sidebar .nav-link,
        .app-sidebar .nav-title {
            color: #e5e7eb;
        }

        .app-sidebar .nav-link:hover {
            color: #ffffff;
            background: var(--sidebar-hover);
        }

        .app-sidebar .nav-link.active {
            color: #ffffff;
            background: var(--sidebar-active);
        }

        .app-sidebar .sidebar-toggle {
            width: 100%;
            border: 0;
            background: transparent;
            text-align: left;
        }

        .app-sidebar .sidebar-toggle:not(.collapsed) {
            color: #ffffff;
            background: var(--sidebar-active);
        }

        .app-sidebar .sidebar-sub-link {
            padding-left: 2.25rem;
            font-size: .95rem;
        }

        .app-sidebar .sidebar-chevron {
            font-size: .75rem;
        }

        .app-sidebar .sidebar-toggle .sidebar-chevron-closed,
        .app-sidebar .sidebar-toggle.collapsed .sidebar-chevron-open {
            display: none;
        }

        .app-sidebar .sidebar-toggle.collapsed .sidebar-chevron-closed,
        .app-sidebar .sidebar-toggle .sidebar-chevron-open {
            display: inline-block;
        }

        .content-wrapper {
            min-height: calc(100vh - 56px);
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                width: 100%;
                min-height: auto;
            }

            .navbar-logo {
                height: 34px;
                max-width: 110px;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-logo {
                height: 30px;
                max-width: 90px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <div class="d-lg-flex">
        @include('layouts.sidebar')

        <div class="content-wrapper flex-grow-1 d-flex flex-column">
            <main class="container-fluid p-4 flex-grow-1">
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
