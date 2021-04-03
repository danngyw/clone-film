<?php
define('FILM_SOURCE_ID','film_source_id');




require_once('includes/init.php');
require_once('includes/default.php');
require_once('includes/html.php');
require_once('includes/wp_head.php');

function clone_includes_file(){
    $act    = isset($_REQUEST['act']) ? $_REQUEST['act']:false;

    if( $act == 'import' || $act == 'importsub') {
        require_once "vendor/autoload.php";

        require_once('includes/import.php');
        require_once ("includes/index.php");
    }
}
add_action('after_setup_theme','clone_includes_file');



function is_film_imported($source_id){
    global $wpdb;
    $sql = "SELECT pm.post_id
                FROM $wpdb->postmeta AS pm
                    WHERE pm.meta_key = 'film_source_id' AND pm.meta_value = '{$source_id}'
                        LIMIT 1";

    return  $wpdb->query($sql);

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