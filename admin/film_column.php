<?php


function crawl_columns($columns){
	   $columns['crawl_status'] = 'Crawled Status';
    $columns['manual_crawl'] = 'Manual Crawl';
     $columns['source_url'] = 'Source Ur';
    return $columns;
}
add_filter('manage_edit-film_columns', 'crawl_columns',99);

add_action('manage_posts_custom_column',  'show_crawl_status');
function show_crawl_status($name) {

    global $post;
    $film_id = $post->ID;
    $link = admin_url('?page=crawl-overview&film_id='.$post->ID);
    switch ($name) {
        case 'manual_crawl':
           	echo '<a target="_blank" href="'.$link.'">Update subtitle</a>';
           	break;
        case 'source_url':
        $film_source_id = get_post_meta($post->ID,'film_source_id', true);
        $film_url     = "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;
        echo '<a target="_blank" href="'.$film_url.'">Source Url </a>';
           break;
        case 'crawl_status':
            global $wpdb;
          	$is_full_update = get_post_meta($post->ID,'is_crawled_sub', true);

          	if($is_full_update == 'done'){
          		echo "Yes - ";
              $sql = "SELECT count(ID) as total
              FROM `{$wpdb->base_prefix}subtitles`
              WHERE film_id = {$film_id} ";

              $result = (int) $wpdb->get_var($sql );


              echo $result.'(subtitles)';

              // update_post_meta($post->ID,'number_subtitles', $result[0]->total);


          	} else {
          		echo 'No';
          	}
           break;
          case 'sub_language':
            $language = get_post_meta($post->ID,'m_sub_language', true);
            echo $language;
          break;
    }
}

function subtitle_language_columns($columns){
  $columns['sub_language'] = 'Language';
    return $columns;
}
add_filter('manage_edit-subtitle_columns', 'subtitle_language_columns',99);
