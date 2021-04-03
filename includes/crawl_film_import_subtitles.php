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
	    'posts_per_page' => 3,

	);
	$query = new WP_Query($args);

	if( $query->have_posts() ){
		while ($query->have_posts()) {
			$query->the_post();
			global $post;
			$p_film = $post;
			$film_id = $p_film->ID;


			$film_source_id = get_post_meta($film_id,'film_source_id', true);
			$film_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;
			film_log('Crawl film url:'.$film_url);

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
			$count = 0;

			foreach($list->find('tr') as $key=> $tr) { // tr = element type
				if( $key == 0){
					continue;
				}
				$sub_source_id = $tr->__get('data-id');

				$exists = is_subtitle_imported($sub_source_id);

				if(! $exists ){
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
					$td_langue = $tr->find('.sub-lang');
					$sub_language =  $td_langue->text();

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

				}


			}


		}
	}







