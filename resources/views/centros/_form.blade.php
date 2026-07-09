@csrf

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="centro" class="form-label">Centro</label>
        <input type="text" id="centro" name="centro" value="{{ old('centro', $centro->centro) }}" maxlength="30" class="form-control @error('centro') is-invalid @enderror" required>
        @error('centro')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="zona_id" class="form-label">Zona</label>
        <select id="zona_id" name="zona_id" class="form-select @error('zona_id') is-invalid @enderror" required>
            <option value="">Seleccione una zona</option>
            @foreach ($zonas as $zona)
                <option value="{{ $zona->id }}" @selected((int) old('zona_id', $centro->zona_id) === $zona->id)>{{ $zona->nombre }}</option>
            @endforeach
        </select>
        @error('zona_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
