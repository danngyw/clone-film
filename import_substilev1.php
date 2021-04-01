<?php



function importSubstitle(){

    if( isset($_POST['import']) ){
        $resp = array('success' => true,'msg' => 'Import Zip Done');
        wp_send_json($resp);
        wp_die('111');
    }
}
add_action('init','importSubstitle');
