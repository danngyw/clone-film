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
function get_flag_css($lang){
	$flag = 'gb';
	switch ($lang) {


		case 'Arabic':
			$flag = 'sa';
			break;

		case 'Romanian':
			$flag = 'ro';
			break;

		case 'Polish':
			$flag = 'pl';
			break;
		case 'Indonesian':
			$flag = 'id';
			break;
		case 'Chinese':
			$flag = 'cn';
			break;
		case 'Bulgarian':
			$flag = 'bg';
			break;
		case 'German':
			$flag = 'gb';
			break;


		case 'Hebrew':
			$flag = 'il';
			break;
		case 'Hungarian':
			$flag = 'hu';
			break;
		case 'Dutch':
			$flag = 'nl';
			break;
		case 'French':
			$flag = 'fr';
			break;
		case 'Finnish':
			$flag = 'fi';
			break;
		case 'Portuguese':
			$flag = 'pt';
			break;
		case 'Polish':
			$flag = 'pl';
			break;
		case 'Spanish':
			$flag = 'gr';
			break;


		case 'Singapore':
			$flag = 'sg';
			break;
		case 'Thai':
			$flag = 'th';
			break;

		case 'Vietnamese':
			$flag = 'vn';
			break;

		default:
			# code...
			break;
	}

	return $flag;
}