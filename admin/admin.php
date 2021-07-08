<?php
use FastSimpleHTMLDom\Document;
require get_parent_theme_file_path('includes/import.php');
require get_parent_theme_file_path( '/admin/film_column.php' );
require get_parent_theme_file_path( '/admin/init_dashboard.php' );

function admin_film_menu_overview(){
	$icon = get_stylesheet_directory_uri().'/images/spider.png';
    add_menu_page('Crawl Overview', 'Crawl Overview', 'manage_options', 'crawl-overview', 'crawl_overview_output',$icon, 2 );
}
add_action('admin_menu', 'admin_film_menu_overview');

function crawl_overview_output(){

	$film_id = isset($_GET['film_id']) ? $_GET['film_id']: 0; ?>
	 <?php
		if( $film_id ){ ?>
			<div class="wrap">
			<h1>Cập nhật substile cho film</h1> <br /><p>
			<?php
			$film 		= get_post($film_id);
			if( $film && !is_wp_error($film) ){
				$sub_news 	= ManualCrwalFilmImportSubtitle($film, 1);
				$link_film  = "<a target='_blank' href='".get_permalink($film->ID)." '> ".$film->post_title."</a>";
				if($sub_news){
					echo  "Film {$link_film} Có {$sub_news} subtiles mới và đã update date thành công";
				} else {
					echo "Không có subtitle mới trong film  {$link_film}";
				}

				echo " | <a target='_blank' href='".get_permalink($film->ID)."'> View Detail Film </a>";
			} else {
				echo  'Film không tồn tại.';
			} ?>
			</p>
		</div> <?php
	} else {
		Crawl_Overview_Info();
	}
}



function list_option_number_films($number){

	for( $i= 1 ; $i <= 10 ; $i++ ){ ?>
		<option value="<?php echo $i;?>" <?php selected($i,$number);?> ><?php echo $i;?></option>
		<?php
	}
}
function Crawl_Overview_Info(){

	$ajax_url = admin_url().'admin-ajax.php';

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
	//$query = new WP_Query( $args );

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
	//$film 	= new WP_Query($args);


	$file_log 	= WP_CONTENT_DIR.'/log.css';
	$link_html 	= false;
	if( file_exists($file_log) ){
		$log_file_link  =home_url().'/wp-content/log.css?rand='.rand();
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
					<td><?php //echo $query->post_count;?></td>
				</tr>

				<tr>
					<th scope="row"><label for="mailserver_url">Số Film Chưa update subtitle:</label></th>
					<td><?php // echo $film->post_count;?></td>
				</tr>
				<tr>
					<th scope="row"><label for="mailserver_url">PHP Version Using:</label></th>
					<td><?php echo phpversion();?></td>
				</tr>

				<tr>

					<th scope="row"><label for="mailserver_url">Server Configuation:</label></th>
					<td>

					<p>
						<label for="mailserver_url">Memory Limit:</label>
						<?php echo ini_get('memory_limit');?>
					</p>
					<p>
						upload_max_filesize: <?php echo ini_get('upload_max_filesize');?> &nbsp; &nbsp;Suggest: 64M
					</p>
					<p>
						max_execution_time: <?php echo ini_get('max_execution_time');?> &nbsp; &nbsp;Suggest: 300 <br />

						max_input_time: <?php echo ini_get('max_input_time');?> &nbsp; &nbsp; Suggest: 1000 <br />
						post_max_size: <?php echo ini_get('post_max_size');?> &nbsp; &nbsp;Suggest: 64M

					</p>

					<?php
					$curl = extension_loaded('curl');
					if( ! $curl){
						echo "Please Enable Curl first.";
					}
					$curl_status = 'Disabled';
					if(function_exists('curl_version')){
						$info = curl_version();
						$curl_status = $info["version"];
					}

					echo 'Curl Version:   '.$curl_status;
					?>
					</td>

				</tr>

				<?php

				$number = get_option('number_film_craw_sub','5');

				?>
				<tr>
					<th scope="row"><p><label for="mailserver_url">Number film import substitle:</label></p></th>
					<td><select class="set-number-film-crawl">
						<?php list_option_number_films($number);?>
					</select></td>
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
			Visit link: <a target="_blank" href="<?php echo home_url();?>/?act=import&ipage=5"><?php echo home_url();?>/?act=import&ipage=5</a> để import tất cả film của trang 5,4,3,2,1 từ site nguồn.
		</p>
		<p>
			Visit link: <a  target="_blank" href="<?php echo home_url();?>/?act=importsub"><?php echo home_url();?>/?act=importsub</a> để import substile cho những film chưa update. Mỗi lần chạy update subtile cho 15 films.
		</p>
		<p>
			Quick link to import homepage: <a target="_blank" href="<?php echo home_url();?>/?act=import">Visit </a> .
		</p>
		<p>
			Manual update post thumbnail: <a target="_blank" href="<?php echo home_url();?>/?act=update_thumb">Manual update thumbnail </a> .
			Mỗi lần chạy link này, hệ thống tự kiểm tra và update 15 film chưa có thumbnail. Một số trường hợp bị timeout/overload nên không thêm upload được hình ảnh. Function này để giải quyết vấn đề trên.
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
				        url : '<?php echo $ajax_url;?>',
				        data: {
				        	action:'save_film_menu',
				        	opt: opt,
				        },
				        beforeSend  : function(event){ console.log('Insert message'); },
				        success: function(res){ console.log(res); },
				    });
				});

				$(".set-number-film-crawl").change(function(event){
				var _this = $(event.currentTarget);
					var opt = _this.val();
					$.ajax({
				        emulateJSON: true,
				        method :'post',
				        url : '<?php echo $ajax_url;?>',
				        data: {
				        	action:'set_number_film_crawl',
				        	number: opt,
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
				         url : '<?php echo $ajax_url;?>',
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
function save_number_film_crawl(){
	$opt = isset($_POST['number']) ? $_POST['number']:'5';
	update_option('number_film_craw_sub',$opt);
	wp_send_json(array('success'=>true,'msg'=>'Done'));
}

add_action( 'wp_ajax_set_number_film_crawl','save_number_film_crawl' );



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

function ManualCrwalFilmImportSubtitle($p_film, $update_film_detail = 1){
	$count_new 		= 0;
	$film_id 		= $p_film->ID;
	$film_source_id = get_post_meta($film_id,'film_source_id', true);
	$film_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;
	//$html 			= file_get_contents($film_url);

	$opts 		= array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context 	= stream_context_create($opts);
    $html 		= file_get_contents($film_url, false, $context);


	$document 		= new Document($html);
    $node = $document->getDocument()->documentElement;
    $element = $document->find('iframe');
  	$iframe = $element->__toString();

  	if($update_film_detail){ // skip update film_content, imdblink, director rate, company ...
  		update_filmd_detail($film_id, $document);
		update_post_meta($film_id, 'trailer_html',$iframe);
	}

	$list = $document->find('.table-responsive .other-subs');
	$count = 0;
	$lang_ids = array();
	foreach($list->find('tr') as $key=> $tr) { // tr = element type
		if( $key == 0){
			continue;
		}
		$sub_source_id = $tr->__get('data-id');
		$imported = is_subtitle_imported_advanced($sub_source_id);

		if( !$imported ){
			$sub_title = $tr->find('td',2);

			$rating_html = $tr->find('.label-success');
			$rating_score =  $rating_html->text();
			$td_subtitle = $tr->find("td",2);
			$sub_slug = $td_subtitle->getElementByTagName('a');
			$sub_slug = $sub_slug->getAttribute("href"); // full path: /subtitles/last-breath-2019-danish-yify-305528"
			$sub_slug = substr($sub_slug, 11, 100); // cut off to :last-breath-2019-danish-yify-305528"


			$sub_title = $td_subtitle->text();
			$sub_title = substr($sub_title, 9, -1); // remove [subtitle ] in the text;

			if( empty($sub_title) ){
				$sub_title = $sub_slug;
			}
			$td_langue = $tr->find('.sub-lang');
			$sub_language =  $td_langue->text();

			$td_uploader = $tr->find(".uploader-cell a");
			$sub_uploader = $td_uploader->text();

			$args['post_title'] 	= $sub_title;
			$args['sub_source_id'] 	= $sub_source_id;
			$args['film_source_id'] = $film_source_id;
			$args['m_sub_language'] = $sub_language;
			$args['m_sub_uploader'] = $sub_uploader;
			$args['m_sub_slug'] 	= $sub_slug;
			$args['m_rating_score'] = (int) $rating_score;


			import_subtitle_film($args, $film_id);
			$count_new++;

			$tag = term_exists( $sub_language, 'language' );

			if ( $tag !== 0 && $tag !== null ) {
				$lang_ids[] = (int) $tag['term_id'];
			} else {
				$tag 	= wp_insert_term($sub_language,'language', array('description' => 'Film Language '.$sub_language)); // insert languages
				if( $tag && ! is_wp_error($tag)){
					$lang_ids[] = (int)  $tag['term_id'];
				} else {
					crawl_log("Add Film Language Fail. Language : ".$sub_language);
				}
			}


		}
	}
	if( $lang_ids ){
		wp_add_object_terms( $film_id, $lang_ids, 'language' );
	}
	update_post_meta($film_id,'number_subtitles', $count_new);
	update_post_meta($film_id,'is_full_updated','full');
	return $count_new;
}

add_action( 'admin_init', 'crawl_codex_init' );
function crawl_codex_init() {
    add_action( 'delete_post', 'crawl_codex_sync', 10 );
}

function crawl_codex_sync( $pid ) {
    global $wpdb;
    $tbl_subtitles = $wpdb->prefix . 'subtitles';

    $sql = $wpdb->prepare( "DELETE FROM {$tbl_subtitles} WHERE film_id = %d", $tbl_subtitles, $pid );
    crawl_log('Sql del subs: '.$sql);
    $wpdb->query( $sql );

}