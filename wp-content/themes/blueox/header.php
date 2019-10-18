<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_4
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/assets/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/assets/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/assets/images/favicon-16x16.png">
	<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/assets/images/site.webmanifest">
	<link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/assets/images/safari-pinned-tab.svg" color="#002d62">
	<meta name="apple-mobile-web-app-title" content="Blue Ox">
	<meta name="application-name" content="Blue Ox">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php bloginfo('template_directory'); ?>/assets/images/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>
	<?php if( get_field('header-code', 'options') ) { ?>

		<?php the_field('header-code', 'option'); ?>

	<?php } ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-4' ); ?></a>

	<header id="masthead" class="site-header <?php if ( get_theme_mod( 'sticky_header', 0 ) ) : echo 'sticky-top'; endif; ?> pt-3 pb-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4 d-flex justify-content-start align-middle">

					<?php the_custom_logo(); ?>

				</div>

				<div class="col-sm-8">

					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location'  => 'menu-top',
								'menu_id'         => 'top-menu',
								'container'       => 'div',
								'container_class' => 'top-navigation text-right',
								'container_id'    => '',
								'menu_class'      => 'navbar navbar-expand-lg list-unstyled',
								'fallback_cb'     => '__return_false',
								'depth'           => 1,
								'walker'          => new WP_bootstrap_4_walker_nav_menu()
							) );
						?>
					</div>
					<nav id="site-navigation" class="main-navigation navbar justify-content-start align-middle">
						<?php if( get_theme_mod( 'header_within_container', 0 ) ) : ?><div class="container"><?php endif; ?>
							<?php
								wp_nav_menu( array(
									'theme_location'  => 'menu-1',
									'menu_id'         => 'primary-menu',
									'container'       => 'div',
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => '',
						            'fallback_cb'     => '__return_false',
						            'depth'           => 2,
						            'walker'          => new WP_bootstrap_4_walker_nav_menu()
								) );
							?>
						<?php if( get_theme_mod( 'header_within_container', 0 ) ) : ?></div><!-- /.container --><?php endif; ?>
					</nav><!-- #site-navigation -->

				</div>

			</div>

		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
