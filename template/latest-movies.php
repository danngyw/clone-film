<div class="row">
	<div class="col-sm-12">
		<h2 class="section-title text-center" style="font-size: 18px;">Latest Subtitle Update</h2>
		<br />

		<div class="owl-carousel owl-theme owl-loaded owl-drag">
			<?php
			wp_reset_query();
			// $args = array(
			// 	'post_type' 	=> 'film',
			// 	'post_status' 	=> 'publish',
			// 	'order'			=> 'rand',
			// 	'posts_per_page' => 9,

			// );
			$args = array(
			    'post_status' => 'publish',
			    'post_type' => 'film',
			    'meta_key' => 'is_crawled_sub',
			    'orderby' => 'meta_value_num',
			   	'order' => 'DESC',
			    'posts_per_page' => 10,
			    //'paged' => 1,
			);
			//is_crawled_sub

			$query = new WP_Query($args);

			if($query->have_posts()){
				$i = 0;
				while ( $query->have_posts() ) {
					$i ++;
					$query->the_post();
					global $post;
					$film = $post;
					render_latest_item($film);
				}
				//echo $i. ' Films';
			} else {
				echo 'NO FILM';
			}
			wp_reset_query();
			?>

		</div>
	</div>
</div>