<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'VI_WOO_CART_ALL_IN_ONE_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woo-cart-all-in-one" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_INC', VI_WOO_CART_ALL_IN_ONE_DIR . "inc" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_LANGUAGES', VI_WOO_CART_ALL_IN_ONE_DIR . "languages" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_ADMIN', VI_WOO_CART_ALL_IN_ONE_INC . "admin" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_FRONTEND', VI_WOO_CART_ALL_IN_ONE_INC . "frontend" . DIRECTORY_SEPARATOR );

define( 'VI_WOO_CART_ALL_IN_ONE_URL', plugins_url() . '/woo-cart-all-in-one/assets/' );
define( 'VI_WOO_CART_ALL_IN_ONE_CSS', VI_WOO_CART_ALL_IN_ONE_URL . 'css/' );
define( 'VI_WOO_CART_ALL_IN_ONE_JS', VI_WOO_CART_ALL_IN_ONE_URL . 'js/' );
define( 'VI_WOO_CART_ALL_IN_ONE_IMAGES', VI_WOO_CART_ALL_IN_ONE_URL . "images/" );


if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "wcaio-function.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "wcaio-function.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "support.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "support.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "wcaio-data.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "wcaio-data.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "mini_cart_ajax.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "mini_cart_ajax.php";
}
vi_include_folder( VI_WOO_CART_ALL_IN_ONE_ADMIN, 'VI_WOO_CART_ALL_IN_ONE_Admin_' );
vi_include_folder( VI_WOO_CART_ALL_IN_ONE_FRONTEND, 'VI_WOO_CART_ALL_IN_ONE_Frontend_' );

