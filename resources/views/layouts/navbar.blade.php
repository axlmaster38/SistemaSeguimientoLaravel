<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">
            <i class="fa-solid fa-scale-balanced me-2"></i>SME
        </a>

        <div class="ms-auto d-flex align-items-center gap-3 text-white">
            <div class="d-none d-sm-block text-end">
                <div class="fw-semibold">{{ session('nombre_usuario') }}</div>
                <small class="text-white-50">{{ session('rol_usuario') }}</small>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-right-from-bracket me-1"></i>Salir
                </button>
            </form>
        </div>
    </div>
</nav>
