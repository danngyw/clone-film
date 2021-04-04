<?php
require get_parent_theme_file_path( '/admin/film_column.php' );
function admin_film_menu_overview(){
	$icon = get_stylesheet_directory_uri().'/images/spider.png';
    add_menu_page('Crawl Overview', 'Crawl Overview', 'manage_options', 'crawl-overview', 'crawl_overview_output',$icon, 3 );
    // add_submenu_page('crawl-overview', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
    // add_submenu_page('crawl-overview', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
}
add_action('admin_menu', 'admin_film_menu_overview');
function crawl_overview_output(){

	$film_id = isset($_GET['film_id']) ? $_GET['film_id']: 0;
	?>
	<div class="wrap">
		<h1>Cập nhật substile cho film</h1>
		<br />
		<p>
		<?php
		if($film_id){
			$film 		= get_post($film_id);
			if( $film && !is_wp_error($film) ){
				$sub_news 	= reCrwalFilmImportSubtitle($film);
				if($sub_news){
					echo  "Film Có {$sub_news} subtiles mới và đã update date thành công.";
				} else {
					echo "Không có subtitle mới trong film này.";
				}
			} else {
				echo  'Film không tồn tại.';
			} ?>
		</p>
		</div>
	<?php

	} else {
		Crwa_Overview_Info();
	}


}

function Crwa_Overview_Info(){
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
	    'posts_per_page' => -1,
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
	$film 	= new WP_Query($args);

	$file_log 	= WP_CONTENT_DIR.'/log.css';
	$link_html 	= false;
	if( file_exists($file_log) ){
		$log_file_link  =home_url().'/wp-content/log.css';
		$link_html = "<a target='_blank' href='".$log_file_link."'>View Log file </a>&nbsp; &nbsp; <a class='del-log' href='#'>Delete Log</span>";
	}
	$opt = get_option('show_menu','no');
	?>
	<div class="wrap">
		<h1>Crawl Overview</h1>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="mailserver_url">Số lượng Film import hôm nay:</label></th>
					<td><?php echo $query->post_count;?></td>
				</tr>

				<tr>
					<th scope="row"><label for="mailserver_url">Số Film Chưa update substitle:</label></th>
					<td><?php echo $film->post_count;?></td>
				</tr>

				<tr>
					<th scope="row"><p><label for="mailserver_url">Hiển thị link Source Site in menu:</label></p><span> Dễ dàng so sánh thông tin</span></th>
					<td><select class="toggle-menu-link">
						<option value="yes" <?php selected('yes',$opt);?>>Yes</option>
						<option value="no" <?php selected('no',$opt);?>>No</option>
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
			Visit link: <a target="_blank" href="<?php echo home_url();?>/?act=import&ipage=2"><?php echo home_url();?>/?act=import&ipage=2</a> để import tất cả film của trang 2 từ site nguồn.
		</p>
		<p>
			Visit link: <a  target="_blank" href="<?php echo home_url();?>/?act=importsub"><?php echo home_url();?>/?act=importsub</a> để import substile cho những film chưa update. Mỗi lần chạy update subtile cho 3 films.
		</p>
		<p>
			Quick link to import homepage: <a target="_blank" href="<?php echo home_url();?>/?act=import">Visit </a> .
		</p>
	</div>
		<script type="text/javascript">
			( function( $ ) {
				$(document).ready( function($) {
					$(".toggle-menu-link").change(function(event){
					var _this = $(event.currentTarget);
						var opt = _this.val();
						$.ajax({
					        emulateJSON: true,
					        method :'post',
					        url : '<?php echo admin_url().'admin-ajax.php'; ?>',
					        data: {
					        	action:'save_film_menu',
					        	opt: opt,
					        },
					        beforeSend  : function(event){ console.log('Insert message'); },
					        success: function(res){ console.log(res); },
					    });
					});
					$(".del-log").click(function(event){
						var answer = window.confirm("Are you sure?");
						if( ! answer ){
							return false;
						}

						$.ajax({
					        emulateJSON: true,
					        method :'post',
					        url : '<?php echo admin_url().'admin-ajax.php'; ?>',
					        data: {
					        	action:'delete_log',
					        },
					        beforeSend  : function(event){ console.log('Insert message'); },
					        success: function(res){  alert(res.msg); if(res.success ) $('.del-log').remove();  },
					    });
					});
					return false;
				});
			})(jQuery);
		</script>
		<?php
}
function save_film_menu(){
	$opt = isset($_POST['opt'])?$_POST['opt']:'no';
	update_option('show_menu',$opt);
	wp_send_json(array('success'=>true,'msg'=>'Done'));
}

add_action( 'wp_ajax_save_film_menu','save_film_menu' );
function film_delete_log_file(){
	$file_log 	= WP_CONTENT_DIR.'/log.css';
	$deleted = unlink($file_log);
	$resp = array('success'=> true,'msg'=>'Log has been deleted');
	if(!$deleted){
		$resp = array('success'=> false,'msg'=>'Delete fail. Can not delete log file.');
	}
	wp_send_json( $resp );
}
add_action( 'wp_ajax_delete_log','film_delete_log_file' );
