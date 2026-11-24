# Bitácora de cambios — boletinsalesiano.pe

Las entradas más recientes, arriba.

## 24/11/2026

- **`avisos-subida.php` instalado** (mu-plugin nuevo). Motivo: al rechazar un PNG, WordPress mostraba a los Autores el mensaje genérico «El archivo no lo ha podido procesar el servidor web», que no explica nada. Ahora se muestra «No se admiten imágenes PNG. Guarda la imagen como JPG y vuelve a subirla.» (y equivalentes para vídeos y archivos de más de 15 MB).
  - v1: revisaba los archivos en `FilesAdded` → no actuaba, porque el cargador rechaza el PNG por tipo antes de ese paso.
  - v2: sustituye el mensaje `FILE_EXTENSION_ERROR` → no actuaba, porque Jetpack VideoPress (`videopress-plupload.js`) reemplaza el cargador después.
  - v3 (definitiva): el mismo código, ejecutado cuando la página termina de cargar (`jQuery(function…)`). **Confirmado por Rodolfo.**
  - Copias: `/home/b0let1n/respaldos/avisos-subida.php.v1` y `.v2`.
- **`reglas-subida.php` probado** con la cuenta de Autor `rodolfovelardeg`: bloquea PNG correctamente (ningún PNG guardado desde el 17/11).

## 23/11/2026

- **`comprimir-al-subir.php` instalado y probado.** jpegoptim y pngquant ya eran visibles dentro de CageFS. Foto de prueba: 2.862 KB → 922 KB, calidad 82.
- **`tamanos-imagen.php` modificado:** el límite de 1.920 px pasa del ancho al **lado más largo**, para que las fotos verticales también se reduzcan (prueba: 1.872×4.096 → 878×1.920 px, 261 KB). Copia: `/home/b0let1n/respaldos/tamanos-imagen.php.2026-11-23`.
- **Registros limpiados:** borrado el `error_log` de root en `public_html` (solo avisos cosméticos `session.gc_divisor` de wp-cli); apartado a `borrar/` el de `wp-admin/includes` (4 errores fatales del 19/11 causados por un escáner que pidió `admin.php` directamente, sin efecto en el sitio).
- **Detectado:** cada foto genera 10 tamaños, no «5 o 6» como dice el informe del 18/11 → corregir el informe.

## 17-18/11/2026 — optimización inicial

Detalle completo en `informes/Informe-optimizacion-boletinsalesiano.pe.docx`.

- uploads 13 → 6,4 GB; BD 124 → 72 MB; respuesta del servidor 3,1 s → 0,015 s; PageSpeed móvil 61 → ~68; LCP de laboratorio 21,8 → 5,7 s.
- Tamaños desactivados y borrados: 1536x1536, 2048x2048, medium_large, td_1920x0, jetpack-portfolio-admin-thumb. Originales borrados con redirección 301 a su versión actual.
- Compresión de toda la biblioteca: jpegoptim 82, pngquant 40-85.
- WP Super Cache 3.1.5 en modo Expert; `WP_CACHE` en `public_html/wp-cache-constante.php`, cargado en la línea 2 de `wp-config.php` (quitar esa línea si se quita WP Super Cache).
- LiteSpeed Cache 7.9.3 solo como optimizador (sin caché); JS diferido excepto jquery.js; CSS asíncrono; CSS crítico con QUIC.cloud gratuito, sin CDN.
- `.htaccess`: caché de navegador, quitar `fbclid`, originales → versión actual. `robots.txt` estático. Cron real cada 5 min en el crontab de `b0let1n`.
- Newspaper: animación de LazyLoad desactivada. Jetpack: búsqueda, comentarios, woocommerce-analytics y búsqueda instantánea desactivados.
- BD limpiada (copia en `/home/b0let1n/respaldos/db-antes-limpieza-2026-11-18.sql.gz`); `WP_POST_REVISIONS = 5`.
- Restos de plugins apartados en `/home/b0let1n/borrar/`. Backup completo previo descargado en el PC de Rodolfo.
