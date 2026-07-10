# Reportes

## Origen Django

Proyecto revisado:

`D:\laragon\www\SistemaSeguimientoLaravel\referencia_django\ProyectoDjangoSME`

Reportes y consultas encontradas:

- `listar_procesos_historicos`
- `filtrar_procesos_historicos`
- `verProceso_historico`
- `exportar_procesos_historicos`
- `descargar_proceso_pdf`
- `exportar_sanciones_excel`

Plantillas relacionadas:

- `listar_procesos_historicos.html`
- `partials/tabla_procesos_historicos.html`
- `partials/lista_procesos_historicos.html`
- `ver_proceso_historico.html`
- `ver_proceso_historico_pdf.html`

## Reportes Laravel

### Antecedentes por estudiante

Ruta:

`GET /reportes/antecedentes-estudiante`

Implementacion:

- `ReporteController::antecedentesEstudiante`
- `ReporteService::antecedentesEstudiante`
- `resources/views/reportes/antecedentes_estudiante.blade.php`

Campos mostrados:

- codigo del estudiante
- nombre y apellido
- programa actual
- centro actual
- denuncias asociadas
- procesos disciplinarios
- estado de cada proceso
- conteo de decisiones
- conteo de sanciones
- conteo de notificaciones
- conteo de apelaciones
- historico de programas
- total de antecedentes

Filtros:

- estudiante
- codigo
- programa
- centro
- estado del proceso
- estado de sancion
- fecha desde
- fecha hasta

### Procesos historicos

Ruta:

`GET /reportes/procesos-historicos`

Detalle:

`GET /reportes/procesos-historicos/{proceso}`

Implementacion:

- `ReporteController::procesosHistoricos`
- `ReporteController::procesoHistoricoDetalle`
- `ReporteService::procesosHistoricos`
- `ReporteService::detalleProcesoHistorico`
- `resources/views/reportes/procesos_historicos.blade.php`
- `resources/views/reportes/proceso_historico_detalle.blade.php`

Campos mostrados:

- proceso
- estudiante
- programa registrado en `historico_estudiantes`
- programa actual
- centro
- denuncia
- fecha de apertura o registro
- estado del proceso
- dias restantes
- semaforo
- decisiones
- sanciones
- notificaciones
- apelaciones

Filtros replicados:

- estudiante
- proceso
- denuncia
- estado del proceso
- clasificacion de falta
- fecha desde
- fecha hasta
- con sancion
- con decision
- con notificacion de proceso
- con notificacion de sancion
- sin sancion
- sin decision
- sin notificacion de proceso
- sin notificacion de sancion

Filtros adicionales aceptados:

- programa actual
- centro actual

## Exportaciones

Encontradas en Django:

- XLSX de procesos historicos con `openpyxl`.
- XLSX de sanciones con `openpyxl`.
- PDF de proceso historico con `xhtml2pdf`.

Implementado en Laravel:

- CSV nativo de procesos historicos: `GET /reportes/procesos-historicos/exportar-csv`.

Diferencia aceptada:

- No se agrego paquete Composer para XLSX/PDF en este sprint.
- La exportacion CSV conserva los campos principales del XLSX historico de Django y evita dependencias nuevas.

## Permisos

- Todas las rutas estan protegidas por `autenticado`.
- Administrador y Operador pueden consultar.
- Los reportes no permiten edicion.

## Rendimiento

- Las consultas usan eager loading para evitar N+1.
- Los filtros se aplican en `ReporteService`.
- Los resultados se paginan con `withQueryString()`.
- El calculo de semaforizacion reutiliza `ReglasNegocioDisciplinarioService`.
