<?php
function elegance_widgets_init() {
	// Sidebar Widget
	// Location: the sidebar
	register_sidebar(array(
		'name'					=> theme_locals("sidebar"),
		'id' 						=> 'main-sidebar',
		'description'   => theme_locals("sidebar_desc"),
		'before_widget' => '<div id="%1$s" class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Header Widget Area
	// Location: at the top of pages
	register_sidebar(array(
		'name'					=> __( 'Header', getCurrentTheme() ),
		'id' 						=> 'header',
		'description'   => __( 'Header widget area', getCurrentTheme() ),
		'before_widget' => '<div id="%1$s" class="header-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// Cart Holder Widget
	// Location: the sidebar
	register_sidebar(array(
		'name'					=> __( "Cart Holder", "themeWoo" ),
		'id' 						=> 'cart-holder',
		'description'   => __( "Widget for cart in Header", "themeWoo" ),
		'before_widget' => '<div id="%1$s" class="cart-holder">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget_shopping_cart_content">',
	));


	// Footer Widget Area 1
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> theme_locals("footer_1"),
		'id' 						=> 'footer-sidebar-1',
		'description'   => theme_locals("footer_desc"),
		'before_widget' => '<div id="%1$s" class="footer-widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Footer Widget Area 2
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> theme_locals("footer_2"),
		'id' 						=> 'footer-sidebar-2',
		'description'   => theme_locals("footer_desc"),
		'before_widget' => '<div id="%1$s" class="footer-widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Footer Widget Area 3
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> theme_locals("footer_3"),
		'id' 						=> 'footer-sidebar-3',
		'description'   => theme_locals("footer_desc"),
		'before_widget' => '<div id="%1$s" class="footer-widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Footer Widget Area 4
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> theme_locals("footer_4"),
		'id' 						=> 'footer-sidebar-4',
		'description'   => theme_locals("footer_desc"),
		'before_widget' => '<div id="%1$s" class="footer-widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

}
/** Register sidebars by running elegance_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'elegance_widgets_init' );
?>