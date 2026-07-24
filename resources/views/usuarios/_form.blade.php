@csrf

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="usuario" class="form-label">Usuario</label>
        <input
            type="text"
            name="usuario"
            id="usuario"
            value="{{ old('usuario', $usuario->usuario) }}"
            class="form-control @error('usuario') is-invalid @enderror"
            maxlength="30"
            required
        >
        @error('usuario')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            value="{{ old('nombre', $usuario->nombre) }}"
            class="form-control @error('nombre') is-invalid @enderror"
            maxlength="30"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="email" class="form-label">Correo</label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', $usuario->email) }}"
            class="form-control @error('email') is-invalid @enderror"
            maxlength="254"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input
            type="password"
            name="contrasena"
            id="contrasena"
            class="form-control @error('contrasena') is-invalid @enderror"
            minlength="8"
            {{ $usuario->exists ? '' : 'required' }}
        >
        @if ($usuario->exists)
            <div class="form-text">Déjala vacía si no quieres cambiarla.</div>
        @endif
        @error('contrasena')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="contrasena_confirmation" class="form-label">Confirmar contraseña</label>
        <input
            type="password"
            name="contrasena_confirmation"
            id="contrasena_confirmation"
            class="form-control"
            minlength="8"
            {{ $usuario->exists ? '' : 'required' }}
        >
    </div>

    <div class="col-12 col-md-6">
        <label for="rol" class="form-label">Rol</label>
        <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required>
            @foreach (['Administrador', 'Operador'] as $opcionRol)
                <option value="{{ $opcionRol }}" @selected(old('rol', $usuario->rol ?: 'Operador') === $opcionRol)>
                    {{ $opcionRol }}
                </option>
            @endforeach
        </select>
        @error('rol')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
            @foreach (['Activo', 'Inactivo'] as $opcionEstado)
                <option value="{{ $opcionEstado }}" @selected(old('estado', $usuario->estado ?: 'Activo') === $opcionEstado)>
                    {{ $opcionEstado }}
                </option>
            @endforeach
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
    </button>
</div>
