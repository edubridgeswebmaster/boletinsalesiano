<?php
// Necesario para WP Super Cache. Está fuera de wp-config.php para que LiteSpeed Cache no lo borre.
if ( ! defined( 'WP_CACHE' ) ) {
    define( 'WP_CACHE', true );
}
