<div class="row">
	<div class="col-sm-12">
		<h4 class="section-title text-center">Latest movies</h4>


		<div class="owl-carousel owl-theme owl-loaded owl-drag">
			<?php
			$args = array(
				'post_type' 	=> 'film',
				'post_status' 	=> 'publish',
				'order'			=> 'rand',
				'posts_per_page' => 9,
			);
			$query = new WP_Query($args);
			if($query->have_posts()){
				while ( $query->have_posts() ) {
					$query->the_post();
					global $post;
					$film = $post;
					render_latest_item($film);
				}
			} else {
				echo 'NO FILM';
			}
			?>

		</div>
	</div>
</div>