@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="estudiante_id" class="form-label">Estudiante</label>
        <select id="estudiante_id" name="estudiante_id" class="form-select @error('estudiante_id') is-invalid @enderror" required>
            <option value="">Seleccione un estudiante</option>
            @foreach ($estudiantes as $estudiante)
                <option value="{{ $estudiante->id }}" @selected((int) old('estudiante_id', $denuncia->estudiante_id) === $estudiante->id)>{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>
            @endforeach
        </select>
        @error('estudiante_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="fecha_creacion" class="form-label">Fecha creacion</label>
        <input type="date" id="fecha_creacion" name="fecha_creacion" value="{{ old('fecha_creacion', $denuncia->fecha_creacion?->format('Y-m-d')) }}" class="form-control @error('fecha_creacion') is-invalid @enderror">
        @error('fecha_creacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-5">
        <label for="estado_denuncia" class="form-label">Estado denuncia</label>
        <select id="estado_denuncia" name="estado_denuncia" class="form-select @error('estado_denuncia') is-invalid @enderror" required>
            <option value="">Seleccione un estado</option>
            @foreach ($estadosDenuncia as $estado)
                <option value="{{ $estado }}" @selected(old('estado_denuncia', $denuncia->estado_denuncia) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
        @error('estado_denuncia')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-3 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input type="hidden" name="denuncia_antigua" value="0">
            <input type="checkbox" id="denuncia_antigua" name="denuncia_antigua" value="1" class="form-check-input" @checked((bool) old('denuncia_antigua', $denuncia->denuncia_antigua))>
            <label for="denuncia_antigua" class="form-check-label">Denuncia antigua</label>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea id="descripcion" name="descripcion" rows="6" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $denuncia->descripcion) }}</textarea>
        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="justificacion" class="form-label">Justificacion</label>
        <textarea id="justificacion" name="justificacion" rows="6" class="form-control @error('justificacion') is-invalid @enderror">{{ old('justificacion', $denuncia->justificacion) }}</textarea>
        @error('justificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('denuncias.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
