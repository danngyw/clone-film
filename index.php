<?php
get_header();
$paged = (get_query_var('page')) ? get_query_var('page') : 1;
$css_class = "col-md-8";
$show_sidebar = 1;

if($paged > 1){
	$show_sidebar = 0;
	$css_class = "col-sm-12";
} ?>
<div class="container">
	<?php
	if( is_home() || is_front_page() ){ ?>
		<?php get_template_part('template/latest','movies');?>
		<?php get_template_part('template/test','flags');?>
	<?php } ?>

	<?php if( is_home() || is_front_page() ){ ?>
		<div class="row"><div class="col-xs-12"><hr><div id="taboola-below-article-thumbnails"></div></div></div>
	<?php } ?>

	<div class="row">
		<div class="<?php echo $css_class;?>">
			<?php if( is_home() || is_front_page() ){?>
				<h4 class="section-title">Recently added movies</h4>
				<br />
			<?php } ?>
		 	<?php  get_recent_films();?>
		</div>
		<?php if($show_sidebar) get_sidebar();?>
	</div>
</div>
<?php get_footer(); ?>