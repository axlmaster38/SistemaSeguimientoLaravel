# Seeders de catalogos base

Sprint 6.5 crea seeders idempotentes para cargar catalogos iniciales desde la base Django original ubicada en:

`D:\laragon\www\SistemaSeguimientoLaravel\referencia_django\ProyectoDjangoSME\db.sqlite3`

## Seeders creados

- `EscuelaSeeder`: 10 escuelas reales.
- `ZonaSeeder`: 9 zonas reales.
- `CentroSeeder`: 69 centros reales, relacionados por zona.
- `ProgramaSeeder`: 183 programas reales, relacionados por escuela.
- `TipologiaFaltaSeeder`: 7 tipologias de falta reales.
- `PeriodoAcademicoSeeder`: 10 periodos academicos reales.
- `NormatividadSeeder`: 1 normatividad real.
- `ArticuloSeeder`: 1 articulo real, relacionado por normatividad.

Todos usan `updateOrCreate` para evitar duplicados al ejecutar el seeder mas de una vez.

## Ajuste Sprint 6.5A

Se agrego una migracion para ampliar `programas.nombre` de 30 a 150 caracteres. Tambien se revisa si existe algun indice unique sobre `programas.nombre` y se elimina antes de ampliar la columna.

`programas.codigo_pro` se mantiene como unico y es la clave usada por `ProgramaSeeder` para `updateOrCreate`. `programas.nombre` ya no se valida como unico, porque en Django existen nombres repetidos para programas con codigos diferentes.

Con este ajuste, `ProgramaSeeder` queda preparado para cargar 183 de 183 programas reales encontrados en Django.

## Datos pendientes

- Programas con nombre mayor a 150 caracteres: 0.
- Codigos de programa duplicados en Django: 0.

## Auditoria

Los catalogos que tienen `usuario_registra_id` usan el usuario administrador `admin`. `DatabaseSeeder` ejecuta primero `UsuarioSeeder`; si por algun motivo no existe, cada seeder que lo necesita intenta crearlo antes de continuar.

Las tablas que ya tienen `estado_registro` reciben el valor `Activo`:

- `escuelas`
- `zonas`
- `centros`
- `programas`

## Ejecucion

Desde la raiz del proyecto Laravel:

```bash
php artisan db:seed
```

En este equipo, si `php` no esta en el PATH, se puede ejecutar con el PHP portable usado durante la migracion:

```powershell
& 'C:\Users\axlmaster\Documents\Codex\2026-07-08\instalar-laravel-12\work\tools\php\php.exe' artisan db:seed
```

No se cargan datos operativos como estudiantes, denuncias ni procesos disciplinarios.
