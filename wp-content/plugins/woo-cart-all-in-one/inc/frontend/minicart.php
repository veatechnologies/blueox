<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_MiniCart {

	protected $settings;
	protected $prefix;
	protected $menu_cart_enable;
	protected $sidebar_cart_enable;

	public function __construct() {
		$this->settings            = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$this->prefix              = 'wcaio_woo_art_all_in_one-';
		$this->menu_cart_enable    = $this->get_params( 'menu_cart_enable' );
		$this->sidebar_cart_enable = $this->get_params( 'sidebar_cart_enable' );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );
		add_action( 'init', array( $this, 'init' ) );
		if ( $this->menu_cart_enable ) {
			add_filter( 'wp_nav_menu_items', array( $this, 'create_menu_cart' ), 10, 2 );
		}
		add_action( 'wp', array( $this, 'set_user_visited_product_cookie' ) );
		add_action( 'wp_ajax_woo_cart_all_in_one_select_cart_icon',
			array(
				$this,
				'woo_cart_all_in_one_select_cart_icon',
			) );
		add_action( 'wp_ajax_woo_cart_all_in_one_cart_icon_default_style',
			array(
				$this,
				'woo_cart_all_in_one_select_cart_icon',
			) );
		add_action( 'wp_ajax_woo_cart_all_in_oneremove_icon_style',
			array(
				$this,
				'woo_cart_all_in_oneremove_icon_style',
			) );
		add_action( 'wp_ajax_woo_cart_all_in_one_loading', array( $this, 'woo_cart_all_in_one_loading' ) );

		add_action( 'wp_ajax_woo_cart_all_in_one_menu_cart_icon',
			array(
				$this,
				'woo_cart_all_in_one_menu_cart_icon',
			) );
		add_action( 'wp_ajax_woo_cart_all_in_one_menu_text_type',
			array(
				$this,
				'woo_cart_all_in_one_menu_text_type',
			) );
	}

	public function init() {
		$custom_ajax = new Vi_WCAIO_Cart_AJAX();
		$custom_ajax::init();
	}

	public function woo_cart_all_in_one_menu_text_type() {
		$style              = ( isset( $_POST['text_type'] ) ) ? sanitize_text_field( $_POST['text_type'] ) : '';
		$total              = ( isset( $_POST['total'] ) ) ? sanitize_text_field( $_POST['total'] ) : '';
		$menu_cart_one_text = $this->set_menu_cart_text( $style, $total );
		echo $menu_cart_one_text;
		die();
	}

	public function set_menu_cart_text( $style, $total, $pro_count = null ) {
		if ( empty( $pro_count ) ) {
			$pro_count = WC()->cart->get_cart_contents_count();
		}
		if ( $total == 'total' ) {

			$total = WC()->cart->get_cart_total();
		} else {

			$total = WC()->cart->get_cart_subtotal();
		}
		$menu_cart_one_text = '';
		if ( $style == 'product_counter' ) {
			$menu_cart_one_text = $pro_count;
		} elseif ( $style == 'price' ) {
			$menu_cart_one_text = $total;
		} elseif ( $style == 'all' ) {
			$menu_cart_one_text = $pro_count . ' - ' . $total;
		}

		return $menu_cart_one_text;
	}

	public function woo_cart_all_in_one_menu_cart_icon() {
		$trash_icon_id = isset( $_POST['cart_icon_id'] ) ? sanitize_text_field( $_POST['cart_icon_id'] ) : '';
		$icon          = $this->set_cart_icon_default_style( $trash_icon_id );
		echo $icon;
		wp_die();
	}

	public function woo_cart_all_in_one_loading() {
		$loading_id = isset( $_POST['loading_id'] ) ? sanitize_text_field( $_POST['loading_id'] ) : '';
		$loading    = $this->mini_cart_loading( $loading_id );
		echo $loading;
		wp_die();
	}

	public function woo_cart_all_in_oneremove_icon_style() {
		$trash_icon_id = isset( $_POST['trash_icon_id'] ) ? sanitize_text_field( $_POST['trash_icon_id'] ) : '';
		$icon          = $this->set_trash_icon_style( $trash_icon_id );
		echo $icon;
		wp_die();
	}

	public function woo_cart_all_in_one_select_cart_icon() {
		$cart_icon                      = isset( $_POST['cart_icon_id'] ) ? sanitize_text_field( $_POST['cart_icon_id'] ) : '';
		$cart_icon_stlye                = isset( $_POST['cart_icon_style'] ) ? sanitize_text_field( $_POST['cart_icon_style'] ) : '';
		$sidebar_cart_icon_default_icon = $this->set_cart_icon_default_style( $cart_icon );
		if ( $cart_icon_stlye == '1' ) {

			echo $sidebar_cart_icon_default_icon;
			?>

            <div class=" vi_wcaio_mini_cart_sidebar_icon_count_one">
                <div class="vi_wcaio_mini_cart_sidebar_icon_count">
					<?php echo WC()->cart->get_cart_contents_count(); ?>
                </div>
            </div>
			<?php

		} elseif ( $cart_icon_stlye == '2' ) {

			echo $sidebar_cart_icon_default_icon;
			?>
            <div class=" vi_wcaio_mini_cart_sidebar_icon_count_two">
                <div class="vi_wcaio_mini_cart_sidebar_icon_count">
					<?php echo WC()->cart->get_cart_contents_count(); ?>
                </div>
            </div>
			<?php

		} elseif ( $cart_icon_stlye == '3' ) {
			?>
            <div class=" vi_wcaio_mini_cart_sidebar_icon_count_three">
                <div class="vi_wcaio_mini_cart_sidebar_icon_count">
					<?php echo WC()->cart->get_cart_contents_count(); ?>
                </div>
            </div>
			<?php
			echo $sidebar_cart_icon_default_icon;
			?>
			<?php
		} elseif ( $cart_icon_stlye == '4' ) {
			echo $sidebar_cart_icon_default_icon;
		}


		wp_die();
	}

	public function enqueue_scripts() {
		wp_enqueue_media();

		wp_enqueue_style( 'wcaio_frontend_minicart-style',
			VI_WOO_CART_ALL_IN_ONE_CSS . 'frontend-mini-cart-style.css',
			array(),
			VI_WOO_CART_ALL_IN_ONE_VERSION );
		if ( ! wp_script_is( 'wcaio_frontend-slick-css', 'registered' ) ) {
			wp_register_style( 'wcaio_frontend-slick-css',
				VI_WOO_CART_ALL_IN_ONE_CSS . 'slick.min.css',
				array(),
				'1.9.0' );
		}
		if ( ! wp_script_is( 'wcaio_frontend-slick-theme', 'registered' ) ) {
			wp_register_style( 'wcaio_frontend-slick-theme',
				VI_WOO_CART_ALL_IN_ONE_CSS . 'slick-theme.min.css',
				array(),
				'1.9.0' );
		}
		wp_enqueue_style( 'wcaio_frontend-cart_icon',
			VI_WOO_CART_ALL_IN_ONE_CSS . 'mini-cart-icon.css',
			'',
			VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_enqueue_script( 'iris',
			admin_url( 'js/iris.min.js' ),
			array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
				'jquery-effects-shake',
				'jquery-effects-bounce',
			),
			false,
			1 );

		if ( ! wp_script_is( 'wcaio_frontend-slick-js', 'registered' ) ) {
			wp_register_script( 'wcaio_frontend-slick-js',
				VI_WOO_CART_ALL_IN_ONE_JS . 'slick.min.js',
				array( 'jquery' ),
				'1.9.0',
				true );
		}
		wp_enqueue_script( 'wcaio_frontend_minicart-script',
			VI_WOO_CART_ALL_IN_ONE_JS . 'frontend-mini-cart-script.js',
			array(
				'jquery',
				'wc-cart-fragments',
			),
			VI_WOO_CART_ALL_IN_ONE_VERSION );

		$wc_ajax_url = add_query_arg( 'wc-ajax', '%%endpoint%%', home_url( '/' ) );
		wp_localize_script( 'wcaio_frontend_minicart-script',
			'wcaio_mini_cart',
			array(
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'wc_ajax_url'   => urldecode( $wc_ajax_url ),
				'cart_hash_key' => WC()->ajax_url() . '-vi_wcaio_wc_cart_hash',


				'ajax_add_to_cart_single_page' => esc_attr( $this->get_params( 'ajax_add_to_cart_single_page' ) ),
				'is_product'                   => ( is_product() && is_single() ) ? 1 : '',

				'sidebar_cart_enable_empty'  => esc_attr( $this->get_params( 'sidebar_cart_enable_empty' ) ),
				'sidebar_cart_enable_device' => esc_attr( $this->get_params( 'sidebar_cart_enable_device' ) ),
				'menu_cart_enable_empty'     => esc_attr( $this->get_params( 'menu_cart_enable_empty' ) ),
				'menu_cart_enable_device'    => esc_attr( $this->get_params( 'menu_cart_enable_device' ) ),

//				'mini_cart_enable_empty'       => esc_attr( $this->get_params( 'mini_cart_enable_empty' ) ),
//				'sidebar_cart_enable_device'   => esc_attr( $this->get_params( 'sidebar_cart_enable_device' ) ),
//				'menu_cart_enable_device'      => esc_attr( $this->get_params( 'menu_cart_enable_device' ) ),

				'menu_cart_show_content' => esc_attr( $this->get_params( 'menu_cart_show_content' ) ),

				'sidebar_fly_img' => esc_attr( $this->get_params( 'sidebar_fly_img' ) ),

				'sidebar_content_display' => esc_attr( $this->get_params( 'sidebar_content_display' ) ),


				'sidebar_position'   => esc_attr( $this->get_params( 'sidebar_position' ) ),
				'sidebar_horizontal' => esc_attr( $this->get_params( 'sidebar_horizontal' ) ),
				'sidebar_vertical'   => esc_attr( $this->get_params( 'sidebar_vertical' ) ),

				'sidebar_show_cart_type'  => esc_attr( $this->get_params( 'sidebar_show_cart_type' ) ),
				'sidebar_show_cart_style' => esc_attr( $this->get_params( 'sidebar_show_cart_style' ) ),
				'sidebar_shake_trigger'   => esc_attr( $this->get_params( 'sidebar_shake_trigger' ) ),
				'sidebar_open'            => esc_attr( $this->get_params( 'sidebar_open' ) ),

				'sidebar_cart_icon_radius' => esc_attr( $this->get_params( 'sidebar_cart_icon_radius' ) ),

				'sidebar_header_coupon_enable' => esc_attr( $this->get_params( 'sidebar_header_coupon_enable' ) ),


				'sidebar_footer_price_enable' => esc_attr( $this->get_params( 'sidebar_footer_price_enable' ) ),

				'sidebar_footer_pro_plus_enable' => esc_attr( $this->get_params( 'sidebar_footer_pro_plus_enable' ) ),

			) );
		if ( $this->sidebar_cart_enable || $this->menu_cart_enable ) {
			$css = '';

			$css .= $this->get_params( 'custom_css' );
			//sidebar general
			$sidebar_cart_icon_box_shadow = esc_attr( $this->get_params( 'sidebar_cart_icon_box_shadow' ) );
			if ( $sidebar_cart_icon_box_shadow == 1 ) {
				$css .= '
                .vi_wcaio_mini_cart_sidebar_icon{
                    box-shadow: inset 0 0 2px rgba(0,0,0,0.03) , 0 4px 10px rgba(0,0,0,0.17);
                }
                .vi_wcaio_mini_cart_sidebar_icon:hover{
                    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                }
                ';
			}
			//cart icon general
			$css .= $this->add_inline_style( array(
				'sidebar_cart_icon_background',
				'sidebar_cart_icon_radius',
			),
				'.vi_wcaio_mini_cart_sidebar_icon',
				array(
					'background-color',
					'border-radius',
				),
				array(
					'',
					'px',
				) );


			//cart icon default
			$css .= $this->add_inline_style( array(
				'sidebar_cart_icon_default_color',
			),
				'.vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i ,
             .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :before ,
             .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :after',
				array(
					'color',
				),
				array(
					'',
				) );


			//cart icon text

			$css .= $this->add_inline_style( array(
				'sidebar_cart_icon_text_background_color',
				'sidebar_cart_icon_text_color',
				'sidebar_cart_icon_text_radius',
			),
				'.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two',
				array(
					'background-color',
					'color',
					'border-radius',
				),
				array(
					'',
					'',
					'px',
				) );
			//cart icon size
			$css .= ' .vi_wcaio_mini_cart_sidebar_icon{';
			$css .= 'transform: scale(' . $this->get_params( 'sidebar_cart_icon_scale' ) . ');';
			$css .= '}';
			$css .= ' .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_hover1{';
			$css .= 'transform: scale(' . $this->get_params( 'sidebar_cart_icon_hover_scale' ) . ');';
			$css .= '}';

			//sidebar content
			$css .= $this->add_inline_style( array(
				'sidebar_cart_content_radius',
			),
				'.vi_wcaio_mini_cart_content ',
				array(
					'border-radius',
				),
				array(
					'px',
				) );
			//sidebar header
			$css                                   .= $this->add_inline_style( array(
				'sidebar_header_background_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title',
				array(
					'background-color',
				),
				array(
					'',
				) );
			$css                                   .= $this->add_inline_style( array(
				'sidebar_header_title_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title h5,
            .vi_wcaio_list_product_plus_title ',
				array(
					'color',
				),
				array(
					'',
				) );
			$sidebar_header_border                 = $this->get_params( 'sidebar_header_border' );
			$sidebar_header_border_color           = $this->get_params( 'sidebar_header_border_color' );
			$sidebar_header_coupon_color           = $this->get_params( 'sidebar_header_coupon_color' );
			$sidebar_header_coupon_underline       = $this->get_params( 'sidebar_header_coupon_underline' );
			$sidebar_header_coupon_underline_color = $this->get_params( 'sidebar_header_coupon_underline_color' );
			$css                                   .= '
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title{
                border-bottom: 1px ' . $sidebar_header_border . ' ' . $sidebar_header_border_color . ' ;
            }
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title a.vi_wcaio_hide-coupon{
                color: ' . $sidebar_header_coupon_color . ' ;
                border-bottom: 1px ' . $sidebar_header_coupon_underline . ' ' . $sidebar_header_coupon_underline_color . ' ;
            }
            ';

			$css .= $this->add_inline_style( array(
				'sidebar_header_coupon_input_radius',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon input#coupon_code.vi_wcaio_input_coupon-code ',
				array(
					'border-radius',
				),
				array(
					'px',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_header_coupon_button_background',
				'sidebar_header_coupon_button_text_color',
				'sidebar_header_coupon_button_radius',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button',
				array(
					'background-color',
					'color',
					'border-radius',
				),
				array(
					'',
					'',
					'px',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_header_coupon_button_hover_background',
				'sidebar_header_coupon_button_text_color_hover',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button:hover',
				array(
					'background-color',
					'color',
				),
				array(
					'',
					'',
				) );
			//sidebar footer
			$css                          .= $this->add_inline_style( array(
				'sidebar_footer_background_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer',
				array(
					'background-color',
				),
				array(
					'',
				) );
			$sidebar_footer_border        = $this->get_params( 'sidebar_footer_border' );
			$sidebar_footer_border_color  = $this->get_params( 'sidebar_footer_border_color' );
			$sidebar_footer_button_enable = $this->get_params( 'sidebar_footer_button_enable' );

			if ( $sidebar_footer_button_enable == 'cart' ) {
				$css .= '
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(2){
                    display: inline-block;
                }
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(3){
                     display: none;
                }
                ';
			} elseif ( $sidebar_footer_button_enable == 'checkout' ) {

				$css .= '
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(2) {
                    display: none;
                }
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(3){
                   display: inline-block;
                }
                ';
			}
			$css .= '
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer{
                border-top: 1px ' . $sidebar_footer_border . ' ' . $sidebar_footer_border_color . ' ;
            }
            ';
			$css .= $this->add_inline_style( array(
				'sidebar_footer_total_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_subtotal div:first-child, 
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_total div:first-child',
				array(
					'color',
				),
				array(
					'',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_footer_price_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_subtotal span.amount, 
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_total span.amount',
				array(
					'color',
				),
				array(
					'',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_footer_button_background',
				'sidebar_footer_button_text_color',
				'sidebar_footer_button_radius',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input',
				array(
					'background-color',
					'color',
					'border-radius',
				),
				array(
					'',
					'',
					'px',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_footer_button_hover_background',
				'sidebar_footer_button_text_color_hover',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input:hover',
				array(
					'background-color',
					'color',
				),
				array(
					'',
					'',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_footer_update_button_background',
				'sidebar_footer_update_button_text_color',
				'sidebar_footer_update_button_radius',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update',
				array(
					'background-color',
					'color',
					'border-radius',
				),
				array(
					'',
					'',
					'px',
				) );
			$css .= $this->add_inline_style( array(
				'sidebar_footer_update_button_hover_background',
				'sidebar_footer_update_button_text_color_hover',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update:hover',
				array(
					'background-color',
					'color',
				),
				array(
					'',
					'',
				) );


			$css .= $this->add_inline_style( array(
				'sidebar_footer_pro_plus_text_color',
			),
				'.vi_wcaio_list_product_plus_title ',
				array(
					'color',
				),
				array(
					'',
				) );
			//sidebar list product
			$css                       .= $this->add_inline_style( array(
				'list_pro_background_color',
				'list_pro_price_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content',
				array(
					'background-color',
					'color',
				),
				array(
					'',
					'',
				) );
			$css                       .= $this->add_inline_style( array(
				'list_pro_name_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a,
			.vi_wcaio_products-plus_item_info a',
				array(
					'color',
				),
				array(
					'',
				) );
			$css                       .= $this->add_inline_style( array(
				'list_pro_hover_name_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a:hover,
			.vi_wcaio_products-plus_item_info a:hover',
				array(
					'color',
				),
				array(
					'',
				) );
			$list_pro_image_box_shadow = esc_attr( $this->get_params( 'list_pro_image_box_shadow' ) );
			if ( $list_pro_image_box_shadow == 1 ) {
				$css .= '
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img{
                    box-shadow:  0 4px 10px rgba(0,0,0,0.07);
                }
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img:hover{
                    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                }
                ';
			}

			$css .= $this->add_inline_style( array(
				'list_pro_image_radius',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img',
				array(
					'border-radius',
				),
				array(
					'px',
				) );
			$css .= $this->add_inline_style( array(
				'list_pro_remove_icon_color',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i',
				array(
					'color',
				),
				array(
					'',
				) );
			$css .= $this->add_inline_style( array(
				'list_pro_remove_icon_color_hover',
			),
				'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i:hover',
				array(
					'color',
				),
				array(
					'',
				) );

			/*
			 * mini cart loading
			 */

			$mini_cart_loading_color = $this->get_params( 'mini_cart_loading_color' );
			$css                     .= '
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-default div {
                background:' . $mini_cart_loading_color . ';
            }
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-dual-ring:after{
                border: 5px solid ' . $mini_cart_loading_color . ';
                border-color: ' . $mini_cart_loading_color . '  transparent ' . $mini_cart_loading_color . '  transparent;
            }
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook div{
                background: ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ring div{
                border: 6px solid ' . $mini_cart_loading_color . ' ;
                border-color: ' . $mini_cart_loading_color . '  transparent transparent transparent;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-roller div:after {
                background: ' . $mini_cart_loading_color . ';
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis div {
                background: ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ripple  div{
                border: 4px solid ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-spinner div:after {
                background:  ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls2 div{
                   background:  ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls3 div{
            
                background: ' . $mini_cart_loading_color . ' ;
            }
            
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook2 div{
                background:  ' . $mini_cart_loading_color . ' ;
            }
            ';

			if ( $this->get_params( 'menu_cart_icon_color' ) !== '' ) {
				$css .= $this->add_inline_style( array(
					'menu_cart_icon_color',
				),
					'.vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i ,
             .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :before ,
             .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :after',
					array(
						'color',
					),
					array(
						'',
					) );
			} else {
				$css .= '
                    .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i ,
                    .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :before ,
                    .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :after{
                        color:  inherit ;
                    }
			    ';
			}

			if ( $this->get_params( 'menu_cart_icon_color_hover' ) !== '' ) {
				$css .= $this->add_inline_style( array(
					'menu_cart_icon_color_hover',
				),
					'.vi_wcaio_menu_cart:hover  .vi_wcaio_mini_cart_menu_icon i',
					array(
						'color',
					),
					array(
						'',
					) );
			} else {
				$css .= '
                    .vi_wcaio_menu_cart:hover  .vi_wcaio_mini_cart_menu_icon i{
                        color:  inherit ;
                    }
			    ';
			}


			if ( $this->get_params( 'menu_cart_style_one_text_color' ) !== '' ) {

				$css .= $this->add_inline_style( array(
					'menu_cart_style_one_text_color',
				),
					'.vi_wcaio_menu_cart .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart .vi_wcaio_menu_cart_text_one span.amount',
					array(
						'color',
					),
					array(
						'',
					) );
			} else {
				$css .= '
                    .vi_wcaio_menu_cart .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart .vi_wcaio_menu_cart_text_one span.amount{
                        color:  inherit ;
                    }
			    ';
			}
			if ( $this->get_params( 'menu_cart_style_one_text_color_hover' ) !== '' ) {
				$css .= $this->add_inline_style( array(
					'menu_cart_style_one_text_color_hover',
				),
					'.vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one span.amount',
					array(
						'color',
					),
					array(
						'',
					) );
			} else {
				$css .= '
                    .vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one span.amount{
                        color:  inherit ;
                    }
			    ';
			}

			wp_add_inline_style( 'wcaio_frontend_minicart-style', $css );

		}


		if ( $this->sidebar_cart_enable ) {
			add_action( 'wp_footer', array( $this, 'create_mini_cart_sidebar' ) );
		}
	}

	public function create_menu_cart( $items, $args ) {
		$mini_cart_menu_enable_pages = $this->get_params( 'menu_cart_enable_menu_type' );
		if ( count( $mini_cart_menu_enable_pages ) == 0 ) {
			return $items;
		}

		$menu_data = array(
			'menu_id'                  => $this->get_params( 'menu_cart_enable_menu_type' ),
			'menu_style'               => $this->get_params( 'menu_cart_style' ),
			'menu_cart_icon'           => $this->get_params( 'menu_cart_icon' ),
			'menu_cart_style_one_text' => $this->get_params( 'menu_cart_style_one_text' ),
			'navigation_page'          => $this->get_params( 'menu_cart_navigation_page' ),
		);

		$navigation_url     = ( $menu_data['navigation_page'] == 1 ) ? get_permalink( wc_get_page_id( 'cart' ) ) : get_permalink( wc_get_page_id( 'checkout' ) );
		$pro_count          = WC()->cart->get_cart_contents_count();
		$menu_cart_one_text = '';
		$total              = $this->get_params( 'menu_cart_style_one_price' );


		$navigation_title = ( $menu_data['navigation_page'] == 1 ) ? 'View your shopping cart' : 'Quick checkout';

		$theme_locations = get_nav_menu_locations();
		foreach ( $theme_locations as $theme_location => $id ) {
			if ( ( $args->theme_location === $theme_location ) && in_array( $id, $menu_data['menu_id'] ) ) {


				$items .= '
                    <li class="vi_wcaio_menu_cart " style="display: none;" >
                        <a href="' . esc_url( $navigation_url ) . '" title="' . $navigation_title . '" style="width: 100%;"  class="vi_wcaio_menubar_dropdowns"><span class="vi_wcaio_mini_cart_menu_icon">Cart ';
				$items .= $this->set_cart_icon_default_style( $menu_data['menu_cart_icon'] ) . '</span>';
				if ( $menu_data['menu_style'] == 1 ) {
					$menu_cart_one_text = $this->set_menu_cart_text( $menu_data['menu_cart_style_one_text'],
						$total,
						$pro_count );

					//$items .= '<span class="vi_wcaio_menu_cart_text_one">' . $menu_cart_one_text . '</span>';
				}
				$items .= '</a> ';
				ob_start();

				$this->create_mini_cart_content_menubar_dropdown();

				$items .= ob_get_clean();
				$items .= '</li>';
			}
		}


		return $items;


	}


	public function create_mini_cart_content_menubar_dropdown() {

		if ( is_cart() || is_checkout() || wp_is_mobile() ) {
			return;
		}
		$args = array(
			'wrap_tag'   => 'div',
			'wrap_class' => 'vi_wcaio_menubar_shopping-cart',
		);
		ob_start();
		the_widget( 'WC_Widget_Cart', array(), $args );
		$content = ob_get_contents();
		ob_end_clean();

		if ( isset( $args['wrap_tag'] ) ) {
			$tag     = $args['wrap_tag'];
			$class   = isset( $args['wrap_class'] ) ? $args['wrap_class'] : "";
			$content = "<{$tag} class='{$class}'>{$content}</{$tag}>";
		}
		// var_dump($cartContent);
		echo $content;
	}


	public function create_mini_cart_sidebar() {
		$mini_cart_sidebar_enable_pages = $this->get_params( 'sidebar_cart_enable_pages' );
		if ( count( $mini_cart_sidebar_enable_pages ) == 0 ) {
			return;
		} else {
			if ( ! in_array( 'all', $mini_cart_sidebar_enable_pages ) ) {
				if ( is_shop() || is_product() || is_product_category() || is_account_page() ) {
					if ( is_shop() ) {
						if ( ! in_array( 'shop', $mini_cart_sidebar_enable_pages ) ) {
							return;
						}
					}
					if ( is_product() ) {
						if ( ! in_array( 'product', $mini_cart_sidebar_enable_pages ) ) {
							return;
						}
					}
					if ( is_product_category() ) {
						if ( ! in_array( 'category', $mini_cart_sidebar_enable_pages ) ) {
							return;
						}
					}
					if ( is_account_page() ) {
						if ( ! in_array( 'my_account', $mini_cart_sidebar_enable_pages ) ) {
							return;
						}
					}

				} else {
					return;
				}
			} else {
				if ( is_checkout() || is_cart() ) {
					return;
				}
			}
		}

		if ( ! wp_script_is( 'wcaio_frontend-slick-js', 'enqueued' ) ) {
			wp_enqueue_script( 'wcaio_frontend-slick-js' );
		}
		if ( ! wp_script_is( 'wcaio_frontend-slick-css', 'enqueued' ) ) {
			wp_enqueue_style( 'wcaio_frontend-slick-css' );
		}
		if ( ! wp_script_is( 'wcaio_frontend-slick-theme', 'enqueued' ) ) {
			wp_enqueue_style( 'wcaio_frontend-slick-theme' );
		}
		echo '<div class="vi_wcaio_sidebar">';
		echo '<div class="vi_wcaion_mini_cart_sidebar_content" >';
		$this->create_mini_cart_icon();
		$this->create_mini_cart_content_sidebar();
		echo '</div>';
		echo '<div class="vi_wcaion_mini_cart_sidebar  vi_wcaion_mini_cart_sidebar_close" >';
		echo '</div> </div>';

	}

	private function set_cart_icon_default_style( $icon ) {
		$sidebar_cart_icon_default_icon = '';
		switch ( $icon ) {
			case 1:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-commerce"></i>';
				break;
			case 2:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-13"></i>';
				break;
			case 3:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-of-ecommerce"></i>';
				break;
			case 4:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-with-product-inside"></i>';
				break;
			case 5:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-plus"></i>';
				break;
			case 6:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-store-cart"></i>';
				break;
			case 7:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-black-shape"></i>';
				break;
			case 8:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-2"></i>';
				break;
			case 9:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-empty-shopping-cart"></i>';
				break;
			case 10:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-2"></i>';
				break;
			case 11:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-6"></i>';
				break;
			case 12:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-5"></i>';
				break;
			case 13:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-sell"></i>';
				break;
			case 14:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-4"></i>';
				break;
			case 15:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-5"></i>';
				break;
			case 16:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-of-checkered-design"></i>';
				break;
			case 17:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-9"></i>';
				break;
			case 18:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-buy"></i>';
				break;
			case 19:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-grocery-trolley"></i>';
				break;
			case 20:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-6"></i>';
				break;
			case 21:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-4"></i>';
				break;
			case 22:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-11"></i>';
				break;
			case 23:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-16"></i>';
				break;
			case 24:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-3"></i>';
				break;
			case 25:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-15"></i>';
				break;
			case 26:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-1"></i>';
				break;
			case 27:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-7"></i>';
				break;
			case 28:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-commerce-and-shopping"></i>';
				break;
			case 29:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-8"></i>';
				break;
			case 30:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-5"></i>';
				break;
			case 31:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket"></i>';
				break;
			case 32:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-1"></i>';
				break;
			case 33:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-online-shopping-cart"></i>';
				break;
			case 34:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-4"></i>';
				break;
			case 35:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-14"></i>';
				break;
			case 36:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-3"></i>';
				break;
			case 37:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-3"></i>';
				break;
			case 38:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-6"></i>';
				break;
			case 39:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-10"></i>';
				break;
			case 40:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-12"></i>';
				break;
			case 41:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-cart-2"></i>';
				break;
			case 42:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-commerce-1"></i>';
				break;
			case 43:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart"></i>';
				break;
			case 44:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-shopping-cart-7"></i>';
				break;
			case 45:
				$sidebar_cart_icon_default_icon = '<i class="vi_wcaio_cart_icon-supermarket-1"></i>';
				break;
		}

		return $sidebar_cart_icon_default_icon;
	}

	private function set_trash_icon_style( $icon ) {
		$data = '';
		switch ( $icon ) {
			case 1:
				$data = '<i class="vi_wcaio_cart_icon-rubbish-bin-delete-button"></i>';
				break;
			case 2:
				$data = '<i class="vi_wcaio_cart_icon-delete-1"></i>';
				break;
			case 3:
				$data = '<i class="vi_wcaio_cart_icon-waste-bin"></i>';
				break;
			case 4:
				$data = '<i class="vi_wcaio_cart_icon-trash"></i>';
				break;
			case 5:
				$data = '<i class="vi_wcaio_cart_icon-garbage-1"></i>';
				break;
			case 6:
				$data = '<i class="vi_wcaio_cart_icon-delete-button"></i>';
				break;
			case 7:
				$data = '<i class="vi_wcaio_cart_icon-delete"></i>';
				break;
			case 8:
				$data = '<i class="vi_wcaio_cart_icon-rubbish-bin"></i>';
				break;
			case 9:
				$data = '<i class="vi_wcaio_cart_icon-dustbin"></i>';
				break;
			case 10:
				$data = '<i class="vi_wcaio_cart_icon-garbage"></i>';
				break;
		}

		return $data;
	}

	public function create_mini_cart_icon() {
		$icon                           = array(
			'sidebar_cart_icon_type'          => esc_attr( $this->settings->get_params( 'sidebar_cart_icon_type' ) ),
			'sidebar_cart_icon_default_icon'  => esc_attr( $this->settings->get_params( 'sidebar_cart_icon_default_icon' ) ),
			'sidebar_cart_icon_default_style' => esc_attr( $this->settings->get_params( 'sidebar_cart_icon_default_style' ) ),
		);
		$sidebar_cart_icon_default_icon = $this->set_cart_icon_default_style( $icon['sidebar_cart_icon_default_icon'] );
		switch ( $icon['sidebar_cart_icon_type'] ) {
			case 'default':
				if ( $icon['sidebar_cart_icon_default_style'] == 1 ) {
					?>
                    <div class="vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_one">

						<?php
						echo $sidebar_cart_icon_default_icon;
						?>

                        <div class=" vi_wcaio_mini_cart_sidebar_icon_count_one">
                            <div class="vi_wcaio_mini_cart_sidebar_icon_count">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
                            </div>
                        </div>
                    </div>
					<?php

				} elseif ( $icon['sidebar_cart_icon_default_style'] == 2 ) {
					?>
                    <div class="vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_two">
						<?php
						echo $sidebar_cart_icon_default_icon;
						?>
                        <div class=" vi_wcaio_mini_cart_sidebar_icon_count_two">
                            <div class="vi_wcaio_mini_cart_sidebar_icon_count">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
                            </div>
                        </div>
                    </div>
					<?php

				} elseif ( $icon['sidebar_cart_icon_default_style'] == 3 ) {
					?>
                    <div class="vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_three">
                        <div class=" vi_wcaio_mini_cart_sidebar_icon_count_three">
                            <div class="vi_wcaio_mini_cart_sidebar_icon_count">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
                            </div>
                        </div>
						<?php
						echo $sidebar_cart_icon_default_icon;
						?>
                    </div>
					<?php
				} elseif ( $icon['sidebar_cart_icon_default_style'] == 4 ) {
					?>
                    <div class="vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_one">
						<?php
						echo $sidebar_cart_icon_default_icon;
						?>
                    </div>
					<?php
				}
				break;
			case 'img':
				break;
		}
	}

	public function create_mini_cart_content_sidebar() {
		$content_data = array(
			'content_style' => $this->settings->get_params( 'mini_cart_content_style' ),

			'content_viewed_text'  => $this->settings->get_params( 'sidebar_footer_viewed_pro_text' ),
			'content_selling_text' => $this->settings->get_params( 'sidebar_footer_best_selling_text' ),
			'content_rating_text'  => $this->settings->get_params( 'sidebar_footer_rating_pro_text' ),

			'content_plus_number' => $this->settings->get_params( 'sidebar_footer_pro_plus_number' ),

			'content_loading' => $this->settings->get_params( 'mini_cart_loading' ),

			'content_header_text'          => $this->settings->get_params( 'sidebar_header_title' ),
			'sidebar_header_coupon_enable' => $this->settings->get_params( 'sidebar_header_coupon_enable' ),

			'content_cart_text'     => $this->settings->get_params( 'sidebar_footer_cart_button_text' ),
			'content_checkout_text' => $this->settings->get_params( 'sidebar_footer_checkout_button_text' ),
		);

		if ( $content_data['content_style'] == 1 ) {
			$content_template = 'template_one';
		} elseif ( $content_data['content_style'] == 2 ) {
			$content_template = 'template_two';
		}

		do_action( 'vi_wcaio_before_mini_cart' );
		?>
        <div class="vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_<?php echo $content_template; ?>">
            <div class="vi_wcaio_mini_cart_sidebar_title">
                <h5><?php echo $content_data['content_header_text'] ?></h5>
                <div class="vi_wcaio_mini_cart_sidebar_title-right">
                    <div class="vi_wcaio_mini_cart_sidebar_coupon">
						<?php if ( wc_coupons_enabled() ) { ?>

                            <div class="vi_wcaio_coupon">
								<?php
								$coupon_applied      = WC()->cart->get_applied_coupons();
								$coupon_applied_name = '';
								if ( ! empty( $coupon_applied ) ) {
									$coupon_applied_name = $coupon_applied[ count( $coupon_applied ) - 1 ];
								}
								?>
                                <input type="text" name="coupon_code" class="vi_wcaio_input_coupon-code"
                                       id="coupon_code"
                                       value="<?php echo ( ! empty( $coupon_applied_name ) ) ? $coupon_applied_name : ''; ?>"
                                       placeholder="<?php esc_attr_e( 'Coupon code', 'woo-cart-all-in-one' ); ?>"/>
                                <button type="submit" class="button vi_wcaio_input_coupon-button" name="apply_coupon"
                                        value="<?php esc_attr_e( 'Apply coupon',
									        'woo-cart-all-in-one' ); ?>"><?php esc_attr_e( 'Apply',
										'woo-cart-all-in-one' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
						<?php } ?>

						<?php wp_nonce_field( 'vi_wcaio_cart', 'vi_wcaio_cart-nonce' ); ?>
                    </div>
                    <div class="vi_wcaio_close_content">
                        <i class="vi_wcaio_cart_icon-clear-button"></i>
                    </div>
                </div>

            </div>
            <div class="vi_wcaio_mini_cart_sidebar_content">
                <ul class="vi_wcaio_mini_cart_sidebar_list_products">

					<?php
					$this->get_list_products_in_cart();
					?>
                </ul>

            </div>

            <div class="vi_wcaio_mini_cart_sidebar-footer">

                <div class="vi_wcaio_mini_cart_sidebar_coupon-total">

                    <div class="vi_wcaio_mini_cart_sidebar_total-subtotal">

                        <div class="vi_wcaio_mini_cart_sidebar_subtotal" style="display: none">
                            <div><?php esc_html_e( 'Subtotal:&nbsp; ', 'woo-cart-all-in-one' ); ?></div>
                            <div id="vi_wcaio_mini_cart_sidebar_subtotal_currency"><?php echo WC()->cart->get_cart_subtotal() ?></div>
                        </div>
                        <div class="vi_wcaio_mini_cart_sidebar_total">
                            <div><?php esc_html_e( 'Subtotal:&nbsp;', 'woo-cart-all-in-one' ); ?></div>
                            <div id="vi_wcaio_mini_cart_sidebar_total_currency"><?php echo WC()->cart->get_total() ?></div>
                        </div>
                    </div>
                    <div class="vi_wcaio_mini_cart_sidebar-button"
                         style="">
                        <input type="button" class="hidden"
                               value=" <?php echo esc_html_e( 'Update Cart', 'woo-cart-all-in-one' ) ?>"
                               id="vi_wcaio_mini_cart_update"/>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ) ?> ">
                            <input type="button"
                                   value=" <?php echo $content_data['content_cart_text'] ?>"/>
                        </a>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) ) ?> ">
                            <input type="button"
                                   value=" <?php echo $content_data['content_checkout_text'] ?>"/>

                        </a>

                    </div>
                </div>
                <div class="vi_wcaio_mini_cart_sidebar_product-plus">
                    <ul class="vi_wcaio_mini_cart_sidebar_product-plus_products-viewed">
						<?php
						$this->get_user_visited_product( $content_data['content_plus_number'],
							$content_data['content_viewed_text'] );

						?>

                    </ul>
                    <ul class="vi_wcaio_mini_cart_sidebar_product-plus_best-selling">
						<?php
						$this->get_best_selling_product( $content_data['content_plus_number'],
							$content_data['content_selling_text'] );

						?>
                    </ul>
                    <ul class="vi_wcaio_mini_cart_sidebar_product-plus_product-rating">
						<?php
						$this->get_rating_product( $content_data['content_plus_number'],
							$content_data['content_rating_text'] );

						?>
                    </ul>
                </div>

            </div>
            <div class="vi_wcaio_mini_cart_sidebar_bg vi_wcaio_mini_cart_sidebar_bg_hidden"></div>

            <div class="vi_wcaio_mini_cart_sidebar_loading" style="display: none">
				<?php
				$this->mini_cart_loading( $content_data['content_loading'] );
				?>
            </div>
        </div>

		<?php
		do_action( 'vi_wcaio_after_mini_cart' );
	}

	public function mini_cart_loading( $loading ) {

		switch ( $loading ) {
			case 0:
				break;
			case 1:
				echo '<div class="vi_wcaio_loading-lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
				break;
			case 2:
				echo '<div class="vi_wcaio_loading-lds-dual-ring"></div>';
				break;
			case 3:
				echo '<div class="vi_wcaio_loading-lds-facebook"><div></div><div></div><div></div></div>';
				break;
			case 4:
				echo ' <div class="vi_wcaio_loading-lds-facebook2 "><div></div><div></div><div></div><div></div></div>';
				break;
			case 5:
				echo '<div class="vi_wcaio_loading-lds-ring"><div></div><div></div><div></div><div></div></div>';
				break;
			case 6:
				echo '<div class="vi_wcaio_loading-lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
				break;
			case 7:
				echo '<div class="vi_wcaio_loading-lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
				break;
			case 8:
				echo '<div class="vi_wcaio_loading-lds-ellipsis-balls2"><div ></div><div ></div><div ></div></div>';
				break;
			case 9:
				echo '<div class="vi_wcaio_loading-lds-ellipsis-balls3" ><div></div><div></div><div></div></div>';
				break;
			case 10:
				echo '<div class="vi_wcaio_loading-lds-ripple"><div></div><div></div></div>';
				break;
			case 11:
				echo '<div class="vi_wcaio_loading-lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
				break;
		}
	}

	public function get_list_products_in_cart() {

		if ( ! ( WC()->cart->is_empty() ) ) {
			$cart_products = WC()->cart->get_cart();
			foreach ( $cart_products as $cart_item_key => $cart_item ) {
				$product    = wc_get_product( $cart_item['data'] );
				$product_id = $cart_item['product_id'];
				if ( $product && $product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible',
						true,
						$cart_item,
						$cart_item_key ) ) {

					$product_name      = $product->get_name();
					$product_thumbnail = $product->get_image();
					$product_price     = WC()->cart->get_product_price( $product );
					$product_permalink = $product->get_permalink();
					?>
                    <li class="vi_wcaio_sidebar_product" data-id="<?php echo $product_id; ?>"
                        data-key="<?php echo $cart_item_key; ?>">
                        <div class="vi_wcaio_sidebar_product_img">
							<?php
							if ( empty( $product_permalink ) ) {
								echo $product_thumbnail;
							} else {
								echo '<a href="' . $product_permalink . '">' . $product_thumbnail . '</a>';
							}
							?>
                        </div>
                        <div class="vi_wcaio_sidebar_product_info">
                            <div class="vi_wcaio_sidebar_product-name-product">
								<?php
								if ( empty( $product_permalink ) ) {
									echo $product_name;
								} else {
									echo '<a href="' . $product_permalink . '">' . $product_name . '</a>';
								}
								?>

                            </div>
                            <div class="vi_wcaio_sidebar_product-meta">
								<?php
								echo wc_get_formatted_cart_item_data( $cart_item );
								?>
                            </div>
                            <div class="vi_wcaio_sidebar_product-info-product">
                                <div class="vi_wcaio_sidebar_product-price-product">
									<?php echo $product_price; ?>
                                </div>
                                <div class="vi_wcaio_sidebar_product-number-product">
									<?php
									if ( $product->is_sold_individually() ) {
										echo sprintf( '<input type="hidden" name="cart[%s][vi_wcaio_qty]" value="1" />',
											$cart_item_key );
									} else {
										$min_value = $product->get_min_purchase_quantity();
										$max_value = $product->get_max_purchase_quantity();
										$min_value = ( $min_value < 0 ) ? 0 : $min_value;
										$max_value = ( $max_value < 0 ) ? 99999 : $max_value;
										echo sprintf( '<input  type="number" name="cart[%s][vi_wcaio_qty]" value="%s" step="1" min="%s" max="%s"  class="vi_wcaio_qty" />',
											$cart_item_key,
											$cart_item['quantity'],
											$min_value,
											$max_value );
									}
									?>
                                </div>
                            </div>
                        </div>
                        <div class="vi_wcaio_sidebar_product-delete-product">
							<?php
							$list_pro_remove_icon_style  = $this->get_params( 'list_pro_remove_icon_style' );
							$list_pro_remove_icon_style1 = $this->set_trash_icon_style( $list_pro_remove_icon_style );
							echo sprintf( '<a href="%s" class="vi_wcaio_sidebar_product-remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">'
							              . $list_pro_remove_icon_style1 . '</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								__( 'Remove', 'woo-cart-all-in-one' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $product->get_sku() )
							);
							?>
                        </div>
                    </li>
					<?php
				}
			}
		} else {

			echo '<li class="vi_wcaio_mini_cart_sidebar_cart_empty" style="text-align: center;">';
			echo esc_html_e( 'No products in the cart.', 'woo-cart-all-in-one' );
			echo '</li>';
		}
	}


	public function set_user_visited_product_cookie() {
		global $post;

		$Existing_product_id = empty( $_COOKIE['vi_wcaio_woocommerce_recently_viewed'] ) ? '' : $_COOKIE['vi_wcaio_woocommerce_recently_viewed'];
		if ( is_product() ) {
			$updated_product_id = $Existing_product_id . '|' . $post->ID;
			wc_setcookie( 'vi_wcaio_woocommerce_recently_viewed', $updated_product_id );
		}

	}

	/*
	 * get recently viewed product of customers
	 */

	public function get_user_visited_product( $number, $text ) {
		global $woocommerce;
		$viewed_pro      = empty( $_COOKIE['vi_wcaio_woocommerce_recently_viewed'] ) ? array() : (array) explode( '|',
			$_COOKIE['vi_wcaio_woocommerce_recently_viewed'] );
		$viewed_pro      = array_unique( $viewed_pro );
		$viewed_pro      = array_filter( array_map( 'absint', $viewed_pro ) );
		$viewed_products = array();
		if ( ! empty( $viewed_pro ) ) {
			$viewed_products = $viewed_pro;

			ob_start();
			$query = array(
				'posts_per_page' => $number,
				'no_found_row'   => 1,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'post__in'       => $viewed_products,
				'orderby'        => 'rand',
				'meta_query'     => array(
					$woocommerce->query->stock_status_meta_query(),
				),
			);
			if ( 2 < $number ) {
				$class_list = 'vi_wcaio_products_plus_product';
			} else {
				$class_list = 'vi_wcaio_products_plus-content';
			}

			$the_query = new WP_Query( $query );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$product           = wc_get_product( get_the_ID() );
					$product_name      = $product->get_name();
					$thumbnail         = $product->get_image();
					$product_price     = $product->get_price_html();
					$product_permalink = $product->get_permalink();

					?>
                    <div class="vi_wcaio_products-plus_item ">
                        <div class="vi_wcaio_products-plus_item_img">
							<?php
							if ( empty( $product_permalink ) ) {
								echo $thumbnail;
							} else { ?>
                                <a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo $thumbnail ?>


                                </a>
							<?php }
							?>
                        </div>
                        <div class="vi_wcaio_products-plus_item_info">
                            <div class="">
								<?php
								if ( empty( $product_permalink ) ) {
									echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
										'...',
										30 ) : esc_attr( $product_name );
								} else { ?>
                                    <a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
											'...',
											30 ) : esc_attr( $product_name ) ?>
                                    </a>
								<?php }
								?>
                            </div>
                            <div class="">
                                <div class="">

									<?php echo $product_price ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
				}
			}
			wp_reset_postdata();
			$content = ob_get_clean();

			echo '<div class="vi_wcaio_list_product_plus" >
                    <div class="vi_wcaio_list_product_plus_title vi_wcaio_list_product_plus_title_viewed_pro">' . $text . '</div>
                    <div class="' . $class_list . '">' . $content . '</div>
                   </div>';
		}
	}

	/*
	 * get list best selling
	 */

	public function get_best_selling_product( $number, $text ) {
		if ( 2 < $number ) {
			$class_list = 'vi_wcaio_products_plus_product';
		} else {
			$class_list = 'vi_wcaio_products_plus-content';
		}
		ob_start();
		$args      = array(
			'post_type'      => 'product',
			'meta_key'       => 'total_sales',
			'order_by'       => 'meta_value meta_value_num',
			'posts_per_page' => $number,
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$product           = wc_get_product( get_the_ID() );
				$product_name      = $product->get_name();
				$thumbnail         = $product->get_image();
				$product_price     = $product->get_price_html();
				$product_permalink = $product->get_permalink();

				?>
                <div class="vi_wcaio_products-plus_item ">
                    <div class="vi_wcaio_products-plus_item_img">
						<?php
						if ( empty( $product_permalink ) ) {
							echo $thumbnail;
						} else { ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo $thumbnail ?>


                            </a>
						<?php }
						?>
                    </div>
                    <div class="vi_wcaio_products-plus_item_info">
                        <div class="">
							<?php
							if ( empty( $product_permalink ) ) {
								echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
									'...',
									30 ) : esc_attr( $product_name );
							} else { ?>
                                <a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
										'...',
										30 ) : esc_attr( $product_name ); ?>
                                </a>
							<?php }
							?>
                        </div>
                        <div class="">
                            <div class="">

								<?php echo $product_price ?>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
		wp_reset_postdata();
		$content = ob_get_clean();

		echo '<div class="vi_wcaio_list_product_plus" >
                    <div class="vi_wcaio_list_product_plus_title vi_wcaio_list_product_plus_title_best_selling">' . $text . '</div>
                    <div class="' . $class_list . '">' . $content . '</div>
                   </div>';

	}

	/*
	 * get top rated product
	 */

	public function get_rating_product( $number, $text ) {

		if ( 2 < $number ) {
			$class_list = 'vi_wcaio_products_plus_product';
		} else {
			$class_list = 'vi_wcaio_products_plus-content';
		}
		ob_start();
		$args      = array(
			'posts_per_page' => $number,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_key'       => '_wc_average_rating',
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'meta_query'     => WC()->query->get_meta_query(),
			'tax_query'      => WC()->query->get_tax_query(),
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$product           = wc_get_product( get_the_ID() );
				$product_name      = $product->get_name();
				$thumbnail         = $product->get_image();
				$product_price     = $product->get_price_html();
				$product_permalink = $product->get_permalink();

				?>
                <div class="vi_wcaio_products-plus_item ">
                    <div class="vi_wcaio_products-plus_item_img">
						<?php
						if ( empty( $product_permalink ) ) {
							echo $thumbnail;
						} else { ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo $thumbnail ?>


                            </a>
						<?php }
						?>
                    </div>
                    <div class="vi_wcaio_products-plus_item_info">
                        <div class="">
							<?php
							if ( empty( $product_permalink ) ) {
								echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
									'...',
									30 ) : esc_attr( $product_name );
							} else { ?>
                                <a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo ( strlen( $product_name ) > 30 ) ? substr_replace( esc_attr( $product_name ),
										'...',
										30 ) : esc_attr( $product_name ); ?>
                                </a>
							<?php }
							?>
                        </div>
                        <div class="">
                            <div class="">

								<?php echo $product_price ?>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
		wp_reset_postdata();
		$content = ob_get_clean();

		echo '<div class="vi_wcaio_list_product_plus" >
                    <div class="vi_wcaio_list_product_plus_title vi_wcaio_list_product_plus_title_rating_pro">' . $text . '</div>
                    <div class="' . $class_list . '">' . $content . '</div>
                   </div>';

	}

	private function get_params( $name = '' ) {
		return $this->settings->get_params( $name );
	}

	private function set( $name ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( $this, 'set' ), $name ) );

		} else {
			return esc_attr__( $this->prefix . $name );

		}
	}

	private function add_inline_style( $name, $element, $style, $suffix = '', $echo = false ) {
		$return = $element . '{';
		if ( is_array( $name ) && count( $name ) ) {
			foreach ( $name as $key => $value ) {
				$return .= $style[ $key ] . ':' . $this->get_params( $name[ $key ] ) . $suffix[ $key ] . ';';
			}
		}
		$return .= '}';
		if ( $echo ) {
			echo $return;
		}

		return $return;
	}
}