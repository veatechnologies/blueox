<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Updater') ) :

/**
 *
 */
class Mega_Menu_Updater {


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		define( 'EDD_MMM_STORE_URL', 'http://www.maxmegamenu.com' );
		define( 'EDD_MMM_ITEM_NAME', 'Max Mega Menu Pro' );

        add_filter( 'megamenu_menu_tabs', array( $this, 'add_license_tab' ), 999 );
        add_action( 'megamenu_page_license', array( $this, 'license_page' ) );

        add_action( 'admin_post_megamenu_update_license', array( $this, 'update_license') );

		add_action( 'admin_init', array( $this, 'edd_mmm_plugin_updater'), 0 );


	}

	/**
	 * Check for new updates
	 */
	public function edd_mmm_plugin_updater() {

		if ( ! class_exists( 'EDD_MMM_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/EDD_MMM_Plugin_Updater.php' );
		}

		// retrieve our license key from the DB
		$license_key = trim( get_option( 'edd_mmm_license_key' ) );

		// setup the updater
		$edd_updater = new EDD_MMM_Plugin_Updater( EDD_MMM_STORE_URL, MEGAMENU_PRO_PLUGIN_FILE, array(
				'version' 	=> MEGAMENU_PRO_VERSION,  // current version number
				'license' 	=> $license_key, // license key (used get_option above to retrieve from DB)
				'item_name' => EDD_MMM_ITEM_NAME, // name of this plugin
				'author' 	=> 'Tom Hemsley'  // author of this plugin
			)
		);

	}


    /**
     * Process license changes
     *
     * @since 1.0
     */
    public function update_license() {

        check_admin_referer( 'megamenu_update_license' );

        if (isset($_POST['edd_mmm_license_key'])) {
        	update_option('edd_mmm_license_key', sanitize_text_field($_POST['edd_mmm_license_key']));
        }

        if( isset( $_POST['edd_mmm_license_activate'] ) ) {
			$this->edd_mmm_activate_license();
		}

		if( isset( $_POST['edd_mmm_license_deactivate'] ) ) {
			$this->edd_mmm_deactivate_license();
		}

    }


	/**
	 * Activate a license
	 */
	public function edd_mmm_activate_license() {

		// retrieve the license from the database
		$license = trim( get_option( 'edd_mmm_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EDD_MMM_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, EDD_MMM_STORE_URL ), array( 'timeout' => 5, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
        	wp_redirect( admin_url( "admin.php?page=maxmegamenu&tab=license&activated=error" ) );
        	exit;
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"
		update_option( 'edd_mmm_license_status', $license_data->license );

        wp_redirect( admin_url( "admin.php?page=maxmegamenu&tab=license&activated={$license_data->license}" ) );
        exit;
	}


	/**
	 * Deactivate the license
	 */
	public function edd_mmm_deactivate_license() {

		// retrieve the license from the database
		$license = trim( get_option( 'edd_mmm_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EDD_MMM_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, EDD_MMM_STORE_URL ), array( 'timeout' => 5, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
	        wp_redirect( admin_url( "admin.php?page=maxmegamenu&tab=license&deactivated=error" ) );
	        exit;
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'edd_mmm_license_status' );
		}

        wp_redirect( admin_url( "admin.php?page=maxmegamenu&tab=license&deactivated={$license_data->license}" ) );
        exit;

	}


	/**
	 * Add the License tab to our available tabs
	 *
	 * @param array $tabs
	 * @since 1.0
	 */
	public function add_license_tab($tabs) {

		$tabs['license'] = __("License", "megamenupro");

		return $tabs;

	}


	/**
	 * Show the license page
	 *
	 * @param array $saved_settings
	 * @since 1.0
	 */
	public function license_page( $saved_settings ) {

		$license = get_option( 'edd_mmm_license_key' );
		$status = get_option( 'edd_mmm_license_status' );

		?>

		<div class='menu_settings'>

            <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
                <input type="hidden" name="action" value="megamenu_update_license" />
                <?php wp_nonce_field( 'megamenu_update_license' ); ?>

				<h4 class='first'><?php _e('Max Mega Menu Pro License', "megamenupro"); ?></h4>

				<table>
					<tbody>
						<tr>
							<td class='mega-name'>
								<?php _e('License Key'); ?>
								<div class='mega-description'>
									<?php _e('A license key must be entered and activated to enable automatic plugin updates', "megamenupro"); ?>
								</div>
							</td>
							<td class='mega-value'>

								<?php $disabled = ( $status !== false && $status == 'valid' ) ? "disabled=disabled" : ""; ?>

								<input <?php echo $disabled ?> style='width: 25em;' name="edd_mmm_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />

								<?php if( $status !== false && $status == 'valid' ) { ?>
									<input type="submit" class="button-secondary" name="edd_mmm_license_deactivate" value="<?php _e('Deactivate License', "megamenupro"); ?>"/>
								<?php } else { ?>
									<input style='width: auto;' type="submit" class="button-secondary" name="edd_mmm_license_activate" value="<?php _e('Activate License', "megamenupro"); ?>"/>
								<?php } ?>
								</td>
							</tr>
					</tbody>
				</table>

			</form>
		</div>
		<?php
	}
}

endif;