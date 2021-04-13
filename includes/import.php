<?php

use FastSimpleHTMLDom\Document;
use FastSimpleHTMLDom\Element;


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

   	$rated = $html->find(".list-group-item .pull-right", 1)->text(); // RATED
   	$released = $html->find(".list-group-item .pull-right", 3)->text(); // RELEASED
   	$dvd_release = $html->find(".list-group-item .pull-right", 4)->text(); // dvd_release
   	$box_office = $html->find(".list-group-item .pull-right", 5)->text(); // box_office
   	$company = $html->find(".list-group-item .pull-right", 0)->text(); // company
   	$writer = $html->find(".list-group-item .pull-right", 6)->text(); // WRITER:
   	$director = $html->find(".list-group-item .pull-right", 7)->text(); // director

   	$website = $html->find(".list-group-item .pull-right", 8)->text(); // website:


   	update_post_meta($film_id,'director', $director);
   	update_post_meta($film_id,'dvd_release', $dvd_release);
   	update_post_meta($film_id,'released', $released);
   	update_post_meta($film_id,'rated', $rated);
   	update_post_meta($film_id,'company', $company);
   	update_post_meta($film_id,'writer', $writer);
   	update_post_meta($film_id,'website', $website);
   	update_post_meta($film_id,'box_office', $box_office);


	if($director){
   		$tag_director = array();
		$tag = term_exists( $director, 'post_tag' );

		if ( $tag !== 0 && $tag !== null ) {
			$tag_director[] = (int) $tag['term_id'];
		} else {
			$tag 	= wp_insert_term($director,'post_tag', array('description' => 'Tag of director '.$director));
			if( $tag && ! is_wp_error($tag)){
				$tag_director[] = (int)  $tag['term_id'];
			} else{
				crawl_log("Add director fail. Name Director: ".$director);
			}
		}

		if( $tag_director ){
			wp_set_post_terms( $film_id, $tag_director, 'post_tag' );
		}
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
	    	crawl_log('wp_handle_sideload Fail');
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
        		crawl_log('set_post_thumbnail DONE');
        	}else{
        		crawl_log('wp_insert_attachment Fail');
        	}

	    }

	}
}
