<?php
require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;
function manually_update_filmd_thumbnail(){
    $act = isset($_GET['act']) ? $_GET['act']:'';
    if( $act !== 'thumbnail')
        return ;
    global $wpdb;
    $args = array(
        'post_type' => 'film',
        'meta_query' => array(
            array(
             'key' => '_thumbnail_id',
             'compare' => 'NOT EXISTS'
            ),
        ),
        'posts_per_page' => 15,
    );
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) :
        while($the_query->have_posts()){

            $the_query->the_post();
            global $post;
            $p_id = $post->ID;
            auto_update_film_thumbnail($p_id);

        }
    endif;

}
add_action('wp_footer','manually_update_filmd_thumbnail', 99);

function auto_update_film_thumbnail($film_id){
    $source_id  = get_post_meta($film_id,'film_source_id', true);
    $movie_url  = "https://yifysubtitles.org/movie-imdb/tt".$source_id;
    $html       = new Document(file_get_contents($movie_url));
    $thumb      = $html->find('img',1);

    $thumbnail_url  = $thumb->getAttribute("src");
    $args['source_thumbnail_url'] = $thumbnail_url;

    crawl_insert_attachment_from_url($thumbnail_url, $film_id);
}
