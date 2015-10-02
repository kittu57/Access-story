<?php
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */
if(!function_exists('optionsframework_options')) {
	function optionsframework_options() {
// Fonts
			global $typography_mixed_fonts, $tm_theme_texdomain;
			$typography_mixed_fonts = array_merge(options_typography_get_os_fonts() , options_typography_get_google_fonts());
			asort($typography_mixed_fonts);

			$options = array();
// ---------------------------------------------------------
// General
// ---------------------------------------------------------
			$options['general'] = array( "name" => theme_locals('general'),
								"type" => "heading");
			// Background Defaults
			$background_defaults = array(
				'color' => '#0e0e0e', 
				'image' => '', 
				'repeat' => 'repeat',
				'position' => 'top center',
				'attachment'=>'scroll'
			);

			$per_page_options = array( '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18, '19' => 19, '20' => 20);
			$yes_no_options = array(
				'yes' => __( 'Yes', $tm_theme_texdomain ),
				'no' => __( 'No', $tm_theme_texdomain )
			);

			$options['body_background'] = array(
								"id" => "body_background",
								"std" => $background_defaults);
			
			$options['header_color'] = array(
								"id" => "header_color",
								"std" => "#ffffff");
			
			$options['links_color'] = array(
								"id" => "links_color",
								"std" => "#8c5e56");

			$options['links_color_hover'] = array(
								"id" => "links_color_hover",
								"std" => "#d78848");
								
			$options['google_mixed_3'] = array(
								'id' => 'google_mixed_3',
								'std' => array( 'size' => '14px', 'lineheight' => '20px', 'face' => 'Georgia, "Times New Roman", Times, serif', 'style' => 'italic', 'character'  => 'latin', 'color' => '#8a8989'));
								
			$options['h1_heading'] = array(
								'id' => 'h1_heading',
								'std' => array( 'size' => '27px', 'lineheight' => '32px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#191919'));
			
			$options['h2_heading'] = array(
								'id' => 'h2_heading',
								'std' => array( 'size' => '24px', 'lineheight' => '30px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#191919'));
								
			$options['h3_heading'] = array(
								'id' => 'h3_heading',
								'std' => array( 'size' => '21px', 'lineheight' => '25px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#ffffff'));
			
			$options['h4_heading'] = array(
								'id' => 'h4_heading',
								'std' => array( 'size' => '18px', 'lineheight' => '22px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#191919'));
								
			$options['h5_heading'] = array(
								'id' => 'h5_heading',
								'std' => array( 'size' => '14px', 'lineheight' => '20px', 'face' => 'Georgia, "Times New Roman", Times, serif', 'style' => 'italic', 'character'  => 'latin', 'color' => '#191919'));
								
			$options['h6_heading'] = array(
								'id' => 'h6_heading',
								'std' => array( 'size' => '14px', 'lineheight' => '20px', 'face' => 'Georgia, "Times New Roman", Times, serif', 'style' => 'italic', 'character'  => 'latin', 'color' => '#191919'));
			
			$options['g_search_box_id'] = array(
								"id" => "g_search_box_id",
								"std" => "yes");

			$options['g_breadcrumbs_id'] = array(
								"id" => "g_breadcrumbs_id",
								"std" => "yes");;	

			$options['custom_css'] = array(
								"id" => "custom_css",
								"std" => "");
//shop			
		$options['shop'] = array( "name" => __( "Shop settings", $tm_theme_texdomain ),
							"id" => "shop",
							"type" => "heading");


		$options['catalog_info'] = array(
					"desc" => __( "Options for catalog page:", $tm_theme_texdomain ),
					"id" => "catalog_info",
					"type" => "info");


		$options['cat_show_desc'] = array( "name" => __( "Product description", $tm_theme_texdomain ),
					"desc" => __( "Show/hide product description on catalog page", $tm_theme_texdomain ),
					"id" => "cat_show_desc",
					"std" => "yes",
					"type" => "radio",
					"options" =>$yes_no_options
				);

		$options['cat_show_details'] = array( "name" => __( "Show details button on catalog page", $tm_theme_texdomain ),
					"desc" => __( "Show/hide product details button on catalog page", $tm_theme_texdomain ),
					"id" => "cat_show_details",
					"std" => "no",
					"type" => "radio",
					"options" =>$yes_no_options
				);

		
		$options['authentication_info'] = array(
							"desc" => __( "Options for Login/out links in shop menu in header:", $tm_theme_texdomain ),
							"id" => "authentication_info",
							"type" => "info");

		$options['login_display_id'] = array( "name" => __( "Display login links?", $tm_theme_texdomain ),
					"desc" => __( "Display login links in the shop menu?", $tm_theme_texdomain ),
					"id" => "login_display_id",
					"std" => "yes",
					"type" => "radio",
					"options" => array(
									"yes" => "Yes",
									"no"	=> "No"));
									
		$options[] = array( "name" => __( "User profile link.", $tm_theme_texdomain ),
					"desc" => __( "Please input user profile link title. If you use macro %username% it will be replaced with the current username. For example Site %username% .", $tm_theme_texdomain ),
					"id" => "site_admin",
					"std" => "Site %username%",
					"class" => "tiny",
					"type" => "text");
					
		$options[] = array( "name" => __( "Logoff link.", $tm_theme_texdomain ),
					"desc" => __( "Please input logoff link title.", $tm_theme_texdomain ),
					"id" => "log_out",
					"std" => "Log out",
					"class" => "tiny",
					"type" => "text");
					
		$options[] = array( "name" => __( "Registration link.", $tm_theme_texdomain ),
					"desc" => __( "Please input registration link title.", $tm_theme_texdomain ),
					"id" => "sign_up",
					"std" => "Registration",
					"class" => "tiny",
					"type" => "text");			
		
		$options[] = array( "name" => __( "Authentication link (login).", $tm_theme_texdomain ),
					"desc" => __( "Please input authentication link title.", $tm_theme_texdomain ),
					"id" => "sign_in",
					"std" => "Log In",
					"class" => "tiny",
					"type" => "text");	
								
//End authentication
// ---------------------------------------------------------
// Logo & Favicon
// ---------------------------------------------------------
			$options["logo_favicon"] = array( "name" => theme_locals('logo_favicon'),
								"type" => "heading");		

			$options['logo_type'] = array(
								"id" => "logo_type",
								"std" => "image_logo");

			$options['logo_typography'] = array(
								'id' => 'logo_typography',
								'std' => array( 'size' => '50px', 'lineheight' => '52px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#ffffff'));
			
			$options['logo_url'] = array(
								"id" => "logo_url",
								"std" => get_stylesheet_directory_uri() . "/images/logo.png");
								
			$options['favicon'] = array(
								"id" => "favicon",
								"std" => get_stylesheet_directory_uri() . "/favicon.ico");

// ---------------------------------------------------------
// Navigation
// ---------------------------------------------------------
			$options['navigation'] = array( "name" => theme_locals('navigation'),
								"type" => "heading");

			$options['menu_typography'] = array(
								'id' => 'menu_typography',
								'std' => array( 'size' => '21px', 'lineheight' => '58px', 'face' => 'Fjalla One', 'style' => 'normal', 'character'  => 'latin', 'color' => '#404040'));

			$options['sf_delay'] = array(
								"id" => "sf_delay",
								"std" => "1000");

			$options['sf_f_animation'] = array(
								"id" => "sf_f_animation",
								"std" => "show");
			
			$options['sf_sl_animation'] = array(
								"id" => "sf_sl_animation",
								"std" => "show");
			
			$options['sf_speed'] = array(
								"id" => "sf_speed",
								"std" => "normal");

			$options['sf_arrows'] = array(
								"id" => "sf_arrows",
								"std" => "false");

			$options['mobile_menu_label'] = array(
								"id" => "mobile_menu_label",
								"std" => theme_locals('mobile_menu_std'));	

// ---------------------------------------------------------
// Slider
// ---------------------------------------------------------
			$options['slider'] = array( "name" => theme_locals('slider'),
	                            "type" => "heading");

	// Slider type
			$options['sl_type'] = array(
								"id" => "slider_type",
								"std" => "camera_slider");
	// ---------------------------------------------------------
	// Camera Slider
	// ---------------------------------------------------------
	        $options['sl_effect'] = array(
	                            "id" => "sl_effect",
	                            "std" => "simpleFade");

	        $options['sl_columns'] = array(
	                            "id" => "sl_columns",
	                            "std" => "12");

	        $options['sl_rows'] = array(
	                            "id" => "sl_rows",
	                            "std" => "8");

	        $options['sl_banner'] = array(
		                        "id" => "sl_banner",
		                        "std" => "fadeIn");

	        $options['sl_pausetime'] = array(
	                            "id" => "sl_pausetime",
	                            "std" => "7000");
	 
	        $options['sl_animation_speed'] = array(
	                            "id" => "sl_animation_speed",
	                            "std" => "500");
	 
	        $options['sl_slideshow'] = array(
	                            "id" => "sl_slideshow",
	                            "std" => "true");

	        $options['sl_thumbnails'] = array(
	                            "id" => "sl_thumbnails",
	                            "std" => "false");

	        $options['sl_control_nav'] = array(
	                            "id" => "sl_control_nav",
	                            "std" => "true");

	        $options['sl_dir_nav'] = array(
	                            "id" => "sl_dir_nav",
	                            "std" => "false");

	        $options['sl_dir_nav_hide'] = array(
	                            "id" => "sl_dir_nav_hide",
	                            "std" => "false");

	        $options['sl_play_pause_button'] = array(
	                            "id" => "sl_play_pause_button",
	                            "std" => "false");
	        $options['sl_loader'] = array(
	                            "id" => "sl_loader",
	                            "std" => "no");
	// ---------------------------------------------------------
	// Accordion Slider
	// ---------------------------------------------------------
	        $multicheck_defaults = array( '43' => 0,  '49' => 0, '50' => 0, '51' => 0, '52' => 0);
	       	$options['acc_show_post'] = array(
                    "id" => "acc_show_post",
                    "std" => $multicheck_defaults);

	        $options['acc_slideshow'] = array(
	                            "id" => "acc_slideshow",
	                            "std" => "false");

	       	$options['acc_hover_pause'] = array(
	                            "id" => "acc_hover_pause",
	                            "std" => "true");

	       	$options['acc_pausetime'] = array(
	                            "id" => "acc_pausetime",
	                            "std" => "6000");

	        $options['acc_animation_speed'] = array(
	                            "id" => "acc_animation_speed",
	                            "std" => "600");

	        $options['acc_easing'] = array(
		                        "id" => "acc_easing",
		                        "std" => "easeOutCubic");

	        $options['acc_trigger'] = array(
		                        "id" => "acc_trigger",
		                        "std" => "mouseover");

	       	$options['acc_starting_slide'] = array(
	                            "id" => "acc_starting_slide",
	                            "std" => "0");
// ---------------------------------------------------------
// Blog
// --------------------------------------------------------
			$options['blog'] = array( "name" => theme_locals('blog'),
								"type" => "heading");
			
			$options['blog_text'] = array(
								"id" => "blog_text",
								"std" => theme_locals('blog'));
			
			$options['blog_related'] = array(
								"id" => "blog_related",
								"std" => theme_locals('posts_std'));
			
			$options['blog_sidebar_pos'] = array(
								"id" => "blog_sidebar_pos",
								"std" => "right");

			$options['post_image_size'] = array(
								"id" => "post_image_size",
								"std" => "normal");
			
			$options['single_image_size'] = array(
								"id" => "single_image_size",
								"std" => "normal");

			$options['post_meta'] = array(
								"id" => "post_meta",
								"std" => "true");
			
			$options['post_excerpt'] = array(
								"id" => "post_excerpt",
								"std" => "true");

// ---------------------------------------------------------
// Portfolio
// ---------------------------------------------------------
			$options['portfolio'] = array(
								"name" => theme_locals("portfolio"),
								"type" => "heading");

			$options['folio_filter'] = array(
								"id" => "folio_filter",
								"std" => "cat");
			
			$options['folio_title'] = array(
								"id" => "folio_title",
								"std" => "yes");

			$options['folio_excerpt'] = array(
								"id" => "folio_excerpt",
								"std" => "yes");

			$options['folio_excerpt_count'] = array(
								"id" => "folio_excerpt_count",
								"std" => "20");

			$options['folio_btn'] = array(
								"id" => "folio_btn",
								"std" => "yes");

			$options['folio_meta'] = array(
								"id" => "folio_meta",
								"std" => "yes");

			$options['layout_mode'] = array(
								"id" => "layout_mode",
								"std" => "fitRows");

			$options['items_count2'] = array(
								"id" => "items_count2",
								"std" => "8");

			$options['items_count3'] = array(
								"id" => "items_count3",
								"std" => "9");
			
			$options['items_count4'] = array(
								"id" => "items_count4",
								"std" => "12");

// ---------------------------------------------------------
// Footer
// ---------------------------------------------------------
			$options['footer'] = array( "name" => theme_locals("footer"),
								"type" => "heading");
			
			$options['footer_text'] = array(
								"id" => "footer_text",
								"std" => "");
			
			$options['ga_code'] = array(
								"id" => "ga_code",
								"std" => "");
			
			$options['feed_url'] = array(
								"id" => "feed_url",
								"std" => "");
			
			$options['footer_menu'] = array(
								"id" => "footer_menu",
								"std" => "false");

			$options['footer_menu_typography'] = array(
								'id' => 'footer_menu_typography',
								'std' => array( 'size' => '14px', 'lineheight' => '20px', 'face' => 'Georgia, "Times New Roman", Times, serif', 'style' => 'italic', 'character'  => 'latin', 'color' => '#8A8989'));

			$options['foo'] = array( "name" => "foo",
								"type" => "heading");
		return $options;
	}
}
?>