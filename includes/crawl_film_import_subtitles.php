<?php
require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;
global $post;

$args = array(
	'post_type' => 'film',
	'post_status' => 'publish',
	'meta_query' => array(
		array(
            'key'     => 'is_full_updated',
            'value'   => 'notyet',
		),
	),
    'posts_per_page' => 15,

);
$query = new WP_Query($args);

if( $query->have_posts() ){
	while ($query->have_posts()) {
		$query->the_post();
		global $post;
		$p_film 		= $post;
		$film_id 		= $p_film->ID;
		$film_source_id = get_post_meta($film_id,'film_source_id', true);
		$film_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;
		// crawl_log("Crawl film ID(".$film_id.") to update subtiles. URL: ".$film_url);

		$html 			= file_get_contents($film_url);
		$document 		= new Document($html);
	    $node = $document->getDocument()->documentElement;
	    $element = $document->find('iframe');
	  	$iframe = $element->__toString();

	  	update_filmd_detail($film_id, $document);
		update_post_meta($film_id, 'trailer_html',$iframe);

	 	$movie_desc     = $document->find(".movie-desc");
	    $movie_content  = $movie_desc->text();

	    $list = $document->find('.table-responsive .other-subs');
		$count = (int) get_post_meta($film_id,'number_substitle', true);
		$lang_ids = array();
		foreach($list->find('tr') as $key=> $tr) { // tr = element type
			if( $key == 0){
				continue;
			}
			$sub_source_id = $tr->__get('data-id');

			$sub_id_exists = is_subtitle_imported_advanced($sub_source_id);

			$td_langue = $tr->find('.sub-lang');
			$sub_language =  $td_langue->text();


			if( $sub_id_exists ){
				$text_log = "Skip -- sub sourceid imported in db. Sub Source ID: ";
				//crawl_log($text_log.$sub_source_id);
			}

			if(! $sub_id_exists ){
				$sub_title = $tr->find('td',2);

				$rating_html = $tr->find('.label-success');
				$rating_score =  $rating_html->text();
				$td_subtitle = $tr->find("td",2);
				$sub_slug = $td_subtitle->getElementByTagName('a');
				$sub_slug = $sub_slug->getAttribute("href"); // full path: /subtitles/last-breath-2019-danish-yify-305528"
				$sub_slug = substr($sub_slug, 11, 100); // cut off to :last-breath-2019-danish-yify-305528"


				$sub_title = $td_subtitle->text();
				$sub_title = substr($sub_title, 9, -1); // remove [subtitle ] in the text;

				if( empty($sub_title) ){
					$sub_title = $sub_slug;
				}


				$td_uploader = $tr->find(".uploader-cell a");
				$sub_uploader = $td_uploader->text();

				$args['post_title'] 	= $sub_title;
				$args['sub_source_id'] 	= $sub_source_id;
				$args['film_source_id'] = $film_source_id;
				$args['m_sub_language'] = $sub_language;
				$args['m_sub_uploader'] = $sub_uploader;
				$args['m_sub_slug'] 	= $sub_slug;
				$args['m_rating_score'] = (int) $rating_score;


				import_subtitle_film($args, $film_id);
				// $text = "DONE: sub_source_id ".$sub_source_id." has been imported successful.";
				//crawl_log($text);
			}
			$count++;
			$tag = term_exists( $sub_language, 'language' );

			if ( $tag !== 0 && $tag !== null ) {
				$lang_ids[] = (int) $tag['term_id'];
			} else {
				$tag 	= wp_insert_term($sub_language,'language', array('description' => 'Film Language '.$sub_language)); // insert languages
				if( $tag && ! is_wp_error($tag)){
					$lang_ids[] = (int)  $tag['term_id'];
				} else {
					crawl_log("Add Film Language Fail. Language : ".$sub_language);
				}
			}


		}

		if( $lang_ids ){
			//$t = wp_set_object_terms( $film_id, $lang_ids, 'language', false );
			// wp_add_object_terms();
			$t = wp_add_object_terms( $film_id, $lang_ids, 'language' );
			if( $t && !is_wp_error($t)){
				// crawl_log("Set tax language  for film_id ".$film_id.". Success");
				// crawl_log($lang_ids);
			} else {
				// crawl_log("Set tax language  for film_id ".$film_id.". Fail");
				// crawl_log($lang_ids);
			}
		}

		update_post_meta($film_id,'number_substitle', $count);
	}
	// sleep(9);
}

$url = home_url().'/?act=importsub';

if ( ! headers_sent() ) {
    wp_redirect($url);
    exit;
}