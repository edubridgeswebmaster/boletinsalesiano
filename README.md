# boletinsalesiano.pe — carpeta del proyecto

Carpeta local de trabajo para el sitio del Boletín Salesiano (TVP) y su mantenimiento.
Ruta: `C:\dev\salesianos\www\boletinsalesiano`

## Estructura

| Carpeta / archivo | Contenido |
| --- | --- |
| `README.md` | Este archivo: ficha técnica y cómo usar la carpeta |
| `BITACORA.md` | Registro fechado de todo lo que se cambia en el servidor |
| `PENDIENTES.md` | Lista de tareas abiertas, con su estado |
| `servidor/` | Copia de los archivos propios instalados en el servidor (mu-plugins, .htaccess, robots.txt…) |
| `scripts/` | Utilidades para traer copias del servidor al PC |
| `informes/` | Informes entregados a TVP (Word/PDF) |

La copia de `servidor/` es de referencia: el original manda siempre. Tras cada cambio en el servidor, se vuelve a traer con `scripts/traer-del-servidor.ps1` y se anota en `BITACORA.md`.

## Ficha técnica

- **Responsable:** TVP — P. Jesús Jurado, sdb (director)
- **Servidor:** VPS castelnuovo.net, host `chianti.castelnuovo.net`
- **Sistema:** AlmaLinux 8.10, cPanel/WHM, CloudLinux con CageFS, Apache
- **PHP:** ea-php84, memory_limit 384M, subida máxima 64 MB
- **Cuenta cPanel:** `b0let1n` — raíz `/home/b0let1n/public_html`
- **Base de datos:** `b0let1n_wpweb`, prefijo `wpyo_`
- **WordPress:** 7.1.5
- **Tema:** Newspaper 12.7.9 + tagDiv Composer + tagDiv Cloud Library
- **Plugins:** Akismet, AIOS, Jetpack (CDN de imágenes), LiteSpeed Cache (solo optimización), Site Kit, WP Super Cache (caché de páginas), Yoast Duplicate Post, Simple Local Avatars
- **Herramientas en el servidor:** jpegoptim, pngquant, ImageMagick, wp-cli, screen
- **Cuenta de Autor para pruebas:** `rodolfovelardeg`

## mu-plugins propios (`wp-content/mu-plugins/`)

| Archivo | Qué hace |
| --- | --- |
| `tamanos-imagen.php` | No genera tamaños innecesarios; limita el lado más largo a 1.920 px al subir; endereza por EXIF; sin `-scaled` |
| `comprimir-al-subir.php` | Pasa jpegoptim (82) o pngquant (40-85) por cada foto subida y sus miniaturas |
| `reglas-subida.php` | Para no administradores: sin PNG ni vídeo, tope 15 MB, peso final máximo 1 MB |
| `avisos-subida.php` | Mensajes claros en el navegador cuando se rechaza un PNG, un vídeo o un archivo de más de 15 MB |
| `imagenes-portada.php` | Prioridad de la foto principal y carga progresiva de miniaturas |
| `sincronizar-caches.php` | Mantiene coordinadas las cachés |
| `aios-firewall-loader.php` | Del plugin AIOS (no es nuestro) |

## Rutas útiles en el servidor

- Copias de archivos antes de cambiarlos: `/home/b0let1n/respaldos/`
- Restos apartados para borrar: `/home/b0let1n/borrar/`
- CSS crítico de LiteSpeed: `wp-content/litespeed/ccss/`
- Registros de visitas: `/etc/apache2/logs/domlogs/boletinsalesiano.pe-ssl_log` (cPanel los vacía periódicamente)

## Forma de trabajo

Comandos SSH en bloques cortos, diagnóstico de solo lectura antes de cambiar nada, copia previa de cada archivo y forma de deshacer indicada en cada paso.
