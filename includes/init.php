<?php
function fix_taxonomy_pagination ( $query ) {
  // not an admin page and it is the main query
  if (!is_admin() && $query->is_main_query()){

    if( is_tax() || is_tag() ){
      // where 24 is number of posts per page on custom taxonomy pages
      $query->set('posts_per_page', 20);

    }
  }
}
add_action( 'pre_get_posts', 'fix_taxonomy_pagination' );

function film_custom_post_type() {
    add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );


    register_post_type('film',
        array(
            'labels'      => array(
                'name'          => __( 'Films', 'textdomain' ),
                'singular_name' => __( 'Film', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => 'film' ), // my custom slug
            'supports'  => array( 'title', 'editor','custom-fields','thumbnail', 'author','excerpt'),
            'taxonomies' => array('post_tag','genre','language'),
            'menu_position' => 2
        )
    );
    register_post_type('subtitle',
        array(
            'labels'      => array(
                'name'          => __( 'Subtitles', 'textdomain' ),
                'singular_name' => __( 'Subtitle', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => 'subtitle' ), // my custom slug
            'supports'  => array( 'title', 'editor','custom-fields', 'author','excerpt'),
            'menu_position' => 3,
            'taxonomies' => array('language'),
        )
    );



}
add_action('init', 'film_custom_post_type', 5);

function register_film_tax() {

    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Genres', 'textdomain' ),
        'all_items'         => __( 'All Genres', 'textdomain' ),
        'parent_item'       => __( 'Parent Genre', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
        'edit_item'         => __( 'Edit Genre', 'textdomain' ),
        'update_item'       => __( 'Update Genre', 'textdomain' ),
        'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
        'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
        'menu_name'         => __( 'Genre', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    );

    register_taxonomy( 'genre', array( 'film' ), $args );


    $labels = array(
        'name'              => _x( 'Languages', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Language', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Language', 'textdomain' ),
        'all_items'         => __( 'All Languages', 'textdomain' ),
        'parent_item'       => __( 'Parent Language', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Language:', 'textdomain' ),
        'edit_item'         => __( 'Edit Language', 'textdomain' ),
        'update_item'       => __( 'Update Language', 'textdomain' ),
        'add_new_item'      => __( 'Add New Language', 'textdomain' ),
        'new_item_name'     => __( 'New Language Name', 'textdomain' ),
        'menu_name'         => __( 'Languages', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
       // 'rewrite'           => array( 'slug' => 'language' ),
        'rewrite' => array(
            'slug'          => 'language',
            'with_front'    => true,
            'hierarchical'  => true
        ),
    );

    register_taxonomy( 'language', array( 'film', ), $args );

    unset( $args );
    unset( $labels );
}
add_action( 'init', 'register_film_tax',99 );





function wpdocs_setup_theme() {
    add_theme_support( 'post-thumbnails', array( 'post', 'film' ) );
    set_post_thumbnail_size( 230, 345 );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'wpdocs_setup_theme' );




function film_theme_enqueue_styles() {

    $parent_style = 'jobcareertheme';
    wp_enqueue_style( 'clone-film', get_stylesheet_uri() );

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/app.css' );

}
add_action( 'wp_enqueue_scripts', 'film_theme_enqueue_styles' );


function crawl_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'textdomain' ),
        'id'            => 'home_sidebar',
        'description'   => __( 'Widgets in this area will be shown on home page.', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h4 class="section-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'crawl_theme_slug_widgets_init' );