<?php


function crawl_columns($columns){
	$columns['crawl_status'] = 'Crawled Status';
    $columns['manual_crawl'] = 'Manual Crawl';
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
          	case 'crawl_status':
            global $wpdb;
          	$is_full_update = get_post_meta($post->ID,'is_full_updated', true);

          	if($is_full_update == 'full'){
          		echo "Yes - ";
              $sql = "SELECT count(ID) as total
              FROM $wpdb->posts
              WHERE post_parent = {$film_id} AND post_type = 'subtitle'";

              $result = $wpdb->get_results($sql, OBJECT );
              if( $result ) echo $result[0]->total.'(subtitles)';


          	} else {
          		echo 'No';
          	}
           break;
    }
}