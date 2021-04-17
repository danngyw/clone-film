<div class="col-md-4">
		<h4 class="section-title">Popular</h4>
		<ul class="media-list" itemscope="" itemtype="http://schema.org/Movie">
			<?php

			$args = array(
			    'post_type'  => 'film',
			    'meta_key'   => 'number_subtitles',
			    //'orderby'    => 'meta_value_num',
			    'orderby' 	 =>' meta_value_num date',
			    'order'      => 'DESC',
			);
			$popular = new WP_Query( $args );
			if($popular->have_posts() ){
				while ($popular->have_posts()) {
					$popular->the_post();
					global $post;

					$film_id = $post->ID;
					$year_release  	= get_post_meta($film_id,'year_release', true);
					$movie_genre 	= get_post_meta($film_id,'movie_genre', true);
					$thumbnail_url 	= get_the_post_thumbnail_url($film_id);
					$number_subtitles = get_post_meta($film_id,'number_subtitles', true);
					 ?>
					<li class="media media-movie-clickable mmc-tiny">
						<div class="media-left media-middle"> <a href="<?php the_permalink();?>" itemprop="url"> <img class="media-object" src="<?php echo $thumbnail_url;?>" alt="<?php the_title();?>" height="42" itemprop="image"> </a> </div>
						<div class="media-body">
						 	<a href="<?php the_permalink();?>">
								<h5 class="media-heading" itemprop="name"><?php the_title();?>(<?php echo $year_release;?>)</h5>
								<small itemprop="genre"><?php echo $movie_genre;?></small>
						</a>
						</div>
					</li>
					<?php
				}
			}?>

		</ul>
		<h4 class="section-title">Genre</h4>
		<ul class="list-group row default-list">
		<?php
		$terms = get_terms( array(
		    'taxonomy' => 'genre',
		    'hide_empty' => false,
		) );
		if ( !empty($terms) && !is_wp_error($terms) ) :

		    foreach( $terms as $term ) {
		    	$link = get_term_link($term,'genre');
		     	echo '<li class="list-group-item col-xs-4"><a href="'.$link.'">'.$term->name.'</a></li>';
			}
	    endif;?>
		</ul>
		<h4 class="section-title">Language</h4>
		<ul class="list-group row default-list">
			<?php
			$langs = get_terms( array(
			    'taxonomy' => 'language',
			    'hide_empty' => false,
			) );
			if ( !empty($langs) && !is_wp_error($langs) ) :
				foreach( $langs as $term ) {
			    	$link = get_term_link($term,'language');
			     	echo '<li class="list-group-item col-xs-6"><a href="'.$link.'">'.$term->name.'</a></li>';
				}
		    endif;?>

		</ul>

		<?php if ( is_active_sidebar( 'home_sidebar' ) ) { ?>
		    <ul id="sidebar" class="sidebar">
		        <?php dynamic_sidebar('home_sidebar'); ?>
		    </ul>
		<?php } ?>


	</div>