<?php
function crawl_log($input, $file_store = ''){

    $file_store = WP_CONTENT_DIR.'/log.css';


    if( is_array( $input ) || is_object( $input ) ){
        error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. print_r($input, TRUE), 3, $file_store );
    } else {
        error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. $input . "\n" , 3, $file_store);
    }
}
/**
 * check the substile imported or not.
*/

function is_subtitle_imported_advanced($sub_source_id){
	global $wpdb;
	$sql = "SELECT pm.post_id
	  		FROM wp_posts p
				LEFT JOIN wp_postmeta as pm ON pm.post_id = p.ID

				WHERE pm.meta_key = 'subtitle_source_id' AND pm.meta_value = '{$sub_source_id}'
						LIMIT 1";
  	return  $wpdb->query($sql);

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

  	return  $wpdb->query($sql);

}
function import_subtitle_film($args, $film_id){

	$args['post_type'] 		= 'subtitle';
	$args['post_status'] 	= 'publish';
	$args['post_parent']  	= $film_id;

	$sub_id = wp_insert_post($args);

	if( ! is_wp_error($sub_id) ){

		update_post_meta( $sub_id,'subtitle_source_id', $args['sub_source_id']);
		update_post_meta( $sub_id,'m_sub_language', $args['m_sub_language']);
		update_post_meta( $sub_id,'m_sub_uploader', $args['m_sub_uploader']);
		update_post_meta( $sub_id,'m_sub_slug', $args['m_sub_slug']);
		update_post_meta( $sub_id, 'm_rating_score', $args['m_rating_score']);


		$data = array(
			'import'              => 'subtitle',
	        'sub_id'              =>  $sub_id,
	        'sub_slug'            =>$args['m_sub_slug'],
			'source'              => home_url(),
		);

		try {
	        $res   = sendSubtileRequest($data);
	       	if( $res->url ){
				update_post_meta( $sub_id,'sub_zip_url', $res->url);
			} else {
				update_post_meta($sub_id,'sub_zip_url','empty');
			}
	    } catch (Exception $e) {

	    }
	}

}


function get_flag_css($lang){
	$flag = '';
	switch ($lang) {


		case 'Arabic':
			$flag = 'sa';
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


		default:
			# code...
			break;
	}

	return $flag;
}