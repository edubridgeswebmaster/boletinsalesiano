# Pendientes — boletinsalesiano.pe

Actualizado: 24/11/2026

## En curso

- [ ] **Recortes del tema 485×360, 324×400 y 218×150** (hasta ~1 GB): decidir con registros de visitas si se usan. Primero, ver si cPanel guarda registros comprimidos en `/home/b0let1n/logs/`.
- [ ] **Prueba en el editor de bloques:** como Autor, arrastrar un PNG a un bloque Imagen y comprobar que el mensaje se entiende.
- [ ] **Borrar las fotos de prueba** de la biblioteca (`IMG_20261121_155855` ×2 y la JPG subida como Autor).

## Próximos

- [ ] **Corregir el informe del 18/11:** «5 o 6 tamaños» → cifra real; añadir límite de 1.920 px en el lado más largo y los avisos claros al subir.
- [ ] **CSS crítico:** 11 tipos de página generados (18-22/11); revisar que no haya parpadeo y purgar.
- [ ] **AIOS:** retención del registro de auditoría a 30–90 días.
- [ ] **Avatares de autores:** subirlos y purgar (`wp litespeed-purge all --allow-root`).
- [ ] **Fotos verticales ya existentes:** calcular cuánto se ahorraría reduciéndolas al nuevo límite de 1.920 px.
- [ ] **Borrar `/home/b0let1n/borrar/` y `/respaldos/`** cuando Rodolfo lo confirme.

## Más adelante

- [ ] **Copias de seguridad fuera del servidor** (Google Drive de TVP), desde el panel edubridges.com/admin. Es lo más importante que queda: hoy la única copia completa está en el PC de Rodolfo.
- [ ] **Informe automático periódico** por correo (con los backups).
- [ ] **Mediados de diciembre de 2026:** revisar los datos de usuarios reales en PageSpeed.
- [ ] **Reglas de subida para redacción:** comunicarlas al equipo de TVP.
- [ ] **Rediseño visual** (aplazado): copia en `/vista-previa/` protegida con contraseña; paletas A) #0B2545 + #8B1E3F, B) #1C1C1E + #B08D57, C) negro/blanco/#B71C1C; titulares serif, texto sans.

## Hecho

- [x] 24/11 — `avisos-subida.php`: mensajes claros al rechazar PNG, vídeo o más de 15 MB.
- [x] 24/11 — `reglas-subida.php` probado con cuenta de Autor.
- [x] 23/11 — `comprimir-al-subir.php` instalado y probado.
- [x] 23/11 — Límite de 1.920 px en el lado más largo (también verticales).
