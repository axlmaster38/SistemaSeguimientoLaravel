<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | SME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f3f6f9;
        }

        .login-panel {
            width: 100%;
            max-width: 420px;
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 login-panel">
                <div class="text-center mb-4">
                    <div class="display-6 "><img class="navbar-logo" src="{{ asset('images/logoUnad4.png') }}" width="200" alt=""></div>
                    <div class="display-6 fw-semibold " style="color: #075b7a;important!">SME</div>
                    <div class="text-muted">Sistema de Monitoreo de Estudiantes</div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-4">Iniciar sesión</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input
                                        id="usuario"
                                        type="text"
                                        name="usuario"
                                        value="{{ old('usuario') }}"
                                        class="form-control @error('usuario') is-invalid @enderror"
                                        required
                                        autofocus
                                    >
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input
                                        id="contrasena"
                                        type="password"
                                        name="contrasena"
                                        class="form-control @error('contrasena') is-invalid @enderror"
                                        required
                                    >
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" style="background-color: #075b7a; border-color: #075b7a;"|>
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Entrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
