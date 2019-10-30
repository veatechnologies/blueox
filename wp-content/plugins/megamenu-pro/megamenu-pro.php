<?php

/*
 * Plugin Name: Max Mega Menu - Pro Addon
 * Plugin URI:  https://www.maxmegamenu.com
 * Description: Extends the core version of Max Mega Menu with additional functionality.
 * Version:     1.3.12
 * Author:      Tom Hemsley
 * Author URI:  https://www.maxmegamenu.com
 * Copyright:   2015 Tom Hemsley (https://www.maxmegamenu.com)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Pro') ) :

/**
 *
 */
class Mega_Menu_Pro {


	/**
	 * @var string
	 */
	public $version = '1.3.12';


	/**
	 * Init
	 *
	 * @since 1.0
	 */
	public static function init() {

		$plugin = new self();

	}


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		define( "MEGAMENU_PRO_VERSION", $this->version );
		define( "MEGAMENU_PRO_PLUGIN_FILE", __FILE__ );


		add_filter("megamenu_versions", array( $this, 'add_version_to_header' ) );

        // backwards compatibility with < MMM 1.8.2
		add_action("megamenu_enqueue_admin_scripts", array( $this, 'enqueue_nav_menu_scripts'), 10 );
        add_action("admin_enqueue_scripts", array( $this, 'enqueue_settings_scripts' ) );

        // Actions registered since MMM 1.8.3
        add_action("megamenu_admin_scripts", array( $this, 'enqueue_admin_scripts') );
        add_action("megamenu_nav_menus_scripts", array( $this, 'enqueue_nav_menu_scripts') );

		add_action("admin_notices", array( $this, 'check_megamenu_is_installed' ) );

        add_action("megamenu_enqueue_public_scripts", array( $this, 'enqueue_public_scripts' ) );

		$this->load();

	}


	/**
	 * Adds the version number to the header on the general settings page.
	 *
	 * @since 1.0
	 * @param array $versions
	 * @return array
	 */
	public function add_version_to_header( $versions ) {

		$versions['pro'] = array(
			'text' => __("Pro version", "megamenupro"),
			'version' => MEGAMENU_PRO_VERSION
		);

		return $versions;

	}


	/**
	 * Enqueue scripts
	 *
	 * @since 1.0
	 */
	public function enqueue_nav_menu_scripts() {

        if ( is_plugin_active( 'megamenu/megamenu.php' ) ) {
        	wp_enqueue_script( 'spectrum', MEGAMENU_BASE_URL . 'js/spectrum/spectrum.js', array( 'jquery' ), MEGAMENU_VERSION );
        	wp_enqueue_style( 'spectrum', MEGAMENU_BASE_URL . 'js/spectrum/spectrum.css', false, MEGAMENU_VERSION );

            wp_enqueue_style( 'codemirror', MEGAMENU_BASE_URL . 'js/codemirror/codemirror.css', false, MEGAMENU_VERSION );
	        wp_enqueue_script( 'codemirror', MEGAMENU_BASE_URL . 'js/codemirror/codemirror.js', array(), MEGAMENU_VERSION );
        }

        wp_enqueue_style( 'megamenu-genericons', plugins_url( 'icons/genericons/genericons/genericons.css' , __FILE__ ), false, MEGAMENU_PRO_VERSION );
        wp_enqueue_style( 'megamenu-fontawesome', plugins_url( 'icons/fontawesome/css/font-awesome.min.css' , __FILE__ ), false, MEGAMENU_PRO_VERSION );
        wp_enqueue_style( 'megamenu-pro-admin', plugins_url( 'assets/admin.css' , __FILE__ ), false, MEGAMENU_PRO_VERSION );

		wp_enqueue_media();

        wp_enqueue_script( 'megamenu-pro-admin', plugins_url( 'assets/admin.js' , __FILE__ ), array('jquery'), MEGAMENU_PRO_VERSION );

		$params = array(
			'file_frame_title' => __("Media Library", "megamenupro")
		);

		wp_localize_script( 'megamenu-pro-admin', 'megamenu_pro', $params );
	}


    /**
     * Enqueue required CSS and JS for Mega Menu
     *
     * @since 1.2.1
     * @todo This offers backwards compatibility with < MMM 1.8.2. To be removed in the future.
     */
    public function enqueue_settings_scripts( $hook ) {

        if( 'appearance_page_megamenu_settings' != $hook )
            return;

        $this->enqueue_admin_scripts( $hook );
    }


    /**
     * Enqueue required CSS and JS for Mega Menu
     *
     */
    public function enqueue_admin_scripts( $hook ) {

        wp_enqueue_style( 'megamenu-pro-admin', plugins_url( 'assets/admin.css' , __FILE__ ), false, MEGAMENU_PRO_VERSION );

    }


	/**
	 * Load the plugin classes
	 *
	 * @since 1.0
	 */
	public function load() {

		$path = plugin_dir_path( __FILE__ );

		$classes = array(
			'Mega_Menu_Updater' => $path . 'updater/updater.php',
			'Mega_Menu_Sticky' => $path . 'sticky/sticky.php',
			'Mega_Menu_Google_Fonts' => $path . 'fonts/google/google-fonts.php',
			'Mega_Menu_Custom_Fonts' => $path . 'fonts/custom/custom-fonts.php',
 			'Mega_Menu_Custom_Icon' => $path . 'icons/custom/custom.php',
			'Mega_Menu_Font_Awesome' => $path . 'icons/fontawesome/fontawesome.php',
			'Mega_Menu_Genericons' => $path . 'icons/genericons/genericons.php',
			'Mega_Menu_Style_Overrides' => $path . 'style-overrides/style-overrides.php',
			'Mega_Menu_Roles' => $path . 'roles/roles.php',
			'Mega_Menu_Vertical' => $path . 'vertical/vertical.php',
			'Mega_Menu_Effects' => $path . 'effects/effects.php',
			'Mega_Menu_Replacements' => $path . 'replacements/replacements.php'
		);

		foreach ( $classes as $classname => $path ) {
			require_once( $path );
			new $classname;
		}

	}

    /**
     * Ensure Max Mega Menu (free) is installed
     *
     * @since 1.3
     */
    public function check_megamenu_is_installed() {

    	if ( is_plugin_active('megamenu/megamenu.php') ) {
    		return;
    	}

		if ( is_plugin_inactive('megamenu/megamenu.php') ) :

            $plugin = plugin_basename('megamenu/megamenu.php');

            $string = __( 'Max Mega Menu Pro requires Max Mega Menu (free). Please {activate} the Max Mega Menu plugin.', 'megamenu' );

            $link = '<a href="' . wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s=' . $s, 'activate-plugin_' . $plugin ) . '" class="edit">' . __( 'activate', 'megamenu' ) . '</a>';

	    ?>

	    <div class="updated">
	        <p>
	        	<?php echo str_replace( "{activate}", $link, $string ); ?>
	        </p>
	    </div>

	    <?php

	   	else:

	    ?>
	    <div class="updated">
	        <p>
	        	<?php _e( 'Max Mega Menu Pro requires Max Mega Menu (free). Please install the Max Mega Menu plugin.', 'megamenu' ); ?>
	        </p>
	        <p class='submit'>
	        	<a href="<?php echo admin_url( "plugin-install.php?tab=search&type=term&s=max+mega+menu" ) ?>" class='button button-secondary'><?php _e("Install Max Mega Menu", "megamenupro"); ?></a>
	        </p>
	    </div>
	    <?php

	    endif;

    }

    /**
     * Enqueue scripts
     *
     * @since 1.3
     */
    public function enqueue_public_scripts() {

        wp_enqueue_script( 'megamenu-search', plugins_url( 'assets/public.js' , __FILE__ ), array('jquery'), MEGAMENU_PRO_VERSION );

    }

}

add_action( 'plugins_loaded', array( 'Mega_Menu_Pro', 'init' ), 11 );

endif;