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

   	// $img            = $li->getElementByTagName('img');
    // $thumbnail_url  = $img->getAttribute("src");

    $thumb 	= $html->find('img',1);

    $thumbnail_url  = $thumb->getAttribute("src");

   	//$dvd_release = $html->find(".list-group-item span", 8)->text(); // DVD RELEASE:

   	$rated = $html->find(".list-group-item .pull-right", 1)->text(); // RATED
   	$released = $html->find(".list-group-item .pull-right", 3)->text(); // RELEASED
   	$dvd_release = $html->find(".list-group-item .pull-right", 4)->text(); // dvd_release
   	$box_office = $html->find(".list-group-item .pull-right", 5)->text(); // box_office
   	$company = $html->find(".list-group-item .pull-right", 0)->text(); // company
   	$writer = $html->find(".list-group-item .pull-right", 6)->text(); // WRITER:
   	$director = $html->find(".list-group-item .pull-right", 7)->text(); // director111

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
			wp_add_object_terms( $film_id, $tag_director, 'post_tag' );
		}
	}
	if( ! has_post_thumbnail($film_id) ) {
		import_film_thumbnail($thumbnail_url, $film_id);
	}
}


function import_film_thumbnail($url, $film_id = 0){

	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$timeout_seconds = 5;
	// Download file to temp dir
	$temp_file = download_url( $url, $timeout_seconds );

	 if( is_wp_error($temp_file) ){
		$url = str_replace("https://", "http://", $url);
        $temp_file = download_url( $url, $timeout_seconds );
        if( is_wp_error($temp_file) ){
            crawl_log('Insert thumbnail fail. URL: '.$url.'. Error:'.$temp_file->get_error_message());
            return false;
        }
	}
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
	        'test_form' => false,

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
        	}else{
        		crawl_log('wp_insert_attachment Fail');
        	}

	    }

	}
}
