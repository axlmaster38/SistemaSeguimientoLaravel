@csrf

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label for="codigo" class="form-label">Codigo</label>
        <input type="number" id="codigo" name="codigo" value="{{ old('codigo', $periodoAcademico->codigo) }}" class="form-control @error('codigo') is-invalid @enderror">
        @error('codigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="periodo" class="form-label">Periodo</label>
        <input type="text" id="periodo" name="periodo" value="{{ old('periodo', $periodoAcademico->periodo) }}" maxlength="10" class="form-control @error('periodo') is-invalid @enderror" required>
        @error('periodo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="anio" class="form-label">Anio</label>
        <input type="number" id="anio" name="anio" value="{{ old('anio', $periodoAcademico->anio) }}" class="form-control @error('anio') is-invalid @enderror" required>
        @error('anio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $periodoAcademico->fecha_inicio?->format('Y-m-d')) }}" class="form-control @error('fecha_inicio') is-invalid @enderror">
        @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="fecha_fin" class="form-label">Fecha fin</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $periodoAcademico->fecha_fin?->format('Y-m-d')) }}" class="form-control @error('fecha_fin') is-invalid @enderror">
        @error('fecha_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('periodos-academicos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
