<?php
function debug_insert_subtile(){
	global $wpdb;
	$sub_title = 'Doraemon: New Nobitaâ€™s Great Demon-Peko and the Exploration Party of Five BluRay Ganoo';
	$source_id = 337821;
	$film_id = 146136;
	$sub_zip_url = 'https://data.roty.tv/wp-content/uploads/2021/07/match-2014-brazillian-portuguese-yify-337821-3.zip';
	$rating = 5;
	$language = 'Brazillian Portuguese';

	$tbl_subtitles = $wpdb->prefix . 'custom_subtitles';
	$args =  array(
        'film_id'       => $film_id,
        'source_id'     => $source_id,
        'sub_title'     => $sub_title,
        'sub_zip_url'   => $sub_zip_url,
        'language'      => $language,
        'rating'        => $rating,
    );
    $insert = $wpdb->insert($tbl_subtitles, $args );
    if( !$insert ){
    	$wpdb->print_error();
    	$sql = "SHOW FULL COLUMNS FROM $tbl_subtitles";
    	$result = $wpdb->get_results($sql);
    	echo '<pre>';
    	var_dump($result);
    	echo '</pre>';
    	die();
    }

}
function manual_film_debug(){
	$args = array(
		'post_type' => 'film',
		'post_status' => 'publish',
		'meta_query' => array(

	         array(
	            'key'     => 'is_crawled_sub',
	            'value'   => 'done',
	            'meta_query' => '!='
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

	$text = "Adventure";
	$genre = $text;
	$terms = explode(",", $genre);

	$list = array();
	foreach ($terms as $key => $term_slug) {

		$term = term_exists( $term_slug, 'genre' );
		if ( $term !== 0 && $term !== null ) {

			$list[] = (int) $term['term_id'];
		} else {
			$term = wp_insert_term($term_slug,'genre', array());
			if( ! is_wp_error( $term )){
				$list[] = (int) $term->term_id;
			}
		}
	}
	$film_id = 1296;
	if($list){
		// wp_set_post_terms( $film_id, $list, 'genre' );
	}

}
// add_action('wp_footer','manual_film_debug');