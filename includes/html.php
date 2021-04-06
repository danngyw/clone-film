<?php

function render_latest_item($film){
	$film_id = $film->ID;

	$thumbnail_url 	= get_the_post_thumbnail_url($film->ID);
	$year_release  	= get_post_meta($film_id,'year_release', true);
	$length_time  	= get_post_meta($film_id,'length_time', true);
	$imdb_score  	= get_post_meta($film_id,'imdb_score', true);
	$source_id 		= get_post_meta($film_id,'film_source_id', true);
	$movie_actors 	= get_post_meta($film_id,'movie_actors', true);
	$movie_genre 	= get_post_meta($film_id,'movie_genre', true);
	$thumbnail_url 	= get_the_post_thumbnail_url($film->ID);
	?>
	<div class="owl-item active" style="width: 235px;">
		<a href="<?php the_permalink();?>" itemprop="url" class="slide-item-wrap">
			<img class="img-responsive" src="<?php echo $thumbnail_url;?>" alt="<?php the_title();?>" itemprop="image">
			<div class="movie-item-overlay">
				<h3 class="title" itemprop="name"><?php the_title();?><br><?php echo $year_release;?></h3>
				<span class="genre" itemprop="genre"><?php echo $movie_genre;?></span>
				<small class="actors" itemprop="actors"><?php echo $movie_actors;?></small>
				<div class="meter">
					<span class="value" style="color:#FFBA00;"><?php echo $imdb_score;?></span>
					<span class="source text-muted">IMDB</span>
				</div>
			</div>
		</a>
	</div>
<?php
}
function get_recent_films(){

	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	$keyword = get_query_var('s');
	$args = array(
		'post_type' => 'film',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => 3,
	);
	if($keyword){
		$args['s'] = $keyword;
	}
	$term_id= 0;
	$name = get_query_var( 'genre' );
	if($name){
		$term = get_term_by( 'slug', $name,'genre');
		// $term_id = $term->term_id;
		$args['tax_query'][] = array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => array( $name ),
		);

	}

	$tag_name = get_query_var( 'tag' );
	if($tag_name){
		$args['tax_query'][] = array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => array( $tag_name ),
		);
	}
	$lang = get_query_var( 'language' );

	if($lang){
		$term = get_term_by( 'slug', $lang,'language');
		$args['tax_query'][] = array(
            'taxonomy' => 'language',
            'field'    => 'slug',
            'terms'    => array( $lang ),
		);
	}
	// echo '<pre>';
	// var_dump($args);
	// echo '</pre>';

	$query = new WP_Query($args);
	if($query->have_posts()){
		echo '<ul class="media-list" itemscope="" itemtype="http://schema.org/Movie">';
		while($query->have_posts()){
			global $post;
			$query->the_post();
			render_item_film($post);
		}
		echo '</ul>';
	} else {
		echo 'No Post Found';
	}?>

	<?php
	if( function_exists('wp_pagenavi') ):
		wp_pagenavi( array( 'query' => $query) );
	endif;
	?>
	<div id="movie-browser-paginate" class="dataTables_paginate paging_simple_numbers"> </div>
	<?php wp_reset_query();?>

<?php }

function render_item_film($film){
	$thumbnail_url 	= get_the_post_thumbnail_url($film->ID);
	$year_release  	= get_post_meta($film->ID,'year_release', true);
	$length_time  	= get_post_meta($film->ID,'length_time', true);
	$imdb_score  	= get_post_meta($film->ID,'imdb_score', true);
	$source_id 		= get_post_meta($film->ID,'film_source_id', true);
	$movie_actors 	= get_post_meta($film->ID,'movie_actors', true);
	$movie_genre 	= get_post_meta($film->ID,'movie_genre', true);

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
			<div class="col-sm-6 col-xs-12 movie-genre" itemprop="genre"><?php echo $movie_genre;?></div>
			<div class="col-sm-6 col-xs-12 movie-genre">
				<span class="movinfo-section"><?php echo $year_release;?><small>year</small></span>
				<span class="movinfo-section"><?php echo $length_time;?><small>min</small></span>
				<span class="movinfo-section" style="color:#009900"><?php echo $imdb_score;?><small>IMDB</small></span>
			</div>
			<div class="col-xs-12">
			<span class="movie-actors" itemprop="actors"><?php echo $movie_actors;?></span>
			</div>
			<div class="col-xs-12">
			<span class="movie-desc" itemprop="description"><?php the_excerpt();?></span>
			</div>
		</a>
		</div>
	</li>
<?php }