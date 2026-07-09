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

## Compatibilidad

Las decisiones de implementacion deben mantenerse compatibles con:

- Apache 2.4.67
- PHP 8.4.16
- MariaDB 11.8.6
