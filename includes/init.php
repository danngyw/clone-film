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
        )
    );
}
add_action('init', 'film_custom_post_type');

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
