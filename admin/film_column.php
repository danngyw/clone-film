<?php


function crawl_columns($columns){
    $columns['crawl_status'] = 'Crawl Status';
     return $columns;
}
add_filter('manage_edit-film_columns', 'crawl_columns',99);



add_action('manage_posts_custom_column',  'show_crawl_status');
function show_crawl_status($name) {

    global $post;
    $link = admin_url('?page=crawl-overview&film_id='.$post->ID);
    switch ($name) {
        case 'crawl_status':
           echo '<a target="_blank" href="'.$link.'">Update subtitle</a>';
    }
}