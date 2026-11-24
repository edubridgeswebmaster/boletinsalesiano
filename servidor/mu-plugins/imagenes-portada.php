<?php
/* Boletín Salesiano: precarga LCP + carga diferida de miniaturas y de fondos del pie (Newspaper) */
add_action('template_redirect', function () {
    if (is_admin() || wp_doing_ajax() || is_feed() || (defined('REST_REQUEST') && REST_REQUEST)) return;
    ob_start('bs_optimizar_imagenes_fondo');
}, 999);

function bs_insertar_antes_de_body($html, $codigo) {
    $p = strripos($html, '</body>');
    return $p === false ? $html : substr_replace($html, $codigo, $p, 0);
}

function bs_optimizar_imagenes_fondo($html) {
    if (stripos($html, '</head>') === false) return $html;

    // 1. Miniaturas: las 6 primeras inmediatas, el resto al acercarse
    $n = 0; $primera = '';
    $html = preg_replace_callback(
        '~(<span class="entry-thumb td-thumb-css[^"]*") style="background-image: url\(\'([^\']+)\'\)"~',
        function ($m) use (&$n, &$primera) {
            $n++;
            if ($n === 1) $primera = $m[2];
            if ($n <= 6) return $m[0];
            return $m[1] . ' data-bs-bg="' . esc_attr($m[2]) . '"';
        }, $html);

    // 2. Fondos de filas de tagDiv en la parte baja de la página (pie): al acercarse
    $total = strlen($html); $copia = $html; $fondos = [];
    $html = preg_replace_callback(
        '~(\.tdi_(\d+)_rand_style\s*>\s*\.td-element-style-before\s*\{[^}]*?background-image\s*:\s*)url\(\s*["\']?([^"\')]+)["\']?\s*\)~',
        function ($m) use (&$fondos, $copia, $total) {
            $pos = strpos($copia, 'id="tdi_' . $m[2] . '"');
            if ($pos === false || $pos / $total < 0.6) return $m[0];
            $fondos[$m[2]] = $m[3];
            return $m[1] . 'var(--bs-bg-' . $m[2] . ',none)';
        }, $html);

    // 3. Precarga de la imagen principal
    $head = '<link rel="preconnect" href="https://i0.wp.com">';
    if ($primera) $head .= '<link rel="preload" as="image" href="' . esc_url($primera) . '" fetchpriority="high">';
    $html = preg_replace('~(<meta charset=[^>]*>)~i', '$1' . $head, $html, 1);

    // 4. Scripts, excluidos del diferido de LiteSpeed
    $js = '';
    if ($n > 6) {
        $js .= "<script data-no-optimize=\"1\" data-no-defer=\"1\">(function(){var s=document.querySelectorAll('[data-bs-bg]');"
            . "function f(e){e.style.backgroundImage=\"url('\"+e.getAttribute('data-bs-bg')+\"')\";e.removeAttribute('data-bs-bg');}"
            . "if(!('IntersectionObserver' in window)){s.forEach(f);return;}"
            . "var o=new IntersectionObserver(function(es){es.forEach(function(x){if(x.isIntersecting){f(x.target);o.unobserve(x.target);}});},{rootMargin:'300px'});"
            . "s.forEach(function(e){o.observe(e);});})();</script>";
    }
    if ($fondos) {
        $js .= '<script data-no-optimize="1" data-no-defer="1">(function(){var f=' . wp_json_encode($fondos, JSON_UNESCAPED_SLASHES) . ';'
            . 'function p(k){document.documentElement.style.setProperty("--bs-bg-"+k,"url(\""+f[k]+"\")");}'
            . 'if(!("IntersectionObserver" in window)){for(var k in f)p(k);return;}'
            . 'var o=new IntersectionObserver(function(es){es.forEach(function(x){if(x.isIntersecting){p(x.target.id.replace("tdi_",""));o.unobserve(x.target);}});},{rootMargin:"600px"});'
            . 'for(var k in f){var e=document.getElementById("tdi_"+k);if(e){o.observe(e);}else{p(k);}}})();</script>';
    }
    if ($js) $html = bs_insertar_antes_de_body($html, $js);
    return $html;
}
