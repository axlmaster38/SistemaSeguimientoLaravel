@csrf

<div class="row g-3">
    <div class="col-12 col-md-4"><label for="nombre" class="form-label">Nombre</label><input type="text" id="nombre" name="nombre" value="{{ old('nombre', $prueba->nombre) }}" maxlength="50" class="form-control @error('nombre') is-invalid @enderror" required>@error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-4"><label for="tipo_prueba" class="form-label">Tipo prueba</label><input type="text" id="tipo_prueba" name="tipo_prueba" value="{{ old('tipo_prueba', $prueba->tipo_prueba) }}" maxlength="50" class="form-control @error('tipo_prueba') is-invalid @enderror" required>@error('tipo_prueba')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-4"><label for="procedencia" class="form-label">Procedencia</label><input type="text" id="procedencia" name="procedencia" value="{{ old('procedencia', $prueba->procedencia) }}" maxlength="50" class="form-control @error('procedencia') is-invalid @enderror" required>@error('procedencia')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-6">
        <label for="proceso_disciplinario_id" class="form-label">Proceso disciplinario</label>
        <select id="proceso_disciplinario_id" name="proceso_disciplinario_id" class="form-select @error('proceso_disciplinario_id') is-invalid @enderror">
            <option value="">Seleccione un proceso</option>
            @foreach ($procesos as $proceso)
                <option value="{{ $proceso->id }}" @selected((int) old('proceso_disciplinario_id', $prueba->proceso_disciplinario_id) === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }} - {{ $proceso->denuncia?->estudiante?->nombre }} {{ $proceso->denuncia?->estudiante?->apellido }}</option>
            @endforeach
        </select>
        @error('proceso_disciplinario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="descargo_id" class="form-label">Descargo</label>
        <select id="descargo_id" name="descargo_id" class="form-select @error('descargo_id') is-invalid @enderror" data-selected="{{ old('descargo_id', $prueba->descargo_id) }}" @disabled(! old('proceso_disciplinario_id', $prueba->proceso_disciplinario_id))>
            <option value="">Seleccione un descargo</option>
            @foreach ($descargos as $descargo)
                <option value="{{ $descargo->id }}" @selected((int) old('descargo_id', $prueba->descargo_id) === $descargo->id)>#{{ $descargo->id }} - {{ \Illuminate\Support\Str::limit($descargo->descripcion, 60) }}</option>
            @endforeach
        </select>
        @error('descargo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12"><label for="descripcion" class="form-label">Descripcion</label><textarea id="descripcion" name="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $prueba->descripcion) }}</textarea>@error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12">
        <label for="archivo" class="form-label">Archivo</label>
        <input type="file" id="archivo" name="archivo" class="form-control @error('archivo') is-invalid @enderror" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        @if ($prueba->archivo)<div class="form-text">Archivo actual: <a href="{{ route('pruebas.archivo', $prueba) }}">descargar</a></div>@endif
        @error('archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4"><button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button><a href="{{ route('pruebas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const proceso = document.getElementById('proceso_disciplinario_id');
            const descargo = document.getElementById('descargo_id');

            const reset = (text) => {
                descargo.innerHTML = '';
                descargo.append(new Option(text, ''));
                descargo.disabled = true;
            };

            const cargarDescargos = async (procesoId, selected = '') => {
                if (!procesoId) {
                    reset('Seleccione un proceso primero');
                    return;
                }

                const response = await fetch(`/ajax/procesos/${procesoId}/descargos`, { headers: { Accept: 'application/json' } });
                const items = await response.json();
                descargo.innerHTML = '';

                if (!items.length) {
                    descargo.append(new Option('No hay descargos disponibles', ''));
                    descargo.disabled = true;
                    return;
                }

                descargo.append(new Option('Seleccione un descargo', ''));
                items.forEach((item) => {
                    const text = `#${item.id} - ${(item.descripcion || '').slice(0, 60)}`;
                    const option = new Option(text, item.id);
                    option.selected = String(item.id) === String(selected);
                    descargo.append(option);
                });
                descargo.disabled = false;
            };

            proceso.addEventListener('change', () => cargarDescargos(proceso.value));

            if (!proceso.value) {
                reset('Seleccione un proceso primero');
            } else if (descargo.options.length <= 1) {
                cargarDescargos(proceso.value, descargo.dataset.selected);
            }
        });
    </script>
@endpush
