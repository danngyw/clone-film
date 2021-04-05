<?php
get_header();
?>
<div class="container">
	<div class="home-cols">
		<h2><?php the_title();?>
		<div class="page-content">
			<?php the_content();?>
		</div>
	</div>
</div>
<?php get_footer(); ?>