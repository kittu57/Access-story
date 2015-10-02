<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, get_stylesheet_directory() . '/languages' );
	$tm_curr_theme = wp_get_theme();
	$tm_theme_texdomain = $tm_curr_theme->Name;

	//Custom theme add-on
	//-------------------
	add_action( 'wp_head', 'tm_format_detection_phone' );
	function tm_format_detection_phone() {
		echo '<meta name = "format-detection" content = "telephone=no" />';
	}
	//-------------------

	add_action( 'wp_enqueue_scripts', 'tm_price_filter_fix', 50, 2 );
	function tm_price_filter_fix() {
		wp_dequeue_script( 'jqueryui' );
		wp_enqueue_script( 'jquery-ui-slider' );
	}
	add_action( 'admin_enqueue_scripts', 'tm_enqueue_custom_css', 20 );
	function tm_enqueue_custom_css() {
		wp_enqueue_style( 'custom-admin', get_stylesheet_directory_uri() . '/includes/admin/custom-admin.css', false, '1.0' );
	}

	// Include scripts for Child Theme
	add_action( 'wp_enqueue_scripts', 'tm_enqueue_custom_script', 30 );
	function tm_enqueue_custom_script() {
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '1.10.2'  );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array( 'jquery' ), '1.0', true );
	}


	//Activate shop menu after data import
	function set_top_menu_on_import() {
	    
	    $menu_seted = get_option( 'menus_seted' );
	    if ( false == $menu_seted ) {
	    	$menu_seted = 0;
	    }

    	if ( 2 >= get_option( 'menus_seted' ) ) {
			$menus = get_terms('nav_menu');
			$menu_seted++;
			$save = array();
			foreach($menus as $menu) {
				if ($menu->name == 'Shop menu') {
			    	$save['shop_menu'] = $menu->term_id;
			    } elseif ($menu->name == 'Header Menu') {
			        $save['header_menu'] = $menu->term_id;
			    } elseif ($menu->name == 'Footer Menu') {
			        $save['footer_menu'] = $menu->term_id;
			    }
			}
			if($save){
				remove_theme_mod( 'nav_menu_locations' );
			    set_theme_mod( 'nav_menu_locations', array_map( 'absint', $save ) );
			}
			update_option( 'menus_seted', $menu_seted );
		}

	}
	add_action( 'generate_rewrite_rules', 'set_top_menu_on_import', 80 );

	// Shop Options Management
	include_once ( CHILD_DIR . '/includes/options-management.php' );
	
	// Works only if Woocommerce activated
	if (function_exists('jigoshop_init')) {

		add_filter('body_class','tm_add_plugin_name_to_body_class');
		function tm_add_plugin_name_to_body_class($classes) {
			if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$classes[] = 'has_jigoshop has_shop';
			}
			return $classes;
		}

		//Related products limit
		function tm_related_products_limit() {
			global $_product, $columns, $per_page;

			// Pass vars to loop
			$posts_per_page = 4;
			$orderby = '';
			$per_page = $posts_per_page;
			$columns = 4;

			$related = $_product->get_related( $posts_per_page );
			$args = array(
				'post_type'	=> 'product',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => 3,
				'orderby' => $orderby,
				'post__in' => $related
			);
			return $args;
		}
		add_filter( 'jigoshop_related_products_args', 'tm_related_products_limit' );

		// Theme Actions
		get_template_part( 'includes/theme-actions' );
		// Theme Shortcodes
		get_template_part( 'includes/child-shortcodes' );

		function tm_open_shop_content_wrappers(){
			echo '<div class="motopress-wrapper content-holder clearfix jigoshop">
					<div class="container">
						<div class="row">
							<div class="span12" data-motopress-type="static" data-motopress-static-file="static/static-title.php">';
								echo get_template_part("static/static-title");
			echo 			'</div>
						</div>
						<div class="row">
							<div class="span8 ' . of_get_option('blog_sidebar_pos') . '" id="content">';
		}
		function tm_close_shop_content_wrappers(){
			echo			'</div>
							<div class="span4 sidebar" id="sidebar" data-motopress-type="static-sidebar"  data-motopress-sidebar-file="sidebar.php">';
								get_sidebar();
			echo			'</div>
						</div>
					</div>
				</div>';
		}

		function tm_prepare_shop_wrappers(){
			/* jigoshop */
			remove_action('jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10);
			remove_action('jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);
			remove_action('jigoshop_single_product_summary', 'jigoshop_template_single_title', 5, 0);
			remove_action('jigoshop_before_main_content', 'jigoshop_breadcrumb', 20, 0);
			remove_action('jigoshop_sidebar', 'jigoshop_get_sidebar', 10);

			add_action('jigoshop_before_main_content', 'tm_open_shop_content_wrappers', 10);
			add_action('jigoshop_after_main_content', 'tm_close_shop_content_wrappers', 10);
			/* end jigoshop */	
		}
		add_action('wp_head', 'tm_prepare_shop_wrappers');

		add_action('jigoshop_template_single_summary', 'tm_product_share', 60, 2);
		function tm_product_share() {
			$jigoshop_options = Jigoshop_Base::get_options();
			if (!$jigoshop_options->get_option('jigoshop_sharethis')) :
				get_template_part( 'includes/post-formats/share-buttons' );
			endif;
		}

add_action( 'jigoshop_before_shop_loop_item_title','tm_product_open_wrap', 9, 9);
 function tm_product_open_wrap() {
  echo "<div class='prod-inner-wrap'>";
 }
 add_action( 'jigoshop_before_shop_loop_item_title','tm_product_close_wrap', 11, 11);
 function tm_product_close_wrap() {
  echo "</div>";
 }


		// Custom Links for Shop Menu
		function login_out_function ($nav, $args){
			
		  if( 'shop_menu' === $args -> theme_location ) {
			if(of_get_option("login_display_id")=="yes"){
	      		$username = (get_current_user_id()!=0) ? get_userdata(get_current_user_id())->user_login : '';
	      		$user_title = str_replace("%username%", $username, of_get_option("site_admin"));
			    $link_string_site = "<a href=\"".get_bloginfo('wpurl')."/wp-admin/index.php\" class='register-link' title=\"".$user_title."\">".$user_title."</a>";
				$link_string_logout = '<a href="'. wp_logout_url($_SERVER['REQUEST_URI']) .'" title="'.of_get_option("log_out").'">'.of_get_option("log_out").'</a>';
				$link_string_register = "<a href=\"".get_bloginfo('wpurl')."/wp-login.php?action=register&amp;redirect_to=".$_SERVER['REQUEST_URI']."\" class='register-link' title=\"".of_get_option("sign_up")."\">".of_get_option("sign_up")."</a>";
				$link_string_login = "<a href=\"".get_bloginfo('wpurl')."/wp-login.php?action=login&amp;redirect_to=".$_SERVER['REQUEST_URI']."\" title=\"".of_get_option("sign_in")."\">".of_get_option("sign_in")."</a>";
		
				if (!is_user_logged_in()) {
		        	$login_links = "<li>".$link_string_register."</li><li>".$link_string_login."</li>";
		     	}else{
		        	$login_links = "<li>".$link_string_site."</li><li>".$link_string_logout."</li>";
				}
				$nav = $login_links.$nav;
				return $nav;
			} else {
				return $nav;
			}
		  } else {
			  return $nav;
		  }
		}
		add_filter('wp_nav_menu_items','login_out_function', 10, 2);


		//Custom theme add-on
		//-------------------
		
		remove_action( 'jigoshop_after_shop_loop_item_title', 'jigoshop_template_loop_price', 10, 2 );
		add_action( 'jigoshop_after_shop_loop_item', 'jigoshop_template_loop_price', 6, 2 );
		add_action( 'jigoshop_after_shop_loop_item', 'tm_prod_inner_wrap_open', 1 );
		function tm_prod_inner_wrap_open() {
			echo "<div class='product-inner-wrap'>";
		}
		add_action( 'jigoshop_after_shop_loop_item', 'tm_prod_inner_wrap_close', 99 );
		function tm_prod_inner_wrap_close() {
			echo "</div>";
		}
		
		add_filter( 'jigoshop_product_taxonomy_description', 'tm_tax_description_wrap', 10, 1 );
		function tm_tax_description_wrap($description) {
			if ( ''!=$description ) {
				$output = "<div class='content_box'>" . $description . "</div>";
				return $output;
			} else {
				return $description;
			}
		}
		//-------------------

	}
	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');
	function myHelpPointers() {
	//First we define our pointers 
	$pointers = array(
	   	array(
	       'id' => 'xyz1',   // unique id for this pointer
	       'screen' => 'options-permalink', // this is the page hook we want our pointer to show on
	       'target' => '#submit', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("submit_permalink"),
	       'content' => theme_locals("submit_permalink_desc"),
	       'position' => array( 
	                          'edge' => 'top', //top, bottom, left, right
	                          'align' => 'left', //top, bottom, left, right, middle
	                          'offset' => '0 5'
	                          )
	       ),

	    array(
	       'id' => 'xyz2',   // unique id for this pointer
	       'screen' => 'themes', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc"),
	       'position' => array( 
	                          'edge' => 'bottom', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 -10'
	                          )
	       ),

	    array(
	       'id' => 'xyz3',   // unique id for this pointer
	       'screen' => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc_2"),
	       'position' => array( 
	                          'edge' => 'left', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 18'
	                          )
	       )
	    // more as needed
	    );
		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers); 
	};
?>