<?php
/*
 * Compresión al subir (mu-plugin).
 * Tras generar las miniaturas, pasa jpegoptim (JPG) y pngquant (PNG) por el archivo principal y cada tamaño.
 * Requisitos: jpegoptim y pngquant accesibles para PHP y la función exec habilitada. Si falta algo, no hace nada.
 */
add_filter('wp_generate_attachment_metadata', function ($meta, $id) {
    if (empty($meta['file'])) return $meta;

    $desactivadas = array_map('trim', explode(',', (string) ini_get('disable_functions')));
    if (!function_exists('exec') || in_array('exec', $desactivadas, true)) return $meta;

    $jpegoptim = is_executable('/usr/bin/jpegoptim') ? '/usr/bin/jpegoptim' : '';
    $pngquant  = is_executable('/usr/bin/pngquant')  ? '/usr/bin/pngquant'  : '';
    if (!$jpegoptim && !$pngquant) return $meta;

    $dir = wp_get_upload_dir()['basedir'] . '/' . dirname($meta['file']);
    $archivos = [basename($meta['file'])];
    foreach (($meta['sizes'] ?? []) as $s) {
        if (!empty($s['file'])) $archivos[] = $s['file'];
    }

    foreach (array_unique($archivos) as $f) {
        $ruta = $dir . '/' . $f;
        if (!is_file($ruta)) continue;
        $ext = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg'], true) && $jpegoptim) {
            $exif  = function_exists('exif_read_data') ? @exif_read_data($ruta) : false;
            $strip = (is_array($exif) && !empty($exif['Orientation']) && (int) $exif['Orientation'] > 1)
                ? '--strip-com --strip-iptc --strip-xmp' : '--strip-all';
            exec($jpegoptim . ' --max=82 ' . $strip . ' --all-progressive --quiet ' . escapeshellarg($ruta) . ' 2>&1');
        } elseif ($ext === 'png' && $pngquant) {
            exec($pngquant . ' --quality=40-85 --skip-if-larger --force --ext .png --strip ' . escapeshellarg($ruta) . ' 2>&1');
        }
    }

    $principal = $dir . '/' . basename($meta['file']);
    clearstatcache(true, $principal);
    if (is_file($principal)) $meta['filesize'] = filesize($principal);
    return $meta;
}, 20, 2);
