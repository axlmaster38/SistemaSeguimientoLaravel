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

## Compatibilidad

Las decisiones de implementacion deben mantenerse compatibles con:

- Apache 2.4.67
- PHP 8.4.16
- MariaDB 11.8.6
