<?php

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE `{$wpdb->base_prefix}imported_track` (
  	ID bigint(20) NOT NULL AUTO_INCREMENT,
  	film_id bigint(20) UNSIGNED NOT NULL,
  	source_id VARCHAR(20) NOT NULL,
  	PRIMARY KEY  (ID),
  	UNIQUE KEY ID (ID)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	$tbl_subtitles = $wpdb->prefix . 'crawl_subtitles';
	$sql = "CREATE TABLE $tbl_subtitles (
	  	ID bigint(20) NOT NULL AUTO_INCREMENT,
	  	film_id bigint(20) UNSIGNED NOT NULL,
	  	source_id VARCHAR(200) NOT NULL,
	  	sub_title  text  NOT NULL,
	  	sub_zip_url  text   NULL,
	  	language  VARCHAR(200) NOT NULL,
	  	rating  FLOAT(11) NOT NULL,
	  	PRIMARY KEY  (ID),
	  	UNIQUE KEY ID (ID)
	) $charset_collate;";

	dbDelta($sql);


	// $sql = "ALTER TABLE {$tbl_subtitles}  MODIFY COLUMN `sub_title` text";
	// $wpdb->query($sql);


// $sql = "DROP TABLE $tbl_subtitles";
// $t = $wpdb->query($sql);
// var_dump($t);
// die('aaa');

// die('1');
// $table = $wpdb->prefix . 'imported_track';
// $sql = "ALTER TABLE `{$table}`
//         MODIFY COLUMN `source_id` VARCHAR(20) NOT NULL;";

// $query_result = $wpdb->query( $sql );