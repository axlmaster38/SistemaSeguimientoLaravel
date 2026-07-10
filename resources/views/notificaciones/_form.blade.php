@csrf
<div class="row g-3">
    <div class="col-12 col-md-6"><label class="form-label" for="tipo_notificacion">Tipo</label><select id="tipo_notificacion" name="tipo_notificacion" class="form-select @error('tipo_notificacion') is-invalid @enderror" required><option value="">Seleccione</option>@foreach ($tiposNotificacion as $tipo)<option value="{{ $tipo }}" @selected(old('tipo_notificacion', $notificacion->tipo_notificacion) === $tipo)>{{ $tipo }}</option>@endforeach</select>@error('tipo_notificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-6"><label class="form-label" for="instancia">Instancia</label><select id="instancia" name="instancia" class="form-select @error('instancia') is-invalid @enderror" required><option value="">Seleccione</option>@foreach ($instancias as $item)<option value="{{ $item }}" @selected(old('instancia', $notificacion->instancia ?: 'Primera Notificación') === $item)>{{ $item }}</option>@endforeach</select>@error('instancia')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-6"><label class="form-label" for="proceso_disciplinario_id">Proceso</label><select id="proceso_disciplinario_id" name="proceso_disciplinario_id" class="form-select @error('proceso_disciplinario_id') is-invalid @enderror"><option value="">Seleccione</option>@foreach ($procesosActivos as $proceso)<option value="{{ $proceso->id }}" @selected((int) old('proceso_disciplinario_id', $notificacion->proceso_disciplinario_id) === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }} - {{ $proceso->denuncia?->estudiante?->nombre }} {{ $proceso->denuncia?->estudiante?->apellido }}</option>@endforeach</select>@error('proceso_disciplinario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12 col-md-6"><label class="form-label" for="sancion_id">Sancion</label><select id="sancion_id" name="sancion_id" class="form-select @error('sancion_id') is-invalid @enderror" data-selected="{{ old('sancion_id', $notificacion->sancion_id) }}"><option value="">Seleccione</option>@foreach ($sancionesActivas as $sancion)<option value="{{ $sancion->id }}" data-proceso="{{ $sancion->decision?->proceso_disciplinario_id }}" @selected((int) old('sancion_id', $notificacion->sancion_id) === $sancion->id)>#{{ $sancion->id }} - Proceso #{{ $sancion->decision?->proceso_disciplinario_id }} - {{ $sancion->decision?->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $sancion->tipo_sancion }}</option>@endforeach</select>@error('sancion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12"><label class="form-label" for="descripcion">Descripcion</label><textarea id="descripcion" name="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $notificacion->descripcion) }}</textarea>@error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12"><label class="form-label" for="archivo">Archivo</label><input type="file" id="archivo" name="archivo" class="form-control @error('archivo') is-invalid @enderror" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">@if ($notificacion->archivo)<div class="form-text">Archivo actual: <a href="{{ route('notificaciones.archivo', $notificacion) }}">descargar</a></div>@endif @error('archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
</div>
<div class="d-flex gap-2 mt-4"><button class="btn btn-primary" type="submit">Guardar</button><a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary">Volver</a></div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tipo = document.getElementById('tipo_notificacion');
    const proceso = document.getElementById('proceso_disciplinario_id');
    const sancion = document.getElementById('sancion_id');
    const syncTipo = () => {
        proceso.disabled = tipo.value === 'Sancion';
        sancion.disabled = tipo.value === 'Proceso';
        if (tipo.value === 'Proceso') sancion.value = '';
        if (tipo.value === 'Sancion') proceso.value = '';
    };
    const cargarSanciones = async () => {
        const selected = sancion.dataset.selected || sancion.value;
        if (!proceso.value) return;
        const response = await fetch(`/ajax/procesos/${proceso.value}/sanciones`, { headers: { Accept: 'application/json' } });
        const items = await response.json();
        sancion.innerHTML = '<option value="">Seleccione</option>';
        items.forEach((item) => {
            const option = new Option(`#${item.id} - ${item.tipo_sancion} - ${item.estado_sancion}`, item.id);
            option.selected = String(item.id) === String(selected);
            sancion.append(option);
        });
    };
    tipo.addEventListener('change', syncTipo);
    proceso.addEventListener('change', cargarSanciones);
    syncTipo();
});
</script>
@endpush
