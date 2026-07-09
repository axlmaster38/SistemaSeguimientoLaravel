@csrf

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label for="codigo_pro" class="form-label">Codigo</label>
        <input type="text" id="codigo_pro" name="codigo_pro" value="{{ old('codigo_pro', $programa->codigo_pro) }}" maxlength="12" class="form-control @error('codigo_pro') is-invalid @enderror" required>
        @error('codigo_pro')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-8">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $programa->nombre) }}" maxlength="30" class="form-control @error('nombre') is-invalid @enderror" required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="escuela_id" class="form-label">Escuela</label>
        <select id="escuela_id" name="escuela_id" class="form-select @error('escuela_id') is-invalid @enderror" required>
            <option value="">Seleccione una escuela</option>
            @foreach ($escuelas as $escuela)
                <option value="{{ $escuela->id }}" @selected((int) old('escuela_id', $programa->escuela_id) === $escuela->id)>
                    {{ $escuela->sigla }} - {{ $escuela->nombre }}
                </option>
            @endforeach
        </select>
        @error('escuela_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('programas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
