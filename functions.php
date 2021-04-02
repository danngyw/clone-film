<?php
function is_film_imported($id){
    global $wpdb;
    $sql = "SELECT p.ID
            FROM $wpdb->posts AS p
                LEFT JOIN $wpdb->postmeta AS pm on pm.post_id = p.ID
                    WHERE p.post_type = 'film'  and pm.meta_key = 'film_source_id' AND pm.meta_value = $id
                        LIMIT 1";

    return  $wpdb->query($sql);

}

require_once('includes/init.php');
require_once('includes/theme.php');
require_once('includes/html.php');

require_once('includes/wp_head.php');

function clone_includes_file(){
    require_once ("includes/index.php");
}
add_action('after_setup_theme','clone_includes_file');

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
    $resp  = json_decode($response);
    return $resp;
}

function testSendPost(){


	$data = array(
		'import'              => 'subtitle',
        'sub_id'              =>  '4488',
        'source_zip_url'      => 'https://yifysubtitles.org/subtitle/mortadelo-and-filemon-mission-implausible-2014-english-yify-323617.zip',
        'sour_sub_id'         =>    323617,
        'sub_slug'            => 'mortadelo-and-filemon-mission-implausible-2014-english-yify-323617',
		'source'              => home_url(),
		'key'                 => 'value1'
	);


    try {
        $res   = sendSubtileRequest($data);
        if($res){

        }
    } catch (Exception $e) {
        var_dump($e);
    }


}
//add_action('wp_footer','testSendPost');