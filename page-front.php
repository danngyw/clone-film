<?php
/**
 *Template Name: Front Page
 */

get_header();
$paged = get_query_var('page');
$css_class = "col-md-8";
$show_sidebar = 1;

if($paged > 1){
	$show_sidebar = 0;
	$css_class = "col-sm-12";
} ?>
<div class="container">
<?php the_title( '<h1>', '</h1>' ); ?>
	<?php
	if( is_home() || is_front_page() ){ ?>
		<?php get_template_part('template/latest','movies');?>
		<?php //get_template_part('template/test','flags');?>
	<?php } ?>

	<?php if( is_home() || is_front_page() ){ ?>
		<div class="row"><div class="col-xs-12"><hr><div id="taboola-below-article-thumbnails"></div></div></div>
	<?php } ?>

	<div class="row">
		<div class="<?php echo $css_class;?>">
			<?php if( is_home() || is_front_page() ){?>
				<h2 class="section-title" style="font-size: 18px;">Recently added movie Subtitles</h2>
			<?php } ?>
		 	<?php  get_recent_films();?>
		</div>
		<?php if($show_sidebar) get_sidebar();?>
	</div>
</div>
<?php get_footer(); ?>