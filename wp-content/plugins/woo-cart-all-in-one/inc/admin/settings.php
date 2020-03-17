<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Settings {
	protected $settings;
	protected $prefix;

	public function __construct() {
		$this->prefix = 'wcaio_woo_art_all_in_one-';
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_filter(
			'plugin_action_links_woo-cart-all-in-one/woo-cart-all-in-one.php', array(
				$this,
				'settings_link'
			)
		);


		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_script' ) );

		add_action( 'admin_init', array( $this, 'save_data' ), 99 );
	}

	public function add_admin_menu() {
		add_menu_page(
			'Cart All In One For Woocommerce',
			'Cart All In One',
			'manage_options',
			'woo-cart-all-in-one', array( $this, 'add_admin_menu_callback' ),
			'dashicons-cart'
		);
	}

	public function add_admin_menu_callback() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		?>
        <div class="wrap">
            <h2><?php echo esc_html__( 'Cart All In One For Woocommerce', 'woo-cart-all-in-one' ); ?></h2>
            <div class="vi-ui raised">
                <form class="vi-ui form" method="post" action="">
					<?php
					wp_nonce_field( 'woo_cart_all_in_one_action_nonce', '_woo_cart_all_in_one_nonce' );
					settings_fields( 'woo_cart_all_in_one' );
					do_settings_sections( 'woo_cart_all_in_one' );
					?>
                    <div class="vi-ui vi-ui-main top attached tabular menu">
                        <a class="item active"
                           data-tab="sidebar_cart"><?php esc_html_e( 'Sidebar Cart', 'woo-cart-all-in-one' ) ?></a>
                        <a class="item "
                           data-tab="menu_cart"><?php esc_html_e( 'Menu Cart', 'woo-cart-all-in-one' ) ?></a>
                        <a class="item "
                           data-tab="add_to_cart_button"><?php esc_html_e( 'Add To Cart Button', 'woo-cart-all-in-one' ) ?></a>
						<?php
						$url = admin_url( 'customize.php' ) . '?url=' . urlencode( get_site_url() ) . '&autofocus[panel]=woo_cart_all_in_one_design_general';
						?>
                        <a class="item " data-href="<?php echo $url; ?>"
                           data-tab="customize"><?php esc_html_e( 'Customize', 'woo-cart-all-in-one' ) ?></a>


                    </div>

                    <div class="vi-ui bottom attached tab segment active" data-tab="sidebar_cart">
                        <table class="form-table">
                            <tbody>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="sidebar_cart_enable"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="sidebar_cart_enable" id="sidebar_cart_enable"
                                               value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'sidebar_cart_enable' ), 1 ); ?>
                                        />
                                        <p class="description"><?php esc_html_e( 'Display sidebar cart in your site.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="sidebar_cart_enable_empty"><?php esc_html_e( 'Visible empty sidebar cart icon', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="sidebar_cart_enable_empty"
                                               id="sidebar_cart_enable_empty"
                                               value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'sidebar_cart_enable_empty' ), 1 ); ?>
                                        />
                                        <p class="description"><?php esc_html_e( 'Display the sidebar cart icon when the cart is empty.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th>
                                    <label for="sidebar_cart_enable_device"><?php esc_html_e( 'Devices', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <select name="sidebar_cart_enable_device" id="sidebar_cart_enable_device"
                                            class="vi-ui fluid dropdown ">
                                        <option value="desktop" <?php selected( $this->settings->get_params( 'sidebar_cart_enable_device' ), 'desktop' ) ?>><?php esc_html_e( 'Only desktop', 'woo-cart-all-in-one' ) ?></option>
                                        <option value="mobile" <?php selected( $this->settings->get_params( 'sidebar_cart_enable_device' ), 'mobile' ) ?>><?php esc_html_e( 'Only mobile', 'woo-cart-all-in-one' ) ?></option>
                                        <option value="all" <?php selected( $this->settings->get_params( 'sidebar_cart_enable_device' ), 'all' ) ?>><?php esc_html_e( 'All devices', 'woo-cart-all-in-one' ) ?></option>
                                    </select>
                                    <p class="description"><?php esc_html_e( 'Select devices to display sidebar cart.', 'woo-cart-all-in-one' ) ?></p>
                                </td>
                            </tr>

                            <tr valign="top"
                            ">
                            <th>
                                <label for="sidebar_cart_enable_pages"><?php esc_html_e( 'Pages', 'woo-cart-all-in-one' ) ?></label>
                            </th>

                            <td>
                                <select name="sidebar_cart_enable_pages[]" id="sidebar_cart_enable_pages"
                                        class="vi-ui fluid dropdown" multiple="">
									<?php
									$enable_page = $this->settings->get_params( 'sidebar_cart_enable_pages' );
									$list_page   = array(
										'shop'       => __( 'Shop page', 'woo-cart-all-in-one' ),
										'category'   => __( 'Product category page', 'woo-cart-all-in-one' ),
										'product'    => __( 'Single product page', 'woo-cart-all-in-one' ),
										'my_account' => __( 'My account page', 'woo-cart-all-in-one' ),
										'all'        => __( 'All pages', 'woo-cart-all-in-one' ),
									);
									foreach ( $list_page as $page => $page_name ) {
										$selected = '';
										if ( in_array( $page, $enable_page ) ) {
											$selected = 'selected="selected"';
										}
										?>
                                        <option <?php echo $selected; ?>
                                                value="<?php echo esc_attr( $page ) ?>"><?php echo esc_html( $page_name ) ?></option>
										<?php
									}
									?>
                                </select>
                                <p class="description"><?php esc_html_e( 'Select pages to display the sidebar cart.', 'woo-cart-all-in-one' ) ?></p>
                            </td>
                            </tr>
                            </tbody>

                        </table>

                    </div>

                    <div class="vi-ui bottom attached tab segment" data-tab="menu_cart">
                        <table class="form-table">
                            <tbody>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="menu_cart_enable"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="menu_cart_enable" id="menu_cart_enable"
                                               value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'menu_cart_enable' ), 1 ); ?>
                                        />
                                        <p class="description"><?php esc_html_e( 'Display menu cart in your site.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="menu_cart_enable_empty"><?php esc_html_e( 'Visible empty menu cart', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="menu_cart_enable_empty" id="menu_cart_enable_empty"
                                               value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'menu_cart_enable_empty' ), 1 ); ?>
                                        />
                                        <p class="description"><?php esc_html_e( 'Display the menu cart when the cart is empty.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="mini_cart_enable_device"><?php esc_html_e( 'Devices', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <select name="menu_cart_enable_device" id="menu_cart_enable_device"
                                            class="vi-ui fluid dropdown ">
                                        <option value="desktop" <?php selected( $this->settings->get_params( 'menu_cart_enable_device' ), 'desktop' ) ?>><?php esc_html_e( 'Only desktop', 'woo-cart-all-in-one' ) ?></option>
                                        <option value="mobile" <?php selected( $this->settings->get_params( 'menu_cart_enable_device' ), 'mobile' ) ?>><?php esc_html_e( 'Only mobile', 'woo-cart-all-in-one' ) ?></option>
                                        <option value="all" <?php selected( $this->settings->get_params( 'menu_cart_enable_device' ), 'all' ) ?>><?php esc_html_e( 'All devices', 'woo-cart-all-in-one' ) ?></option>
                                    </select>
                                    <p class="description"><?php esc_html_e( 'Select devices to display menu cart.', 'woo-cart-all-in-one' ) ?></p>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="menu_cart_enable_menu_type"><?php esc_html_e( 'Menus', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <select name="menu_cart_enable_menu_type[]" id="menu_cart_enable_menu_type"
                                            class="vi-ui fluid dropdown" multiple="">
										<?php
										$list_menu   = wp_get_nav_menus();
										$enable_menu = $this->settings->get_params( 'menu_cart_enable_menu_type' );
										foreach ( $list_menu as $k ) {
											$selected = '';
											if ( in_array( $k->term_id, $enable_menu ) ) {
												$selected = 'selected="selected"';
											}
											?>
                                            <option <?php echo $selected; ?>
                                                    value="<?php echo esc_attr( $k->term_id ) ?>"><?php echo esc_html( $k->name ) ?></option>
											<?php
										}
										?>
                                    </select>
                                    <p class="description"><?php esc_html_e( 'Select menus to display the menu cart.', 'woo-cart-all-in-one' ) ?></p>
                                </td>
                            </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="vi-ui bottom attached tab segment " data-tab="add_to_cart_button">
                        <table class="form-table">
                            <tbody>
                            <h3>AJAX Add to Cart</h3>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="ajax_add_to_cart_single_page"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="ajax_add_to_cart_single_page"
                                               id="ajax_add_to_cart_single_page" value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'ajax_add_to_cart_single_page' ), 1 ); ?>
                                        />
                                        <p class="description"><?php esc_html_e( 'Add product to cart without reloading on single product pages and Quick View popup.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="form-table">
                            <tbody>
                            <h3>Add to Cart for variable products</h3>
                            <tr valign="top">
                                <th scope="row" rowspan="">
                                    <label for="show_variation_enable"><?php esc_html_e( 'Select variation pop-up', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="show_variation_enable" id="show_variation_enable"
                                               value="1"
                                               tabindex="0"
											<?php
											checked( $this->settings->get_params( 'show_variation_enable' ), 1 );
											?>
                                        />
                                        <p class="description"><?php esc_html_e( 'After click add to cart button, a pop-up will appear allowing select variations and add to cart without redirect to the single product page.', 'woo-cart-all-in-one' ) ?></p>

                                    </div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row" rowspan="">
                                    <label for="set_text_select_option_button_enable"><?php esc_html_e( ' Add to Cart button label', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui toggle checkbox checked">
                                        <input type="checkbox" name="set_text_select_option_button_enable"
                                               id="set_text_select_option_button_enable" value="1"
                                               tabindex="0" <?php checked( $this->settings->get_params( 'set_text_select_option_button_enable' ), 1 ); ?> />
                                        <p class="description"><?php esc_html_e( 'Change the label of the add to cart button with variable products.', 'woo-cart-all-in-one' ) ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr valign="top" class="vi_wcaion_set_text_select_option_button">
                                <th scope="row" rowspan="">
                                    <label for="set_text_select_option_button"><?php esc_html_e( 'Add to Cart button label', 'woo-cart-all-in-one' ) ?></label>
                                </th>
                                <td>
                                    <input type="text" name="set_text_select_option_button"
                                           id="set_text_select_option_button"
                                           value="<?php echo $this->settings->get_params( 'set_text_select_option_button' ) ?>"
                                           placeholder="<?php esc_html_e( 'Select option', 'woo-cart-all-in-one' ) ?>"/>
                                    <p class="description"><?php esc_html_e( 'Enter you own label for the add to cart button of variable products.', 'woo-cart-all-in-one' ) ?></p>


                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                    <p>
                        <input type="submit" name="wcaio_save_data" value="Save" class="vi-ui primary button"/>
                    </p>
                </form>
            </div>
        </div>
		<?php
		do_action( 'villatheme_support_woo-cart-all-in-one' );
	}

	public function save_data() {
		global $wcaio_settings;
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! isset( $_POST['_woo_cart_all_in_one_nonce'] ) || ! wp_verify_nonce( $_POST['_woo_cart_all_in_one_nonce'], 'woo_cart_all_in_one_action_nonce' ) ) {
			return;
		}
		$args = array();

		//ajax add to cart
		$args['ajax_add_to_cart_single_page'] = isset( $_POST['ajax_add_to_cart_single_page'] ) ? sanitize_text_field( $_POST['ajax_add_to_cart_single_page'] ) : '';

		//sidebar cart
		$args['sidebar_cart_enable']        = isset( $_POST['sidebar_cart_enable'] ) ? sanitize_text_field( $_POST['sidebar_cart_enable'] ) : '';
		$args['sidebar_cart_enable_empty']  = isset( $_POST['sidebar_cart_enable_empty'] ) ? sanitize_text_field( $_POST['sidebar_cart_enable_empty'] ) : '';
		$args['sidebar_cart_enable_device'] = isset( $_POST['sidebar_cart_enable_device'] ) ? sanitize_text_field( $_POST['sidebar_cart_enable_device'] ) : '';
		$args['sidebar_cart_enable_pages']  = isset( $_POST['sidebar_cart_enable_pages'] ) ? array_map('sanitize_text_field', $_POST['sidebar_cart_enable_pages'] ) : array();

		//menu cart
		$args['menu_cart_enable']           = isset( $_POST['menu_cart_enable'] ) ? sanitize_text_field( $_POST['menu_cart_enable'] ) : '';
		$args['menu_cart_enable_empty']     = isset( $_POST['menu_cart_enable_empty'] ) ? sanitize_text_field( $_POST['menu_cart_enable_empty'] ) : '';
		$args['menu_cart_enable_device']    = isset( $_POST['menu_cart_enable_device'] ) ? sanitize_text_field( $_POST['menu_cart_enable_device'] ) : '';
		$args['menu_cart_enable_menu_type'] = isset( $_POST['menu_cart_enable_menu_type'] ) ?  array_map('sanitize_text_field',$_POST['menu_cart_enable_menu_type'] ) : array();


		//variation product
		$args['show_variation_enable']                = isset( $_POST['show_variation_enable'] ) ? sanitize_text_field( $_POST['show_variation_enable'] ) : '';
		$args['set_text_select_option_button_enable'] = isset( $_POST['set_text_select_option_button_enable'] ) ? sanitize_text_field( $_POST['set_text_select_option_button_enable'] ) : '';
		$args['set_text_select_option_button']        = isset( $_POST['set_text_select_option_button'] ) ? sanitize_text_field( $_POST['set_text_select_option_button'] ) : '';
		$args                                         = wp_parse_args( $args, get_option( 'woo_cart_all_in_one_params', $wcaio_settings ) );
		update_option( 'woo_cart_all_in_one_params', $args );
		$wcaio_settings = $args;

	}

	public function settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'admin.php' ) . '?page=woo-cart-all-in-one" title="' . __( 'Settings', 'woo-cart-all-in-one' ) . '">' . __( 'Settings', 'woo-cart-all-in-one' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	public function admin_enqueue_script() {
		if ( isset( $_REQUEST['page'] ) && wp_unslash( sanitize_text_field($_REQUEST['page']) ) == 'woo-cart-all-in-one' ) {

			wp_enqueue_style( 'wcaio_admin_form', VI_WOO_CART_ALL_IN_ONE_CSS . 'form.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_checkbox', VI_WOO_CART_ALL_IN_ONE_CSS . 'checkbox.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_button', VI_WOO_CART_ALL_IN_ONE_CSS . 'button.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_dropdown', VI_WOO_CART_ALL_IN_ONE_CSS . 'dropdown.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_icon', VI_WOO_CART_ALL_IN_ONE_CSS . 'icon.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_tab', VI_WOO_CART_ALL_IN_ONE_CSS . 'tab.css' );
			wp_enqueue_style( 'wcaio_admin_transition', VI_WOO_CART_ALL_IN_ONE_CSS . 'transition.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_menu', VI_WOO_CART_ALL_IN_ONE_CSS . 'menu.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_segment', VI_WOO_CART_ALL_IN_ONE_CSS . 'segment.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_select2', VI_WOO_CART_ALL_IN_ONE_CSS . 'select2.min.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'wcaio_admin_style', VI_WOO_CART_ALL_IN_ONE_CSS . 'admin-style.css', '', VI_WOO_CART_ALL_IN_ONE_VERSION );

			wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch'
			), false, 1 );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'wcaio_admin_form', VI_WOO_CART_ALL_IN_ONE_JS . 'form.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_checkbox', VI_WOO_CART_ALL_IN_ONE_JS . 'checkbox.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_dropdown', VI_WOO_CART_ALL_IN_ONE_JS . 'dropdown.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_tab', VI_WOO_CART_ALL_IN_ONE_JS . 'tab.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_transition', VI_WOO_CART_ALL_IN_ONE_JS . 'transition.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_select2', VI_WOO_CART_ALL_IN_ONE_JS . 'select2.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_address', VI_WOO_CART_ALL_IN_ONE_JS . 'jquery.address-1.6.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'wcaio_admin_script', VI_WOO_CART_ALL_IN_ONE_JS . 'admin-script.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}

	}
}