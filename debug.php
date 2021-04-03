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
}
// add_action('wp_footer','manual_film_debug');