<?php
function crawl_del_subtitle_of_film($film_id){
	global $wpdb;
	$sql = "DELETE FROM `{$wpdb->posts}` WHERE  post_type = 'subtitle' AND post_parent = {$film_id}";
	crawl_log('Delete all subtiles of film.'.$film_id);
	$wpdb->query($sql);
}
add_action('after_delete_post','crawl_del_subtitle_of_film');