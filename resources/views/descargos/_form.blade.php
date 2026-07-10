@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="proceso_disciplinario_id" class="form-label">Proceso disciplinario</label>
        <select id="proceso_disciplinario_id" name="proceso_disciplinario_id" class="form-select @error('proceso_disciplinario_id') is-invalid @enderror" required>
            <option value="">Seleccione un proceso</option>
            @foreach ($procesos as $proceso)
                <option value="{{ $proceso->id }}" @selected((int) old('proceso_disciplinario_id', $descargo->proceso_disciplinario_id) === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }} - {{ $proceso->denuncia?->estudiante?->nombre }} {{ $proceso->denuncia?->estudiante?->apellido }}</option>
            @endforeach
        </select>
        @error('proceso_disciplinario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea id="descripcion" name="descripcion" rows="8" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $descargo->descripcion) }}</textarea>
        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('descargos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
