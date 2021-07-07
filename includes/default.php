<?php

function crawl_log($input, $file_store = ''){
	$file_store = WP_CONTENT_DIR.'/log.css';
	if( is_array( $input ) || is_object( $input ) ){
        error_log( date( 'Y/m/d H:i:s', current_time( 'timestamp', 0 ) ). ': '. print_r($input, TRUE), 3, $file_store );
    } else {
        error_log( date( 'Y/m/d H:i:s', current_time( 'timestamp', 0 ) ). ': '. $input . "\n" , 3, $file_store);
    }
}


function import_film($args){

	$args['post_type'] = 'film';
	$args['post_status'] = 'publish';
	$source_id  =   $args['film_source_id'];

	$film_id = wp_insert_post($args);
	if( ! is_wp_error($film_id) ){
		wa_add_film_track($film_id, $source_id);

		update_post_meta($film_id,'film_source_id', $source_id);
		update_post_meta($film_id,'year_release', $args['year_release']);
		update_post_meta($film_id,'length_time', $args['length_time']);
		update_post_meta($film_id,'imdb_score', $args['imdb_score']);
		update_post_meta($film_id,'movie_actors', $args['movie_actors']);
		update_post_meta($film_id,'movie_genre', $args['movie_genre']);

		$genre_string 	= $args['movie_genre'];
		$terms 			= explode(",", $genre_string);
		$tag_genre 		= $tag_actors = array();
		foreach ($terms as $key => $term_slug) {

			$term = term_exists( $term_slug, 'genre' );
			if ( $term !== 0 && $term !== null ) {
				$tag_genre[] = (int) $term['term_id'];
			} else {
				$term 	= wp_insert_term($term_slug,'genre', array('description' => 'Term of'.$term_slug));
				if( $term && ! is_wp_error($term)){
					$tag_genre[] = (int)  $term['term_id'];
				}
			}
		}
		$actor_sring 	= $args['movie_actors'];
		$tags 	= explode(",", $actor_sring);
		if( $tags && count($tags) > 0 ){
			foreach ($tags as $key => $actor) {
				if($actor){
					$tag = term_exists( $actor, 'post_tag' );

					if ( $tag !== 0 && $tag !== null ) {
						$tag_actors[] = (int) $tag['term_id'];
					} else {
						$tag 	= wp_insert_term($actor,'post_tag', array('description' => 'Tag of actor '.$actor));
						if( $tag && ! is_wp_error($tag)){
							$tag_actors[] = (int)  $tag['term_id'];
						} else {
							crawl_log("Add actor fail. Name Actor: ".$actor);
						}
					}
				}
			}
		}
		if( $tag_genre ){
			wp_set_object_terms( $film_id, $tag_genre, 'genre' );
		}
		if( $tag_actors ){
			wp_set_object_terms( $film_id, $tag_actors, 'post_tag' );
		}

		$url =  $args['source_thumbnail_url'];
		import_film_thumbnail($url, $film_id);
	}
	update_post_meta($film_id,'is_full_updated','notyet');

}

/**
 * check the substile imported or not.
*/

function is_subtitle_imported_advanced_old($sub_source_id){
	global $wpdb;
	$sql = "SELECT p.ID
	  		FROM $wpdb->posts as p
				LEFT JOIN $wpdb->postmeta as pm ON pm.post_id = p.ID
					WHERE pm.meta_key = 'subtitle_source_id' AND pm.meta_value = '{$sub_source_id}' AND p.post_status ='publish'
						LIMIT 1";

  	return $wpdb->get_row($sql);
}
function is_subtitle_imported_advanced1($sub_source_id){
	global $wpdb;
	$sql = "SELECT p.ID
	  		FROM $wpdb->posts as p
				LEFT JOIN $wpdb->postmeta as pm ON pm.post_id = p.ID
					WHERE pm.meta_key = 'subtitle_source_id' AND pm.meta_value = '{$sub_source_id}' AND p.post_status ='publish'
						LIMIT 1";

  	return $wpdb->get_row($sql);
}

function is_subtitle_imported_advanced($sub_source_id){
	global $wpdb;
	$sql = "SELECT sub.ID
	  		FROM `{$wpdb->base_prefix}subtitles`  as sub
			WHERE sub.source_id = {$sub_source_id} LIMIT 1";

  	return $wpdb->get_row($sql);
}

/**
 * simplecheck the substile imported or not.
*/

function is_subtitle_imported_simple($sub_source_id){
	global $wpdb;
	$sql = "SELECT pm.post_id
				FROM $wpdb->postmeta AS pm
					WHERE pm.meta_key = 'subtitle_source_id' AND pm.meta_value = '{$sub_source_id}'
						LIMIT 1";

  	return  $wpdb->get_row($sql);

}
function import_subtitle_film($args, $film_id){

	$sub_source_id = $args['sub_source_id'];
	$sub_id_exists = is_subtitle_imported_advanced($sub_source_id);
	if($sub_id_exists){
		crawl_log('Fail : Sub exists '.$sub_id_exists);
		return false;
	}

	$sub_id = crawl_insert_subtitle($args, $film_id);
	crawl_log('crawl_insert_subtitle Return:');
	crawl_log($sub_id);

	if( ! is_wp_error($sub_id) ){

		$data = array(
			'import'              => 'subtitle',
	        'sub_id'              =>  $sub_id,
	        'sub_slug'            =>$args['m_sub_slug'],
			'source'              => home_url(),
		);

		try {
	        $res   = sendSubtileRequest($data);
	       	if( isset($res->url) && !empty($res->url) ){
				update_substile_zip($sub_id, $res->url);
			}
	    } catch (Exception $e) {

	    }
	}

}


function get_flag_css($text){
	$flag = '';
	$text =  explode(" ", $text);
	$lang =  $text[0];
	switch ($lang) {


		case 'Arabic':
			$flag = 'sa';
			break;
		case 'Albanian':
			$flag = 'al';
			break;

		case 'Brazillian':
		case 'Brazilian':
			$flag = 'br';
			break;



		case 'Canada':
			$flag = 'ca';
			break;
		case 'Croatian':
			$flag = 'hr';
			break;
		case 'Czech':
			$flag = 'cz';
			break;

		case 'German':  //germany
			$flag = 'de';
			break;
		case 'Romanian':
			$flag = 'ro';
			break;
		case 'Indonesian':
			$flag = 'id';
			break;
		case 'Chinese':
			$flag = 'cn';
			break;
		case 'Bulgarian':
			$flag = 'bg';
			break;
		case 'Bengali':
			$flag = 'bd';
			break;

		case 'Swedish':
			$flag = 'se';
			break;

		case 'Russian':
			$flag = 'ru';
			break;

		case 'Norwegian':
			$flag = 'no';
			break;



		case 'Korean':
			$flag = 'kr';
			break;
		case 'Italian':
			$flag = 'it';
			break;
		case 'Greek':
			$flag = 'gr';
			break;


		case 'Icelandic':
			$flag = 'is';
			break;

		case 'Japanese':
			$flag = 'jp';
			break;


		case 'German':
			$flag = 'gb';
			break;

		case 'Danish':
			$flag = 'dk';
			break;
		case 'English':
			$flag = 'gb';
			break;


		case 'Hebrew':
			$flag = 'il';
			break;
		case 'Hungarian':
			$flag = 'hu';
			break;
		case 'Dutch':
			$flag = 'nl';
			break;
		case 'French':
			$flag = 'fr';
			break;
		case 'Finnish':
			$flag = 'fi';
			break;

		case 'Malay':
			$flag = 'my';
			break;

		case 'Slovenian':
			$flag = 'si';
			break;
		case 'Serbian':
			$flag = 'rs';
			break;


		case 'Farsi/Persian':
			$flag = 'ir';
			break;

		case 'Urdu':
		case 'Pakistan':
			$flag = 'pk';
			break;

		case 'Portuguese':
			$flag = 'pt';
			break;
		case 'Polish':
			$flag = 'pl';
			break;
		// case 'Spanish':
		// 	$flag = 'gr';
		// 	break;

		case 'Polish':
			$flag = 'pl';
			break;
		case 'Singapore':
			$flag = 'sg';
			break;

		case 'Spanish':
			$flag = 'es';
			break;

		case 'Thai':
			$flag = 'th';
			break;

		case 'Turkish':
			$flag = 'tr';
			break;

		case 'Vietnamese':
			$flag = 'vn';
			break;

		case 'Ukrainian':
			$flag = 'ua';
			break;

		default:
			# code...
			break;
	}

	return $flag;
}