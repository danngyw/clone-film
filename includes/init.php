<?php

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
        )
    );
}
add_action('init', 'film_custom_post_type', 10);

function register_film_tax() {
    register_taxonomy( 'genre', 'film', array(
        'public'        => true,
        'label'        => __( 'Genre', 'textdomain' ),
        'rewrite'      => array( 'slug' => 'genre' ),
        'hierarchical' => true,
        'query_var' => true,
        )
    );

    register_taxonomy( 'language', 'film', array(
        'public'        => true,
        'label'        => __( 'Language', 'textdomain' ),
        'rewrite'      => array( 'slug' => 'language' ),
        'hierarchical' => true,
        'query_var' => true,
        )
    );

}
add_action( 'init', 'register_film_tax',99 );



function subtitle_custom_post_type() {
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
        )
    );
}
add_action('init', 'subtitle_custom_post_type');

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