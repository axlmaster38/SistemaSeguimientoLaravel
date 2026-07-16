# Instalación en producción

## Requisitos

- Apache 2.4.67 o compatible.
- PHP 8.4.16 con extensiones requeridas por Laravel: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `session`, `tokenizer`, `xml`.
- MariaDB 11.8.6.
- Composer 2.x.

## Preparar el proyecto

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Configurar `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dominio-institucional

DB_CONNECTION=mariadb
DB_HOST=host_base_datos
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario_base_datos
DB_PASSWORD=clave_base_datos

FILESYSTEM_DISK=public
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Base de datos

Ejecutar migraciones y seeders sin borrar datos:

```bash
php artisan migrate --force
php artisan db:seed --force
```

No ejecutar `migrate:fresh` en producción.

## Storage

Crear enlace público para archivos:

```bash
php artisan storage:link
```

Verificar que existan y sean escribibles:

- `storage/app/public`
- `storage/framework/cache`
- `storage/framework/sessions`
- `storage/framework/views`
- `bootstrap/cache`

## Apache

El DocumentRoot debe apuntar a la carpeta `public` del proyecto:

```apache
DocumentRoot /ruta/SistemaSeguimientoLaravel/public
```

La carpeta `public` ya incluye `.htaccess` compatible con Apache 2.4 y `mod_rewrite`.

Si el hosting no permite apuntar el DocumentRoot a `public`, se debe coordinar con el proveedor una configuración segura. No se recomienda exponer la raíz completa del proyecto.

## Optimización

Después de configurar `.env`:

```bash
php artisan optimize
```

Si se cambia `.env`, rutas, configuración o vistas:

```bash
php artisan optimize:clear
php artisan optimize
```

## Validación final

```bash
php -l app/Http/Controllers/DashboardController.php
php artisan route:list
php artisan migrate:status
php artisan optimize
```

## Acceso inicial

Si se ejecutan seeders, debe existir el usuario administrador inicial:

- Usuario: `admin`
- Contraseña: `admin123`

Cambiar esta contraseña inmediatamente después de la primera entrada.
