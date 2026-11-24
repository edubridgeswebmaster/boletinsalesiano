<?php
/* Boletín Salesiano: reglas de subida para usuarios que no son administradores */

function bs_es_admin() {
    return current_user_can('manage_options');
}

// 1. Sin PNG ni vídeos para no administradores
add_filter('upload_mimes', function ($mimes) {
    if (bs_es_admin()) return $mimes;
    foreach ($mimes as $ext => $type) {
        if ($type === 'image/png' || strpos($type, 'video/') === 0) unset($mimes[$ext]);
    }
    return $mimes;
});

// 2. Tope de 15 MB antes de procesar (las fotos grandes se reducen solas después)
$bs_tope = function ($file) {
    if (bs_es_admin() || empty($file['size'])) return $file;
    if ($file['size'] > 15 * MB_IN_BYTES) {
        $file['error'] = 'El archivo pesa más de 15 MB. Redúcelo antes de subirlo.';
    }
    return $file;
};
add_filter('wp_handle_upload_prefilter', $bs_tope);
add_filter('wp_handle_sideload_prefilter', $bs_tope);

// 3. Máximo 1 MB después de la reducción automática a 1920 px
add_filter('wp_handle_upload', function ($upload) {
    if (bs_es_admin() || empty($upload['file']) || !empty($upload['error'])) return $upload;
    $type = $upload['type'] ?? '';
    if (strpos($type, 'image/') !== 0) return $upload;

    $limite = MB_IN_BYTES;
    clearstatcache(true, $upload['file']);
    if (filesize($upload['file']) <= $limite) return $upload;

    // Intentar recomprimir JPG/WebP antes de rechazar
    if (in_array($type, ['image/jpeg', 'image/webp'], true)) {
        foreach ([72, 62] as $q) {
            $ed = wp_get_image_editor($upload['file']);
            if (is_wp_error($ed)) break;
            $ed->set_quality($q);
            $ed->save($upload['file']);
            clearstatcache(true, $upload['file']);
            if (filesize($upload['file']) <= $limite) return $upload;
        }
    }

    $mb = round(filesize($upload['file']) / MB_IN_BYTES, 1);
    @unlink($upload['file']);
    return ['error' => "La imagen pesa {$mb} MB incluso después de optimizarla (máximo 1 MB). Guárdala como JPG con menor calidad o menor tamaño y vuelve a subirla."];
}, 20);
