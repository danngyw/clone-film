<?php
function get_recent_films(){
	?>
	<h4 class="section-title">Recently added movies</h4>
	<?php
	$paged  = get_query_var('paged');
	$args = array(
		'post_type' => 'film',
		'post_status' => 'publish',
		'paged' => $paged,
	);
	$query = new WP_Query($args);
	if($query->have_posts()){
		echo '<ul class="media-list" itemscope="" itemtype="http://schema.org/Movie">';
		while($query->have_posts()){
			global $post;
			$query->the_post();
			render_item_film($post);
		}
		echo '</ul>';
	}?>

	<?php wp_pagenavi( array( 'query' => $query) );?>
	<div id="movie-browser-paginate" class="dataTables_paginate paging_simple_numbers"> </div>
	<?php wp_reset_query();?>

<?php }

function render_item_film($film){
	$thumbnail_url 	= get_the_post_thumbnail_url($film->ID);
	$year_release  	= get_post_meta($film->ID,'year_release', true);
	$length_time  	= get_post_meta($film->ID,'length_time', true);
	$imdb_score  	= get_post_meta($film->ID,'imdb_score', true);
	$source_id 		= get_post_meta($film->ID,'film_source_id', true);
	$actor 			= get_post_meta($film->ID,'actor', true);

	?>
	<li class="media media-movie-clickable film-id-<?php echo $film->ID;?> source-id-<?php echo $source_id;?>">
		<div class="media-left media-middle">
			<a href="<?php the_permalink();?>" itemprop="url"> <img class="media-object" src="<?php echo $thumbnail_url;?>" alt="<?php the_title();?>" itemprop="image" width="92"> </a>
		</div>
		<div class="media-body">
		<a href="<?php the_permalink();?>">
			<div class="col-xs-12">
			<h3 class="media-heading" itemprop="name"><?php the_title();?></h3>
			</div>
			<div class="col-sm-6 col-xs-12 movie-genre" itemprop="genre"><?php echo $actor;?></div>
			<div class="col-sm-6 col-xs-12 movie-genre">
				<span class="movinfo-section"><?php echo $year_release;?><small>year</small></span>
				<span class="movinfo-section"><?php echo $length_time;?><small>min</small></span>
				<span class="movinfo-section" style="color:#009900"><?php echo $imdb_score;?><small>IMDB</small></span>
			</div>
			<div class="col-xs-12">
			<span class="movie-actors" itemprop="actors">David Dencik</span>
			</div>
			<div class="col-xs-12">
			<span class="movie-desc" itemprop="description"><?php the_excerpt();?></span>
			</div>
		</a>
		</div>
	</li>
	<?php }