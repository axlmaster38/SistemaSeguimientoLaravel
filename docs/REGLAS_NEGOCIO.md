# Reglas de negocio migradas desde Django

Proyecto origen:

`D:\laragon\www\SistemaSeguimientoLaravel\referencia_django\ProyectoDjangoSME`

Proyecto destino:

`D:\laragon\www\SistemaSeguimientoLaravel`

## Procesos disciplinarios

Origen Django:

- `sistemaSeguimiento/forms.py::ESTADO_PROCESO_CHOICES`
- `sistemaSeguimiento/views.py::sumar_dias_habiles`
- `sistemaSeguimiento/views.py::contar_dias_habiles`
- `sistemaSeguimiento/views.py::listar_procesos_disciplinarios`
- `sistemaSeguimiento/views.py::filtrar_procesos_disciplinarios`
- `sistemaSeguimiento/templates/partials/tabla_procesos_disciplinarios.html`

Implementacion Laravel:

- `app/Services/ReglasNegocioDisciplinarioService.php`
- `app/Services/ProcesoDisciplinarioService.php`
- `resources/views/procesos/index.blade.php`

Reglas:

- Los dias habiles son lunes a viernes.
- La fecha limite se obtiene sumando 10 dias habiles a la fecha base.
- La fecha base es `fecha_2da_notificacion` de la ultima notificacion del proceso si existe.
- Si no existe `fecha_2da_notificacion`, la fecha base es `fecha_registro` de la ultima notificacion del proceso.
- Los dias restantes se calculan como dias habiles desde hoy hasta la fecha limite.
- Los dias transcurridos se calculan desde la ultima sancion; si no existe sancion, desde la ultima decision; si no existe decision, desde `fecha_registro` del proceso.
- Si el proceso no tiene notificacion, se muestra `Proceso sin notificar`.

Semaforizacion:

- Rojo: `dias_restantes <= 2`, color `rgb(250, 124, 124)`.
- Amarillo: `dias_restantes <= 5`, color `rgb(250, 239, 124)`.
- Sin color: `dias_restantes > 5`.

Colores de estado:

- Estados exactos de Django: `Proceso Abierto`, `Fallo en primera instancia`, `Fallo en segunda instancia`, `Cumpliendo Sanción`, `Proceso Cerrado`, `Sanción cumplida`.
- `Proceso Abierto`: `rgb(0, 242, 255)`.
- `Fallo en primera instancia`: `rgb(0, 153, 255)`.
- `Fallo en segunda instancia`: `rgb(0, 153, 255)`.
- `Cumpliendo Sanción`: `rgb(0, 153, 255)`.
- `Proceso Cerrado`: `rgb(17, 0, 255)`.
- `Sanción cumplida`: `rgb(17, 0, 255)`.

## Sanciones

Origen Django:

- `sistemaSeguimiento/views.py::listar_sanciones`
- `sistemaSeguimiento/views.py::filtrar_sanciones`
- `sistemaSeguimiento/templates/partials/tabla_sanciones.html`

Implementacion Laravel:

- `app/Services/ReglasNegocioDisciplinarioService.php`
- `app/Services/SancionService.php`
- `resources/views/sanciones/index.blade.php`

Reglas:

- Los meses restantes se calculan desde hoy hasta `periodo_final_sancion.fecha_inicio`.
- Si quedan dias adicionales, el calculo redondea al siguiente mes.
- Si los meses restantes son negativos o no existen, se muestra `Sancion finalizada`.
- La notificacion de sancion se obtiene desde la ultima notificacion asociada a la sancion.

Semaforizacion:

- Rojo: meses restantes entre `0` y `1`, color `rgb(250, 124, 124)`.
- Amarillo: meses restantes entre `2` y `4`, color `rgb(250, 239, 124)`.
- Sin color: meses restantes mayores o iguales a `5`.

## Estados automaticos

Origen Django:

- `sistemaSeguimiento/views.py::registrarSancion`

Implementacion Laravel:

- `app/Services/SancionService.php`

Reglas:

- Si una sancion es de `Primera Instancia`, el proceso relacionado cambia a `Fallo en primera instancia`.
- Si una sancion es de `Segunda Instancia`, el proceso relacionado cambia a `Fallo en segunda instancia`.

## Antecedentes

Origen Django:

- `sistemaSeguimiento/views.py::registrarDenuncia`
- `sistemaSeguimiento/views.py::ajax_guardar_denuncia`

Implementacion Laravel:

- `app/Services/DenunciaService.php`

Regla:

- Al crear o editar una denuncia, se cuenta el total de denuncias del estudiante y se guarda en sesion como `denuncias_estudiante_count`.

## Historico

Origen Django:

- `sistemaSeguimiento/views.py::listar_procesos_historicos`
- `sistemaSeguimiento/views.py::filtrar_procesos_historicos`
- `sistemaSeguimiento/views.py::verProceso_historico`

Implementacion Laravel existente:

- `app/Services/ProcesoDisciplinarioService.php`
- `app/Models/HistoricoEstudiante.php`

Reglas identificadas:

- Django consulta procesos historicos con relaciones de denuncia, estudiante, decisiones, sanciones, notificaciones, descargos, pruebas, articulos y apelaciones.
- Laravel ya crea o actualiza `historico_estudiantes` al crear o editar un proceso disciplinario, guardando estudiante, proceso y programa actual del estudiante.

## Dashboard

Origen Django:

- `sistemaSeguimiento/views.py::sistema`

Resultado de revision:

- No se encontro en Django un dashboard con consultas de procesos abiertos, cerrados, vencidos, proximos a vencer o estudiantes con antecedentes.
- La vista `sistema` solo renderiza el menu principal.

## Reglas pendientes

- No queda una regla Django pendiente de implementar dentro del alcance revisado.
- No se implementaron conteos nuevos de dashboard porque no existen como regla en Django.
- No se creo un calculo independiente de `dias_vencidos` porque Django no lo define; solo calcula `dias_restantes`.

## Alertas del Resumen General

Implementación Laravel:

- `app/Services/AlertaDashboardService.php`
- `app/Http/Controllers/DashboardController.php`
- `resources/views/dashboard/index.blade.php`

Criterio de procesos:

- Se reutiliza `ReglasNegocioDisciplinarioService::calcularProceso`.
- La alerta se muestra cuando `dias_restantes` es menor o igual a `3`.
- El cálculo de días se mantiene en días hábiles de lunes a viernes.
- La fecha límite sigue siendo la fecha base de la última notificación más `10` días hábiles.
- Se excluyen procesos con `estado_registro = Inactivo`.
- Se excluyen estados cerrados o finalizados: `Proceso Cerrado`, `Sanción cumplida`, `Sancion cumplida`, `Cerrado`, `Finalizado`, `Archivado`.
- Se muestran máximo `5` procesos, ordenados primero por menor cantidad de días restantes y luego por fecha límite.

Criterio de apelaciones:

- No se implementa cálculo de vencimiento porque no existe una regla real documentada en Django ni en los servicios actuales de Laravel.
- No se encontró una fecha inicial ni un plazo definido para apelaciones.
- El Resumen General muestra la categoría como pendiente de definición para evitar cálculos arbitrarios.

Criterio de sanciones:

- Se reutiliza `ReglasNegocioDisciplinarioService::calcularSancion`.
- La alerta se muestra cuando `meses_restantes` es menor o igual a `1`.
- Se incluyen sanciones vencidas que continúan activas.
- Se excluyen sanciones con `estado_registro = Inactivo`.
- Se excluyen sanciones con estado `Finalizada`, `Finalizado`, `Inactiva` o `Inactivo`.
- Se muestran máximo `5` sanciones, ordenadas primero por menor cantidad de meses restantes y luego por fecha final.

## REPORTES E HISTORICOS MIGRADOS

Origen Django:

- `sistemaSeguimiento/views.py::listar_procesos_historicos`
- `sistemaSeguimiento/views.py::filtrar_procesos_historicos`
- `sistemaSeguimiento/views.py::verProceso_historico`
- `sistemaSeguimiento/views.py::exportar_procesos_historicos`
- `sistemaSeguimiento/views.py::descargar_proceso_pdf`
- `sistemaSeguimiento/views.py::exportar_sanciones_excel`
- `sistemaSeguimiento/forms.py::proceso_historicoFiltroForm`
- `sistemaSeguimiento/templates/listar_procesos_historicos.html`
- `sistemaSeguimiento/templates/partials/tabla_procesos_historicos.html`
- `sistemaSeguimiento/templates/ver_proceso_historico.html`
- `sistemaSeguimiento/templates/ver_proceso_historico_pdf.html`

Implementacion Laravel:

- `app/Http/Controllers/ReporteController.php`
- `app/Services/ReporteService.php`
- `resources/views/reportes/index.blade.php`
- `resources/views/reportes/antecedentes_estudiante.blade.php`
- `resources/views/reportes/procesos_historicos.blade.php`
- `resources/views/reportes/proceso_historico_detalle.blade.php`

Reportes migrados:

- Antecedentes por estudiante: consolidado por estudiante con datos actuales, denuncias, procesos, decisiones, sanciones, notificaciones, apelaciones e historico de programas.
- Procesos historicos: listado con estudiante, denuncia, proceso, estado, fechas, programa historico, programa actual, centro, decisiones, sanciones, notificaciones, apelaciones y semaforizacion.
- Detalle historico de proceso: vista de consulta de relaciones del proceso, equivalente funcional al detalle historico de Django.

Filtros replicados desde Django para procesos historicos:

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

Filtros adicionales usados en el reporte consolidado de antecedentes:

- codigo del estudiante
- programa actual
- centro actual
- estado de sancion

Exportaciones:

- Django tenia exportacion XLSX de procesos historicos y sanciones con `openpyxl`.
- Django tenia PDF de detalle historico con `xhtml2pdf`.
- Laravel implementa exportacion CSV nativa de procesos historicos usando los mismos campos principales del XLSX Django.
- No se agrego dependencia Composer para XLSX/PDF en este sprint.
