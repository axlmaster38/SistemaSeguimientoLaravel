@csrf

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label for="codigo_estu" class="form-label">Codigo</label>
        <input type="text" id="codigo_estu" name="codigo_estu" value="{{ old('codigo_estu', $estudiante->codigo_estu) }}" maxlength="20" class="form-control @error('codigo_estu') is-invalid @enderror" required>
        @error('codigo_estu')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $estudiante->nombre) }}" maxlength="30" class="form-control @error('nombre') is-invalid @enderror" required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $estudiante->apellido) }}" maxlength="30" class="form-control @error('apellido') is-invalid @enderror" required>
        @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="estado_academico" class="form-label">Estado academico</label>
        <select id="estado_academico" name="estado_academico" class="form-select @error('estado_academico') is-invalid @enderror" required>
            <option value="">Seleccione un estado</option>
            @foreach ($estadosAcademicos as $estado)
                <option value="{{ $estado }}" @selected(old('estado_academico', $estudiante->estado_academico) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
        @error('estado_academico')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="centro_id" class="form-label">Centro</label>
        <select id="centro_id" name="centro_id" class="form-select @error('centro_id') is-invalid @enderror" required>
            <option value="">Seleccione un centro</option>
            @foreach ($centros as $centro)
                <option value="{{ $centro->id }}" @selected((int) old('centro_id', $estudiante->centro_id) === $centro->id)>{{ $centro->centro }}</option>
            @endforeach
        </select>
        @error('centro_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label for="programa_id" class="form-label">Programa</label>
        <select id="programa_id" name="programa_id" class="form-select @error('programa_id') is-invalid @enderror" required>
            <option value="">Seleccione un programa</option>
            @foreach ($programas as $programa)
                <option value="{{ $programa->id }}" @selected((int) old('programa_id', $estudiante->programa_id) === $programa->id)>{{ $programa->codigo_pro }} - {{ $programa->nombre }}</option>
            @endforeach
        </select>
        @error('programa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="email_institucional" class="form-label">Email institucional</label>
        <input type="email" id="email_institucional" name="email_institucional" value="{{ old('email_institucional', $estudiante->email_institucional) }}" maxlength="254" class="form-control @error('email_institucional') is-invalid @enderror" required>
        @error('email_institucional')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="email_personal" class="form-label">Email personal</label>
        <input type="email" id="email_personal" name="email_personal" value="{{ old('email_personal', $estudiante->email_personal) }}" maxlength="254" class="form-control @error('email_personal') is-invalid @enderror" required>
        @error('email_personal')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="email_alternativo" class="form-label">Email alternativo</label>
        <input type="email" id="email_alternativo" name="email_alternativo" value="{{ old('email_alternativo', $estudiante->email_alternativo) }}" maxlength="254" class="form-control @error('email_alternativo') is-invalid @enderror">
        @error('email_alternativo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label for="telefono" class="form-label">Telefono</label>
        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $estudiante->telefono) }}" maxlength="30" class="form-control @error('telefono') is-invalid @enderror">
        @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="direccion" class="form-label">Direccion</label>
        <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $estudiante->direccion) }}" maxlength="200" class="form-control @error('direccion') is-invalid @enderror">
        @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
</div>
