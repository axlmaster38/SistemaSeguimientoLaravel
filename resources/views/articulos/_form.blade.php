@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="normatividad_id" class="form-label">Normatividad</label>
        <select
            name="normatividad_id"
            id="normatividad_id"
            class="form-select @error('normatividad_id') is-invalid @enderror"
            required
        >
            <option value="">Seleccione una normatividad</option>
            @foreach ($normatividades as $normatividad)
                <option value="{{ $normatividad->id }}" @selected((int) old('normatividad_id', $articulo->normatividad_id) === $normatividad->id)>
                    {{ $normatividad->no_acuerdo }}{{ $normatividad->estado_registro === 'Inactivo' ? ' (Inactiva)' : '' }}
                </option>
            @endforeach
        </select>
        @error('normatividad_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="no_articulo" class="form-label">Número de artículo</label>
        <input
            type="text"
            name="no_articulo"
            id="no_articulo"
            value="{{ old('no_articulo', $articulo->no_articulo) }}"
            class="form-control @error('no_articulo') is-invalid @enderror"
            maxlength="12"
            required
        >
        @error('no_articulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="capitulo" class="form-label">Capítulo</label>
        <input
            type="text"
            name="capitulo"
            id="capitulo"
            value="{{ old('capitulo', $articulo->capitulo) }}"
            class="form-control @error('capitulo') is-invalid @enderror"
            maxlength="30"
            required
        >
        @error('capitulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea
            name="descripcion"
            id="descripcion"
            rows="4"
            class="form-control @error('descripcion') is-invalid @enderror"
        >{{ old('descripcion', $articulo->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="literal" class="form-label">Literal</label>
        <textarea
            name="literal"
            id="literal"
            rows="4"
            class="form-control @error('literal') is-invalid @enderror"
        >{{ old('literal', $articulo->literal) }}</textarea>
        @error('literal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('articulos.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
    </button>
</div>
