<?php
define('FILM_SOURCE_ID','film_source_id');


require_once('includes/init.php');


require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;

require_once('includes/default.php');
require_once('includes/html.php');
require_once('debug.php');

function is_film_imported($source_id){
    global $wpdb;
    $sql = "SELECT pm.post_id
                FROM $wpdb->postmeta AS pm
                    WHERE pm.meta_key = 'film_source_id' AND pm.meta_value = '".$source_id."'
                        LIMIT 1";

    return  $wpdb->get_row($sql);
}

if( is_admin() ){
    require_once('admin/admin.php');
}


function crawl_include_files(){
    $act    = isset($_REQUEST['act']) ? $_REQUEST['act']:false;
    if( $act == 'import' || $act == 'importsub') {
        require_once('includes/import.php');
        if($act == "import"){
            $ipage      = isset($_REQUEST['ipage']) ? (int) $_REQUEST['ipage']: 0;
            if($ipage){
                require_once ("includes/crawl_pages_import_films.php");
            } else {
                require_once ("includes/crawl_home_page_import_films.php");
            }

        } else if($act =="importsub"){
            crawl_log("start crawl subtitles");
            require_once ("includes/crawl_film_import_subtitles.php");
        }
    }
    require_once ("includes/update_fillm_detail.php");

}
add_action('init','crawl_include_files', 99);



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

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Auto Crawl Subtitles'), 'id' => 'quick-link-subtile', 'href' => home_url().'/?act=importsub' , 'meta' => array('target' => '_blank') ));

    $url = admin_url( 'edit.php?post_type=film');

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('List Films'), 'id' => 'admin-link-film', 'href' => $url));
    $subtitle = admin_url( 'edit.php?post_type=subtitle');

    $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('List Subtitles'), 'id' => 'admin-link-subtitle', 'href' => $subtitle));
    $file_log   = WP_CONTENT_DIR.'/log.css';
    if( file_exists($file_log) ){
        $log_file_link  = home_url().'/wp-content/log.css?rand='.rand();
        $wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Check Log'), 'id' => 'dwb-home', 'href' => $log_file_link, 'meta' => array('target' => '_blank')));
    }
}
add_action('admin_bar_menu', 'film_create_admin_bar_menus', 2000);


/**
 * Insert an attachment from an URL address.
 *
 * @param  String $url
 * @param  Int    $parent_post_id
 * @return Int    Attachment ID
 */
function crawl_insert_attachment_from_url($url, $film_id = 0) {

    if( !class_exists( 'WP_Http' ) )
        include_once( ABSPATH . WPINC . '/class-http.php' );

    $http = new WP_Http();
    $response = $http->request( $url );
    if( is_wp_error($response)){

        $url = str_replace("https://", "http://", $url);
        $response = $http->request( $url );
        if( is_wp_error($response) ){
            crawl_log('Insert thumbnail fail. URL: '.$url.'. Error:'.$response->get_error_message());
            return false;
        }

    }
    if( $response['response']['code'] != 200 ) {
        return false;
    }

    $upload = wp_upload_bits( basename($url), null, $response['body'] );
    if( !empty( $upload['error'] ) ) {
        return false;
    }

    $file_path = $upload['file'];
    $file_name = basename( $file_path );
    $file_type = wp_check_filetype( $file_name, null );
    $attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
    $wp_upload_dir = wp_upload_dir();

    $post_info = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
        'post_mime_type' => $file_type['type'],
        'post_title'     => $attachment_title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    // Create the attachment
    $attach_id = wp_insert_attachment( $post_info, $file_path, $film_id );
    if( !is_wp_error($attach_id) ){
        set_post_thumbnail( $film_id, $attach_id );
        //crawl_log('set_post_thumbnail DONE');
     }else{
        //crawl_log('wp_insert_attachment Fail');
     }


    // Include image.php
    // require_once( ABSPATH . 'wp-admin/includes/image.php' );

    // // Define attachment metadata
    // $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

    // // Assign metadata to attachment
    // wp_update_attachment_metadata( $attach_id,  $attach_data );

    return $attach_id;

}