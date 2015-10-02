<?php
/**
*
* Shop Options Managment
* 
*/


//Init shop options BackUp post type
add_action( 'init', 'initOptionsPost', 10);
function initOptionsPost() {
	register_post_type( 'shop_options',
		array( 
			'label'               => 'shop_options', 
			'singular_label'      => 'shop_options',
			'exclude_from_search' => true, // Exclude from Search Results
			'capability_type'     => 'page',
			'public'              => true, 
			'show_ui'             => false,
			'show_in_nav_menus'   => false,
			'supports'  => array('title', 'custom-fields')
		)
	);
}

//Create post for shop options
add_action( 'jigoshop_update_options', 'createOptionsPost', 40);
function createOptionsPost() {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	if ( !$opt_post ) {
		$post = array(
		  'post_name' => 'shop-options',
		  'post_title' => 'shop-options',
		  'post_type' => 'shop_options',
		  'post_status' => 'publish'
		);
		$post_id = wp_insert_post( $post );
	}

}

//First time write options top post
add_action( 'jigoshop_update_options', 'addOptions', 50);
function addOptions() {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	$opt_to_rewrite = array('jigoshop_default_country', 'jigoshop_currency', 'jigoshop_catalog_product_button', 'jigoshop_catalog_sort_direction', 'jigoshop_catalog_columns', 'jigoshop_catalog_per_page', 'jigoshop_use_wordpress_tiny_crop', 'jigoshop_use_wordpress_thumbnail_crop', 'jigoshop_use_wordpress_catalog_crop', 'jigoshop_use_wordpress_featured_crop', 'jigoshop_shop_tiny_w', 'jigoshop_shop_tiny_h', 'jigoshop_shop_thumbnail_w', 'jigoshop_shop_thumbnail_h', 'jigoshop_shop_small_w', 'jigoshop_shop_small_h', 'jigoshop_shop_large_w', 'jigoshop_shop_large_h', 'jigoshop_shop_page_id', 'jigoshop_shop_redirect_page_id', 'jigoshop_cart_page_id', 'jigoshop_track_order_page_id', 'jigoshop_myaccount_page_id', 'jigoshop_edit_address_page_id', 'jigoshop_change_password_page_id', 'jigoshop_view_order_page_id', 'jigoshop_checkout_page_id', 'jigoshop_pay_page_id', 'jigoshop_thanks_page_id');
	if ( $opt_post ) {
		$all_options = wp_load_alloptions();
		foreach ( $opt_post as $post ) {
			foreach( $all_options as $name => $value ) {
				if( in_array($name, $opt_to_rewrite)) {
					$already_exist = get_post_meta( $post->ID, $name );
					if( empty( $already_exist ) ) {
						add_post_meta($post->ID, $name, $value, true);
					} 
				}
			}
		}
	}
}

//Update shop options backup in post meta
add_action( 'jigoshop_update_options', 'updateOptions', 60);
function updateOptions() {

	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post = get_posts( $args );
	$opt_to_rewrite = array('jigoshop_default_country', 'jigoshop_currency', 'jigoshop_catalog_product_button', 'jigoshop_catalog_sort_direction', 'jigoshop_catalog_columns', 'jigoshop_catalog_per_page', 'jigoshop_use_wordpress_tiny_crop', 'jigoshop_use_wordpress_thumbnail_crop', 'jigoshop_use_wordpress_catalog_crop', 'jigoshop_use_wordpress_featured_crop', 'jigoshop_shop_tiny_w', 'jigoshop_shop_tiny_h', 'jigoshop_shop_thumbnail_w', 'jigoshop_shop_thumbnail_h', 'jigoshop_shop_small_w', 'jigoshop_shop_small_h', 'jigoshop_shop_large_w', 'jigoshop_shop_large_h', 'jigoshop_shop_page_id', 'jigoshop_shop_redirect_page_id', 'jigoshop_cart_page_id', 'jigoshop_track_order_page_id', 'jigoshop_myaccount_page_id', 'jigoshop_edit_address_page_id', 'jigoshop_change_password_page_id', 'jigoshop_view_order_page_id', 'jigoshop_checkout_page_id', 'jigoshop_pay_page_id', 'jigoshop_thanks_page_id');
	if ( $opt_post ) {
		$all_options = wp_load_alloptions();
		foreach ( $opt_post as $post ) {
			foreach( $all_options as $name => $value ) {
				if ( in_array($name, $opt_to_rewrite)) {
					update_post_meta($post->ID, $name, $value);
				}
			}
		}
	}
		
}

//Remove old shop pages when new are imported
add_action( 'import_start', 'removeShopPages');
function removeShopPages() {
	$shop_pages = get_option('jigoshop_page-ids');
	$pages_removed = get_option( 'pages_removed' );
	if ( ( false != $shop_pages ) && ( false === $pages_removed ) ) {
		foreach($shop_pages as $page) {
			wp_delete_post( $page, true );
		}
		update_option( 'pages_removed', 'removed' );
	}
}

//Rewrite shop options on import
add_action( 'import_post_meta', 'extractOptions', 30, 3);
function extractOptions($post_id, $key, $value) {
	$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
	$opt_post =  get_posts( $args );

	$opt_to_rewrite = array('jigoshop_default_country', 'jigoshop_currency', 'jigoshop_catalog_product_button', 'jigoshop_catalog_sort_direction', 'jigoshop_catalog_columns', 'jigoshop_catalog_per_page', 'jigoshop_use_wordpress_tiny_crop', 'jigoshop_use_wordpress_thumbnail_crop', 'jigoshop_use_wordpress_catalog_crop', 'jigoshop_use_wordpress_featured_crop', 'jigoshop_shop_tiny_w', 'jigoshop_shop_tiny_h', 'jigoshop_shop_thumbnail_w', 'jigoshop_shop_thumbnail_h', 'jigoshop_shop_small_w', 'jigoshop_shop_small_h', 'jigoshop_shop_large_w', 'jigoshop_shop_large_h', 'jigoshop_shop_page_id', 'jigoshop_shop_redirect_page_id', 'jigoshop_cart_page_id', 'jigoshop_track_order_page_id', 'jigoshop_myaccount_page_id', 'jigoshop_edit_address_page_id', 'jigoshop_change_password_page_id', 'jigoshop_view_order_page_id', 'jigoshop_checkout_page_id', 'jigoshop_pay_page_id', 'jigoshop_thanks_page_id');

	if ( $opt_post ) {

		if (class_exists('Jigoshop_Options')) {
			$opt = new Jigoshop_Options;
		}

		foreach ( $opt_post as $post ) {
			$meta_options = get_post_meta( $post->ID );
			if ($post_id == $post->ID) {
				if( in_array($key, $opt_to_rewrite)) {
					update_option( $key, $value );
					//echo $name . "-" . $value[0];
					if (class_exists('Jigoshop_Options')) {
						$opt->set_option( $key, $value  );
					}
				}
			}
		}
	}
}

//Rewrite final options array after imoprt end & regenerate product images
add_action ('generate_rewrite_rules', 'altExtractOptions', 50);
function altExtractOptions() {

	$extracted = get_option('extracted');

	if ( false == $extracted ) {
		$extracted = 1;
	}
	
	if ( 3 >= $extracted ) {

		$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
		$opt_post =  get_posts( $args );

		$opt_to_rewrite = array('jigoshop_default_country', 'jigoshop_currency', 'jigoshop_catalog_product_button', 'jigoshop_catalog_sort_direction', 'jigoshop_catalog_columns', 'jigoshop_catalog_per_page', 'jigoshop_use_wordpress_tiny_crop', 'jigoshop_use_wordpress_thumbnail_crop', 'jigoshop_use_wordpress_catalog_crop', 'jigoshop_use_wordpress_featured_crop', 'jigoshop_shop_tiny_w', 'jigoshop_shop_tiny_h', 'jigoshop_shop_thumbnail_w', 'jigoshop_shop_thumbnail_h', 'jigoshop_shop_small_w', 'jigoshop_shop_small_h', 'jigoshop_shop_large_w', 'jigoshop_shop_large_h');
		$p_opt_to_rewrite = array('jigoshop_shop_page_id', 'jigoshop_shop_redirect_page_id', 'jigoshop_cart_page_id', 'jigoshop_track_order_page_id', 'jigoshop_myaccount_page_id', 'jigoshop_edit_address_page_id', 'jigoshop_change_password_page_id', 'jigoshop_view_order_page_id', 'jigoshop_checkout_page_id', 'jigoshop_pay_page_id', 'jigoshop_thanks_page_id');

		if ( $opt_post ) {

			$new_options = array();

			$jigo_opt = get_option( 'jigoshop_options' );
			$jigo_p_opt = get_option( 'jigoshop_page-ids' );

			foreach ( $opt_post as $post ) {
				foreach($jigo_opt as $opt_key=>$opt_val) {
					if ( in_array($opt_key, $opt_to_rewrite)) {
						$meta_option = get_post_meta( $post->ID, $opt_key, true );
						$new_options[$opt_key] = $meta_option;
						//echo $opt_key . " - " . $meta_option . "<br>";
					} else {
						$new_options[$opt_key] = $opt_val;
						//echo $opt_key . " - " . $opt_val . "<br>";
					}
				}
				$meta_options = get_post_meta( $post->ID );
				$all_pages = array();
				foreach ( $p_opt_to_rewrite as $page ) {
					$meta_option = get_post_meta( $post->ID, $page, true );
					$all_pages[] = $meta_option;
				}
			}

			//var_dump($new_options);
			update_option( 'jigoshop_options', $new_options );
			update_option( 'jigoshop_page-ids', $all_pages );
			$extracted++;
			update_option( 'extracted ', $extracted );
		}
		

		if (!function_exists('wp_generate_attachment_metadata')) {
			include( ABSPATH . 'wp-admin/includes/image.php' );
		}
		$post_args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'product'
		);
		$all_products = get_posts( $post_args );
		$attach_num = 0;
		$last_product = 0;
		$last_attach = 0;
		
		$all_options = array_merge($opt_to_rewrite, $p_opt_to_rewrite );
		foreach($all_options as $option) {
			$opt_val = get_option($option);
			Jigoshop_Base::get_options()->set_option( $option, $opt_val );
		}
		foreach($all_products as $product) {
			$img_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'attachment',
				'post_parent'	   => $product->ID
			);
			$last_product = $product->ID;
			$prod_attach = get_posts( $img_args );
			
			foreach($prod_attach as $attach) {
				$attach_id = $attach->ID;
				$filename = get_attached_file( $attach_id );
				set_time_limit ( 3 );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id,  $attach_data );
				$last_attach = $attach_id;
				$attach_num ++;	
			}
		}

		update_option('regenerated_attach', $attach_num);
		update_option('last_prod', $last_product);
		update_option('last_attach', $last_attach);

	}
}

//Set Jigoshop current options (for correct pages attach at Jigoshop settings)
add_action('init','altSetOptions', 70);
function altSetOptions() {
	if (class_exists('Jigoshop_Options')) {

		$extracted = get_option('extracted');

		if (3 == $extracted ) {
			$args = array( 'posts_per_page' => 1, 'post_type'=> 'shop_options' );
			$opt_post =  get_posts( $args );
			if ( $opt_post ) {
				foreach ( $opt_post as $post ) {
					$opt = new Jigoshop_Options;
					$p_opt_to_rewrite = array('jigoshop_shop_page_id', 'jigoshop_shop_redirect_page_id', 'jigoshop_cart_page_id', 'jigoshop_track_order_page_id', 'jigoshop_myaccount_page_id', 'jigoshop_edit_address_page_id', 'jigoshop_change_password_page_id', 'jigoshop_view_order_page_id', 'jigoshop_checkout_page_id', 'jigoshop_pay_page_id', 'jigoshop_thanks_page_id');
					foreach ($p_opt_to_rewrite as $page) {
						$meta_option = get_post_meta( $post->ID, $page, true );
						$opt->set_option( $page, $meta_option );
					}
				}
			}
		}

	}			
}

//Check if Jigoshop not activated on import start
add_action( 'check_shop_activation', 'check_jigo' );
function check_jigo() {
	if ( !in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		echo "<div class='note'>" . theme_locals('jigoshop_attention') . "</div>";
	}
}
?>