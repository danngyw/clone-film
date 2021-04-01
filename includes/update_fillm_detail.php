<?php
require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;
function manually_update_filmd_thumbnail(){
    global $wpdb;
    $args = array(
        'post_type' => 'film',
        'meta_query' => array(
            array(
             'key' => '_thumbnail_id',
             'compare' => 'NOT EXISTS'
            ),
        ),
        'posts_per_page' => 3,
    );
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) :
        while($the_query->have_posts()){

            $the_query->the_post();
            get_the_title();
            global $post;
            $p_id = $post->ID;
            auto_update_film_thumbnail($p_id);

        }
    endif;

}
 add_action('wp_footer','manually_update_filmd_thumbnail', 99);

function manually_update_filmd_detail($film_id ){
    $film_id = 526;
    $source_id = get_post_meta($film_id,'film_source_id', true);
    $movie_url = "https://yifysubtitles.org/movie-imdb/tt".$source_id;



    $html   = new Document(file_get_contents($movie_url));
    $movie_desc = $html->find(".movie-desc");
    $movie_content = $movie_desc->text();
    $args['post_content'] = $movie_content;
    $args['ID'] = $film_id;
    wp_update_post($args);

    $thumbnail = $html->find(".img-responsive");
    $aml = $html->find(".slide-item-wrap");


    // foreach($html->find('img') as $img) {


    // }
    $thumb = $html->find('img',1);
    $thumbnail_url  = $thumb->getAttribute("src");
    $args['source_thumbnail_url'] = $thumbnail_url;
    if( has_post_thumbnail($film_id) ){
        import_film_thumbnail($args, $film_id);
    }


}
add_action('wp_footer','manually_update_filmd_detail', 99);

function auto_update_film_thumbnail($film_id){
    $source_id = get_post_meta($film_id,'film_source_id', true);
    $movie_url = "https://yifysubtitles.org/movie-imdb/tt".$source_id;
    $html   = new Document(file_get_contents($movie_url));
    $thumb = $html->find('img',1);

    $thumbnail_url  = $thumb->getAttribute("src");
    $args['source_thumbnail_url'] = $thumbnail_url;

    import_film_thumbnail($args, $film_id);
}
