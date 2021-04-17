		<footer class="footer">
			<div class="container text-center">
				<div class="row">
					<div class="col-xs-12"><a href="<?php echo home_url();?>/privacy">privacy</a> | <a href="<?php echo home_url();?>/legal-information">legal</a> | <a href="<?php echo home_url();?>/contact">contact</a></div>
					<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©yifysubtitles. </div>
				</div>
			</div>
		</footer>
		<?php if(  is_singular( 'film') ) {  ?>
	    	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/assets/jquery.circliful.js"></script>
	    	<script>
	    		(function($){
				    $(document).ready(function() {
				        var loader = $("#ajaxloader");

				        $("#circle-score-year").circliful({
				        });
				        $("#circle-score-length").circliful({

				        });

				        $("#circle-score-imdb").circliful({

				        });
				        $("#circle-score-tomatoes").circliful({

				        });
				    });
				})(jQuery);
			</script>

	    <?php } ?>


	    <?php
		do_action('wp_footer');
		// global $post;
		// $film_id = $post->ID;

		// $actor_string 	= get_post_meta($film_id,'movie_actors', true);
		// $tags 	= explode(",", $actor_string);

		// $tag_actors = array();
		// if( $tags && count($tags) > 0 ){
		// 	foreach ($tags as $key => $actor) {
		// 		if($actor){
		// 			$tag = term_exists( $actor, 'post_tag' );

		// 			if ( $tag !== 0 && $tag !== null ) {
		// 				$tag_actors[] = (int) $tag['term_id'];
		// 			} else {
		// 				$tag 	= wp_insert_term($actor,'post_tag', array('description' => 'Tag of actor '.$actor));
		// 				if( $tag && ! is_wp_error($tag)){
		// 					$tag_actors[] = (int)  $tag['term_id'];
		// 				} else {
		// 					crawl_log("Add actor fail. Name Actor: ".$actor);
		// 				}
		// 			}
		// 		}
		// 	}
		// }
		// if( $tag_actors ){
		// 	wp_set_object_terms( $film_id, $tag_actors, 'post_tag' );
		// }



		?>
	</body>
</html>