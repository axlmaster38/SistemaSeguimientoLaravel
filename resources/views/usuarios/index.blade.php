@extends('layouts.app')

@section('title', 'Usuarios | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Usuarios</h1>
            <div class="text-muted">Administración de accesos al sistema.</div>
        </div>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
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
            <form method="GET" action="{{ route('usuarios.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-lg">
                    <input
                        type="search"
                        name="buscar"
                        value="{{ $buscar }}"
                        class="form-control"
                        placeholder="Buscar por usuario, nombre o correo"
                    >
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="rol" class="form-select">
                        @foreach (['Todos', 'Administrador', 'Operador'] as $opcionRol)
                            <option value="{{ $opcionRol }}" @selected($rol === $opcionRol)>
                                {{ $opcionRol }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="estado" class="form-select">
                        @foreach (['Todos', 'Activo', 'Inactivo'] as $opcionEstado)
                            <option value="{{ $opcionEstado }}" @selected($estado === $opcionEstado)>
                                {{ $opcionEstado }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="estado_registro" class="form-select">
                        @foreach (['Activo', 'Inactivo', 'Todos'] as $opcionEstadoRegistro)
                            <option value="{{ $opcionEstadoRegistro }}" @selected($estadoRegistro === $opcionEstadoRegistro)>
                                {{ $opcionEstadoRegistro }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Registro</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td class="fw-semibold">{{ $usuario->usuario }}</td>
                                <td>{{ trim($usuario->nombre . ' ' . $usuario->apellido) }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $usuario->rol === 'Administrador' ? 'primary' : 'info' }}">
                                        {{ $usuario->rol }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-{{ $usuario->estado === 'Activo' ? 'success' : 'secondary' }}">
                                        {{ $usuario->estado }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-{{ $usuario->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                                        {{ $usuario->estado_registro }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </a>
                                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="status-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $usuario->estado_registro === 'Activo' ? 'danger' : 'success' }}">
                                                <i class="fa-solid {{ $usuario->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>
                                                {{ $usuario->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $usuarios->links() }}
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
                    text: `Se va a ${action} este usuario.`,
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
