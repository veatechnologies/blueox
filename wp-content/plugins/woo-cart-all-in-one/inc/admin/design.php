<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	require_once( ABSPATH . WPINC . '/class-wp-customize-control.php' );
}
if ( ! class_exists( 'VI_WCAIO_Customize_Range_Control' ) ) {
	class VI_WCAIO_Customize_Range_Control extends WP_Customize_Control {
		public $type = 'vi_wcaio_custom_range';
		protected $data = array();

		public function enqueue() {
			if ( ! is_customize_preview() ) {
				return;
			}
			wp_enqueue_style( 'woo-cart-all-in-one-customize-range',
				VI_WOO_CART_ALL_IN_ONE_CSS . 'range.css',
				array(),
				VI_WOO_CART_ALL_IN_ONE_VERSION );

			wp_enqueue_script( 'woo-cart-all-in-one-customize-preview-range',
				VI_WOO_CART_ALL_IN_ONE_JS . 'custom-preview-range.js',
				array(
					'jquery',
				),
				VI_WOO_CART_ALL_IN_ONE_VERSION,
				true );
			wp_enqueue_script(
				'woo-cart-all-in-one-customize-range-js',
				VI_WOO_CART_ALL_IN_ONE_JS . 'range.js',
				array( 'jquery' ),
				VI_WOO_CART_ALL_IN_ONE_VERSION,
				true
			);
		}

		public function render_content() {
			?>
            <label>
				<?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
                <div class="vi_wcaio_customize_range" style="display: flex; justify-content: space-between;">
                    <div class="ui range" <?php $this->input_attrs(); ?>
                         value="<?php echo esc_attr( $this->value() ); ?>"></div>
                    <input type="text" class="vi_wcaio_customize_range_value "
                           style="width: 36px;text-align: center; border-radius: 10px;"
                           value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
                </div>
                <div class="vi_wcaio_customize_range_min_max"
                     style="max-width: 85%;display: flex; justify-content: space-between;">
                    <span class="vi_wcaio_customize_range_min"><?php echo esc_attr( $this->input_attrs['min'] ); ?></span>
                    <span class="vi_wcaio_customize_range_max"><?php echo esc_attr( $this->input_attrs['max'] ); ?></span>
                </div>
            </label>
			<?php
		}
	}
}
if ( ! class_exists( 'VI_WCAIO_Customize_Checkbox_Control' ) ) {
	class VI_WCAIO_Customize_Checkbox_Control extends WP_Customize_Control {
		public $type = 'vi_wcaio_customize_checkbox';
		protected $data = array();

		public function enqueue() {

			wp_enqueue_style( 'woo-cart-all-in-one-customize-checkbox',
				VI_WOO_CART_ALL_IN_ONE_CSS . 'checkbox.min.css',
				array(),
				VI_WOO_CART_ALL_IN_ONE_VERSION );

			wp_enqueue_script( 'woo-cart-all-in-one-customize-preview-range',
				VI_WOO_CART_ALL_IN_ONE_JS . 'custom-preview-range.js',
				array(
					'jquery',
				),
				VI_WOO_CART_ALL_IN_ONE_VERSION,
				true );
			wp_enqueue_script(
				'woo-cart-all-in-one-customize-checkbox-js',
				VI_WOO_CART_ALL_IN_ONE_JS . 'checkbox.min.js',
				array( 'jquery' ),
				VI_WOO_CART_ALL_IN_ONE_VERSION,
				true
			);
		}

		public function render_content() {
			?>
            <label>
				<?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
                <div class="vi-ui toggle checkbox checked vi_wcaio_customize_checkbox_content">
                    <input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>"
                           name="<?php echo esc_attr( $this->id ); ?>" value="1" tabindex="0" <?php $this->link();
					checked( $this->value(), 1 ); ?> />
                </div>

            </label>
			<?php
		}
	}
}
if ( ! class_exists( 'VI_WCAIO_Customize_Radio_Control' ) ) {
	class VI_WCAIO_Customize_Radio_Control extends WP_Customize_Control {
		public $type = 'vi_wcaio_radio_cart_icon';
		protected $data = array();

		public function enqueue() {

			wp_enqueue_script( 'jquery-ui-button' );

			wp_enqueue_script( 'woo-cart-all-in-one-customize-preview-range',
				VI_WOO_CART_ALL_IN_ONE_JS . 'custom-preview-range.js',
				array(
					'jquery',
				),
				VI_WOO_CART_ALL_IN_ONE_VERSION,
				true );
		}

		public function render_content() {
			?>
            <label>
				<?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php
				foreach ( $this->choices as $choice => $value ) { ?>
                    <div class="vi_wcaio_radio_button_img">
                        <input type="radio" value="<?php echo esc_attr( $choice ); ?>"
                               name="_customize-<?php echo esc_attr( $this->type ) . '-' . esc_attr( $this->id ); ?>"
                               id="<?php echo esc_attr( $this->id ) . '-choice' . esc_attr( $choice ); ?>"
							<?php
							echo $this->link();
							echo ( $this->value() == $choice ) ? ' checked="checked" ' : ''; ?> />
                        <label for="<?php echo esc_attr( $this->id ) . '-choice' . esc_attr( $choice ); ?>"><?php echo $value ?></label>
                    </div>
					<?php
				}
				?>

            </label>
			<?php
		}
	}
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Design {
	protected $settings;
	protected $prefix;

	public function __construct() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$this->prefix   = 'wcaio_woo_art_all_in_one-';
		add_action( 'customize_register', array( $this, 'design_option_customizer' ) );
		add_action( 'wp_head', array( $this, 'customize_controls_print_styles' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ), 99 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 30 );
	}

	public function customize_controls_print_styles() {

		if ( ! is_customize_preview() ) {
			return;
		}
		$this->add_preview_style( 'sidebar_cart_content_radius', '.vi_wcaio_mini_cart_content', 'border-radius', 'px' );
		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-mini-cart-loading' ) ?>">
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-default div,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook div,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-roller div:after,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis div,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-spinner div:after,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls2 div,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls3 div,
            .vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook2 div {
                background: <?php echo $this->get_params('mini_cart_loading_color');  ?>;
            }

            .vi_wcaio_sidebar .vi_wcaio_loading-lds-dual-ring:after {
                border: 5px solid<?php echo $this->get_params('mini_cart_loading_color');  ?>;
                border-color: <?php echo $this->get_params('mini_cart_loading_color');  ?> transparent <?php echo $this->get_params('mini_cart_loading_color');  ?>  transparent;
            }

            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ring div {
                border: 6px solid<?php echo $this->get_params('mini_cart_loading_color');  ?>;
                border-color: <?php echo $this->get_params('mini_cart_loading_color');  ?> transparent transparent transparent;
            }

            .vi_wcaio_sidebar .vi_wcaio_loading-lds-ripple div {
                border: 4px solid<?php echo $this->get_params('mini_cart_loading_color');  ?>;
            }

        </style>
		<?php
		//sidebar icon
		$this->add_preview_style( 'sidebar_cart_icon_background',
			'.vi_wcaio_mini_cart_sidebar_icon',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_cart_icon_radius',
			'.vi_wcaio_mini_cart_sidebar_icon',
			'border-radius',
			'px' );
		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-sidebar-cart-icon-box-shadow' ) ?>">
            <?php
            if ($this->get_params( 'sidebar_cart_icon_box_shadow')==1){
            ?>
            .vi_wcaio_mini_cart_sidebar_icon {
                box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.17);
            }

            .vi_wcaio_mini_cart_sidebar_icon:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            }

            <?php
            }else{
                echo ' .vi_wcaio_mini_cart_sidebar_icon, .vi_wcaio_mini_cart_sidebar_icon:hover  {
                            box-shadow: unset;
                        }';
            }
            ?>
        </style>
        <style type="text/css" id="<?php echo $this->set( 'preview-sidebar-cart-icon-scale' ) ?>">
            <?php
            if ($this->get_params( 'sidebar_cart_icon_scale')){
            ?>
            .vi_wcaio_mini_cart_sidebar_icon {
                transform: scale(<?php echo $this->get_params('sidebar_cart_icon_scale'); ?>);
            }

            <?php
            }
            ?>
        </style>
        <style type="text/css" id="<?php echo $this->set( 'preview-sidebar-cart-icon-hover-scale' ) ?>">
            <?php
            if ($this->get_params( 'sidebar_cart_icon_hover_scale')){
            ?>
            .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_hover1 {
                transform: scale(<?php echo $this->get_params('sidebar_cart_icon_hover_scale'); ?>);
            }

            <?php
            }
            ?>
        </style>
		<?php
		$this->add_preview_style( 'sidebar_cart_icon_default_color',
			'.vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i ,
             .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :before ,
             .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :after',
			'color',
			'' );

		$this->add_preview_style( 'sidebar_cart_icon_text_background_color',
			'.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_cart_icon_text_color',
			'.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_cart_icon_text_radius',
			'.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two',
			'border-radius',
			'px' );

		//sidebar header
		$this->add_preview_style( 'sidebar_header_background_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title',
			'background-color',
			'' );
		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-sidebar-header-border' ) ?>">
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title {
                border-bottom: 1px<?php echo $this->get_params('sidebar_header_border').' '.$this->get_params('sidebar_header_border_color')?>;
            }
        </style>
		<?php
		$this->add_preview_style( 'sidebar_header_title_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title h5',
			'color',
			'' );


		$this->add_preview_style( 'sidebar_header_coupon_button_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_header_coupon_button_text_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_header_coupon_button_hover_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button:hover',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_header_coupon_button_text_color_hover',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button:hover',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_header_coupon_button_radius',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button',
			'border-radius',
			'px' );
		$this->add_preview_style( 'sidebar_header_coupon_input_radius',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  input#coupon_code.vi_wcaio_input_coupon-code ',
			'border-radius',
			'px' );

		//sidebar footer
		$this->add_preview_style( 'sidebar_footer_background_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer',
			'background-color',
			'' );
		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-sidebar-footer-border' ) ?>">
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer {
                border-top: 1px<?php echo $this->get_params('sidebar_footer_border').' '.$this->get_params('sidebar_footer_border_color')?>;
            }
        </style>
		<?php
		$this->add_preview_style( 'sidebar_footer_pro_plus_text_color',
			'  .vi_wcaio_list_product_plus_title ',
			'color',
			'' );

		$this->add_preview_style( 'sidebar_footer_total_color',
			' .vi_wcaio_mini_cart_sidebar_subtotal div:first-child, .vi_wcaio_mini_cart_sidebar_total div:first-child',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_footer_price_color',
			' .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_subtotal span.amount,.vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_total span.amount',
			'color',
			'' );

		$this->add_preview_style( 'sidebar_footer_button_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_footer_button_text_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_footer_button_hover_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input:hover',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_footer_button_text_color_hover',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input:hover',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_footer_button_radius',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input',
			'border-radius',
			'px' );

		$this->add_preview_style( 'sidebar_footer_update_button_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_footer_update_button_text_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_footer_update_button_hover_background',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update:hover',
			'background-color',
			'' );
		$this->add_preview_style( 'sidebar_footer_update_button_text_color_hover',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update:hover',
			'color',
			'' );
		$this->add_preview_style( 'sidebar_footer_update_button_radius',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update',
			'border-radius',
			'px' );

		//sidebar list pro
		$this->add_preview_style( 'list_pro_background_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content',
			'background-color',
			'' );
		$this->add_preview_style( 'list_pro_price_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content',
			'color',
			'' );
		$this->add_preview_style( 'list_pro_name_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a',
			'color',
			'' );
		$this->add_preview_style( 'list_pro_hover_name_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a:hover',
			'color',
			'' );
		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-list-pro-image-box-shadow' ) ?>">
            <?php
            if ($this->get_params( 'list_pro_image_box_shadow')==1){
            ?>
            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img {
                box-shadow: 0 0px 10px rgba(0, 0, 0, 0.07);
            }

            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img:hover {
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            }

            <?php
            }else{
                echo
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img, 
                .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img:hover{
                            box-shadow: unset;
                        }';
            }
            ?>
        </style>
		<?php
		$this->add_preview_style( 'list_pro_image_radius',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img',
			'border-radius',
			'px' );
		$this->add_preview_style( 'list_pro_remove_icon_color',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i',
			'color',
			'' );
		$this->add_preview_style( 'list_pro_remove_icon_color_hover',
			'.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i:hover',
			'color',
			'' );


		?>
        <style type="text/css" id="<?php echo $this->set( 'preview-menu-cart-icon-color' ) ?>">
            <?php
            if ($this->get_params('menu_cart_icon_color')!==''){
                ?>
            .vi_wcaio_mini_cart_menu_icon i, .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :before, .vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :after {
                color: <?php echo $this->get_params('menu_cart_icon_color') ?>;
            }

            <?php
		}
		 ?>
        </style>

        <style type="text/css" id="<?php echo $this->set( 'preview-menu-cart-icon-color-hover' ) ?>">
            <?php
            if ($this->get_params('menu_cart_icon_color_hover')!==''){
                ?>
            .vi_wcaio_menu_cart:hover .vi_wcaio_mini_cart_menu_icon i {
                color: <?php echo $this->get_params('menu_cart_icon_color_hover') ?>;
            }

            <?php
        }
         ?>
        </style>
        <style type="text/css" id="<?php echo $this->set( 'preview-menu-cart-style-one-text-color' ) ?>">
            <?php
            if ($this->get_params('menu_cart_style_one_text_color')!==''){
                ?>
            .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart_text_one span.amount {
                color: <?php echo $this->get_params('menu_cart_style_one_text_color') ?>;
            }

            <?php
		}
		 ?>
        </style>

        <style type="text/css" id="<?php echo $this->set( 'preview-menu-cart-style-one-text-color-hover' ) ?>">
            <?php
            if ($this->get_params('menu_cart_style_one_text_color_hover')!==''){
                ?>
            .vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart:hover .vi_wcaio_menu_cart_text_one span.amount {
                color: <?php echo $this->get_params('menu_cart_style_one_text_color_hover') ?>;
            }

            <?php
		}
		 ?>
        </style>


        <style type="text/css"
               id="<?php echo $this->set( 'preview-custom-css' ) ?>"><?php echo $this->get_params( 'custom_css' ) ?></style>
		<?php
	}

	private function set( $name ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( $this, 'set' ), $name ) );

		} else {
			return esc_attr__( $this->prefix . $name );

		}
	}

	private function get_params( $name = '' ) {
		return $this->settings->get_params( $name );
	}

	private function add_preview_style( $name, $element, $style, $suffix = '', $echo = true ) {
		ob_start();
		?>
        <style type="text/css"
               id="<?php echo $this->set( 'preview-' ) . str_replace( '_',
				       '-',
				       $name ) ?>"><?php echo $element . '{' . ( ( $this->get_params( $name ) === '' ) ? '' : ( $style . ':' . $this->get_params( $name ) . $suffix ) ) . '}' ?></style>
		<?php
		$return = ob_get_clean();
		if ( $echo ) {
			echo $return;
		}

		return $return;
	}

	public function customize_controls_print_scripts() {
		if ( ! is_customize_preview() ) {
			return;
		}
		?>
        <script type="text/javascript">

            if (typeof wp.customize !== 'undefined') {
                wp.customize.bind('ready', function () {

                });


            }
            jQuery(document).ready(function ($) {
                wp.customize.section('woo_cart_all_in_one_design_sidebar_general', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_open_cart_sidebar_content', 'show');
                        }
                    })
                });
                wp.customize.section('woo_cart_all_in_one_design_sidebar_header', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_open_cart_sidebar_content', 'show');
                        }
                    })
                });
                wp.customize.section('woo_cart_all_in_one_design_sidebar_footer', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_open_cart_sidebar_content', 'show');
                        }
                    })
                });
                wp.customize.section('woo_cart_all_in_one_design_sidebar_list_pro', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_open_cart_sidebar_content', 'show');
                        }
                    })
                });
                wp.customize.section('woo_cart_all_in_one_design_sidebar_icon', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_close_cart_sidebar_content', 'show');
                        }
                    })
                });
                wp.customize.section('woo_cart_all_in_one_design_menucart_general', function (section) {
                    section.expanded.bind(function (isExpanded) {
                        if (isExpanded) {
                            wp.customize.previewer.send('vi_wcaio_open_cart_menu_cart_content', 'show');
                        }
                    })
                });
            });
        </script>
		<?php
	}

	public function customize_controls_enqueue_scripts() {
		wp_enqueue_style( 'woo-cart-all-in-one-customize-preview-style',
			VI_WOO_CART_ALL_IN_ONE_CSS . 'customize-preview.css',
			array(),
			VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_enqueue_style( 'woo-cart-all-in-one-customize-icon',
			VI_WOO_CART_ALL_IN_ONE_CSS . 'mini-cart-icon.css',
			array(),
			VI_WOO_CART_ALL_IN_ONE_VERSION );
	}

	public function customize_preview_init() {
		wp_enqueue_script( 'woo-cart-all-in-one-customize-preview-js',
			VI_WOO_CART_ALL_IN_ONE_JS . 'customize-preview.js',
			array(
				'jquery',
				'customize-preview',
				'select2',
			),
			VI_WOO_CART_ALL_IN_ONE_VERSION,
			true );

		wp_localize_script( 'woo-cart-all-in-one-customize-preview-js',
			'woo_cart_all_in_one_params',
			array(
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'page_enable' => $this->get_params( 'mini_cart_sidebar_enable_pages' ),
			) );
	}


	public function design_option_customizer( $wp_customize ) {
		$this->add_section_design_general( $wp_customize );

		$this->add_section_design_sidebar_general( $wp_customize );

		$this->add_section_design_sidebar_icon( $wp_customize );
		$this->add_section_design_sidebar_header( $wp_customize );
		$this->add_section_design_sidebar_footer( $wp_customize );
		$this->add_section_design_sidebar_list_pro( $wp_customize );


		$this->add_section_design_menucart_general( $wp_customize );

		$this->add_section_design_custom_css( $wp_customize );

	}

	protected function add_section_design_general( $wp_customize ) {
		$wp_customize->add_panel( 'woo_cart_all_in_one_design_general',
			array(
				'priority'       => 200,
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Cart All In One For Woocommerce', 'woo-cart-all-in-one' ),
			) );
//sidebar cart
		$wp_customize->add_section( 'woo_cart_all_in_one_design_sidebar_general',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Sidebar Cart', 'woo-cart-all-in-one' ),

			) );
		$wp_customize->add_section( 'woo_cart_all_in_one_design_sidebar_icon',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Sidebar Cart Icon', 'woo-cart-all-in-one' ),

			) );

		$wp_customize->add_section( 'woo_cart_all_in_one_design_sidebar_header',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Sidebar Cart Header', 'woo-cart-all-in-one' ),

			) );
		$wp_customize->add_section( 'woo_cart_all_in_one_design_sidebar_footer',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Sidebar Cart Footer', 'woo-cart-all-in-one' ),

			) );
		$wp_customize->add_section( 'woo_cart_all_in_one_design_sidebar_list_pro',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Sidebar Cart List Products', 'woo-cart-all-in-one' ),

			) );
		//menu cart

		$wp_customize->add_section( 'woo_cart_all_in_one_design_menucart_general',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Menu Cart', 'woo-cart-all-in-one' ),

			) );
		//custom css

		$wp_customize->add_section( 'woo_cart_all_in_one_design_custom_css',
			array(
				'priority'       => 20,
				'panel'          => 'woo_cart_all_in_one_design_general',
				'capability'     => 'manage_options',
				'theme_supports' => '',
				'title'          => __( 'Custom CSS', 'woo-cart-all-in-one' ),

			) );

	}

	protected function add_section_design_custom_css( $wp_customize ) {
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[custom_css]',
			array(
				'default'           => $this->settings->get_default( 'custom_css' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( 'woo_cart_all_in_one_params[custom_css]',
			array(
				'type'     => 'textarea',
				'priority' => 10,
				'section'  => 'woo_cart_all_in_one_design_custom_css',
				'label'    => __( 'Custom CSS', 'woo-cart-all-in-one' ),
			) );
	}

	protected function add_section_design_menucart_general( $wp_customize ) {
		//menu cart navigation
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_navigation_page]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_navigation_page' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[menu_cart_navigation_page]',
			array(
				'label'    => esc_html__( 'Navigation Page', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[menu_cart_navigation_page]',
				'section'  => 'woo_cart_all_in_one_design_menucart_general',
				'choices'  => array(
					'1' => __( 'Cart page', 'woo-cart-all-in-one' ),
					'2' => __( 'Checkout page', 'woo-cart-all-in-one' ),
				),

			) );
		//show menu cart content
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_show_content]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_show_content' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[menu_cart_show_content]', array(
				'label'    => esc_html__( 'Show content cart', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[menu_cart_show_content]',
				'section'  => 'woo_cart_all_in_one_design_menucart_general',
			) ) );


		//menu cart icon
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_icon]',
			array(
				'default'    => $this->settings->get_default( 'menu_cart_icon' ),
				'type'       => 'option',
				'capability' => 'manage_options',
				'transport'  => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Radio_Control(
			$wp_customize,
			'woo_cart_all_in_one_params[menu_cart_icon]',
			array(
				'label'   => __( 'Cart icon Type', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_menucart_general',
				'choices' => array(
					'1'  => '<i class="vi_wcaio_cart_icon-commerce"></i>',
					'2'  => '<i class="vi_wcaio_cart_icon-shopping-cart-13"></i>',
					'3'  => '<i class="vi_wcaio_cart_icon-cart-of-ecommerce"></i>',
					'4'  => '<i class="vi_wcaio_cart_icon-shopping-cart-with-product-inside"></i>',
					'5'  => '<i class="vi_wcaio_cart_icon-plus"></i>',
					'6'  => '<i class="vi_wcaio_cart_icon-shopping-store-cart"></i>',
					'7'  => '<i class="vi_wcaio_cart_icon-shopping-cart-black-shape"></i>',
					'8'  => '<i class="vi_wcaio_cart_icon-shopping-cart-2"></i>',
					'9'  => '<i class="vi_wcaio_cart_icon-empty-shopping-cart"></i>',
					'10' => '<i class="vi_wcaio_cart_icon-supermarket-2"></i>',
					'11' => '<i class="vi_wcaio_cart_icon-cart-6"></i>',

					'12' => '<i class="vi_wcaio_cart_icon-shopping-cart-5"></i>',
					'13' => '<i class="vi_wcaio_cart_icon-sell"></i>',
					'14' => '<i class="vi_wcaio_cart_icon-supermarket-4"></i>',
					'15' => '<i class="vi_wcaio_cart_icon-supermarket-5"></i>',
					'16' => '<i class="vi_wcaio_cart_icon-shopping-cart-of-checkered-design"></i>',
					'17' => '<i class="vi_wcaio_cart_icon-shopping-cart-9"></i>',
					'18' => '<i class="vi_wcaio_cart_icon-buy"></i>',
					'19' => '<i class="vi_wcaio_cart_icon-grocery-trolley"></i>',


					'20' => '<i class="vi_wcaio_cart_icon-supermarket-6"></i>',
					'21' => '<i class="vi_wcaio_cart_icon-shopping-cart-4"></i>',
					'22' => '<i class="vi_wcaio_cart_icon-shopping-cart-11"></i>',
					'23' => '<i class="vi_wcaio_cart_icon-shopping-cart-16"></i>',
					'24' => '<i class="vi_wcaio_cart_icon-supermarket-3"></i>',
					'25' => '<i class="vi_wcaio_cart_icon-shopping-cart-15"></i>',
					'26' => '<i class="vi_wcaio_cart_icon-cart-1"></i>',
					'27' => '<i class="vi_wcaio_cart_icon-cart-7"></i>',
					'28' => '<i class="vi_wcaio_cart_icon-commerce-and-shopping"></i>',
					'29' => '<i class="vi_wcaio_cart_icon-shopping-cart-8"></i>',
					'30' => '<i class="vi_wcaio_cart_icon-cart-5"></i>',
					'31' => '<i class="vi_wcaio_cart_icon-supermarket"></i>',
					'32' => '<i class="vi_wcaio_cart_icon-shopping-cart-1"></i>',

					'33' => '<i class="vi_wcaio_cart_icon-online-shopping-cart"></i>',
					'34' => '<i class="vi_wcaio_cart_icon-cart-4"></i>',
					'35' => '<i class="vi_wcaio_cart_icon-shopping-cart-14"></i>',
					'36' => '<i class="vi_wcaio_cart_icon-shopping-cart-3"></i>',
					'37' => '<i class="vi_wcaio_cart_icon-cart-3"></i>',
					'38' => '<i class="vi_wcaio_cart_icon-shopping-cart-6"></i>',
					'39' => '<i class="vi_wcaio_cart_icon-shopping-cart-10"></i>',
					'40' => '<i class="vi_wcaio_cart_icon-shopping-cart-12"></i>',
					'41' => '<i class="vi_wcaio_cart_icon-cart-2"></i>',
					'42' => '<i class="vi_wcaio_cart_icon-commerce-1"></i>',
					'43' => '<i class="vi_wcaio_cart_icon-shopping-cart"></i>',
					'44' => '<i class="vi_wcaio_cart_icon-shopping-cart-7"></i>',
					'45' => '<i class="vi_wcaio_cart_icon-supermarket-1"></i>',
				),
			)
		) );

		//menu cart icon  color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_icon_color]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_icon_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[menu_cart_icon_color]',
				array(
					'label'    => __( 'Cart Icon Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_menucart_general',
					'settings' => 'woo_cart_all_in_one_params[menu_cart_icon_color]',
				) )
		);
		//menu cart icon h0ver  color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_icon_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_icon_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[menu_cart_icon_color_hover]',
				array(
					'label'    => __( 'Cart Icon Hover Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_menucart_general',
					'settings' => 'woo_cart_all_in_one_params[menu_cart_icon_color_hover]',
				) )
		);
		//menu cart style one text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_style_one_text]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_style_one_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[menu_cart_style_one_text]',
			array(
				'label'    => esc_html__( 'Menu Cart Text', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[menu_cart_style_one_text]',
				'section'  => 'woo_cart_all_in_one_design_menucart_general',
				'choices'  => array(
					'product_counter' => __( 'Product Counter', 'woo-cart-all-in-one' ),
					'price'           => __( 'Price', 'woo-cart-all-in-one' ),
					'all'             => __( 'Product Counter & Price', 'woo-cart-all-in-one' ),
				),

			) );
		//menu cart style one price
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_style_one_price]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_style_one_price' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[menu_cart_style_one_price]',
			array(
				'label'    => esc_html__( 'Menu Cart Price', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[menu_cart_style_one_price]',
				'section'  => 'woo_cart_all_in_one_design_menucart_general',
				'choices'  => array(
					'total'    => __( 'Total', 'woo-cart-all-in-one' ),
					'subtotal' => __( 'Subtotal', 'woo-cart-all-in-one' ),
				),

			) );
		//menu cart text  color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_style_one_text_color]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_style_one_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[menu_cart_style_one_text_color]',
				array(
					'label'    => __( 'Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_menucart_general',
					'settings' => 'woo_cart_all_in_one_params[menu_cart_style_one_text_color]',
				) )
		);
		//menu cart text hover color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[menu_cart_style_one_text_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'menu_cart_style_one_text_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[menu_cart_style_one_text_color_hover]',
				array(
					'label'    => __( 'Text Color Hover', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_menucart_general',
					'settings' => 'woo_cart_all_in_one_params[menu_cart_style_one_text_color_hover]',
				) )
		);


	}

	protected function add_section_design_sidebar_list_pro( $wp_customize ) {
		//sidebar list pro background color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_background_color]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_background_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_background_color]',
				array(
					'label'    => __( 'Background Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_background_color]',
				) )
		);

		//image enable box shadow
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_image_box_shadow]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_image_box_shadow' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[list_pro_image_box_shadow]', array(
				'label'    => esc_html__( 'Enable Image Box Shadow', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[list_pro_image_box_shadow]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
			) ) );

		//image border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_image_radius]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_image_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[list_pro_image_radius]',
			array(
				'label'       => esc_html__( 'Product Image border radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_list_pro',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_list_pro_image_radius',
				),
			)
		) );


		//name color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_name_color]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_name_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_name_color]',
				array(
					'label'    => __( 'Name Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_name_color]',
				) )
		);

		//sidebar list pro name color hover

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_hover_name_color]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_hover_name_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_hover_name_color]',
				array(
					'label'    => __( 'Name Hover Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_hover_name_color]',
				) )
		);

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[list_pro_qty_enable]', array(
				'label'    => esc_html__( 'Enable Product Quantity', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[list_pro_qty_enable]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
			) ) );

		//price & qty color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_price_color]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_price_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_price_color]',
				array(
					'label'    => __( 'Price Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_price_color]',
				) )
		);


		//delete icon style
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_remove_icon_style]',
			array(
				'default'    => $this->settings->get_default( 'list_pro_remove_icon_style' ),
				'type'       => 'option',
				'capability' => 'manage_options',
				'transport'  => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Radio_Control(
			$wp_customize,
			'woo_cart_all_in_one_params[list_pro_remove_icon_style]',
			array(
				'label'   => __( 'Trash Icon Style', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_list_pro',
				'choices' => array(
					'1'  => '<i class="vi_wcaio_cart_icon-rubbish-bin-delete-button"></i>',
					'2'  => '<i class="vi_wcaio_cart_icon-delete-1"></i>',
					'3'  => '<i class="vi_wcaio_cart_icon-waste-bin"></i>',
					'4'  => '<i class="vi_wcaio_cart_icon-trash "></i>',
					'5'  => '<i class="vi_wcaio_cart_icon-garbage-1"></i>',
					'6'  => '<i class="vi_wcaio_cart_icon-delete-button"></i>',
					'7'  => '<i class="vi_wcaio_cart_icon-delete"></i>',
					'8'  => '<i class="vi_wcaio_cart_icon-rubbish-bin"></i>',
					'9'  => '<i class="vi_wcaio_cart_icon-dustbin"></i>',
					'10' => '<i class="vi_wcaio_cart_icon-garbage"></i>',
				),
			)
		) );

		//delete icon color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_remove_icon_color]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_remove_icon_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_remove_icon_color]',
				array(
					'label'    => __( 'Trash Icon Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_remove_icon_color]',
				) )
		);
		//delete icon color hover

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[list_pro_remove_icon_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'list_pro_remove_icon_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[list_pro_remove_icon_color_hover]',
				array(
					'label'    => __( 'Trash Icon Hover Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_list_pro',
					'settings' => 'woo_cart_all_in_one_params[list_pro_remove_icon_color_hover]',
				) )
		);
	}

	protected function add_section_design_sidebar_footer( $wp_customize ) {
		//sidebar footer background color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_background_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_background_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_background_color]',
				array(
					'label'    => __( 'Background Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_background_color]',
				) )
		);
		//sidebar footer border
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_border]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_border' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_footer_border]',
			array(
				'label'   => __( 'Footer Border Style ', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
				'type'    => 'radio',
				'choices' => array(
					'none'   => __( 'No border', 'woo-cart-all-in-one' ),
					'solid'  => __( 'Solid', 'woo-cart-all-in-one' ),
					'dotted' => __( 'Dotted', 'woo-cart-all-in-one' ),
					'dashed' => __( 'Dashed', 'woo-cart-all-in-one' ),
				),
			)
		);
		//sidebar footer border color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_border_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_border_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_border_color]',
				array(
					'label'    => __( 'Footer Border Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_border_color]',
				) )
		);

		//sidebar footer Price to display
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_price_enable]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_price_enable' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_footer_price_enable]',
			array(
				'label'    => esc_html__( 'Price to display', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[sidebar_footer_price_enable]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
				'choices'  => array(
					'subtotal' => __( 'Subtotal (total of products)', 'woo-cart-all-in-one' ),
					'total'    => __( 'Cart total', 'woo-cart-all-in-one' ),
				),

			) );

		//sidebar footer text total color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_total_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_total_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_total_color]',
				array(
					'label'    => __( 'Total Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_total_color]',
				) )
		);

		//sidebar footer price color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_price_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_price_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_price_color]',
				array(
					'label'    => __( 'Price Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_price_color]',
				) )
		);

		//sidebar footer button enable
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_enable]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_enable' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_footer_button_enable]',
			array(
				'label'    => esc_html__( 'Button Enable', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[sidebar_footer_button_enable]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
				'choices'  => array(
					'cart'     => __( 'View cart ', 'woo-cart-all-in-one' ),
					'checkout' => __( 'Checkout ', 'woo-cart-all-in-one' ),
				),

			) );

		//sidebar footer cart button text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_cart_button_text]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_cart_button_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_cart_button_text]',
			array(
				'label'   => __( 'View Cart Button Text', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );
		//sidebar footer checkout button text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_checkout_button_text]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_checkout_button_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_checkout_button_text]',
			array(
				'label'   => __( 'Checkout Button Text', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );

		//sidebar footer button background
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_button_background]',
				array(
					'label'    => __( 'Button Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_button_background]',
				) )
		);

		//sidebar footer button text color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_text_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_button_text_color]',
				array(
					'label'    => __( 'Button Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_button_text_color]',
				) )
		);
		//sidebar footer button hover background color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_hover_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_hover_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_button_hover_background]',
				array(
					'label'    => __( 'Button Hover Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_button_hover_background]',
				) )
		);
		//sidebar footer button text color hover
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_text_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_text_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_button_text_color_hover]',
				array(
					'label'    => __( 'Button Hover Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_button_text_color_hover]',
				) )
		);

		//sidebar footer button border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_button_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_button_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_footer_button_radius]',
			array(
				'label'       => esc_html__( 'Button radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_footer',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_sidebar_footer_button_radius',
				),
			)
		) );

		//sidebar footer update button background
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_update_button_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_update_button_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_update_button_background]',
				array(
					'label'    => __( 'Update Button Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_update_button_background]',
				) )
		);

		//sidebar footer update button text color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_update_button_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color]',
				array(
					'label'    => __( 'Update Button Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color]',
				) )
		);
		//sidebar footer update button hover background color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_update_button_hover_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_update_button_hover_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_update_button_hover_background]',
				array(
					'label'    => __( 'Update Button Hover Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_update_button_hover_background]',
				) )
		);
		//sidebar footer update button text color hover
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_update_button_text_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color_hover]',
				array(
					'label'    => __( 'Update Button Hover Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_update_button_text_color_hover]',
				) )
		);

		//sidebar footer update button border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_update_button_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_update_button_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_footer_update_button_radius]',
			array(
				'label'       => esc_html__( 'Button radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_footer',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_sidebar_footer_update_button_radius',
				),
			)
		) );

		//sidebar footer product plus enable
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_enable]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_pro_plus_enable' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_footer_pro_plus_enable]',
			array(
				'label'    => esc_html__( 'Show Products Plus', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_enable]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
				'choices'  => array(
					'none'           => __( 'Don\'t show', 'woo-cart-all-in-one' ),
					'best_selling'   => __( 'Best selling Products ', 'woo-cart-all-in-one' ),
					'viewed_product' => __( 'Recently viewed products ', 'woo-cart-all-in-one' ),
					'product_rating' => __( 'Top rated Products ', 'woo-cart-all-in-one' ),
				),
			) );


		//sidebar footer checkout best selling text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_best_selling_text]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_best_selling_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_best_selling_text]',
			array(
				'label'   => __( 'Best Selling Title', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );
		//sidebar footer checkout viewed product text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_viewed_pro_text]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_viewed_pro_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_viewed_pro_text]',
			array(
				'label'   => __( 'Title For Viewed Products', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );
		//sidebar footer checkout top rated product text
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_rating_pro_text]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_rating_pro_text' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_rating_pro_text]',
			array(
				'label'   => __( 'Top Rated Title', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );

		//sidebar footer product plus text color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_text_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_pro_plus_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_footer_pro_plus_text_color]',
				array(
					'label'    => __( 'Product Plus Title Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_footer',
					'settings' => 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_text_color]',
				) )
		);
		//sidebar footer product plus number
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_number]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_footer_pro_plus_number' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_footer_pro_plus_number]',
			array(
				'label'   => __( 'Number Of Products To Show', 'woo-cart-all-in-one' ),
				'type'    => 'number',
				'section' => 'woo_cart_all_in_one_design_sidebar_footer',
			) );

	}

	protected function add_section_design_sidebar_header( $wp_customize ) {
		//sidebar header background color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_background_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_background_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_background_color]',
				array(
					'label'    => __( 'Background Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_background_color]',
				) )
		);

		//sidebar header border
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_border]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_border' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_header_border]',
			array(
				'label'   => __( 'Header Border Style ', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_header',
				'type'    => 'radio',
				'choices' => array(
					'none'   => __( 'No border', 'woo-cart-all-in-one' ),
					'solid'  => __( 'Solid', 'woo-cart-all-in-one' ),
					'dotted' => __( 'Dotted', 'woo-cart-all-in-one' ),
					'dashed' => __( 'Dashed', 'woo-cart-all-in-one' ),
				),
			)
		);
		//sidebar header border color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_border_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_border_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_border_color]',
				array(
					'label'    => __( 'Header Border Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_border_color]',
				) )
		);

		//sidebar header title
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_title]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_title' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_header_title]',
			array(
				'label'   => __( 'Cart Title', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_header',
			) );

		//sidebar header title color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_title_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_title_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_title_color]',
				array(
					'label'    => __( 'Title Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_title_color]',
				) )
		);

		//coupon enable
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_enable]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_enable' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_header_coupon_enable]', array(
				'label'    => esc_html__( 'Enable Coupon', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[sidebar_header_coupon_enable]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_header',
			) ) );


		//sidebar coupon input border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_input_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_input_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_header_coupon_input_radius]',
			array(
				'label'       => esc_html__( 'Coupon Input Radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_header',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_sidebar_header_coupon_input_radius',
				),
			)
		) );

		//sidebar coupon button background
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_button_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_button_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_coupon_button_background]',
				array(
					'label'    => __( 'Apply Coupon Button Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_coupon_button_background]',
				) )
		);

		//sidebar coupon button text color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_button_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color]',
				array(
					'label'    => __( 'Apply Coupon Button Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color]',
				) )
		);
		//sidebar coupon button hover background color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_button_hover_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_button_hover_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_coupon_button_hover_background]',
				array(
					'label'    => __( 'Apply Coupon Button Hover Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_coupon_button_hover_background]',
				) )
		);
		//sidebar coupon button text color hover
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color_hover]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_button_text_color_hover' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color_hover]',
				array(
					'label'    => __( 'Apply Coupon Button Hover Text Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_header',
					'settings' => 'woo_cart_all_in_one_params[sidebar_header_coupon_button_text_color_hover]',
				) )
		);

		//sidebar coupon button border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_header_coupon_button_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_header_coupon_button_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_header_coupon_button_radius]',
			array(
				'label'       => esc_html__( 'Apply Coupon Button Radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_header',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_sidebar_header_coupon_button_radius',
				),
			)
		) );
	}

	protected function add_section_design_sidebar_icon( $wp_customize ) {
		//cart icon box shadow
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_box_shadow]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_box_shadow' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_cart_icon_box_shadow]', array(
				'label'    => esc_html__( 'Enable Box Shadow', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_box_shadow]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
			) ) );

		//cart icon background color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_background]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_background' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_cart_icon_background]',
				array(
					'label'    => __( 'Cart Icon Background', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
					'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_background]',
				) )
		);

		//cart icon reduce size

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_scale]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_scale' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_cart_icon_scale]',
			array(
				'label'   => __( 'Reduce size', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_icon',
			) );


		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_hover_scale]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_hover_scale' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( 'woo_cart_all_in_one_params[sidebar_cart_icon_hover_scale]',
			array(
				'label'   => __( 'Reduce size when hovering', 'woo-cart-all-in-one' ),
				'type'    => 'text',
				'section' => 'woo_cart_all_in_one_design_sidebar_icon',
			) );

		//cart icon text border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_cart_icon_radius]',
			array(
				'label'       => esc_html__( 'Cart Icon radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_icon',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_cart_icon_radius',
				),
			)
		) );

		//cart icon default style
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_default_style]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_default_style' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_cart_icon_default_style]',
			array(
				'label'    => esc_html__( 'Cart Style', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_default_style]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
				'choices'  => array(
					'1' => __( 'Style one', 'woo-cart-all-in-one' ),
					'2' => __( 'Style two', 'woo-cart-all-in-one' ),
					'3' => __( 'Style three', 'woo-cart-all-in-one' ),
					'4' => __( 'Style four', 'woo-cart-all-in-one' ),
				),

			) );
		//cart icon default
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_default_icon]',
			array(
				'default'    => $this->settings->get_default( 'sidebar_cart_icon_default_icon' ),
				'type'       => 'option',
				'capability' => 'manage_options',
				'transport'  => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Radio_Control(
			$wp_customize,
			'woo_cart_all_in_one_params[sidebar_cart_icon_default_icon]',
			array(
				'label'   => __( 'Cart icon Type', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_icon',
				'choices' => array(
					'1'  => '<i class="vi_wcaio_cart_icon-commerce"></i>',
					'2'  => '<i class="vi_wcaio_cart_icon-shopping-cart-13"></i>',
					'3'  => '<i class="vi_wcaio_cart_icon-cart-of-ecommerce"></i>',
					'4'  => '<i class="vi_wcaio_cart_icon-shopping-cart-with-product-inside"></i>',
					'5'  => '<i class="vi_wcaio_cart_icon-plus"></i>',
					'6'  => '<i class="vi_wcaio_cart_icon-shopping-store-cart"></i>',
					'7'  => '<i class="vi_wcaio_cart_icon-shopping-cart-black-shape"></i>',
					'8'  => '<i class="vi_wcaio_cart_icon-shopping-cart-2"></i>',
					'9'  => '<i class="vi_wcaio_cart_icon-empty-shopping-cart"></i>',
					'10' => '<i class="vi_wcaio_cart_icon-supermarket-2"></i>',
					'11' => '<i class="vi_wcaio_cart_icon-cart-6"></i>',

					'12' => '<i class="vi_wcaio_cart_icon-shopping-cart-5"></i>',
					'13' => '<i class="vi_wcaio_cart_icon-sell"></i>',
					'14' => '<i class="vi_wcaio_cart_icon-supermarket-4"></i>',
					'15' => '<i class="vi_wcaio_cart_icon-supermarket-5"></i>',
					'16' => '<i class="vi_wcaio_cart_icon-shopping-cart-of-checkered-design"></i>',
					'17' => '<i class="vi_wcaio_cart_icon-shopping-cart-9"></i>',
					'18' => '<i class="vi_wcaio_cart_icon-buy"></i>',
					'19' => '<i class="vi_wcaio_cart_icon-grocery-trolley"></i>',


					'20' => '<i class="vi_wcaio_cart_icon-supermarket-6"></i>',
					'21' => '<i class="vi_wcaio_cart_icon-shopping-cart-4"></i>',
					'22' => '<i class="vi_wcaio_cart_icon-shopping-cart-11"></i>',
					'23' => '<i class="vi_wcaio_cart_icon-shopping-cart-16"></i>',
					'24' => '<i class="vi_wcaio_cart_icon-supermarket-3"></i>',
					'25' => '<i class="vi_wcaio_cart_icon-shopping-cart-15"></i>',
					'26' => '<i class="vi_wcaio_cart_icon-cart-1"></i>',
					'27' => '<i class="vi_wcaio_cart_icon-cart-7"></i>',
					'28' => '<i class="vi_wcaio_cart_icon-commerce-and-shopping"></i>',
					'29' => '<i class="vi_wcaio_cart_icon-shopping-cart-8"></i>',
					'30' => '<i class="vi_wcaio_cart_icon-cart-5"></i>',
					'31' => '<i class="vi_wcaio_cart_icon-supermarket"></i>',
					'32' => '<i class="vi_wcaio_cart_icon-shopping-cart-1"></i>',

					'33' => '<i class="vi_wcaio_cart_icon-online-shopping-cart"></i>',
					'34' => '<i class="vi_wcaio_cart_icon-cart-4"></i>',
					'35' => '<i class="vi_wcaio_cart_icon-shopping-cart-14"></i>',
					'36' => '<i class="vi_wcaio_cart_icon-shopping-cart-3"></i>',
					'37' => '<i class="vi_wcaio_cart_icon-cart-3"></i>',
					'38' => '<i class="vi_wcaio_cart_icon-shopping-cart-6"></i>',
					'39' => '<i class="vi_wcaio_cart_icon-shopping-cart-10"></i>',
					'40' => '<i class="vi_wcaio_cart_icon-shopping-cart-12"></i>',
					'41' => '<i class="vi_wcaio_cart_icon-cart-2"></i>',
					'42' => '<i class="vi_wcaio_cart_icon-commerce-1"></i>',
					'43' => '<i class="vi_wcaio_cart_icon-shopping-cart"></i>',
					'44' => '<i class="vi_wcaio_cart_icon-shopping-cart-7"></i>',
					'45' => '<i class="vi_wcaio_cart_icon-supermarket-1"></i>',
				),
			)
		) );

		//cart icon default color

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_default_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_default_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_cart_icon_default_color]',
				array(
					'label'    => __( 'Cart Icon Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
					'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_default_color]',
				) )
		);


		//cart icon text color
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_text_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_text_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_cart_icon_text_color]',
				array(
					'label'    => __( 'Product Counter Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
					'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_text_color]',
				) )
		);

		//cart icon text background
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_text_background_color]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_text_background_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[sidebar_cart_icon_text_background_color]',
				array(
					'label'    => __( 'Product Counter Background Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_icon',
					'settings' => 'woo_cart_all_in_one_params[sidebar_cart_icon_text_background_color]',
				) )
		);

		//cart icon text border radius

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_icon_text_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_icon_text_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_cart_icon_text_radius]',
			array(
				'label'       => esc_html__( 'Product Counter border radius(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_icon',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 30,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_icon_text_radius',
				),
			)
		) );


	}

	protected function add_section_design_sidebar_general( $wp_customize ) {

		//sidebar position
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_content_display]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_content_display' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_content_display]',
			array(
				'label'   => __( 'Display sidebar content', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_general',
				'type'    => 'select',
				'choices' => array(
					'0' => __( 'Style one', 'woo-cart-all-in-one' ),
					'1' => __( 'Style two', 'woo-cart-all-in-one' ),
				),
			)
		);
		//sidebar position
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_position]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_position' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_position]',
			array(
				'label'   => __( 'Sidebar Cart Position', 'woo-cart-all-in-one' ),
				'section' => 'woo_cart_all_in_one_design_sidebar_general',
				'type'    => 'radio',
				'choices' => array(
					'top_left'     => __( 'Top Left', 'woo-cart-all-in-one' ),
					'top_right'    => __( 'Top Right', 'woo-cart-all-in-one' ),
					'bottom_left'  => __( 'Bottom Left', 'woo-cart-all-in-one' ),
					'bottom_right' => __( 'Bottom Right', 'woo-cart-all-in-one' ),
				),
			)
		);

		//sidebar offset
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_horizontal]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_horizontal' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_horizontal]',
			array(
				'label'       => esc_html__( 'Sidebar Cart Horizontal(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_general',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_range_horizontal',
				),
			)
		) );
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_vertical]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_vertical' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_vertical]',
			array(
				'label'       => esc_html__( 'Sidebar Cart Vertical(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_general',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_range_vertical',
				),
			)
		) );

		//sidebar content border radius
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_cart_content_radius]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_cart_content_radius' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
		$wp_customize->add_control( new VI_WCAIO_Customize_Range_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_cart_content_radius]',
			array(
				'label'       => esc_html__( 'Border Radius For Sidebar Cart Content(px)', 'woo-cart-all-in-one' ),
				'section'     => 'woo_cart_all_in_one_design_sidebar_general',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
					'id'   => 'vi_wcaio_customize_sidebar_content_radius',
				),
			)
		) );

		//open cart after add pro

		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_open]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_open' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_open]', array(
				'label'    => esc_html__( 'Open Cart After Add Product', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[sidebar_open]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
			) ) );

		//fly to cart
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_fly_img]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_fly_img' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control( new VI_WCAIO_Customize_Checkbox_Control( $wp_customize,
			'woo_cart_all_in_one_params[sidebar_fly_img]', array(
				'label'    => esc_html__( 'Fly To Cart', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[sidebar_fly_img]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
			) ) );


		//shake trigger
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_shake_trigger]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_shake_trigger' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_shake_trigger]',
			array(
				'label'    => esc_html__( 'Shake Effect Cart After Add Product', 'woo-cart-all-in-one' ),
				'settings' => 'woo_cart_all_in_one_params[sidebar_shake_trigger]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
				'type'     => 'radio',
				'choices'  => array(
					'none'   => __( 'No Shake', 'woo-cart-all-in-one' ),
					'shake'  => __( 'Shake Horizontal', 'woo-cart-all-in-one' ),
					'bounce' => __( 'Shake Vertical', 'woo-cart-all-in-one' ),
				),
			)
		);


		//show cart content style
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_show_cart_style]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_show_cart_style' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_show_cart_style]',
			array(
				'label'    => esc_html__( 'Sidebar Trigger Event Style', 'woo-cart-all-in-one' ),
				'type'     => 'radio',
				'settings' => 'woo_cart_all_in_one_params[sidebar_show_cart_style]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
				'choices'  => array(
					'1' => __( 'Style One', 'woo-cart-all-in-one' ),
					'2' => __( 'Style Two', 'woo-cart-all-in-one' ),
					'3' => __( 'Style Three', 'woo-cart-all-in-one' ),
					'4' => __( 'Style Four', 'woo-cart-all-in-one' ),
					'5' => __( 'Style Five', 'woo-cart-all-in-one' ),
					'6' => __( 'Style Six', 'woo-cart-all-in-one' ),
					'7' => __( 'Style Seven', 'woo-cart-all-in-one' ),
				),

			) );

		//mini cart loading
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[mini_cart_loading]',
			array(
				'default'           => $this->settings->get_default( 'mini_cart_loading' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[mini_cart_loading]',
			array(
				'label'    => esc_html__( 'Loading Type', 'woo-cart-all-in-one' ),
				'type'     => 'radio',
				'settings' => 'woo_cart_all_in_one_params[mini_cart_loading]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
				'choices'  => array(
					'0' => __( 'Hidden', 'woo-cart-all-in-one' ),
					'1' => __( 'Default', 'woo-cart-all-in-one' ),
					'2' => __( 'Dual Ring', 'woo-cart-all-in-one' ),

					'3' => __( 'Animation Facebook 1', 'woo-cart-all-in-one' ),
					'4' => __( 'Animation Facebook 2', 'woo-cart-all-in-one' ),

					'5' => __( 'Ring', 'woo-cart-all-in-one' ),
					'6' => __( 'Roller', 'woo-cart-all-in-one' ),

					'7' => __( 'Loader Balls 1', 'woo-cart-all-in-one' ),
					'8' => __( 'Loader Balls 2', 'woo-cart-all-in-one' ),
					'9' => __( 'Loader Balls 3', 'woo-cart-all-in-one' ),

					'10' => __( 'Ripple', 'woo-cart-all-in-one' ),
					'11' => __( 'Spinner', 'woo-cart-all-in-one' ),
				),

			) );
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[mini_cart_loading_color]',
			array(
				'default'           => $this->settings->get_default( 'mini_cart_loading_color' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_all_in_one_params[mini_cart_loading_color]',
				array(
					'label'    => __( 'Loading Color', 'woo-cart-all-in-one' ),
					'section'  => 'woo_cart_all_in_one_design_sidebar_general',
					'settings' => 'woo_cart_all_in_one_params[mini_cart_loading_color]',
				) )
		);

		//show cart content
		$wp_customize->add_setting( 'woo_cart_all_in_one_params[sidebar_show_cart_type]',
			array(
				'default'           => $this->settings->get_default( 'sidebar_show_cart_type' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );

		$wp_customize->add_control(
			'woo_cart_all_in_one_params[sidebar_show_cart_type]',
			array(
				'label'    => esc_html__( 'Sidebar Trigger Event Type', 'woo-cart-all-in-one' ),
				'type'     => 'select',
				'settings' => 'woo_cart_all_in_one_params[sidebar_show_cart_type]',
				'section'  => 'woo_cart_all_in_one_design_sidebar_general',
				'choices'  => array(
					'hover' => __( 'MouseOver', 'woo-cart-all-in-one' ),
					'click' => __( 'Click', 'woo-cart-all-in-one' ),
				),

			) );
	}
}