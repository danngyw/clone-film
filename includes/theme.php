<?php
define('FILM_SOURCE_ID','film_source_id');
use FastSimpleHTMLDom\Document;
use FastSimpleHTMLDom\Element;

function is_film_imported($id){
	global $wpdb;
	$sql = "SELECT p.ID
			FROM $wpdb->posts AS p
				LEFT JOIN $wpdb->postmeta AS pm on pm.post_id = p.ID
					WHERE p.post_type = 'film'  and pm.meta_key = 'film_source_id' AND pm.meta_value = $id
						LIMIT 1";

  	return  $wpdb->query($sql);

}

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

}
function import_subtitle_film($args, $film_id){

	$args['post_type'] 		= 'subtitle';
	$args['post_status'] 	= 'publish';
	//$args['post_parent'] 	= is_film_imported($args['film_source_id']);
	$args['post_parent']  	= $film_id;

	$sub_id = wp_insert_post($args);
	if( ! is_wp_error($sub_id) ){
		update_post_meta( $sub_id,'subtitle_source_id', $args['sub_source_id']);
		update_post_meta( $sub_id,'m_sub_language', $args['m_sub_language']);
		update_post_meta( $sub_id,'m_sub_uploader', $args['m_sub_uploader']);
		update_post_meta( $sub_id,'m_sub_slug', $args['m_sub_slug']);
		update_post_meta( $sub_id, 'm_rating_score', $args['m_rating_score']);
	}

}

function is_subtitle_imported($sub_source_id){
	global $wpdb;
	$sql = "SELECT p.ID
			FROM $wpdb->posts AS p
				LEFT JOIN $wpdb->postmeta AS pm on pm.post_id = p.ID
					WHERE p.post_type = 'subtitle'  and pm.meta_key = 'subtitle_source_id' AND pm.meta_value = $sub_source_id
						LIMIT 1";

  	return  $wpdb->query($sql);

}

function check_sub_of_filme(){
	//https://yifysubtitles.org/movie-imdb/tt9056818
	if( ! is_singular( 'film') ){
		return ;
	}
	global $post;
	$film_id 		= $post_id =  $post->ID;

	$number_subtile = (int) get_post_meta($post_id,'number_subtile', true);


	// if( $number_subtile > 0 )
	// 	return;

	$film_source_id = get_post_meta($film_id,'film_source_id', true);
	$site_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;

	$html 			= file_get_contents($site_url);
	$document = new Document($html);
    $node = $document->getDocument()->documentElement;
    $element = $document->find('iframe');
  	$iframe = $element->__toString();
 	update_post_meta($post_id, 'trailer_html',$iframe);

 	update_filmd_detail($film_id, $document);

 	$movie_desc     = $document->find(".movie-desc");
    $movie_content  = $movie_desc->text();

    $list = $document->find('.table-responsive .other-subs');
	$count = 0;

	foreach($list->find('tr') as $key=> $tr) { // tr = element type
		if( $key == 0){
			continue;
		}
		$sub_source_id = $tr->__get('data-id');

		$check = is_subtitle_imported($sub_source_id);

		if(! $check){
			$sub_title = $tr->find('td',2);

			$rating_html = $tr->find('.label-success');
			$rating_score =  $rating_html->text();


			$td_subtitle = $tr->find("td",2);
			$sub_slug = $td_subtitle->getElementByTagName('a');
			$sub_slug = $sub_slug->getAttribute("href"); // full path: /subtitles/last-breath-2019-danish-yify-305528"
			$sub_slug = substr($sub_slug, 11, -1); // cut off to :last-breath-2019-danish-yify-305528"


			$sub_title = $td_subtitle->text();
			$sub_title = substr($sub_title, 9, -1); // remove [subtitle ] in the text;



			$td_langue = $tr->find('.sub-lang');
			$sub_language =  $td_langue->text();

			$td_uploader = $tr->find(".uploader-cell a");
			$sub_uploader = $td_uploader->text();

			// $rating_cell  = $tr->find('.rating-cell');
			// $rating_cell = $rating_cell->text();



			$args['post_title'] 	= $sub_title;
			$args['sub_source_id'] 	= $sub_source_id;
			$args['film_source_id'] = $film_source_id;
			$args['m_sub_language'] = $sub_language;
			$args['m_sub_uploader'] = $sub_uploader;
			$args['m_sub_slug'] 	= $sub_slug;
			$args['m_rating_score'] = (int) $rating_score;
			var_dump($sub_title);
			echo '<br />';

			// import_subtitle_film($args, $film_id);

		}
		$count ++;

	}
	update_post_meta($post_id,'number_subtile',$count);

}

add_action('wp_footer','check_sub_of_filme');

function update_filmd_detail( $film_id, $html){

	$movie_desc     = $html->find(".movie-desc");
    $movie_content  = $movie_desc->text();
    $args['post_content'] = $movie_content;

    $args['ID'] = $film_id;
    wp_update_post($args);

	if( has_post_thumbnail($film_id) ){
    	$thumbnail = $html->find(".img-responsive");
	    $aml = $html->find(".slide-item-wrap");

	    $thumb = $html->find('img',1);
	    $thumbnail_url  = $thumb->getAttribute("src");
	    $args['source_thumbnail_url'] = $thumbnail_url;
        // import_film_thumbnail($args, $film_id);
    }
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