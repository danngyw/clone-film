<?php

use FastSimpleHTMLDom\Document;
use FastSimpleHTMLDom\Element;

function import_film($args){

	$args['post_type'] = 'film';
	$args['post_status'] = 'publish';

	$p_id = wp_insert_post($args);
	if( ! is_wp_error($p_id) ){
		update_post_meta($p_id,FILM_SOURCE_ID, $args[FILM_SOURCE_ID]);
		update_post_meta($p_id,'year_release', $args['year_release']);
		update_post_meta($p_id,'length_time', $args['length_time']);
		update_post_meta($p_id,'imdb_score', $args['imdb_score']);
		update_post_meta($p_id,'movie_actors', $args['movie_actors']);
		update_post_meta($p_id,'movie_type', $args['movie_type']);

		import_film_thumbnail($args, $p_id);

	}
	update_post_meta($p_id,'is_full_updated','notyet');

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
/**
 * check the substile imported or not.
*/

function is_subtitle_imported($sub_source_id){
	global $wpdb;
	$sql = "SELECT pm.post_id
				FROM $wpdb->postmeta AS pm
					WHERE pm.meta_key = 'subtitle_source_id' AND pm.meta_value = '{$sub_source_id}'
						LIMIT 1";

  	return  $wpdb->query($sql);

}

/**
 * update company, idbm link, director ... of film. these information only show in the page detail url.
*/
function update_filmd_detail( $film_id, $html){

	$movie_desc     = $html->find(".movie-desc");
    $movie_content  = $movie_desc->text();
    $args['post_content'] = $movie_content;

    $args['ID'] = $film_id;
    wp_update_post($args);
    $imdb_link = $html->find(".list-group-item a");
    $imdb_link = $imdb_link->innerHtml();
   	update_post_meta($film_id,'imdb_link',$imdb_link );


   	//$dvd_release = $html->find(".list-group-item span", 8)->text(); // DVD RELEASE:
   	$director = $html->find(".list-group-item .pull-right", 7)->text(); // director
   	$dvd_release = $html->find(".list-group-item .pull-right", 4)->text(); // dvd_release
   	$released = $html->find(".list-group-item .pull-right", 3)->text(); // RELEASED
   	$rated = $html->find(".list-group-item .pull-right", 1)->text(); // RATED
   	$company = $html->find(".list-group-item .pull-right", 0)->text(); // company
   	$writer = $html->find(".list-group-item .pull-right", 6)->text(); // WRITER:


   	update_post_meta($film_id,'director', $director);
   	update_post_meta($film_id,'dvd_release', $dvd_release);
   	update_post_meta($film_id,'released', $released);
   	update_post_meta($film_id,'rated', $rated);
   	update_post_meta($film_id,'company', $company);
   	update_post_meta($film_id,'writer', $writer);



	if( ! has_post_thumbnail($film_id) ){
    	$thumbnail = $html->find(".img-responsive");
	    $aml = $html->find(".slide-item-wrap");
	    $thumb = $html->find('img',1);
	    $thumbnail_url  = $thumb->getAttribute("src");
	    $args['source_thumbnail_url'] = $thumbnail_url;
        import_film_thumbnail($args, $film_id);
    }

    update_post_meta($film_id, 'is_full_updated','full');
}


function import_film_thumbnail($args, $film_id = 0){
	$url =  $args['source_thumbnail_url'];
	require_once( ABSPATH . 'wp-admin/includes/file.php' );

	$timeout_seconds = 5;

	// Download file to temp dir
	$temp_file = download_url( $url, $timeout_seconds );

	if ( ! is_wp_error( $temp_file ) ) {

	    // Array based on $_FILE as seen in PHP file uploads
	    $file = array(
	        'name'     => basename($url), // ex: wp-header-logo.png
	        'type'     => 'image/png',
	        'tmp_name' => $temp_file,
	        'error'    => 0,
	        'size'     => filesize($temp_file),
	    );

	    $overrides = array(
	        // Tells WordPress to not look for the POST form
	        // fields that would normally be present as
	        // we downloaded the file from a remote server, so there
	        // will be no form fields
	        // Default is true
	        'test_form' => false,

	        // Setting this to false lets WordPress allow empty files, not recommended
	        // Default is true
	        'test_size' => true,
	    );

	    // Move the temporary file into the uploads directory
	    $results = wp_handle_sideload( $file, $overrides );


	    if ( !empty( $results['error'] ) ) {
	        // Insert any error handling here
	        update_post_meta($film_id,'no_thumbnail',1);
	    } else {

	    	$attachment = array(
	            'post_mime_type' => $results['type'],
	            'post_title' => basename($url),
	            'post_content' => ' ',
	            'post_status' => 'inherit'
	        );

        	$attach_id = wp_insert_attachment( $attachment, $results['file'], $film_id );
        	set_post_thumbnail( $film_id, $attach_id );

	    }

	}
}
