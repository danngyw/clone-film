<?php
define('FILM_SOURCE_ID','film_source_id');
require_once('includes/init.php');


require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;

require_once('includes/default.php');
require_once('includes/html.php');
require_once('debug.php');

if( is_admin() ){
    require_once('includes/import.php');
    require_once('admin/admin.php');
}


function crawl_include_files(){
    $act    = isset($_REQUEST['act']) ? $_REQUEST['act']:false;
    if( $act == 'import' || $act == 'importsub') {
        require_once('includes/import.php');
        if($act == "import"){
            $ipage      = isset($_REQUEST['ipage']) ? (int) $_REQUEST['ipage']: 0;
            if($ipage){
                include ("includes/crawl_pages_import_films.php");
            } else{
                include ("includes/crawl_home_page_import_films.php");
            }

        } else if($act =="importsub"){
            include ("includes/crawl_film_import_subtitles.php");
        }
    }
}
add_action('init','crawl_include_files', 99);

function is_film_imported($source_id){
    global $wpdb;
    $sql = "SELECT pm.post_id
                FROM $wpdb->postmeta AS pm
                    WHERE pm.meta_key = 'film_source_id' AND pm.meta_value = '{$source_id}'
                        LIMIT 1";

    return  $wpdb->get_row($sql);
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
	);
    try {
        $res   = sendSubtileRequest($data);
        var_dump($res);
    } catch (Exception $e) {
    }


}
// add_action('wp_footer','testSendPost');


function film_create_admin_bar_menus() {
    global $wp_admin_bar;

    $menu_id        = 'crawl_panel';
    $url            = admin_url( 'admin.php?page=crawl-overview');
    $wp_admin_bar->add_menu(array('id' => $menu_id, 'title' => __('Crawl Overview'), 'href' => $url));
    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Crawl Overview'), 'id' => 'overview-panel', 'href' => $url));





    $wp_admin_bar->add_menu( array('parent' => $menu_id, 'title' => __('Crawl Home'), 'id' => 'quick-link-home', 'href' => home_url().'/?act=import' , 'meta' => array('target' => '_blank') ));

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Import Subtitles'), 'id' => 'quick-link-subtile', 'href' => home_url().'/?act=importsub' , 'meta' => array('target' => '_blank') ));

    $url = admin_url( 'edit.php?post_type=film');

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Link Films'), 'id' => 'admin-link-film', 'href' => $url));
    $subtitle = admin_url( 'edit.php?post_type=subtitle');

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Subtitles'), 'id' => 'admin-link-subtitle', 'href' => $subtitle));
    $file_log   = WP_CONTENT_DIR.'/log.css';
    if( file_exists($file_log) ){
        $log_file_link  = home_url().'/wp-content/log.css?rand='.rand();
        $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Check Log'), 'id' => 'dwb-home', 'href' => $log_file_link, 'meta' => array('target' => '_blank')));
    }
}
add_action('admin_bar_menu', 'film_create_admin_bar_menus', 2000);