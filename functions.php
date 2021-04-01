<?php
include_once('includes/init.php');
include_once('includes/theme.php');
include_once('includes/html.php');

include_once('includes/wp_head.php');

require_once TEMPLATEPATH."/includes/index.php";


require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;

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

function httpPost($url, $data) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function sendSubtileRequest( $data ) {
	$url = "https://data.slav.tv/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function testSendPost(){
	echo 'Test Request';
	$url = "https://data.slav.tv/";
	$data = array(
		'source' => home_url(),
		'key' => 'value1'
	);
	$res = httpPost($url,$data);
	var_dump($res);
}
add_action('wp_footer','testSendPost');