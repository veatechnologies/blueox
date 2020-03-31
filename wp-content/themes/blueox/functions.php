<?php
/**
 * WP Bootstrap 4 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_4
 */

if ( ! function_exists( 'wp_bootstrap_4_setup' ) ) :
	function wp_bootstrap_4_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'wp-bootstrap-4', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Enable Post formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'status', 'quote', 'link' ) );

		// Enable support for woocommerce.
		add_theme_support( 'woocommerce' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wp-bootstrap-4' ),
			'menu-top' => esc_html__( 'Top', 'wp-bootstrap-4' )
		) );

		// Switch default core markup for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_4_custom_background_args', array(
			'default-color' => 'f8f9fa',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_4_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_4_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_bootstrap_4_content_width', 800 );
}
add_action( 'after_setup_theme', 'wp_bootstrap_4_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_4_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs Sidebar', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Baseplate Finder Left', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-baseplate-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Baseplate Finder Middle', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-baseplate-2',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Baseplate Finder Right', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-baseplate-3',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'SwayPro Finder Left', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-swaypro-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'SwayPro Finder Middle', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-swaypro-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'SwayPro Finder Right', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-swaypro-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	//BXW series sidebar section
	register_sidebar( array(
		'name'          => esc_html__( 'Swaypro section', 'wp-bootstrap-4' ),
		'id'            => 'swaypro_section',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'wp-bootstrap-4' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'wp-bootstrap-4' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'wp-bootstrap-4' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'wp-bootstrap-4' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Cart items', 'wp-bootstrap-4' ),
		'id'            => 'cart-items',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );
	//Industry Leading Towing Equipment section
	register_sidebar(array(
		'name'          => esc_html__('Industry Towing Equipment section', 'wp-bootstrap-4' ),
		'id'            => 'industry_towing_equipment_section',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="nav-footer-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'wp_bootstrap_4_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_4_scripts() {
	wp_enqueue_style( 'open-iconic-bootstrap', get_template_directory_uri() . '/assets/css/open-iconic-bootstrap.css', array(), 'v4.0.0', 'all' );
	wp_enqueue_style( 'bootstrap-4', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), 'v4.0.0', 'all' );
	wp_enqueue_style( 'font-awesome-5', esc_url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'), array(), false );
	wp_enqueue_style( 'magnific-style', esc_url('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css'), array(), false );
	wp_enqueue_style( 'slick-style', esc_url('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css'), array(), false );
	wp_enqueue_style( 'slick-theme-style', esc_url('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css'), array(), false );

	$ctime = filemtime( get_template_directory() . '/assets/js/scripts.js' );
	wp_enqueue_style( 'blueox-style', get_stylesheet_uri(), array(), $ctime, false );

	$ctime_new = filemtime( get_template_directory() . '/assets/js/scripts.js' );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/custom.css', array(), $ctime_new, false );

	wp_enqueue_script( 'bootstrap-4-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), 'v4.0.0', true );
	wp_enqueue_script( 'blazy', esc_url('https://cdnjs.cloudflare.com/ajax/libs/blazy/1.8.2/blazy.min.js'), array('jquery'), '1.8.2', true );
	wp_enqueue_script( 'matchHeight', esc_url('https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js'), array('jquery'), '0.7.2', true );
	wp_enqueue_script( 'magnific-scripts', esc_url('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true );
	wp_enqueue_script( 'slick', esc_url('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js'), array('jquery'), '2.9.2', true );

	$jtime = filemtime( get_template_directory() . '/assets/js/scripts.js' );
	wp_enqueue_script( 'blueox-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), $jtime, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_4_scripts' );


/**
 * Registers an editor stylesheet for the theme.
 */
function wp_bootstrap_4_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'wp_bootstrap_4_add_editor_styles' );


// Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';

// Implement the Custom Comment feature.
require get_template_directory() . '/inc/custom-comment.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom Navbar
require get_template_directory() . '/inc/custom-navbar.php';

// Customizer additions.
require get_template_directory() . '/inc/tgmpa/tgmpa-init.php';

// Use Kirki for customizer API
require get_template_directory() . '/inc/theme-options/add-settings.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Load Jetpack compatibility file.
if( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Load WooCommerce compatibility file.
if( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    // return
    return $path;
}

// Jobs CUSTOM POST TYPE
add_action('init', 'register_jobs');

function register_jobs(){
    $args = array(
        'label' => __('Jobs'),
       	'singular_label' => __('Listing'),
       	'public' => true,
       	'show_ui' => true,
		'menu_icon' => 'dashicons-id-alt',
       	'capability_type' => 'post',
       	'hierarchical' => true,
		'rewrite' => array("slug" => "/careers",'with_front' => true), // Permalinks format
		'add_new' => __( 'Add New Listing' ),
		'add_new_item' => __( 'Add New Info' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Info' ),
		'new_item' => __( 'New Info' ),
		'view' => __( 'View Info' ),
		'view_item' => __( 'View Info' ),
		'search_items' => __( 'Search Listings' ),
		'not_found' => __( 'No info found' ),
		'not_found_in_trash' => __( 'No info found in Trash' ),
		'parent' => __( 'Parent Info' ),
//		'menu_position' =>__( 50 ),
       );

   	register_post_type( 'jobs' , $args );
}

// Automagically add Jobs to Jobs menu
add_filter( 'wp_get_nav_menu_items', 'cpt_custom_menu', 10, 3 );

function cpt_custom_menu( $items, $menu, $args ) {
  $child_items = array();
  $menu_order = count($items);
  $parent_item_id = 0;

  foreach ( $items as $item ) {
    if( in_array('jobs-menu', $item->classes) ) { //add this class to your menu item
        $parent_item_id = $item->ID;
    }
  }

  if( $parent_item_id >= 1 ) {
		$post->target = '';
		$post->attr_title = '';
		$post->description = '';
		$post->classes = '';
		$post->xfn = '';
		$post->status = 'publish';
		$post->original_title = '';

      foreach ( get_posts( 'post_type=jobs&numberposts=-1' ) as $post ) {
        $post->menu_item_parent = $parent_item_id;
        $post->post_type = 'nav_menu_item';
        $post->object = 'custom';
        $post->type = 'custom';
        $post->menu_order = ++$menu_order;
        $post->title = $post->post_title;
        $post->url = get_permalink( $post->ID );
		$post->target = '';
		$post->attr_title = '';
		$post->description = '';
		$post->classes = '';
		$post->xfn = '';
		$post->status = 'publish';
		$post->original_title = '';
        array_push( $child_items, $post );
      }

  }

  return array_merge( $items, $child_items );
}




function blueox_scrpits(){

/* FUNCTIONS BY KELLTON START */

//wp_enqueue_style( 'ktstyle_font', get_template_directory_uri() . '/assets/css/kt_fontawesome.min.css',false,rand(1,5),'all');
wp_enqueue_style( 'ktstyle_slider', get_template_directory_uri() . '/assets/css/kt_slick.css',false,rand(1,5),'all');
wp_enqueue_style( 'ktstyle', get_template_directory_uri() . '/assets/css/kt_style.css',false,rand(1,5),'all');
wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js',false,rand(1,5),'all');

}

add_action( 'wp_enqueue_scripts', 'blueox_scrpits' );

// Remove breadcrumbs from shop & categories
add_filter( 'woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_tabs', 98 );
function woo_remove_tabs( $tabs ){
    if(is_product()){
      unset( $tabs['description'] ); // Remove the description tab
      unset( $tabs['reviews'] ); // Remove the reviews tab
      unset( $tabs['additional_information'] ); // Remove the additional information tab
      }
  return $tabs;
 }

/**
 * Change number of related products output
 */
function woo_related_products_limit() {
  global $product;

	$args['posts_per_page'] = 8;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 8; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

//create a post type in woocommerce post pages
function product_section(){
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$product_id = get_post_meta($post->ID,'product_id', true);
	$product_related_yes = get_post_meta($post->ID,'product_related_yes', true);
	$product_related_no = get_post_meta($post->ID,'product_related_no', true);
	$product_text_content = get_post_meta($post->ID,'product_text_content', true);

	?><div class="wrap">
		<table class="form-table">
			<tbody class="input_fields_wrap_about_video">

				<!--<tr>

					<td><label><b>Show Additional Products Title</b></label><br> <input type='checkbox' name="product_related_yes" id="product_related_yes" value="1" <?php if($product_related_yes == '1'){  ?> checked="checked"<?php } ?> class="regular-text"><label>Yes</label>
					<input type='checkbox' name="product_related_no" id="product_related_no" value="0" <?php if($product_related_no == '0') { ?> checked="checked" <?php } ?> class="regular-text"><label>No</label></td>
				</tr>-->

				<tr>
					<td><label><b>Additional Products Title</b></label> <input type="text" name="product_text_content" id="product_text_content" value="<?php echo trim($product_text_content); ?>" class="regular-text"></td>

				</tr>
				

<tr>
					<td><label><b>Products Ids</b></label> <input type="text" name="product_id" id="product_id" value="<?php echo trim($product_id); ?>" class="regular-text"></td>

				</tr>
			</tbody>
		</table>

	</div><?php
}

function product_related_items(){
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$product_checkbox_yes = get_post_meta($post->ID,'product_checkbox_yes', true);
	$product_checkbox_no = get_post_meta($post->ID,'product_checkbox_no', true);
	
	?><div class="wrap">
		<table class="form-table">
			<tbody class="input_fields_wrap_about_video">
				<tr>
					<label><b>Show Related Products</b></label>
				</tr>
				<tr>
					<td><input type='checkbox' name="product_checkbox_yes" id="product_checkbox_yes" value="1" <?php if($product_checkbox_yes == '1'){  ?> checked="checked"<?php } ?> class="regular-text"><label>Yes</label>
					<input type='checkbox' name="product_checkbox_no" id="product_checkbox_no" value="0" <?php if($product_checkbox_no == '0') { ?> checked="checked" <?php } ?> class="regular-text"><label>No</label></td>
				</tr>



			</tbody>
		</table>

	</div><?php
}


function stock_products(){
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	
	$stock_id = get_post_meta($post->ID,'stock_id', true);
	?><div class="wrap">
		<table class="form-table">
			<tbody class="input_fields_wrap_about_video">
				
				<tr>
					 <input type="hidden" name="stock_id" id="stock_id" value="<?php echo trim($stock_id); ?>" class="regular-text"></td>

				</tr>
			</tbody>
		</table>

	</div><?php
}

function blueox_metaboxes() {
    global $post;

	if($post->post_type == "product"){
	add_meta_box('Product-ids','Products ID','product_section','product');
	add_meta_box('Product-products','Related Products','product_related_items','product');
	add_meta_box('Product-stock','','stock_products','product');
	}

}
add_action( 'add_meta_boxes', 'blueox_metaboxes' );


//for save the data of post type


function blueox_meta_save($post_id) {
	global $post;
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }


	if($post->post_type == "product"){
	$product_id= $_POST["product_id"];
	$product_related_yes= $_POST["product_related_yes"];
	$product_related_no= $_POST["product_related_no"];
	$product_text_content= $_POST["product_text_content"];
	$product_checkbox_yes= $_POST["product_checkbox_yes"];
	$product_checkbox_no= $_POST["product_checkbox_no"];

	update_post_meta($post_id,'product_id', $product_id);
	update_post_meta($post_id,'product_checkbox_yes', $product_checkbox_yes);
	update_post_meta($post_id,'product_checkbox_no', $product_checkbox_no);
	update_post_meta($post_id,'product_related_yes', $product_related_yes);
	update_post_meta($post_id,'product_related_no', $product_related_no);
	update_post_meta($post_id,'product_text_content', $product_text_content);
	}

}

add_action('save_post', 'blueox_meta_save' );

//product category content
add_action( 'woocommerce_after_shop_loop_item', 'woo_show_excerpt_shop_page', 5 );
function woo_show_excerpt_shop_page() {
	global $product;
	if(is_shop()) {
		echo '<p>' . $product->post->post_excerpt . '</p>';
	}
}

//number of products you wanna show per page
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 9;
  return $cols;
}
/* FUNCTIONS BY KELLTON ENDS */


add_filter( 'woocommerce_email_styles', 'mm_add_custom_woocommerce_email_styles', 10, 2 );
function mm_add_custom_woocommerce_email_styles( $css, $email ) {
	return $css . '
td h1 {
    color: #1b3d80 !important;
	text-align: center !important;
	font-size: 26px;
}
address.order_onhold h2 {
	color: #002d62;
}

table address h2 {
    margin-bottom: 0px !important;
}

table address address {
    border: 0px !important;
}

address table {
    margin-bottom: 0px !important;
}
';
}

// For Create Menu Download list
add_action('admin_menu', 'bor_plugin_menu');
function bor_plugin_menu() {
    if (is_admin()){
        add_menu_page('Import UserPrice','Download List', 'manage_options','prices', 'packageDataConfig','dashicons-arrow-down-alt',85); 

    }
}

function packageDataConfig(){
     package_manage_pressure();
}

function package_manage_pressure()
  {
	  ?>
	  <div class="content">
	
<div id="users_list" style="border: 1px solid; height: auto; padding-left: 50px; padding-right: 50px; display: 
<?php if(isset($_GET['upload_product_list'])){echo 'none';} else{echo 'block';}?>" >
       <h3>Download /Upload  Product List</h3>
	      <div class="box">  
  <table id="customers">
    <tr>
          
          <th>Download File</th>
           <th>Upload File</th>   
    </tr>
      
    <tr>
          
          <td><a href="<?php $url = admin_url(); ?>?page=prices&user_list=<?php echo $value->term_id; ?>&username=<?php echo $value->name; ?>&slug=<?php echo $value->slug; ?>" class="button-primary">Download</a></td>  
           <td><a href="<?php $url = admin_url(); ?>?page=prices&upload_product_list=<?php //echo $value->term_id; ?>" class="button-primary">Upload File</a></td>   
    </tr>
    <?php 
        
      ?>
  </table>
    </div>
	
	</div>
	     <?php if(isset($_GET['upload_product_list'])){?>
     <div id="texx" style="border: 1px solid; height: 201px; padding-left: 82px; margin-top: 50px;">
          <h3>Upload Product List</h3>
         <div class="box">  
         <form role="form" method="post" action="" method="post" enctype="multipart/form-data">
               <div class="box-body ml-6">
        <div class="form-group col-xs-6">
                   <input type="file" name="csv" value=""  id="file-7" class="inputfile inputfile-6 upload-file" />
                   <button type="submit" class="btn btn-primary newbtn" name="add_vpn_csv">Upload file</button>
                   
                   </div>
               </div>
            </form>
       
    </div>
  </div>
<?php } ?>

	   
      
 
<script type="text/javascript">
function download_reseller(page)
  {
    document.getElementById('users_list').style.display = 'block';
    document.getElementById('users_download_list').style.display = 'none';
    document.getElementById('vpn_list').style.display = 'none';
    document.getElementById('texx').style.display = 'none';

    
  }
 

</script>
<style>
#customers 
 {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
 }
#customers td, #customers th 
 {
  border: 1px solid #ddd;
  padding: 8px;
 }

#customers tr:nth-child(even){background-color: #f2f2f2;}
#customers tr:hover {background-color: #ddd;}
#customers th 
 {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;

    
  background-color: #23282d96;
  color: white;
  }

  .content {
    margin-top: 40px;
}

</style>
<?php
if(isset($_POST['add_vpn_csv']))
    {
      		if(isset($_FILES['csv']) && !empty($_FILES['csv']))
        	{
      			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
            	if(!empty($_FILES['csv']['name']) && in_array($_FILES['csv']['type'],$csvMimes))
            	{
            		if(is_uploaded_file($_FILES['csv']['tmp_name']))
                	{
                    	//open uploaded csv file with read only mode
	                    $csvFile = fopen($_FILES['csv']['tmp_name'], 'r');
	                    //skip first line
	                    $ss =fgetcsv($csvFile);
	                    $row =1;
	                    while(($line = fgetcsv($csvFile, 10000, ",")) !== FALSE)
                    	{
                    		if(!empty($line[0])){

                    			//$skuValue = wc_get_product($line[0]);
                    			$productid= $line[1];
                    			//$regularprice= $line[1];
                    			//$saleprice= $line[2];
                    			$stock= $line[2];
                    			
								/*if(!empty($productid)){
			
        							update_post_meta($productid, '_regular_price',$regularprice);
								}

								if(!empty($productid)){
			
        							update_post_meta($productid, '_price',$saleprice);
								}
*/
								if(!empty($productid)){
			
        							update_post_meta($productid, '_stock' ,$stock);
        							update_post_meta($productid, '_manage_stock' ,'yes');
								}
                    		}
                    		$row++; 
                    	}
                    	//close opened csv file
                    	fclose($csvFile);
                    	$error ="Successfully Imported";
						echo '<p style="color: white; background-color: green;width: 19%;">'.$error.'</p>';
	                }else{
	                	$error="Something went wrong";
         				echo '<p style="color: white; background-color: red;width: 19%;">'.$error.'</p>';
	                }

            	} else{
                	$error="Invalid File.";
         			echo '<p style="color: white; background-color: red;width: 19%;">'.$error.'</p>';
            	}
            }

       }
  ?>
  </div>
 <style type="text/css">
      button.newbtn {
      border: none;
            background-color: #d3394c;
            color: white;
            width: 135px;
           height: 55px;
           margin-top: 20px;}
      .upload-file {
        background: #fff7f7;
          padding: 15px !important;
          margin-top: 10px;
          color: #424242;
          border: 1px solid #d3394c;
      }
      
        </style>
  <?php
  }
 add_action("admin_init", "download_csv");
function download_csv() { 

 if (isset($_GET['user_list'])) {
	 global $wpdb;
  $user=$_GET['username'];
        $csv_output .= "Product Name,Product Id,Stock";
        $csv_output .= "\n";
		
		$args = array(
    'posts_per_page'   => -1,
    'orderby'          => 'name',
    'order'            => 'ASC',
    'post_type'        => 'product'
);
		
		
        $products1 = get_posts($args);
		
		 /* print_r($products1);
	
		exit;  */
        foreach ($products1 as $key => $value)
      {
		  
		  //print_r($value);
		$title= $value->post_title;
		$id= $value->ID;
		 //exit; 
			 
	$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",$title))).", "; 
	$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",$id))).", ";
	//$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",get_post_meta($value->ID, '_regular_price', true )))).", ";
	//$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",get_post_meta($value->ID, '_price', true )))).", "; 
	$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",get_post_meta($value->ID, '_stock', true )))); 
	//$csv_output .= trim(preg_replace('/\s\s+/', ' ',str_replace(",","",$user))).", ";
	$csv_output .= "\n";
		     
		
    }
	
	
$filename = 'blueox_'.$_GET['slug']."_Pricelist_".date("dmY_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");
print $csv_output;  
exit;   
  }


   }