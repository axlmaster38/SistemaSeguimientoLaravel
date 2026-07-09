<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Seguimiento')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .app-sidebar {
            width: 280px;
            min-height: calc(100vh - 56px);
            background: #172033;
        }

        .app-sidebar .nav-link,
        .app-sidebar .nav-title {
            color: #d9e2f2;
        }

        .app-sidebar .nav-link:hover,
        .app-sidebar .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, .1);
        }

        .content-wrapper {
            min-height: calc(100vh - 56px);
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                width: 100%;
                min-height: auto;
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
