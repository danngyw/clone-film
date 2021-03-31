<?php
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