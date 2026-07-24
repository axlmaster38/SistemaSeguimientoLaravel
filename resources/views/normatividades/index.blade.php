@extends('layouts.app')

@section('title', 'Normatividades | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Normatividades</h1>
            <div class="text-muted">Gestión de normas y acuerdos institucionales.</div>
        </div>
        <a href="{{ route('normatividades.create') }}" class="btn btn-primary">
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
            <form method="GET" action="{{ route('normatividades.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-md">
                    <input
                        type="search"
                        name="buscar"
                        value="{{ $buscar }}"
                        class="form-control"
                        placeholder="Buscar por acuerdo o descripción"
                    >
                </div>
                <div class="col-12 col-md-3">
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
                    <a href="{{ route('normatividades.index') }}" class="btn btn-outline-secondary">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Acuerdo</th>
                            <th scope="col">Fecha norma</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Artículos</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($normatividades as $normatividad)
                            <tr>
                                <td class="fw-semibold">{{ $normatividad->no_acuerdo }}</td>
                                <td>{{ $normatividad->fecha_norma ? \Illuminate\Support\Carbon::parse($normatividad->fecha_norma)->format('Y-m-d') : '' }}</td>
                                <td>{{ Str::limit($normatividad->descripcion, 90) }}</td>
                                <td>{{ $normatividad->articulos_count }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $normatividad->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                                        {{ $normatividad->estado_registro }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('normatividades.show', $normatividad) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('normatividades.edit', $normatividad) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('normatividades.destroy', $normatividad) }}" class="status-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $normatividad->estado_registro === 'Activo' ? 'danger' : 'success' }}">
                                                    <i class="fa-solid {{ $normatividad->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>
                                                    {{ $normatividad->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay normatividades registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $normatividades->links() }}
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
                    text: `Se va a ${action} esta normatividad.`,
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
