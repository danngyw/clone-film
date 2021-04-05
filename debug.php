<?php
function manual_film_debug(){
	$args = array(
		'post_type' => 'film',
		'post_status' => 'publish',
		'meta_query' => array(

	         array(
	            'key'     => 'is_full_updated',
	            'value'   => 'notyet',
	            //'meta_query' => '=='
	        ),

	    ),
	    'posts_per_page' => -1,

	);
	$query = new WP_Query($args);
	echo '<pre>';
	var_dump('Number film need to be crawl:'.$query->post_count);
	echo '</pre>';

	$args = array(
		'post_type' => 'subtitle',
		'post_status' => 'publish',

	    'posts_per_page' => -1,

	);
	$query = new WP_Query($args);
	if($query->have_posts() ){
		while ($query->have_posts() ) {
			$query->the_post();
			global $post;
			$film_id = $post->post_parent;
			$film  = get_post($film_id);
			if(!$film){
				// xóa nhưng substile không có giá trị sử dụng.
				// wp_delete_post($post->ID, true);
			}
		}
	}

	$text = "Adventure, Comedy, Family, Horror";
	$genre = $text;
	$terms = explode(",", $genre);

	$list = array();
	foreach ($terms as $key => $term_slug) {

		$term = term_exists( $term_slug, 'genre' );
		if ( $term !== 0 && $term !== null ) {
			var_dump($term['term_id']);
			$list[] = (int) $term['term_id'];
		} else {
			$term = wp_insert_term($term_slug,'genre', array());
			echo '<pre>';
			echo 'insert term';
			//var_dump($term->term_id);
			echo '</pre>';
			$list[] = (int) $term->term_id;
		}
		echo '<pre>';
		var_dump($list);
		echo '</pre>';
	}
	$film_id = 1296;
	if($list){
		wp_set_post_terms( $film_id, $list, 'genre' );
	}
}
//add_action('wp_footer','manual_film_debug');