@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="denuncia_id" class="form-label">Denuncia</label>
        <select id="denuncia_id" name="denuncia_id" class="form-select @error('denuncia_id') is-invalid @enderror" required>
            <option value="">Seleccione una denuncia</option>
            @foreach ($denuncias as $denuncia)
                <option value="{{ $denuncia->id }}" @selected((int) old('denuncia_id', $proceso->denuncia_id) === $denuncia->id)>#{{ $denuncia->id }} - {{ $denuncia->estudiante?->codigo_estu }} - {{ $denuncia->estudiante?->nombre }} {{ $denuncia->estudiante?->apellido }} - {{ $denuncia->estado_denuncia }}</option>
            @endforeach
        </select>
        @error('denuncia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="fecha_apertura" class="form-label">Fecha apertura</label>
        <input type="date" id="fecha_apertura" name="fecha_apertura" value="{{ old('fecha_apertura', $proceso->fecha_apertura?->format('Y-m-d')) }}" class="form-control @error('fecha_apertura') is-invalid @enderror">
        @error('fecha_apertura')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-5">
        <label for="estado_proceso" class="form-label">Estado proceso</label>
        <select id="estado_proceso" name="estado_proceso" class="form-select @error('estado_proceso') is-invalid @enderror" required>
            <option value="">Seleccione un estado</option>
            @foreach ($estadosProceso as $estado)
                <option value="{{ $estado }}" @selected(old('estado_proceso', $proceso->estado_proceso) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
        @error('estado_proceso')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-3 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input type="hidden" name="proceso_antiguo" value="0">
            <input type="checkbox" id="proceso_antiguo" name="proceso_antiguo" value="1" class="form-check-input" @checked((bool) old('proceso_antiguo', $proceso->proceso_antiguo))>
            <label for="proceso_antiguo" class="form-check-label">Proceso antiguo</label>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <label for="tipologias_faltas" class="form-label">Tipologias de falta</label>
        <select id="tipologias_faltas" name="tipologias_faltas[]" class="form-select @error('tipologias_faltas') is-invalid @enderror @error('tipologias_faltas.*') is-invalid @enderror" multiple size="8" required>
            @php($tipologiasSeleccionadas = collect(old('tipologias_faltas', $proceso->tipologiasFalta?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id)->all())
            @foreach ($tipologiasFaltas as $tipologia)
                <option value="{{ $tipologia->id }}" @selected(in_array($tipologia->id, $tipologiasSeleccionadas, true))>{{ $tipologia->nombre }}</option>
            @endforeach
        </select>
        @error('tipologias_faltas')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @error('tipologias_faltas.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="articulos" class="form-label">Articulos</label>
        <select id="articulos" name="articulos[]" class="form-select @error('articulos') is-invalid @enderror @error('articulos.*') is-invalid @enderror" multiple size="8" required>
            @php($articulosSeleccionados = collect(old('articulos', $proceso->articulos?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id)->all())
            @foreach ($articulos as $articulo)
                <option value="{{ $articulo->id }}" @selected(in_array($articulo->id, $articulosSeleccionados, true))>{{ $articulo->no_articulo }} - {{ $articulo->normatividad?->no_acuerdo }}</option>
            @endforeach
        </select>
        @error('articulos')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @error('articulos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('procesos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
