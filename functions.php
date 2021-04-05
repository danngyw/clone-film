<?php
define('FILM_SOURCE_ID','film_source_id');
require_once('includes/init.php');


require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;

require_once('includes/default.php');
require_once('includes/html.php');
require_once('debug.php');

if( is_admin() ){
    include('includes/import.php');
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
        var_dump($e);
    }


}
// add_action('wp_footer','testSendPost');


add_filter( 'widget_tag_cloud_args', 'custom_widget_tag_cloud_args' );
function custom_widget_tag_cloud_args( $args ) {
    $args['largest'] = 160;
    $args['smallest'] = 80;
    $args['unit'] = '%';
    return $args;
}