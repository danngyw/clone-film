<?php

use FastSimpleHTMLDom\Document;
use FastSimpleHTMLDom\Element;



function import_film($args){

	$args['post_type'] = 'film';
	$args['post_status'] = 'publish';

	$film_id = wp_insert_post($args);
	if( ! is_wp_error($film_id) ){
		update_post_meta($film_id,FILM_SOURCE_ID, $args[FILM_SOURCE_ID]);
		update_post_meta($film_id,'year_release', $args['year_release']);
		update_post_meta($film_id,'length_time', $args['length_time']);
		update_post_meta($film_id,'imdb_score', $args['imdb_score']);
		update_post_meta($film_id,'movie_actors', $args['movie_actors']);
		update_post_meta($film_id,'movie_genre', $args['movie_genre']);

		$genre 	= $args['movie_genre'];
		$terms 	= explode(",", $genre);
		$list 	= array();
		foreach ($terms as $key => $term_slug) {

			$term = term_exists( $term_slug, 'genre' );
			if ( $term !== 0 && $term !== null ) {

				$list[] = (int) $term['term_id'];
			} else {
				$term 	= wp_insert_term($term_slug,'genre', array());
				if( $term && ! is_wp_error($term)){
					$list[] = (int) $term->term_id;
				} else {
					var_dump($term);
					die();
				}
			}
		}

		if( $list ){
			wp_set_post_terms( $film_id, $list, 'genre' );
		}

		import_film_thumbnail($args, $film_id);
	}
	update_post_meta($film_id,'is_full_updated','notyet');

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



	// if( ! has_post_thumbnail($film_id) ){
 //    	$thumbnail = $html->find(".img-responsive");
	//     $aml = $html->find(".slide-item-wrap");
	//     $thumb = $html->find('img',1);
	//     $thumbnail_url  = $thumb->getAttribute("src");
	//     $args['source_thumbnail_url'] = $thumbnail_url;
 //       // import_film_thumbnail($args, $film_id);
 //    }

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
        	if(!is_wp_error($attach_id)){
        		set_post_thumbnail( $film_id, $attach_id );
        	}

	    }

	}
}
