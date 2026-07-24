@php
    $rolUsuario = session('rol_usuario');
    $puedeVerUsuarios = $rolUsuario === 'Administrador';
    $puedeVerAcerca = in_array($rolUsuario, ['Administrador', 'Operador'], true);

    $gestionAcademicaOpen = request()->routeIs(
        'escuelas.*',
        'programas.*',
        'zonas.*',
        'centros.*',
        'periodos-academicos.*',
        'estudiantes.*'
    );

    $procesosDisciplinariosOpen = request()->routeIs(
        'denuncias.*',
        'procesos.*',
        'descargos.*',
        'pruebas.*',
        'decisiones.*',
        'sanciones.*',
        'notificaciones.*',
        'apelaciones.*'
    );

    $reportesOpen = request()->routeIs('reportes.*');
    $administracionOpen = request()->routeIs('usuarios.*', 'administracion.*');
@endphp

<aside class="app-sidebar p-3">
    <nav id="sidebarAccordion" class="nav flex-column gap-1">
        <a class="nav-link rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fa-solid fa-gauge-high me-2"></i>Resumen General
        </a>

        <div class="nav-title small text-uppercase mt-3 mb-1">Menú principal</div>

        <button
            class="nav-link sidebar-toggle rounded d-flex align-items-center justify-content-between {{ $gestionAcademicaOpen ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarGestionAcademica"
            aria-expanded="{{ $gestionAcademicaOpen ? 'true' : 'false' }}"
            aria-controls="sidebarGestionAcademica"
        >
            <span><i class="fa-solid fa-building-columns me-2"></i>Gestión Académica</span>
            <span class="sidebar-chevron">
                <i class="fa-solid fa-chevron-right sidebar-chevron-closed"></i>
                <i class="fa-solid fa-chevron-down sidebar-chevron-open"></i>
            </span>
        </button>
        <div id="sidebarGestionAcademica" class="collapse {{ $gestionAcademicaOpen ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
            <div class="nav flex-column gap-1 py-1">
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('escuelas.*') ? 'active' : '' }}" href="{{ route('escuelas.index') }}">
                    <i class="fa-solid fa-school me-2"></i>Escuelas
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('programas.*') ? 'active' : '' }}" href="{{ route('programas.index') }}">
                    <i class="fa-solid fa-graduation-cap me-2"></i>Programas
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('zonas.*') ? 'active' : '' }}" href="{{ route('zonas.index') }}">
                    <i class="fa-solid fa-map-location-dot me-2"></i>Zonas
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('centros.*') ? 'active' : '' }}" href="{{ route('centros.index') }}">
                    <i class="fa-solid fa-location-dot me-2"></i>Centros
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}" href="{{ route('periodos-academicos.index') }}">
                    <i class="fa-solid fa-calendar-days me-2"></i>Periodos académicos
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}" href="{{ route('estudiantes.index') }}">
                    <i class="fa-solid fa-user-graduate me-2"></i>Estudiantes
                </a>
            </div>
        </div>

        <button
            class="nav-link sidebar-toggle rounded d-flex align-items-center justify-content-between {{ $procesosDisciplinariosOpen ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarProcesosDisciplinarios"
            aria-expanded="{{ $procesosDisciplinariosOpen ? 'true' : 'false' }}"
            aria-controls="sidebarProcesosDisciplinarios"
        >
            <span><i class="fa-solid fa-scale-balanced me-2"></i>Procesos Disciplinarios</span>
            <span class="sidebar-chevron">
                <i class="fa-solid fa-chevron-right sidebar-chevron-closed"></i>
                <i class="fa-solid fa-chevron-down sidebar-chevron-open"></i>
            </span>
        </button>
        <div id="sidebarProcesosDisciplinarios" class="collapse {{ $procesosDisciplinariosOpen ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
            <div class="nav flex-column gap-1 py-1">
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('denuncias.*') ? 'active' : '' }}" href="{{ route('denuncias.index') }}">
                    <i class="fa-solid fa-file-circle-exclamation me-2"></i>Denuncias
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('procesos.*') ? 'active' : '' }}" href="{{ route('procesos.index') }}">
                    <i class="fa-solid fa-folder-open me-2"></i>Procesos
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('descargos.*') ? 'active' : '' }}" href="{{ route('descargos.index') }}">
                    <i class="fa-solid fa-comment-dots me-2"></i>Descargos
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('pruebas.*') ? 'active' : '' }}" href="{{ route('pruebas.index') }}">
                    <i class="fa-solid fa-paperclip me-2"></i>Pruebas
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('decisiones.*') ? 'active' : '' }}" href="{{ route('decisiones.index') }}">
                    <i class="fa-solid fa-check-to-slot me-2"></i>Decisiones
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('sanciones.*') ? 'active' : '' }}" href="{{ route('sanciones.index') }}">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Sanciones
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}" href="{{ route('notificaciones.index') }}">
                    <i class="fa-solid fa-envelope-open-text me-2"></i>Notificaciones
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('apelaciones.*') ? 'active' : '' }}" href="{{ route('apelaciones.index') }}">
                    <i class="fa-solid fa-scale-unbalanced-flip me-2"></i>Apelaciones
                </a>
            </div>
        </div>

        <button
            class="nav-link sidebar-toggle rounded d-flex align-items-center justify-content-between {{ $reportesOpen ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarReportes"
            aria-expanded="{{ $reportesOpen ? 'true' : 'false' }}"
            aria-controls="sidebarReportes"
        >
            <span><i class="fa-solid fa-chart-line me-2"></i>Reportes</span>
            <span class="sidebar-chevron">
                <i class="fa-solid fa-chevron-right sidebar-chevron-closed"></i>
                <i class="fa-solid fa-chevron-down sidebar-chevron-open"></i>
            </span>
        </button>
        <div id="sidebarReportes" class="collapse {{ $reportesOpen ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
            <div class="nav flex-column gap-1 py-1">
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('reportes.index') ? 'active' : '' }}" href="{{ route('reportes.index') }}">
                    <i class="fa-solid fa-chart-pie me-2"></i>Reporte principal
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('reportes.antecedentes-estudiante') ? 'active' : '' }}" href="{{ route('reportes.antecedentes-estudiante') }}">
                    <i class="fa-solid fa-user-clock me-2"></i>Antecedentes por estudiante
                </a>
                <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('reportes.procesos-historicos*') ? 'active' : '' }}" href="{{ route('reportes.procesos-historicos') }}">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i>Procesos históricos
                </a>
            </div>
        </div>

        <div class="nav-title small text-uppercase mt-3 mb-1">Normatividad</div>
        <a class="nav-link rounded {{ request()->routeIs('normatividades.*') ? 'active' : '' }}" href="{{ route('normatividades.index') }}">
            <i class="fa-solid fa-book me-2"></i>Normatividades
        </a>
        <a class="nav-link rounded {{ request()->routeIs('articulos.*') ? 'active' : '' }}" href="{{ route('articulos.index') }}">
            <i class="fa-solid fa-section me-2"></i>Artículos
        </a>

        @if ($puedeVerUsuarios || $puedeVerAcerca)
            <div class="nav-title small text-uppercase mt-3 mb-1">General</div>
            <button
                class="nav-link sidebar-toggle rounded d-flex align-items-center justify-content-between {{ $administracionOpen ? '' : 'collapsed' }}"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#sidebarAdministracion"
                aria-expanded="{{ $administracionOpen ? 'true' : 'false' }}"
                aria-controls="sidebarAdministracion"
            >
                <span><i class="fa-solid fa-gear me-2"></i>Administración</span>
                <span class="sidebar-chevron">
                    <i class="fa-solid fa-chevron-right sidebar-chevron-closed"></i>
                    <i class="fa-solid fa-chevron-down sidebar-chevron-open"></i>
                </span>
            </button>
            <div id="sidebarAdministracion" class="collapse {{ $administracionOpen ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="nav flex-column gap-1 py-1">
                    @if ($puedeVerUsuarios)
                        <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                            <i class="fa-solid fa-user me-2"></i>Usuarios
                        </a>
                    @endif

                    @if ($puedeVerAcerca)
                        <a class="nav-link sidebar-sub-link rounded {{ request()->routeIs('administracion.acerca') ? 'active' : '' }}" href="{{ route('administracion.acerca') }}">
                            <i class="fa-solid fa-circle-info me-2"></i>Acerca del Sistema
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </nav>
</aside>
