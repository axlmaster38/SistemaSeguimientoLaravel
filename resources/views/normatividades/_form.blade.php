@csrf

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="no_acuerdo" class="form-label">Número de acuerdo</label>
        <input
            type="text"
            name="no_acuerdo"
            id="no_acuerdo"
            value="{{ old('no_acuerdo', $normatividad->no_acuerdo) }}"
            class="form-control @error('no_acuerdo') is-invalid @enderror"
            maxlength="100"
            required
        >
        @error('no_acuerdo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="fecha_norma" class="form-label">Fecha norma</label>
        <input
            type="date"
            name="fecha_norma"
            id="fecha_norma"
            value="{{ old('fecha_norma', $normatividad->fecha_norma ? \Illuminate\Support\Carbon::parse($normatividad->fecha_norma)->format('Y-m-d') : '') }}"
            class="form-control @error('fecha_norma') is-invalid @enderror"
        >
        @error('fecha_norma')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea
            name="descripcion"
            id="descripcion"
            rows="5"
            class="form-control @error('descripcion') is-invalid @enderror"
        >{{ old('descripcion', $normatividad->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('normatividades.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
    </button>
</div>
