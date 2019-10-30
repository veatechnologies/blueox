<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Replacements') ) :

/**
 *
 */
class Mega_Menu_Replacements {

	/**
	 * Constructor
	 *
	 * @since 1.3
	 */
	public function __construct() {

		add_filter( 'megamenu_tabs', array( $this, 'add_replacements_tab'), 10, 5 );
		add_filter( 'megamenu_walker_nav_menu_start_el', array( $this, 'process_replacements'), 10, 4 );
		add_filter( 'megamenu_scss_variables', array( $this, 'add_vars_to_scss'), 10, 4 );
		add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_scss'), 10 );

		add_shortcode( 'maxmegamenu_woo_cart_count', array($this, 'shortcode_woo_cart_count') );
		add_shortcode( 'maxmegamenu_woo_cart_total', array($this, 'shortcode_woo_cart_total') );

		add_shortcode( 'maxmegamenu_edd_cart_count', array($this, 'shortcode_edd_cart_count') );
		add_shortcode( 'maxmegamenu_edd_cart_total', array($this, 'shortcode_edd_cart_total') );

		add_filter( 'woocommerce_add_to_cart_fragments', array($this, 'woocommerce_header_add_to_cart_fragment' ) );

	}

	/**
	 * Update cart total/count via AJAX
	 *
	 * @since 1.3.3
	 */
	public function woocommerce_header_add_to_cart_fragment( $fragments ) {

		$fragments['span.mega-menu-woo-cart-total'] = "<span class='mega-menu-woo-cart-total'>" . strip_tags( WC()->cart->get_cart_total() ) . "</span>";
		$fragments['span.mega-menu-woo-cart-count'] = "<span class='mega-menu-woo-cart-count'>" . WC()->cart->cart_contents_count . "</span>";

		return $fragments;
	}


	/**
	 * Append the logo SCSS to the main SCSS file
	 *
	 * @since 1.3
	 * @param string $scss
	 * @param string
	 */
	public function append_scss( $scss ) {

		$path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'scss/replacements.scss';

		$contents = file_get_contents( $path );

 		return $scss . $contents;

	}


	/**
	 * Create a new variable containing the IDs and icons of menu items to be used by the SCSS file
	 *
	 * @param array $vars
	 * @param string $location
	 * @param string $theme
	 * @param int $menu_id
	 * @return array - all custom SCSS vars
	 * @since 1.3
	 */
	public function add_vars_to_scss( $vars, $location, $theme, $menu_id ) {

		$menu_items = wp_get_nav_menu_items( $menu_id );

		$custom_vars = array();

		if ( is_array( $menu_items ) ) {

			foreach ( $menu_items as $menu_order => $item ) {

				if ( $settings = get_post_meta( $item->ID, "_megamenu", true ) ) {

					if ( isset( $settings['replacements']['type'] ) && in_array($settings['replacements']['type'], array('search')) ) {

						$styles = array(
							'id' => $item->ID,
							'search_height' => isset($settings['replacements']['search']['height']) ? $settings['replacements']['search']['height'] : '30px',
							'search_text_color' => isset($settings['replacements']['search']['text_color']) ? $settings['replacements']['search']['text_color'] : '#333',
							'search_icon_color_closed' => isset($settings['replacements']['search']['icon_color_closed']) ? $settings['replacements']['search']['icon_color_closed'] : '#fff',
							'search_icon_color_open' => isset($settings['replacements']['search']['icon_color_open']) ? $settings['replacements']['search']['icon_color_open'] : '#333',
							'search_background_color_closed' => isset($settings['replacements']['search']['background_color_closed']) ? $settings['replacements']['search']['background_color_closed'] : 'transparent',
							'search_background_color_open' => isset($settings['replacements']['search']['background_color_open']) ? $settings['replacements']['search']['background_color_open'] : '#fff',
							'search_border_radius' => isset($settings['replacements']['search']['border_radius']) ? $settings['replacements']['search']['border_radius'] : '2px'
						);

						$custom_vars[ $item->ID ] = $styles;

					}

				}

			}

		}

		//$custom_styles:(
		// (123, red, 150px),
	    // (456, green, null),
		// (789, blue, 90%),());

		if ( count( $custom_vars ) ) {

			$list = "(";

			foreach ( $custom_vars as $id => $vals ) {
				$list .= "(" . implode( ",", $vals ) . "),";
			}

			// Always add an empty list item to meke sure there are always at least 2 items in the list
			// Lists with a single item are not treated the same way by SASS
			$list .= "());";

			$vars['replacements_search'] = $list;

		} else {

			$vars['replacements_search'] = "()";

		}

		return $vars;

	}


	/**
	 * Replace a menu item with the selected type
	 *
	 * @param string $item_output
	 * @param object $item
	 * @param int $depth
	 * @param array $args
	 * @return string
	 */
	public function process_replacements( $item_output, $item, $depth, $args ) {

		if ( isset( $item->megamenu_settings['replacements'] ) && $item->megamenu_settings['replacements']['type'] != 'disabled' ) {

			$type = $item->megamenu_settings['replacements']['type'];

			if ( $type == 'html' ) {
				return $this->do_html_replacement( $item, $item_output );
			}

			if ( $type == 'search' ) {
				return $this->do_search_replacement( $item, $item_output );
			}

			if ( $type == 'logo' ) {
				return $this->do_logo_replacement( $item, $item_output );
			}

			if ( $type == 'woo_cart_count' ) {
				return $this->do_woo_cart_count_replacement( $item, $item_output );
			}

			if ( $type == 'woo_cart_total' ) {
				return $this->do_woo_cart_total_replacement( $item, $item_output );
			}

			if ( $type == 'edd_cart_count' ) {
				return $this->do_edd_cart_count_replacement( $item, $item_output );
			}

			if ( $type == 'edd_cart_total' ) {
				return $this->do_edd_cart_total_replacement( $item, $item_output );
			}

		}

		return $item_output;

	}

	/**
	 * Return woocommerce cart total (e.g. $5.99)
	 *
	 * @since 1.3.3
	 * @return string
	 */
	public function shortcode_edd_cart_total() {

		if ( function_exists('edd_cart_total') ) {
			return "<span class='mega-menu-edd-cart-total'>" . edd_cart_total(false) . "</span>";
		}

	}


	/**
	 * Return woocommerce number of items in cart (e.g 1)
	 *
	 * @since 1.3.3
	 * @return string
	 */
	public function shortcode_edd_cart_count() {

		if ( function_exists('edd_get_cart_quantity') ) {
			return "<span class='mega-menu-edd-cart-count'>" . edd_get_cart_quantity() . "</span>";
		}

	}

	/**
	 * Replace a menu item with an EDD cart total
	 *
	 * @since 1.3.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_edd_cart_total_replacement( $item, $item_output ) {

		if ( function_exists('edd_cart_total') ) {
			$replacement = do_shortcode('[maxmegamenu_edd_cart_total]');

			return str_replace( strip_tags( $item_output ), $replacement, $item_output );
		}

		return $item_output;

	}

	/**
	 * Replace a menu item with an EDD cart count
	 *
	 * @since 1.3.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_edd_cart_count_replacement( $item, $item_output ) {

		if ( function_exists('edd_get_cart_quantity') ) {
			$replacement = do_shortcode('[maxmegamenu_edd_cart_count]');

			return str_replace( strip_tags( $item_output ), $replacement, $item_output );
		}

		return $item_output;

	}

	/**
	 * Return woocommerce cart total (e.g. $5.99)
	 *
	 * @since 1.3.3
	 * @return string
	 */
	public function shortcode_woo_cart_total() {

		if ( function_exists('WC') ) {
			return "<span class='mega-menu-woo-cart-total'>" . strip_tags( WC()->cart->get_cart_total() ) . "</span>";
		}

	}


	/**
	 * Return woocommerce number of items in cart (e.g 1)
	 *
	 * @since 1.3.3
	 * @return string
	 */
	public function shortcode_woo_cart_count() {

		if ( function_exists('WC') ) {
			return "<span class='mega-menu-woo-cart-count'>" . WC()->cart->cart_contents_count . "</span>";
		}

	}

	/**
	 * Replace a menu item with a WooCommerce cart total
	 *
	 * @since 1.3.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_woo_cart_total_replacement( $item, $item_output ) {

		if ( function_exists('WC') ) {
			$replacement = do_shortcode('[maxmegamenu_woo_cart_total]');

			return str_replace( strip_tags( $item_output ), $replacement, $item_output );
		}

		return $item_output;

	}

	/**
	 * Replace a menu item with a WooCommerce cart count
	 *
	 * @since 1.3.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_woo_cart_count_replacement( $item, $item_output ) {

		if ( function_exists('WC') ) {
			$replacement = do_shortcode('[maxmegamenu_woo_cart_count]');

			return str_replace( strip_tags( $item_output ), $replacement, $item_output );
		}

		return $item_output;

	}


	/**
	 * Replace a menu item with html
	 *
	 * @since 1.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_html_replacement( $item, $item_output ) {

		if ( ! isset( $item->megamenu_settings['replacements']['html']['code'] ) ) {
			return $item_output;
		}

		if ( ! strlen( $item->megamenu_settings['replacements']['html']['code'] ) ) {
			return $item_output;
		}

		$replacement = do_shortcode( $item->megamenu_settings['replacements']['html']['code'] );

		if ( $item->megamenu_settings['replacements']['html']['mode'] == 'inner' ) {

			return str_replace( strip_tags( $item_output ), $replacement, $item_output );

		} else {

			return $replacement;

		}

	}


	/**
	 * Replace a menu item with a logo
	 *
	 * @since 1.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_logo_replacement( $item, $item_output ) {

		if ( ! isset( $item->megamenu_settings['replacements']['logo']['id'] ) ) {
			return $item_output;
		} else {
			$id = $item->megamenu_settings['replacements']['logo']['id'];
		}

		$width = isset( $item->megamenu_settings['replacements']['logo']['width'] ) ? $item->megamenu_settings['replacements']['logo']['width'] : '100';
		$height = isset( $item->megamenu_settings['replacements']['logo']['height'] ) ? $item->megamenu_settings['replacements']['logo']['height'] : '100';

		$url = $item->url;

		if ( $url == '#' || $url == 'http://#' ) {
			$url = get_home_url();
		}

		$logo_url = apply_filters("megamenu_logo_url", $url, $item );

		$url = $this->get_resized_image_url( $id, $width, $height );

		$replacement = "<a class='mega-menu-link mega-menu-logo' href='" . $logo_url . "'><img class='mega-menu-logo' width='{$width}px' height='{$height}px' src='{$url}' /></a>";

		return $replacement;

	}


	/**
	 * Replace a menu item with a search box
	 *
	 * @since 1.3
	 * @param object $item
	 * @param string $item_output
	 * @return string
	 */
	private function do_search_replacement( $item, $item_output ) {

		$placeholder = isset($item->megamenu_settings['replacements']['search']['placeholder_text']) ? $item->megamenu_settings['replacements']['search']['placeholder_text'] : "Search...";

		$type = isset($item->megamenu_settings['replacements']['search']['type']) ? $item->megamenu_settings['replacements']['search']['type'] : "expand_to_left";

		if ( $type == 'expand_to_left' ) {
			$html = "<div class='mega-search-wrap'><form class='mega-search expand-to-left mega-search-closed' action='" .  trailingslashit( home_url() ) . "'>
				        <span class='dashicons dashicons-search search-icon'></span>
				        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
				        <input type='text' data-placeholder='{$placeholder}' name='s'>
				    </form></div>";
		}

		if ( $type == 'expand_to_right' ) {
			$html = "<div class='mega-search-wrap'><form class='mega-search expand-to-right mega-search-closed' action='" .  trailingslashit( home_url() ) . "'>
				        <span class='dashicons dashicons-search search-icon'></span>
				        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
				        <input type='text' data-placeholder='{$placeholder}' name='s'>
				    </form></div>";
		}

		if ( $type == 'static' ) {
			$html = "<div class='mega-search-wrap'><form class='mega-search static mega-search-open' action='" .  trailingslashit( home_url() ) . "'>
				        <span class='dashicons dashicons-search search-icon'></span>
				        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
				        <input type='text' placeholder='{$placeholder}' name='s'>
				    </form></div>";
		}

	    return $html;
	}


	/**
	 * Add the Styling tab to the menu item options
	 *
	 * @since 1.3
	 * @param array $tabs
	 * @param int $menu_item_id
	 * @param int $menu_id
	 * @param int $menu_item_depth
	 * @param array $menu_item_meta
	 * @return string
	 */
	public function add_replacements_tab( $tabs, $menu_item_id, $menu_id, $menu_item_depth, $menu_item_meta ) {

		$type = isset( $menu_item_meta['replacements']['type'] ) ? $menu_item_meta['replacements']['type'] : 'disabled';

		$html_code = isset( $menu_item_meta['replacements']['html']['code'] ) ? $menu_item_meta['replacements']['html']['code'] : '';
		$html_mode = isset( $menu_item_meta['replacements']['html']['mode'] ) ? $menu_item_meta['replacements']['html']['mode'] : 'inner';
		$logo_id = isset( $menu_item_meta['replacements']['logo']['id'] ) ? $menu_item_meta['replacements']['logo']['id'] : false;
		$logo_width = isset( $menu_item_meta['replacements']['logo']['width'] ) ? $menu_item_meta['replacements']['logo']['width'] : apply_filters("megamenu_logo_default_width", 100);
		$logo_height = isset( $menu_item_meta['replacements']['logo']['height'] ) ? $menu_item_meta['replacements']['logo']['height'] : apply_filters("megamenu_logo_default_height", 60);
		$logo_url = isset( $menu_item_meta['replacements']['logo']['url'] ) ? $menu_item_meta['replacements']['logo']['url'] : get_home_url();
		$search_height = isset( $menu_item_meta['replacements']['search']['height'] ) ? $menu_item_meta['replacements']['search']['height'] : apply_filters("megamenu_search_default_height", '30px');
		$search_text_color = isset( $menu_item_meta['replacements']['search']['text_color'] ) ? $menu_item_meta['replacements']['search']['text_color'] : '#333';
		$search_icon_color_closed = isset( $menu_item_meta['replacements']['search']['icon_color_closed'] ) ? $menu_item_meta['replacements']['search']['icon_color_closed'] : '#fff';
		$search_icon_color_open = isset( $menu_item_meta['replacements']['search']['icon_color_open'] ) ? $menu_item_meta['replacements']['search']['icon_color_open'] : '#333';
		$search_background_color_closed = isset( $menu_item_meta['replacements']['search']['background_color_closed'] ) ? $menu_item_meta['replacements']['search']['background_color_closed'] : 'transparent';
		$search_background_color_open = isset( $menu_item_meta['replacements']['search']['background_color_open'] ) ? $menu_item_meta['replacements']['search']['background_color_open'] : '#fff';
		$search_border_radius = isset( $menu_item_meta['replacements']['search']['border_radius'] ) ? $menu_item_meta['replacements']['search']['border_radius'] : '2px';
		$search_placeholder_text = isset( $menu_item_meta['replacements']['search']['placeholder_text'] ) ? $menu_item_meta['replacements']['search']['placeholder_text'] : 'Search...';
		$search_type = isset( $menu_item_meta['replacements']['search']['type'] ) ? $menu_item_meta['replacements']['search']['type'] : 'expand_to_left';

		$logo_src = "";

		if ( $logo_id ) {
			$logo = wp_get_attachment_image_src( $logo_id, 'thumbnail' );
			$logo_src = $logo[0];
		}

		$inner_display = $html_mode == 'inner' ? 'block' : 'none';
		$outer_display = $html_mode == 'outer' ? 'block' : 'none';
		$logo_display = $type == 'logo' ? 'table-row' : 'none';
		$html_display = $type == 'html' ? 'table-row' : 'none';
		$search_display = $type == 'search' ? 'table-row' : 'none';

		$html  = "<form>";
		$html .= "    <input type='hidden' name='_wpnonce' value='" . wp_create_nonce('megamenu_edit') . "' />";
		$html .= "    <input type='hidden' name='menu_item_id' value='{$menu_item_id}' />";
		$html .= "    <input type='hidden' name='action' value='mm_save_menu_item_settings' />";
		$html .= "    <input type='hidden' name='clear_cache' value='true' />";
		$html .= "    <h4 class='first'>" . __("Replacements", "megamenu_pro") . "</h4>";
		$html .= "    <p class='tab-description'>" . __("Replace this menu item with something else: a logo, a search box, WooCommerce total, EDD total, custom HTML or a shortcode", "megamenu_pro") . "</p>";
		$html .= "    <table>";
		$html .= "        <tr class='type'>";
		$html .= "            <td class='mega-name'>" . __("Type", "megamenupro") . "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <select name='settings[replacements][type]' id='mega_replacement_type'>";
		$html .= "                    <option value='disabled' " . selected( $type, 'disabled', false ) . ">" . __("Disabled", "megamenupro") . "</option>";
		$html .= "                    <option value='logo' " . selected( $type, 'logo', false ) . ">" . __("Logo", "megamenupro") . "</option>";
		$html .= "                    <option value='search' " . selected( $type, 'search', false ) . ">" . __("Search box", "megamenupro") . "</option>";
		$html .= "                    <option value='html' " . selected( $type, 'html', false ) . ">" . __("HTML", "megamenupro") . "</option>";
		$html .= "                    <option value='woo_cart_total' " . selected( $type, 'woo_cart_total', false ) . ">" . __("WooCommerce Cart Total", "megamenupro") . "</option>";
		$html .= "                    <option value='woo_cart_count' " . selected( $type, 'woo_cart_count', false ) . ">" . __("WooCommerce Cart Count", "megamenupro") . "</option>";
		$html .= "                    <option value='edd_cart_total' " . selected( $type, 'edd_cart_total', false ) . ">" . __("EDD Cart Total", "megamenupro") . "</option>";
		$html .= "                    <option value='edd_cart_count' " . selected( $type, 'edd_cart_count', false ) . ">" . __("EDD Cart Count", "megamenupro") . "</option>";
		$html .= "                </select>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='logo' style='display: {$logo_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Logo", "megamenupro");
		$html .= "                <div class='mega-description'>" . __( "Choose a logo from your Media Library" , "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "				  <div class='mmm_image_selector' data-src='{$logo_src}' data-field='custom_logo_id' data-menu-item-id='" . esc_attr( $menu_item_id ) . "'></div>";
		$html .= "                <input type='hidden' id='custom_logo_id' name='settings[replacements][logo][id]' value='{$logo_id}' />";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='logo' style='display: {$logo_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Width", "megamenupro");
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='number' name='settings[replacements][logo][width]' class='mm_logo_width' value='{$logo_width}' />px";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='logo' style='display: {$logo_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Height", "megamenupro");
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='number' name='settings[replacements][logo][height]' class='mm_logo_width' value='{$logo_height}' />px";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Style", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Select the search box style", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <select name='settings[replacements][search][type]'>";
		$html .= "                    <option value='expand_to_left' " . selected( $search_type, 'expand_to_left', false ) . ">" . __("Expand to Left", "megamenupro") . "</option>";
		$html .= "                    <option value='expand_to_right' " . selected( $search_type, 'expand_to_right', false ) . ">" . __("Expand to Right", "megamenupro") . "</option>";
		$html .= "                    <option value='static' " . selected( $search_type, 'static', false ) . ">" . __("Static", "megamenupro") . "</option>";
		$html .= "                </select>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Height", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Define the height of the search icon and search input box", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='text' name='settings[replacements][search][height]' value='{$search_height}' />";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Text Color", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Define the color for the text within the search input box", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .=                  $this->print_theme_color_option('text_color', $search_text_color);
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Icon Color", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Search icon color", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
        $html .= "                <label>";
        $html .= "                    <span class='mega-short-desc'>" . __("Closed State", "megamenupro") . "</span>";
        $html .=                      $this->print_theme_color_option('icon_color_closed', $search_icon_color_closed);
        $html .= "                </label>";
        $html .= "                <label>";
        $html .= "                    <span class='mega-short-desc'>" . __("Open State", "megamenupro") . "</span>";
        $html .=                      $this->print_theme_color_option('icon_color_open', $search_icon_color_open);
        $html .= "                </label>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Background Color", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Background color for search icon and search input box", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
        $html .= "                <label>";
        $html .= "                    <span class='mega-short-desc'>" . __("Closed State", "megamenupro") . "</span>";
		$html .=                      $this->print_theme_color_option('background_color_closed', $search_background_color_closed);
        $html .= "                </label>";
        $html .= "                <label>";
        $html .= "                    <span class='mega-short-desc'>" . __("Open State", "megamenupro") . "</span>";
        $html .=                      $this->print_theme_color_option('background_color_open', $search_background_color_open);
        $html .= "                </label>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Border Radius", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Set rounded corners for the search icon and search input box", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='text' name='settings[replacements][search][border_radius]' value='{$search_border_radius}' />";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='search' style='display: {$search_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Placeholder Text", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Define the pre-populated text within the search box", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='text' name='settings[replacements][search][placeholder_text]' value='{$search_placeholder_text}' />";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='html' style='display: {$html_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("Mode", "megamenupro");
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <select name='settings[replacements][html][mode]' id='mega_replacement_mode'>";
		$html .= "                    <option value='inner' " . selected( $html_mode, 'inner', false ) . ">" . __("Replace the menu item link text", "megamenupro") . "</option>";
		$html .= "                    <option value='outer' " . selected( $html_mode, 'outer', false ) . ">" . __("Replace the whole menu item link", "megamenupro") . "</option>";
		$html .= "                </select>";
        $html .= "                <div class='mega-description'>";
        $html .= "                    <div class='inner' style='display:{$inner_display}'>&lt;li class='menu-item'&gt;&lt;a href='url'&gt;<span style='color: red'>Link Text</span>&lt;/a&gt;&lt;/li&gt;</div>";
        $html .= "                    <div class='outer' style='display:{$outer_display}'>&lt;li class='menu-item'&gt;<span style='color: red'>&lt;a href='url'&gt;Link Text&lt;/a&gt;</span>&lt;/li&gt;</div>";
        $html .= "                </div>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr class='html' style='display: {$html_display}'>";
		$html .= "            <td class='mega-name'>";
		$html .=                  __("HTML", "megamenupro");
		$html .= "                <div class='mega-description'>" . __("Enter the text to replace this menu item with. HTML and Shortcodes accepted.", "megamenupro") . "</div>";
		$html .=              "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <textarea id='codemirror' name='settings[replacements][html][code]'>{$html_code}</textarea>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "    </table>";
		$html .= get_submit_button();
		$html .= "</form>";

		$tabs['replacements'] = array(
			'title' => __("Replacements", "megamenupro"),
			'content' => $html
		);

		return $tabs;
	}


    /**
	 * Return the HTML for a color picker
	 *
	 * @since 1.3
	 * @param string $key
	 * @param string $value
	 * @return string
	 */
    public function print_theme_color_option( $key, $value ) {

        if ( $value == 'transparent' ) {
            $value = 'rgba(0,0,0,0)';
        }

        if ( $value == 'rgba(0,0,0,0)' ) {
            $value_text = 'transparent';
        } else {
            $value_text = $value;
        }

        $html  = "<div class='mm-picker-container'>";
        $html .= "    <input type='text' class='mm_colorpicker' name='settings[replacements][search][$key]' value='{$value}' />";
        $html .= "    <div class='chosen-color'>{$value_text}</div>";
        $html .= "</div>";

		return $html;

    }

    /**
     * Return the image URL, crop the image to the correct dimensions if required
     *
     * @param int $attachment_id
     * @param int $dest_width
     * @param int $dest_height
     * @since 1.3
     * @return string resized image URL
     */
    public function get_resized_image_url( $attachment_id, $dest_width, $dest_height ) {

        $meta = wp_get_attachment_metadata( $attachment_id );

        $upload_dir = wp_upload_dir();

        $full_url = $upload_dir['baseurl'] . "/" . get_post_meta( $attachment_id, '_wp_attached_file', true );

        if ( ! isset( $meta['width'], $meta['height'] ) ) {
            return $full_url; // image is not valid
        }

        // if the full size is the same as the required size, return the full URL
        if ( $meta['width'] == $dest_width && $meta['height'] == $dest_height ) {
            return $full_url;
        }

        $path = get_attached_file( $attachment_id );
        $info = pathinfo( $path );
        $dir = $info['dirname'];
        $ext = $info['extension'];
        $name = wp_basename( $path, ".$ext" );
        $dest_file_name = "{$dir}/{$name}-{$dest_width}x{$dest_height}.{$ext}";

        if ( file_exists( $dest_file_name ) ) {
            // good. no need for resize, just return the URL
            return str_replace( basename( $full_url ), basename( $dest_file_name ), $full_url );
        }


        $image = wp_get_image_editor( $path );

        // editor will return an error if the path is invalid
        if ( is_wp_error( $image ) ) {
            return $full_url;
        }

		$image->resize( $dest_width, $dest_height, true );

        $saved = $image->save( $dest_file_name );

        if ( is_wp_error( $saved ) ) {
            return;
        }

        // Record the new size so that the file is correctly removed when the media file is deleted.
        $backup_sizes = get_post_meta( $attachment_id, '_wp_attachment_backup_sizes', true );

        if ( ! is_array( $backup_sizes ) ) {
            $backup_sizes = array();
        }

        $backup_sizes["resized-{$dest_width}x{$dest_height}"] = $saved;
        update_post_meta( $attachment_id, '_wp_attachment_backup_sizes', $backup_sizes );

        $url = str_replace( basename( $full_url ), basename( $saved['path'] ), $full_url );

        return $url;
    }

}

endif;