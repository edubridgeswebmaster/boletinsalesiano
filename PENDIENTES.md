# Pendientes — boletinsalesiano.pe

Actualizado: 24/11/2026

## En curso

- [ ] **30/11: revisar 404 de los tamaños retirados** y, si no hay, borrar `borrar/tamanos-2026-11-24` (645 MB en disco; 609 MB de contenido). Comando en el servidor:
  `grep -E '" 404 ' /etc/apache2/logs/domlogs/boletinsalesiano.pe-ssl_log | grep -E '\-(485|324)x[0-9]+\.' | tail -10`
- [ ] **Prueba en el editor de bloques:** como Autor, arrastrar un PNG a un bloque Imagen y comprobar que el mensaje se entiende.
- [ ] **Borrar las fotos de prueba** de la biblioteca (`IMG_20261121_155855` ×2 y la JPG subida como Autor).

## Próximos

- [ ] **Corregir el informe del 18/11:** «5 o 6 tamaños» → 8 tamaños; añadir el límite de 1.920 px en el lado más largo, los avisos claros al subir y la retirada de `td_485x360` y `td_324x400` (609 MB más).
- [ ] **CSS crítico:** 11 tipos de página generados (18-22/11); revisar que no haya parpadeo y purgar.
- [ ] **Avatares de autores:** subirlos y purgar (`wp litespeed-purge all --allow-root`).
- [ ] **Borrar el resto de `/home/b0let1n/borrar/` y `/respaldos/`** cuando Rodolfo lo confirme.

## Más adelante

- [ ] **Copias de seguridad fuera del servidor** (Google Drive de TVP), desde el panel edubridges.com/admin. Es lo más importante que queda: hoy la única copia completa está en el PC de Rodolfo.
- [ ] **Informe automático periódico** por correo (con los backups).
- [ ] **Mediados de diciembre de 2026:** revisar los datos de usuarios reales en PageSpeed.
- [ ] **Reglas de subida para redacción:** comunicarlas al equipo de TVP.
- [ ] **Jetpack:** Rodolfo lo valora por los suscriptores por correo, el carrusel y la vista previa en Facebook. Se habló de retirarlo; sin decidir (no recomendado por ahora).
- [ ] **Rediseño visual** (aplazado): copia en `/vista-previa/` protegida con contraseña; paletas A) #0B2545 + #8B1E3F, B) #1C1C1E + #B08D57, C) negro/blanco/#B71C1C; titulares serif, texto sans.
- [ ] **Otros sitios salesianos en `C:\dev\www`:** revisar qué merece repositorio en GitHub (código propio) y qué va a los backups de Drive (sitios completos).

## Hecho

- [x] 24/11 — Fotos verticales ya existentes: descartado (148 fotos, ahorro estimado 31 MB; no compensa).
- [x] 24/11 — AIOS: retención del registro de auditoría revisada; tablas de 2 y 1 MB, sin acción. Revisar de nuevo en mayo de 2027.
- [x] 24/11 — Retirados `td_485x360` y `td_324x400`: 17.731 archivos, 609 MB apartados.
- [x] 24/11 — Carpeta local y repositorio privado en GitHub.
- [x] 24/11 — `avisos-subida.php`: mensajes claros al rechazar PNG, vídeo o más de 15 MB.
- [x] 24/11 — `reglas-subida.php` probado con cuenta de Autor.
- [x] 23/11 — `comprimir-al-subir.php` instalado y probado.
- [x] 23/11 — Límite de 1.920 px en el lado más largo (también verticales).
