<?php
/* Boletín Salesiano: control de imágenes */

// 1. No generar tamaños innecesarios
add_filter('intermediate_image_sizes_advanced', function ($sizes) {
    foreach (['1536x1536', '2048x2048', 'medium_large', 'td_1920x0', 'jetpack-portfolio-admin-thumb'] as $s) {
        unset($sizes[$s]);
    }
    return $sizes;
});

// 2. Ancho máximo 1920 px al subir (altura proporcional); sin "-scaled" ni copia del original
add_filter('big_image_size_threshold', '__return_false');
add_filter('wp_handle_upload', function ($upload) {
    if (empty($upload['file']) || !in_array($upload['type'] ?? '', ['image/jpeg', 'image/png', 'image/webp'], true)) {
        return $upload;
    }
    $ed = wp_get_image_editor($upload['file']);
    if (is_wp_error($ed)) return $upload;
    $ed->maybe_exif_rotate();
    $s = $ed->get_size();
    if (max($s['width'], $s['height']) > 1920) {
        $ed->resize(1920, 1920, false);
        $ed->set_quality(82);
        $ed->save($upload['file']);
    }
    return $upload;
});
