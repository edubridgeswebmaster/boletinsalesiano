# Pedido para Cowork: actualizar bitácora y pendientes

Uso: en una tarea de Cowork del proyecto, escribe
"Sigue scripts\pedido-cowork.md de C:\dev\salesianos\www\boletinsalesiano con este resumen:"
y pega debajo el "Resumen para Cowork" de la sesión.

## Instrucciones para Claude

Trabaja solo dentro de C:\dev\salesianos\www\boletinsalesiano y no modifiques nada fuera de esa carpeta.

Con el resumen de la sesión que se te pegue:

1. Añade las entradas a BITACORA.md, bajo la fecha que corresponda (las más recientes arriba). Si la fecha ya existe, añade dentro de ella; si no, crea la sección.
2. Actualiza PENDIENTES.md: cambia la fecha de "Actualizado", marca como hechos los que se completaron (muévelos a "Hecho" con su fecha) y añade los nuevos en la sección que indique el resumen.
3. Si el resumen menciona cambios en archivos del servidor, recuérdame ejecutar scripts\traer-del-servidor.ps1 antes del commit.
4. No cambies README.md salvo que el resumen lo pida expresamente.
5. Muéstrame qué cambiaste en cada archivo. No hagas commit hasta que te lo apruebe; cuando lo apruebe, haz el commit con un mensaje corto que resuma la sesión.
