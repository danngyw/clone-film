<?php

function my_menu_pages(){
    add_menu_page('Crawl Overview', 'Crawl Overview', 'manage_options', 'crawl-overview', 'crawl_overview_output' );
    // add_submenu_page('crawl-overview', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
    // add_submenu_page('crawl-overview', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
}
add_action('admin_menu', 'my_menu_pages');
function crawl_overview_output(){ ?>
	<div class="wrap">
		<h1>Crawl Overview</h1>

<?php
$args = array(
		'post_type' => 'film',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
	            'key'     => 'is_full_updated',
	            'value'   => 'notyet',
			),
		),
	    'posts_per_page' => 3,

	);

$today = date( 'Y-m-d' );
$args = array(
    'post_type' => 'film',
    'post_status' => 'publish',
    'date_query' => array(
        'after' => 'today',
        'inclusive'         => true,
    ),
);
$query = new WP_Query( $args );

$args = array(
	'post_type' => 'film',
	'post_status' => 'publish',
	'meta_query' => array(
		array(
            'key'     => 'is_full_updated',
            'value'   => 'notyet',
		),
	),
    'posts_per_page' => -1,

);
$film = new WP_Query($args);

$file_log = WP_CONTENT_DIR.'/log.css';
$link_html = false;
if( file_exists($file_log)){
	$log_file_link  =home_url().'/wp-content/log.css';
	$link_html = "<a target='_blank' href='".$log_file_link."'>View Log file </a>";
}
 ?>

<table class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row"><label for="mailserver_url">Số lượng film import hôm nay:</label></th>
			<td><?php echo $query->post_count;?></td>
		</tr>
	<tbody>
		<tr>
			<th scope="row"><label for="mailserver_url">Số Film Chưa update substitle:</label></th>
			<td><?php echo $film->post_count;?></td>
		</tr>

		<tr>
			<th scope="row"><p><label for="mailserver_url">Hiển thị link Source Site in menu:</label></p><span> Dễ dàng so sánh thông tin</span></th>
			<td><select>
				<option>Yes</option>
				<option>No</option>
			</select></td>
		</tr>

		<?php if($link_html){?>
		<tr>
			<th scope="row"><label for="mailserver_login">Check Log</label></th>
			<td><?php echo $link_html;?></td>
		</tr>
		<?php } ?>

	</tbody>
</table>
<h2> NOTE</h2>
<p>
	Visit link: <a href="<?php echo home_url();?>/?act=import&ipage=2"><?php echo home_url();?>/?act=import&ipage=2</a> để import tất cả film của trang 2 từ site nguồn.
</p>
<p>
	Visit link: <a href="<?php echo home_url();?>/?act=importsub"><?php echo home_url();?>/?act=importsub</a> để import substile của những film chưa update. Mỗi lần chạy update subtile cho 2 film
</p>

 <?php
}