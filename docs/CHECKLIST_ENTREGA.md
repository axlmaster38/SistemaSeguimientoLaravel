# Checklist de entrega

## Código

- [ ] `php -l` ejecutado sin errores en archivos PHP del proyecto.
- [ ] `php artisan route:list` ejecutado sin errores.
- [ ] `php artisan optimize` ejecutado sin errores.
- [ ] No hay `dd()`, `dump()`, `var_dump()` ni código de depuración.
- [ ] `.env` real no se entrega públicamente.

## Base de datos

- [ ] `php artisan migrate:status` revisado.
- [ ] No hay migraciones pendientes inesperadas.
- [ ] Seeders de catálogos ejecutados si corresponde.
- [ ] Usuario administrador inicial creado o validado.
- [ ] No se ejecutó `migrate:fresh` sobre datos reales.

## Seguridad

- [ ] `APP_ENV=production`.
- [ ] `APP_DEBUG=false`.
- [ ] `APP_KEY` generado.
- [ ] Rutas internas protegidas por middleware `autenticado`.
- [ ] Cambios de `estado_registro` limitados al rol `Administrador`.
- [ ] Descargas de archivos protegidas por sesión.

## Archivos

- [ ] `php artisan storage:link` ejecutado.
- [ ] Upload de pruebas validado.
- [ ] Upload de decisiones validado.
- [ ] Upload de notificaciones validado.
- [ ] Reemplazo de archivos validado.
- [ ] Descarga de archivos validada.

## Flujo funcional

- [ ] Login como Administrador.
- [ ] Login como Operador.
- [ ] CRUD Escuelas.
- [ ] CRUD Programas.
- [ ] CRUD Zonas.
- [ ] CRUD Centros.
- [ ] CRUD Periodos Académicos.
- [ ] CRUD Estudiantes con selects dependientes.
- [ ] CRUD Denuncias.
- [ ] CRUD Procesos Disciplinarios.
- [ ] CRUD Descargos.
- [ ] CRUD Pruebas.
- [ ] CRUD Decisiones.
- [ ] CRUD Sanciones.
- [ ] CRUD Notificaciones.
- [ ] CRUD Apelaciones.
- [ ] Reporte de antecedentes.
- [ ] Reporte de procesos históricos.
- [ ] Exportación CSV.

## Producción

- [ ] Hosting confirma PHP 8.4.16.
- [ ] Hosting confirma Apache 2.4.67.
- [ ] Hosting confirma MariaDB 11.8.6.
- [ ] DocumentRoot apunta a `public`.
- [ ] Permisos de `storage` y `bootstrap/cache` configurados.
- [ ] Dominio configurado en `APP_URL`.
- [ ] Cache regenerada con `php artisan optimize`.
