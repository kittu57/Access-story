<?php /* Static Name: Search */ ?>
<?php dynamic_sidebar( 'cart-holder' ); ?>
<!-- BEGIN SEARCH FORM -->
<?php if ( of_get_option('g_search_box_id') == 'yes') { ?>
	<div class="search-form search-form__h clearfix">
		<form id="search-header" class="navbar-form pull-right" method="get" action="<?php echo home_url(); ?>/" accept-charset="utf-8">
			<input type="text" name="s" class="search-form_it"><input type="submit" value="<?php echo theme_locals('search'); ?>" id="search-form_is" class="search-form_is btn btn-primary">
		</form>
	</div>
<?php } ?>
<!-- END SEARCH FORM -->