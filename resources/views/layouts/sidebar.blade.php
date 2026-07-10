<aside class="app-sidebar p-3">
    <nav class="nav flex-column gap-1">
        <a class="nav-link rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
        </a>

        <div class="nav-title small text-uppercase mt-3 mb-1">Gestion Academica</div>
        <a class="nav-link rounded {{ request()->routeIs('escuelas.*') ? 'active' : '' }}" href="{{ route('escuelas.index') }}">
            <i class="fa-solid fa-school me-2"></i>Escuelas
        </a>
        <a class="nav-link rounded {{ request()->routeIs('programas.*') ? 'active' : '' }}" href="{{ route('programas.index') }}">
            <i class="fa-solid fa-graduation-cap me-2"></i>Programas
        </a>
        <a class="nav-link rounded {{ request()->routeIs('zonas.*') ? 'active' : '' }}" href="{{ route('zonas.index') }}">
            <i class="fa-solid fa-map-location-dot me-2"></i>Zonas
        </a>
        <a class="nav-link rounded {{ request()->routeIs('centros.*') ? 'active' : '' }}" href="{{ route('centros.index') }}">
            <i class="fa-solid fa-building-columns me-2"></i>Centros
        </a>
        <a class="nav-link rounded {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}" href="{{ route('periodos-academicos.index') }}">
            <i class="fa-solid fa-calendar-days me-2"></i>Periodos academicos
        </a>
        <a class="nav-link rounded {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}" href="{{ route('estudiantes.index') }}">
            <i class="fa-solid fa-user-graduate me-2"></i>Estudiantes
        </a>

        <div class="nav-title small text-uppercase mt-3 mb-1">Procesos Disciplinarios</div>
        <a class="nav-link rounded {{ request()->routeIs('denuncias.*') ? 'active' : '' }}" href="{{ route('denuncias.index') }}">
            <i class="fa-solid fa-file-circle-exclamation me-2"></i>Denuncias
        </a>
        <a class="nav-link rounded {{ request()->routeIs('procesos.*') ? 'active' : '' }}" href="{{ route('procesos.index') }}">
            <i class="fa-solid fa-folder-open me-2"></i>Procesos
        </a>
        <a class="nav-link rounded {{ request()->routeIs('descargos.*') ? 'active' : '' }}" href="{{ route('descargos.index') }}">
            <i class="fa-solid fa-comment-dots me-2"></i>Descargos
        </a>
        <a class="nav-link rounded {{ request()->routeIs('pruebas.*') ? 'active' : '' }}" href="{{ route('pruebas.index') }}">
            <i class="fa-solid fa-paperclip me-2"></i>Pruebas
        </a>
        <a class="nav-link rounded {{ request()->routeIs('decisiones.*') ? 'active' : '' }}" href="{{ route('decisiones.index') }}">
            <i class="fa-solid fa-check-to-slot me-2"></i>Decisiones
        </a>
        <a class="nav-link rounded {{ request()->routeIs('sanciones.*') ? 'active' : '' }}" href="{{ route('sanciones.index') }}">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Sanciones
        </a>
        <a class="nav-link rounded {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}" href="{{ route('notificaciones.index') }}">
            <i class="fa-solid fa-envelope-open-text me-2"></i>Notificaciones
        </a>
        <a class="nav-link rounded {{ request()->routeIs('apelaciones.*') ? 'active' : '' }}" href="{{ route('apelaciones.index') }}">
            <i class="fa-solid fa-scale-unbalanced-flip me-2"></i>Apelaciones
        </a>

        <div class="nav-title small text-uppercase mt-3 mb-1">Normatividad</div>
        <a class="nav-link rounded" href="#"><i class="fa-solid fa-book me-2"></i>Normatividades</a>
        <a class="nav-link rounded" href="#"><i class="fa-solid fa-section me-2"></i>Articulos</a>

        <div class="nav-title small text-uppercase mt-3 mb-1">Reportes</div>
        <a class="nav-link rounded {{ request()->routeIs('reportes.antecedentes-estudiante') ? 'active' : '' }}" href="{{ route('reportes.antecedentes-estudiante') }}">
            <i class="fa-solid fa-user-clock me-2"></i>Antecedentes por estudiante
        </a>
        <a class="nav-link rounded {{ request()->routeIs('reportes.procesos-historicos*') ? 'active' : '' }}" href="{{ route('reportes.procesos-historicos') }}">
            <i class="fa-solid fa-clock-rotate-left me-2"></i>Procesos historicos
        </a>

        <div class="nav-title small text-uppercase mt-3 mb-1">General</div>
        <a class="nav-link rounded" href="#"><i class="fa-solid fa-gear me-2"></i>Configuracion</a>
    </nav>
</aside>
