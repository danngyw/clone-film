<?php

$siteurl = get_option('siteurl', true);

$home = get_option('home', true);
echo $home;
update_option('home',$siteurl);
$home = get_option('home', true);
echo 'New Home';
echo $home;

$old_url = "https://slav.tv";
$new_url = "http://slav.tv";

$sql = "UPDATE wp_options SET option_value = replace(option_value, 'https://slav.tv', 'http://slav.tv') WHERE option_name = 'home' OR option_name = 'siteurl'";
$wpdb->query($sql);

// $sql = "UPDATE wp_options SET option_value = replace(option_value, 'oldurl.com', 'newurl.com') WHERE option_name = 'home' OR option_name = 'siteurl'"
// UPDATE wp_posts SET guid = replace(guid, 'oldurl.com','newurl.com');UPDATE wp_posts SET post_content = replace(post_content, 'oldurl.com', 'newurl.com');
// UPDATE wp_postmeta SET meta_value = replace(meta_value,'oldurl.com','newurl.com');