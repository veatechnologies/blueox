<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_DATA {
	private $params;
	private $default;
	protected $prefix;

	public function __construct() {
		$this->prefix = 'wcaio_woo_art_all_in_one-';
		global $wcaio_settings;
		if ( ! $wcaio_settings ) {
			$wcaio_settings = get_option( 'woo_cart_all_in_one_params', array() );
		}
		$this->default = array(
			//general
			'ajax_add_to_cart_single_page'         => 0,


			//variable product
			'show_variation_enable'                => 0,
			'set_text_select_option_button_enable' => 0,
			'set_text_select_option_button'        => 'Add To Cart',
			'show_variation_type'                  => 1,


			//mini cart
			'custom_css'                           => '',

			'sidebar_cart_enable'        => 1,
			'sidebar_cart_enable_empty'  => 0,
			'sidebar_cart_enable_device' => 'all',
			'sidebar_cart_enable_pages'  => array( 'all' ),//all,shop,category,product,my_account


			'menu_cart_enable'           => 0,
			'menu_cart_enable_empty'     => 0,
			'menu_cart_enable_device'    => 'all',
			'menu_cart_enable_menu_type' => array( '' ),//main, second menu

			'mini_cart_loading'       => 1,//0->11 style
			'mini_cart_loading_color' => '#a0e224',


			'menu_cart_navigation_page' => 1,
			'menu_cart_style'           => 1,

			'menu_cart_icon'                       => 2,
			'menu_cart_icon_color'                 => '',
			'menu_cart_icon_color_hover'           => '',
			'menu_cart_style_one_text'             => "all",//product_counter, price(total/subtotal),all
			'menu_cart_style_one_price'            => "total",
			'menu_cart_style_one_text_color'       => "",
			'menu_cart_style_one_text_color_hover' => "",

			'menu_cart_show_content' => 1,

			//mini cart content

			'mini_cart_content_style' => 1,


			'sidebar_fly_img'         => 1,
			'sidebar_content_display' => 1,


			'sidebar_horizontal'       => 20,
			'sidebar_vertical'         => 20,
			'sidebar_position'         => 'bottom_left',//bottom_right,bottom_left, top_left, top_right
			'sidebar_show_cart_type'   => 'click',//hover, click
			'sidebar_show_cart_style'  => 1,
			'sidebar_shake_trigger'    => 'shake',//shake trigger: none, shake, bounce
			'sidebar_open'             => 0,//no, yes
			'sidebar_cart_icon_radius' => '80',

			'sidebar_cart_icon_type'       => 'default',
			'sidebar_cart_icon_box_shadow' => 1,
			//'sidebar_cart_icon_box_shadow_color'                   =>'#ccc',
			'sidebar_cart_content_radius'  => '10',
			'sidebar_cart_icon_background' => '#fff',

			'sidebar_cart_icon_default_style' => 1,

			'sidebar_cart_icon_default_icon'  => 33,
			'sidebar_cart_icon_default_color' => '#d2691e',

			'sidebar_cart_icon_text_color'            => "#fff",
			'sidebar_cart_icon_text_background_color' => "#20cc59",
			'sidebar_cart_icon_text_radius'           => "25",
			'sidebar_cart_icon_scale'                 => 1,
			'sidebar_cart_icon_hover_scale'           => 1.02,

			'sidebar_header_border'           => 'solid',
			'sidebar_header_border_color'     => '#e6e6e6',
			'sidebar_header_title'            => 'Your Cart',
			'sidebar_header_title_color'      => '#181818',
			'sidebar_header_background_color' => '#fff',

			'sidebar_header_coupon_enable' => 1,


			'sidebar_header_coupon_input_radius' => '0',

			'sidebar_header_coupon_button_text_color'       => '#fff',
			'sidebar_header_coupon_button_text_color_hover' => '#fff',
			'sidebar_header_coupon_button_background'       => '#a4a7a9',
			'sidebar_header_coupon_button_hover_background' => '#a4a7a9',
			'sidebar_header_coupon_button_radius'           => '0',

			'list_pro_background_color' => '#fff',

			'list_pro_image_box_shadow' => 0,
			'list_pro_image_radius'     => "100",


			'list_pro_name_color'       => '#2b3e51',
			'list_pro_hover_name_color' => '#4096dd',

			'list_pro_price_color' => "#222",


			'list_pro_remove_icon_style'       => 1,
			'list_pro_remove_icon_color'       => "#808b97",
			'list_pro_remove_icon_color_hover' => "#4096dd",


			'sidebar_footer_background_color' => '#fff',
			'sidebar_footer_border'           => 'solid',
			'sidebar_footer_border_color'     => '#e6e6e6',

			'sidebar_footer_price_enable' => 'total',//total,subtotal
			'sidebar_footer_total_color'  => "#181818",
			'sidebar_footer_price_color'  => "#181818",

			'sidebar_footer_button_enable' => 'checkout',//cart, checkout

			'sidebar_footer_cart_button_text'     => 'View Cart',
			'sidebar_footer_checkout_button_text' => 'CHECKOUT',


			'sidebar_footer_button_text_color'       => '#fff',
			'sidebar_footer_button_text_color_hover' => '#fff',
			'sidebar_footer_button_background'       => '#0888dd',
			'sidebar_footer_button_hover_background' => '#2795dd',
			'sidebar_footer_button_radius'           => '0',

			'sidebar_footer_update_button_text_color'       => '#fff',
			'sidebar_footer_update_button_text_color_hover' => '#fff',
			'sidebar_footer_update_button_background'       => '#a4a7a9',
			'sidebar_footer_update_button_hover_background' => '#a4a7a9',
			'sidebar_footer_update_button_radius'           => '0',

			'sidebar_footer_pro_plus_enable' => 'best_selling',//best_selling, viewed_product,product_rating,none

			'sidebar_footer_viewed_pro_text'   => 'Your recently viewed items',
			'sidebar_footer_best_selling_text' => "Best selling products",
			'sidebar_footer_rating_pro_text'   => 'Top rated products',

			'sidebar_footer_pro_plus_text_color' => '#181818',
			'sidebar_footer_pro_plus_number'     => 5,

		);
		$this->params  = apply_filters( 'woo_cart_all_in_one_params',
			wp_parse_args( $wcaio_settings, $this->default ) );
	}

	public function get_params( $name = "" ) {
		if ( ! $name ) {
			return $this->params;
		} elseif ( isset( $this->params[ $name ] ) ) {
			return apply_filters( 'woo_cart_all_in_one_params' . $name, $this->params[ $name ] );
		} else {
			return false;
		}
	}


	public function get_default( $name = "" ) {
		if ( ! $name ) {
			return $this->default;
		} elseif ( isset( $this->default[ $name ] ) ) {
			return apply_filters( 'woo_cart_all_in_one_params_default' . $name, $this->default[ $name ] );
		} else {
			return false;
		}
	}

	public function set( $name ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( $this, 'set' ), $name ) );

		} else {
			return esc_attr__( $this->prefix . $name );

		}
	}
}

new VI_WOO_CART_ALL_IN_ONE_DATA();
