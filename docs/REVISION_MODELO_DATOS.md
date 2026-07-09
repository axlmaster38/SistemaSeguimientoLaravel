# Revision comparativa del modelo de datos

Fecha: 2026-07-09

## Alcance

Fuente Django original:

```text
D:\laragon\www\SistemaSeguimientoLaravel\referencia_django\ProyectoDjangoSME\sistemaSeguimiento\models.py
```

Proyecto Laravel actual:

```text
D:\laragon\www\SistemaSeguimientoLaravel
```

Esta revision es documental. En Sprint 5.1B solo se ajustaron relaciones inversas Eloquent y texto de encoding en codigo/documentacion. No se crearon migraciones nuevas ni se ejecuto ningun cambio de base de datos.

## 1. Modelos Django vs modelos Laravel

| Django | Laravel | Tabla Laravel | Estado |
| --- | --- | --- | --- |
| `Usuario` | `Usuario` | `usuarios` | Existe |
| `Escuela` | `Escuela` | `escuelas` | Existe |
| `Programa` | `Programa` | `programas` | Existe |
| `Zona` | `Zona` | `zonas` | Existe |
| `Centro` | `Centro` | `centros` | Existe |
| `Estudiante` | `Estudiante` | `estudiantes` | Existe |
| `Historico_Estudiante` | `HistoricoEstudiante` | `historico_estudiantes` | Existe |
| `Tipologia_falta` | `TipologiaFalta` | `tipologias_faltas` | Existe |
| `Proceso_Disciplinario` | `ProcesoDisciplinario` | `procesos_disciplinarios` | Existe |
| `Denuncia` | `Denuncia` | `denuncias` | Existe |
| `tipologiaFalta_Proceso` | `TipologiaFaltaProceso` | `tipologia_falta_proceso` | Existe |
| `Normatividad` | `Normatividad` | `normatividades` | Existe |
| `Articulo` | `Articulo` | `articulos` | Existe |
| `Articulo_Proceso` | `ArticuloProceso` | `articulo_proceso` | Existe |
| `Descargo` | `Descargo` | `descargos` | Existe |
| `Prueba` | `Prueba` | `pruebas` | Existe |
| `Decision` | `Decision` | `decisiones` | Existe |
| `Periodo_academico` | `PeriodoAcademico` | `periodos_academicos` | Existe |
| `Sancion` | `Sancion` | `sanciones` | Existe |
| `Notificacion` | `Notificacion` | `notificaciones` | Existe |
| `Apelacion` | `Apelacion` | `apelaciones` | Existe |

Laravel conserva `User` y `users` de la instalacion base, pero la autenticacion del sistema usa `usuarios`.

## 2. Tablas Laravel SME

- `usuarios`
- `escuelas`
- `programas`
- `zonas`
- `centros`
- `estudiantes`
- `historico_estudiantes`
- `tipologias_faltas`
- `procesos_disciplinarios`
- `denuncias`
- `tipologia_falta_proceso`
- `normatividades`
- `articulos`
- `articulo_proceso`
- `descargos`
- `apelaciones`
- `pruebas`
- `decisiones`
- `periodos_academicos`
- `sanciones`
- `notificaciones`

## 3. Campos faltantes o diferentes

| Modelo/tabla | Diferencia documentada |
| --- | --- |
| `usuarios` | Django usa `fecha_creacion`; Laravel usa `fecha_registro`. No se cambia por ahora. |
| `usuarios` | Django valida `identificacion` con regex numerico; Laravel conserva el campo y el unique, pero la validacion debe vivir en Form Requests. |
| `periodos_academicos` | Django usa `año`; Laravel usa `anio` por compatibilidad ASCII. No se cambia por ahora. |
| `periodos_academicos` | Django define defaults en `fecha_inicio` y `fecha_fin`; Laravel las dejo nullable. No se cambia por ahora. |
| `periodos_academicos` | Laravel agrega unique compuesto `periodo` + `anio`; Django no lo define. Queda documentado. |
| `escuelas` | Django no define `estado_registro`; Laravel lo aplica inicialmente solo en `escuelas` como campo tecnico de eliminacion logica. |
| `escuelas` | Laravel tiene `sigla` unique y el CRUD valida `nombre` unique; Django no lo declara igual. Queda documentado. |
| `zonas` | Laravel tiene `nombre` unique; Django no lo declara igual. Queda documentado. |
| `programas` | Laravel tiene `codigo_pro` unique; Django no lo declara igual. Queda documentado. |
| `notificaciones` | El valor esperado es `Primera Notificación`. Se debe evitar cualquier variante mojibakeada en codigo fuente. |
| `pruebas`, `decisiones`, `notificaciones` | Django usa `FileField(upload_to=...)`; Laravel usa `string(255)` para ruta de archivo. Falta definir estrategia de storage/upload. |
| `historico_estudiantes` | Django y Laravel coinciden: solo tiene `fecha_registro`, sin usuario auditor ni `fecha_actualiza`. |

## 4. Relaciones

Las relaciones de base de datos principales coinciden con Django: claves foraneas, pivotes y relaciones many-to-many existen.

Relaciones inversas Eloquent ajustadas en Sprint 5.1B:

- `Usuario`: relaciones inversas para denuncias, tipologias, normatividades, articulos, procesos, descargos, apelaciones, pruebas, decisiones, sanciones y notificaciones.
- `Estudiante`: relaciones inversas hacia `denuncias` e `historicos`.
- `Programa`: relacion inversa hacia `historicosEstudiantes`.
- `PeriodoAcademico`: relaciones inversas hacia sanciones como periodo inicial y periodo final.
- `ProcesoDisciplinario`: relaciones hasMany hacia `descargos`, `pruebas`, `decisiones`, `notificaciones` y `apelaciones`.

Diferencias restantes:

- `Denuncia` usa `usuario_registra_evalua_id`, equivalente al `usuarioRegistraEvalua` de Django.
- Las tablas pivote Laravel usan columnas `tipologia_falta_id` y `proceso_disciplinario_id`; Django usa conceptos `falta` y `proceso`. Es una diferencia de convencion, no de funcionalidad.

## 5. Auditoria

| Tabla | Auditoria |
| --- | --- |
| `usuarios` | Fechas propias: `fecha_registro` y `fecha_actualiza`; difiere del `fecha_creacion` Django. |
| `escuelas`, `zonas`, `centros` | Sin auditoria por usuario ni fechas, igual que Django. |
| `programas`, `estudiantes`, `periodos_academicos` | Auditoria con usuario registra, usuario actualiza, fecha registro y fecha actualiza. |
| `denuncias` | Usa `usuario_registra_evalua_id`, `usuario_actualiza_id`, `fecha_registro`, `fecha_actualiza`. |
| `tipologias_faltas`, `normatividades`, `articulos`, `procesos_disciplinarios` | Auditoria completa. |
| `descargos`, `apelaciones`, `pruebas`, `decisiones`, `sanciones`, `notificaciones` | Auditoria completa. |
| `historico_estudiantes` | Solo `fecha_registro`. |
| `tipologia_falta_proceso`, `articulo_proceso` | Sin auditoria; se consideran pivotes tecnicos. |

## 6. Estados funcionales del negocio

No deben usarse para eliminacion logica:

- `usuarios.estado`
- `estudiantes.estado_academico`
- `denuncias.estado_denuncia`
- `procesos_disciplinarios.estado_proceso`
- `sanciones.estado_sancion`

## 7. Estado tecnico de eliminacion logica

Campo tecnico:

```text
estado_registro
```

Valores:

```text
Activo
Inactivo
```

Estado actual:

- Aplicado inicialmente solo en `escuelas`.
- No se agrega a mas tablas todavia.
- No reemplaza estados funcionales del negocio.

## 8. Tablas que deberian tener estado_registro

Recomendadas para evaluacion gradual:

- `escuelas` (ya implementado)
- `zonas`
- `centros`
- `programas`
- `estudiantes`
- `periodos_academicos`
- `tipologias_faltas`
- `normatividades`
- `articulos`
- `denuncias`
- `procesos_disciplinarios`
- `descargos`
- `apelaciones`
- `pruebas`
- `decisiones`
- `sanciones`
- `notificaciones`

Caso especial:

- `usuarios`: si se requiere eliminacion logica, debe agregarse `estado_registro` aparte de `estado`.

## 9. Tablas que NO deberian tener estado_registro

- `tipologia_falta_proceso`
- `articulo_proceso`
- `historico_estudiantes`
- `users`
- `cache`
- `cache_locks`
- `jobs`
- `job_batches`
- `failed_jobs`
- `sessions`
- `password_reset_tokens`
- `migrations`

## 10. Recomendaciones

- Mantener documentadas las diferencias `fecha_creacion` vs `fecha_registro` y `año` vs `anio`.
- No cambiar defaults de fechas ni unique/index hasta validar reglas de negocio.
- Definir estrategia de archivos para `Prueba`, `Decision` y `Notificacion`.
- Agregar `estado_registro` por modulo antes de construir cada CRUD, no de forma masiva.
- Revisar casts de fechas en modelos que aun no los tienen.
- Mantener nombres cortos de indices compuestos para MariaDB.
