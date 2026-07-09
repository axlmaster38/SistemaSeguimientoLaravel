@csrf

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label for="sigla" class="form-label">Sigla</label>
        <input
            type="text"
            id="sigla"
            name="sigla"
            value="{{ old('sigla', $escuela->sigla) }}"
            maxlength="8"
            class="form-control @error('sigla') is-invalid @enderror"
            required
        >
        @error('sigla')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-8">
        <label for="nombre" class="form-label">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="{{ old('nombre', $escuela->nombre) }}"
            maxlength="100"
            class="form-control @error('nombre') is-invalid @enderror"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
    </button>
    <a href="{{ route('escuelas.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>Volver
    </a>
</div>
