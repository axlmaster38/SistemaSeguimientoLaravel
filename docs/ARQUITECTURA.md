# Arquitectura del Sistema SME

## Eliminacion logica

El sistema no debe usar estados funcionales del negocio para representar eliminacion logica.

Para eliminacion logica se usa exclusivamente el campo:

```text
estado_registro
```

Valores permitidos:

```text
Activo
Inactivo
```

Esta decision evita mezclar el ciclo de vida tecnico del registro con estados propios del negocio, por ejemplo:

- `estado_proceso`
- `estado_denuncia`
- `estado_sancion`

## Aplicacion inicial

La primera implementacion se aplica al modulo `escuelas`.

Reglas:

- No se eliminan fisicamente registros de `escuelas`.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- Por defecto los listados muestran registros `Activo`.
- Los listados deben permitir filtrar por `Activo`, `Inactivo` o `Todos`.
- Solo el rol `Administrador` puede cambiar `estado_registro`.
- El rol `Operador` puede crear, consultar y editar, pero no cambiar `estado_registro`.

## Gestion academica

En Sprint 6 se extiende el mismo patron a:

- `programas`
- `zonas`
- `centros`

Reglas adicionales:

- No se eliminan fisicamente programas, zonas ni centros.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- Por defecto los listados muestran registros `Activo`.
- Los listados permiten filtrar por `Activo`, `Inactivo` o `Todos`.
- Solo `Administrador` puede cambiar `estado_registro`.
- `Operador` puede crear, consultar y editar, pero no cambiar `estado_registro`.
- No se puede inactivar un programa si tiene estudiantes activos.
- No se puede inactivar un centro si tiene estudiantes activos.
- No se puede inactivar una zona si tiene centros activos.

Definicion operativa:

- Estudiante activo: `estudiantes.estado_academico = Activo`.
- Centro activo: `centros.estado_registro = Activo`.

## Periodos academicos y estudiantes

En Sprint 7 se extiende `estado_registro` a:

- `periodos_academicos`
- `estudiantes`

Reglas:

- No se eliminan fisicamente periodos academicos ni estudiantes.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- Por defecto los listados muestran registros `Activo`.
- Los listados permiten filtrar por `Activo`, `Inactivo` o `Todos`.
- Solo `Administrador` puede cambiar `estado_registro`.
- `Operador` puede crear, consultar y editar.
- No se puede inactivar un estudiante si tiene denuncias activas.
- No se puede inactivar un estudiante si tiene procesos disciplinarios activos.

Definicion operativa:

- Denuncia activa: denuncia cuyo `estado_denuncia` no esta en estados finales o inactivos conocidos.
- Proceso disciplinario activo: proceso cuyo `estado_proceso` no esta en estados finales o inactivos conocidos.

## Denuncias

En Sprint 8 se extiende `estado_registro` a `denuncias`.

Reglas:

- No se eliminan fisicamente denuncias.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- `estado_denuncia` es un estado funcional del negocio.
- `estado_registro` es el estado tecnico para activar o inactivar el registro.
- Solo se pueden crear denuncias para estudiantes con `estado_registro = Activo`.
- No se puede inactivar una denuncia si tiene procesos disciplinarios activos asociados.
- Solo `Administrador` puede cambiar `estado_registro`.
- `Operador` puede crear, consultar y editar.

Estados funcionales sugeridos para `estado_denuncia`:

- Recibida
- En evaluación
- Admitida
- Rechazada
- Archivada

## Procesos disciplinarios

En Sprint 9 se extiende `estado_registro` a `procesos_disciplinarios`.

Reglas:

- No se eliminan fisicamente procesos disciplinarios.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- `estado_proceso` es un estado funcional del negocio.
- `estado_registro` es el estado tecnico para activar o inactivar el registro.
- Solo se pueden crear procesos para denuncias con `estado_registro = Activo`.
- No se permite crear mas de un proceso activo para la misma denuncia.
- Al crear o editar un proceso se sincronizan sus tipologias de falta y articulos.
- Al crear o editar un proceso se crea o actualiza `historico_estudiantes` con el estudiante de la denuncia y el programa actual del estudiante.
- Solo `Administrador` puede cambiar `estado_registro`.
- `Operador` puede crear, consultar y editar.

Estados funcionales sugeridos para `estado_proceso`:

- En estudio
- Abierto
- Cerrado
- Archivado

## Descargos y pruebas

En Sprint 10 se extiende `estado_registro` a:

- `descargos`
- `pruebas`

Reglas:

- No se eliminan fisicamente descargos ni pruebas.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- Solo se pueden registrar descargos para procesos disciplinarios activos.
- No se puede inactivar un descargo si tiene pruebas activas asociadas.
- Una prueba debe estar asociada al menos a un proceso disciplinario, descargo o apelacion.
- En Sprint 12 se habilita tambien la asociacion de pruebas a apelaciones.
- Si una prueba se asocia a un descargo y no se informa proceso, el sistema toma el proceso desde el descargo.
- Si se informa proceso y descargo, el descargo debe pertenecer al proceso indicado.

Archivos de pruebas:

- Los archivos se almacenan en el disco `public`, carpeta `pruebas`.
- En base de datos se guarda solo la ruta relativa.
- Formatos permitidos: `pdf`, `doc`, `docx`, `jpg`, `jpeg`, `png`.
- Tamano maximo: 10 MB.
- Al actualizar una prueba, si no se carga archivo nuevo se conserva el anterior.
- Si se reemplaza el archivo, se elimina el archivo anterior del storage.
- No se eliminan archivos al inactivar una prueba.
- La descarga se realiza mediante ruta protegida por autenticacion.

## Decisiones y sanciones

En Sprint 11 se extiende `estado_registro` a:

- `decisiones`
- `sanciones`

Reglas:

- No se eliminan fisicamente decisiones ni sanciones.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- `tipo_decision`, `clasificacion_falta`, `tipo_sancion` y `estado_sancion` son campos funcionales del negocio.
- `estado_registro` es el estado tecnico para activar o inactivar el registro.
- Solo se pueden crear decisiones para procesos activos.
- No se puede inactivar una decision si tiene sanciones activas asociadas.
- Solo se pueden crear sanciones para decisiones activas.
- No se puede inactivar una sancion si tiene notificaciones asociadas o activas.
- La relacion funcional queda: Proceso disciplinario -> Decision -> Sancion.

Choices replicados desde Django:

- `tipo_decision`: Apertura de proceso disciplinario, Primera Instancia, Segunda Instancia.
- `clasificacion_falta`: Leve, Grave, Gravisima.
- `tipo_sancion`: Primera Instancia, Segunda Instancia.
- `estado_sancion`: En proceso, Finalizada.

Archivos de decisiones:

- Los archivos se almacenan en el disco `public`, carpeta `decisiones`.
- En base de datos se guarda solo la ruta relativa.
- Formatos permitidos: `pdf`, `doc`, `docx`, `jpg`, `jpeg`, `png`.
- Tamano maximo: 10 MB.
- Al actualizar una decision, si no se carga archivo nuevo se conserva el anterior.
- Si se reemplaza el archivo, se elimina el archivo anterior del storage.
- No se eliminan archivos al inactivar una decision.
- La descarga se realiza mediante ruta protegida por autenticacion.

Logica replicada desde Django:

- Al crear o editar una sancion de `Primera Instancia`, el proceso pasa a `Fallo en primera instancia`.
- Al crear o editar una sancion de `Segunda Instancia`, el proceso pasa a `Fallo en segunda instancia`.

## Notificaciones y apelaciones

En Sprint 12 se extiende `estado_registro` a:

- `notificaciones`
- `apelaciones`

Reglas:

- No se eliminan fisicamente notificaciones ni apelaciones.
- La accion de eliminar se reemplaza por cambio de `estado_registro`.
- `tipo_notificacion`, `instancia` y `tipo_apelacion` son campos funcionales del negocio.
- `estado_registro` es el estado tecnico para activar o inactivar el registro.
- Solo se pueden crear notificaciones para procesos o sanciones activas.
- Una notificacion de tipo `Proceso` exige `proceso_disciplinario_id`.
- Una notificacion de tipo `Sancion` exige `sancion_id`.
- Una apelacion exige un proceso disciplinario activo.
- No se puede inactivar una apelacion si tiene pruebas activas asociadas.
- Las pruebas pueden asociarse a una apelacion activa.

Choices replicados desde Django:

- `tipo_notificacion`: Sancion, Proceso.
- `instancia`: Primera Notificacion, Segunda Notificacion.
- `tipo_apelacion`: Recurso de reposicion, Recurso de reposicion en subsidio de apelacion, Apelacion.

Archivos de notificaciones:

- Los archivos se almacenan en el disco `public`, carpeta `notificaciones`.
- En base de datos se guarda solo la ruta relativa.
- Formatos permitidos: `pdf`, `doc`, `docx`, `jpg`, `jpeg`, `png`.
- Tamano maximo: 10 MB.
- Al actualizar una notificacion, si no se carga archivo nuevo se conserva el anterior.
- Si se reemplaza el archivo, se elimina el archivo anterior del storage.
- No se eliminan archivos al inactivar una notificacion.
- La descarga se realiza mediante ruta protegida por autenticacion.

Logica replicada desde Django:

- Al crear o editar una notificacion con instancia `Segunda Notificación`, se registra automaticamente `fecha_2da_notificacion`.
- Al crear o editar una notificacion con instancia `Primera Notificación`, se limpia `fecha_2da_notificacion`.

## Compatibilidad

Las decisiones de implementacion deben mantenerse compatibles con:

- Apache 2.4.67
- PHP 8.4.16
- MariaDB 11.8.6

## REGLAS DE NEGOCIO MIGRADAS

Origen Django:

- `sistemaSeguimiento/views.py::sumar_dias_habiles`
- `sistemaSeguimiento/forms.py::ESTADO_PROCESO_CHOICES`
- `sistemaSeguimiento/views.py::contar_dias_habiles`
- `sistemaSeguimiento/views.py::listar_procesos_disciplinarios`
- `sistemaSeguimiento/views.py::filtrar_procesos_disciplinarios`
- `sistemaSeguimiento/views.py::listar_sanciones`
- `sistemaSeguimiento/views.py::filtrar_sanciones`
- `sistemaSeguimiento/views.py::registrarSancion`
- `sistemaSeguimiento/views.py::registrarDenuncia`
- `sistemaSeguimiento/views.py::ajax_guardar_denuncia`
- `sistemaSeguimiento/templates/partials/tabla_procesos_disciplinarios.html`
- `sistemaSeguimiento/templates/partials/tabla_sanciones.html`

Implementacion Laravel:

- `app/Services/ReglasNegocioDisciplinarioService.php`
- `app/Services/ProcesoDisciplinarioService.php`
- `app/Services/SancionService.php`
- `app/Services/DenunciaService.php`
- `resources/views/procesos/index.blade.php`
- `resources/views/sanciones/index.blade.php`

Reglas migradas:

- Los dias habiles se calculan de lunes a viernes.
- La fecha limite del proceso es 10 dias habiles despues de la fecha base de notificacion.
- La fecha base del proceso es `fecha_2da_notificacion` si existe; si no, `fecha_registro` de la ultima notificacion de proceso.
- Los dias restantes del proceso se cuentan como dias habiles desde hoy hasta la fecha limite.
- Los dias transcurridos del proceso se calculan desde la ultima sancion; si no existe, desde la ultima decision; si no existe, desde `fecha_registro` del proceso.
- Semaforo de procesos: rojo cuando `dias_restantes <= 2`, amarillo cuando `dias_restantes <= 5`.
- Color de `estado_proceso`: `Proceso Abierto` usa `rgb(0, 242, 255)`; `Fallo en primera instancia`, `Fallo en segunda instancia` y `Cumpliendo Sanción` usan `rgb(0, 153, 255)`; `Proceso Cerrado` y `Sanción cumplida` usan `rgb(17, 0, 255)`.
- El catalogo de estados de proceso se homologa al Django original: `Proceso Abierto`, `Fallo en primera instancia`, `Fallo en segunda instancia`, `Cumpliendo Sanción`, `Proceso Cerrado`, `Sanción cumplida`.
- Meses restantes de sancion: diferencia entre hoy y `periodo_final_sancion.fecha_inicio`, redondeando hacia arriba si quedan dias adicionales.
- Semaforo de sanciones: rojo para meses `0..1`, amarillo para meses `2..4`.
- Al crear o editar sancion de `Primera Instancia`, el proceso pasa a `Fallo en primera instancia`.
- Al crear o editar sancion de `Segunda Instancia`, el proceso pasa a `Fallo en segunda instancia`.
- Al crear o editar denuncia, se guarda en sesion `denuncias_estudiante_count` con el total de denuncias del estudiante.

Reglas revisadas sin implementacion nueva:

- En Django no se encontro un dashboard con consultas de procesos abiertos, cerrados, vencidos, proximos a vencer o estudiantes con antecedentes; la vista `sistema` solo renderiza el menu.
- En Django no se encontro una regla explicita llamada `dias_vencidos`; el listado usa `dias_restantes` y sus colores.

## Reportes, antecedentes e historicos

En Sprint 14 se agregan reportes de solo consulta:

- Antecedentes por estudiante.
- Procesos historicos.
- Detalle historico de proceso.

Arquitectura:

- Las consultas, filtros y eager loading viven en `ReporteService`.
- `ReporteController` solo coordina request, service y vista.
- Las vistas Blade no calculan reglas de negocio; solo presentan datos y valores ya resueltos.
- Todas las rutas quedan dentro del middleware `autenticado`.
- Administrador y Operador pueden consultar reportes.

Rutas:

- `GET /reportes`
- `GET /reportes/antecedentes-estudiante`
- `GET /reportes/procesos-historicos`
- `GET /reportes/procesos-historicos/{proceso}`
- `GET /reportes/procesos-historicos/exportar-csv`

Exportacion:

- Django tenia XLSX con `openpyxl` y PDF con `xhtml2pdf`.
- Laravel actual no tiene dependencia instalada para XLSX/PDF.
- Para mantener compatibilidad sin agregar paquetes, se implementa CSV nativo para procesos historicos.
- XLSX/PDF queda como mejora futura condicionada a aprobar una dependencia Composer compatible con PHP 8.4.16.

## DESPLIEGUE EN PRODUCCIÓN

El sistema debe desplegarse como aplicación Laravel estándar, manteniendo la raíz pública en la carpeta `public`.

Compatibilidad objetivo:

- Apache 2.4.67.
- PHP 8.4.16.
- MariaDB 11.8.6.

Variables obligatorias en producción:

- `APP_ENV=production`.
- `APP_DEBUG=false`.
- `APP_URL` con el dominio real.
- `DB_CONNECTION=mariadb`.
- `FILESYSTEM_DISK=public`.
- `SESSION_DRIVER=database`.
- `CACHE_STORE=database`.
- `QUEUE_CONNECTION=database`.

Reglas de despliegue:

- El DocumentRoot de Apache debe apuntar a `public`.
- No se debe exponer la raíz completa del proyecto desde el servidor web.
- No se debe ejecutar `migrate:fresh` en ambientes con datos reales.
- Los comandos de migración y seed deben ejecutarse con `--force` en producción.
- `storage` y `bootstrap/cache` deben tener permisos de escritura para PHP/Apache.
- `php artisan storage:link` debe ejecutarse para habilitar descargas de archivos guardados en el disco `public`.
- Después de configurar `.env`, se debe ejecutar `php artisan optimize`.

Documentación operativa:

- `docs/INSTALACION_PRODUCCION.md`.
- `docs/CHECKLIST_ENTREGA.md`.
