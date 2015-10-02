<?php
/**
 * Custom template actions 
 */

/*==============
  Catalog Page 
================*/

//Product short description
add_action( 'jigoshop_after_shop_loop_item', 'tm_catalog_product_description', 5 );
function tm_catalog_product_description() {
	$cat_show_desc = of_get_option( 'cat_show_desc' );
	if ( 'yes' == $cat_show_desc ) {
		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		global $post;
		if ( ! $post->post_excerpt ) return;
		?>
		<div class="short_desc">
			<?php echo $post->post_excerpt; ?>
		</div>
<?php 
	}
}

//Catalog details button
add_action( 'jigoshop_after_shop_loop_item', 'tm_catalog_product_details', 15 );
function tm_catalog_product_details() {
	$cat_show_details = of_get_option( 'cat_show_details' );
	if ( 'yes' == $cat_show_details ) {
		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		global $post, $product, $tm_theme_texdomain;
		if ( ('variable' != $product->product_type) && ('external' != $product->product_type) ) {
			echo "<a href='" . get_permalink() . "' class='btn'>" . __( "Details", $tm_theme_texdomain ) . "</a>";
		}
	}
}  

?>