<?php /* Wrapper Name: Header */ ?>
<div class="header-top-row">
	<div class="header-top-row-inner">
		<div class="motopress-inactive">
			<?php dynamic_sidebar( 'header' ); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
		<?php get_template_part("static/static-logo"); ?>
	</div>
	<div class="span6">
		<div class="row">
			<div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-shop-nav.php">
				<?php get_template_part("static/static-shop-nav"); ?>
			</div>
		</div>
		<div class="row">
			<div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-search.php">
				<?php get_template_part("static/static-search"); ?>
			</div>
		</div>
	</div>
</div>
<div class="header_row_bottom">
	<div class="row">
		<div class="span12" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
			<?php get_template_part("static/static-nav"); ?>
		</div>
	</div>
</div>