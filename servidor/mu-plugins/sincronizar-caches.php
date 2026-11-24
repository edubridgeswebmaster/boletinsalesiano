<?php
/* Boletín Salesiano: cuando LiteSpeed purga todo, vaciar también WP Super Cache */
add_action('litespeed_purged_all', function () {
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }
});
