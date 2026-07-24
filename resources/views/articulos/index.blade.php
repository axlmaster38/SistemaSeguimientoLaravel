@extends('layouts.app')

@section('title', 'Artículos | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Artículos</h1>
            <div class="text-muted">Gestión de artículos asociados a normatividades.</div>
        </div>
        <a href="{{ route('articulos.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>Nuevo
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('articulos.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-lg">
                    <input
                        type="search"
                        name="buscar"
                        value="{{ $buscar }}"
                        class="form-control"
                        placeholder="Buscar por artículo, capítulo, descripción o literal"
                    >
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <select name="normatividad_id" class="form-select">
                        <option value="">Todas las normatividades</option>
                        @foreach ($normatividades as $normatividad)
                            <option value="{{ $normatividad->id }}" @selected($normatividadId === $normatividad->id)>
                                {{ $normatividad->no_acuerdo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="estado_registro" class="form-select">
                        @foreach (['Activo', 'Inactivo', 'Todos'] as $estado)
                            <option value="{{ $estado }}" @selected($estadoRegistro === $estado)>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
                    </button>
                    <a href="{{ route('articulos.index') }}" class="btn btn-outline-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Artículo</th>
                            <th scope="col">Capítulo</th>
                            <th scope="col">Normatividad</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articulos as $articulo)
                            <tr>
                                <td class="fw-semibold">{{ $articulo->no_articulo }}</td>
                                <td>{{ $articulo->capitulo }}</td>
                                <td>{{ $articulo->normatividad?->no_acuerdo }}</td>
                                <td>{{ Str::limit($articulo->descripcion ?: $articulo->literal, 90) }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $articulo->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                                        {{ $articulo->estado_registro }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('articulos.show', $articulo) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('articulos.edit', $articulo) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('articulos.destroy', $articulo) }}" class="status-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $articulo->estado_registro === 'Activo' ? 'danger' : 'success' }}">
                                                    <i class="fa-solid {{ $articulo->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>
                                                    {{ $articulo->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay artículos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $articulos->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.status-form').forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const button = form.querySelector('button[type="submit"]');
                const action = button ? button.textContent.trim().toLowerCase() : 'cambiar estado';

                Swal.fire({
                    title: 'Confirmar acción',
                    text: `Se va a ${action} este artículo.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#0d6efd'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
