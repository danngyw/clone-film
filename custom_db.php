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

$table = $wpdb->prefix . 'imported_track';
$sql = "ALTER TABLE `{$table}`
        MODIFY COLUMN `source_id` VARCHAR(20) NOT NULL;";

$query_result = $wpdb->query( $sql );