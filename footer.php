		<footer class="footer"><br>
			<div class="container text-center">
				<div class="row">
					<div class="col-xs-12"><a href="/about" rel="nofollow">ABOUT</a> | <a href="/privacy">PRIVACY</a> | <a href="/legal">LEGAL</a> | <a href="/dmca">DMCA</a> | <a href="/contact">CONTACT</a></div>
					<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©Roty. </div>
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

		global $wpdb;


		// $remove_track = "DELETE FROM `{$wpdb->base_prefix}imported_track`";
		// $wpdb->query($remove_track);

		// $sql = "SELECT *  from `{$wpdb->base_prefix}imported_track`";
		// $track = $wpdb->get_results($sql);
		// foreach ($track as $key => $record) {
		// 	var_dump($record);
		// 	echo '<br />';
		// }
		// $imported = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->base_prefix}imported_track`");
		// var_dump($imported);

		// $sql = "SELECT count(*) FROM $wpdb->postmeta pm WHERE pm.meta_key = 'film_source_id' ";
		// $real = $wpdb->get_var($sql);
		// var_dump('Real Meta:');
		// var_dump($real);

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


		// $source_id =1378378;
	    //$t = is_film_imported($source_id);


		// if($t){
		// 	echo ' Film da imported';
		// } else {
		// 	echo 'Film chua import';
		// }
	 //   	global $wpdb;
		// $sql = "SELECT  count(*) from $wpdb->postmeta";
		// $result = $wpdb->get_var($sql);
		// var_dump($result);
		// $sql = "SELECT  count(*) from $wpdb->posts";
		// $result = $wpdb->get_var($sql);
		// var_dump($result);
		// $sql = "SELECT pm.post_id, pm.meta_value FROM $wpdb->postmeta pm WHERE pm.meta_key = 'film_source_id' ";

		// $results = $wpdb->get_results($sql);

		// foreach ($results as $key => $record) {

		// 	//var_dump($record);
		// 	//echo '<br />';
		// 	$source_id = $record->meta_value;
		// 	$imported = is_film_imported_v2($source_id);
		// 	if(  ! $imported ){
		// 		$film_id 	= (int) $record->post_id;
		// 		$source_id 	= $record->meta_value;
		// 		// wa_add_film_track($film_id, $source_id);
		// 	}
		// }


		?>
	</body>
</html>