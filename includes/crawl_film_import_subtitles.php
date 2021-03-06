<?php
require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;
global $post;
$number = (int) get_option('number_film_craw_sub','5');
$args = array(
	'post_type' => 'film',
	'post_status' => 'publish',
	'meta_query' => array(
		'relation' => 'OR',
		array(
            'key'     => 'is_crawled_sub', // is_full_updated
            'value'   => 0, // notyet
            //'compare' => '>',

		),
		array(
            'key'     => 'is_crawled_sub', // is_full_updated
            'compare' => 'NOT EXISTS'

		),
	),
	'orderby'        => 'rand',
    'posts_per_page' => $number,

);

$query = new WP_Query($args);
$loop = 1;

if( $query->have_posts() ){
	while ($query->have_posts()) {
		$query->the_post();
		global $post;
		$p_film 		= $post;
		$film_id 		= $p_film->ID;
		$film_source_id = get_post_meta($film_id,'film_source_id', true);
		$film_url 		= "https://yifysubtitles.org/movie-imdb/tt".urlencode($film_source_id);
		$film_url 		= esc_url($film_url);
		$urlOnline = checkURlOnline($film_url);
		if( ! $urlOnline){
			//crawl_log('url site NotOnline: '.$film_url);
			//continue;
		}

		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		//Basically adding headers to the request
		$context = stream_context_create($opts);
		$html 	= file_get_contents($film_url,false,$context);
		// end new code

		$document 		= new Document($html);
	    $node = $document->getDocument()->documentElement;
	    $element = $document->find('iframe');
	  	$iframe = $element->__toString();

	  	update_filmd_detail($film_id, $document);
		update_post_meta($film_id, 'trailer_html',$iframe);

	 	$movie_desc     = $document->find(".movie-desc");
	    $movie_content  = $movie_desc->text();

	    $list = $document->find('.table-responsive .other-subs');
		$count = (int) get_post_meta($film_id,'number_subtitles', true);
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
				crawl_log('Sub exit.');
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
				$count++;
			}
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
		}

		update_post_meta($film_id,'number_subtitles', $count);
		update_post_meta($film_id, 'is_crawled_sub', time());
	}
	// sleep(9);
} else {
	$loop = 0;
}
if( $loop ){

	$url = home_url().'/?act=importsub&rand='.rand();

	if ( ! headers_sent() ) {
	    wp_redirect_replace($url);
	    exit;
	}
}