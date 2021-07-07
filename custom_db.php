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


$sql = "CREATE TABLE `{$wpdb->base_prefix}substitles` (
  	ID bigint(20) NOT NULL AUTO_INCREMENT,
  	film_id bigint(20) UNSIGNED NOT NULL,
  	source_id VARCHAR(200) NOT NULL,
  	sub_title VARCHAR(200) NOT NULL,
  	sub_zip_url VARCHAR(120),
  	language  VARCHAR(20) NOT NULL,
  	rating  FLOAT(11) NOT NULL,
  	PRIMARY KEY  (ID),
  	UNIQUE KEY ID (ID)
	) $charset_collate;";

dbDelta($sql);


// $table = $wpdb->prefix . 'imported_track';
// $sql = "ALTER TABLE `{$table}`
//         MODIFY COLUMN `source_id` VARCHAR(20) NOT NULL;";

// $query_result = $wpdb->query( $sql );