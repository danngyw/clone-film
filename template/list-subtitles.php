<?php
wp_reset_query();
global $post, $film_id;

$args = array(
	'post_type' => 'subtitle',
	'post_parent' => $film_id,
	'post_status' =>'publish',
	'posts_per_page' => -1,
	'order' => 'ASC',// abc 1, 2 3
	'meta_query' => array(

        'city_clause' => array(
            'key' => 'm_sub_language',
            'compare' => 'EXISTS',
        ),
    ),
    'orderby' => array(
        'city_clause' => 'ASC',
    ),

);

$query  = new WP_Query($args);
$trailer_html 	= get_post_meta($film_id,'trailer_html', true);

$tbl_subtitles = $wpdb->prefix . 'subtitles';
$sql = "SELECT * FROM $tbl_subtitles WHERE film_id = $film_id";

$results = $wpdb->get_results($sql);
?>

<?php if(true)  { ?>
<div class="row">
	<h2 class="section-title" style="font-size: 18px;">All subtitles for "<?php the_title();?>" Movie:</h2>
	<div class="table-responsive">
	<table class="table other-subs">
		<thead><tr><th>Rating</th><th>Language</th><th>Release</th><th>Link</th></tr></thead><?php
		if($results){
			foreach($results as $sub){
				$sub_id = $sub->source_id;
				$sub_title = $sub->sub_title;
				$language = $sub->language;
				$rating = $sub->rating;
				$sub_zip_url = $sub->sub_zip_url;
				$flag_css 		= get_flag_css($language);
				$css 		= wp_is_mobile() ? 'is_mobile' :'is_desktop';
				$btn_download  = '<a follow class="btn-download '.$css.'" href="'.$sub_zip_url.'"><span class="title">DOWNLOAD</span></a>';
				?>
				<tr data-id="<?php echo $post->ID;?>" class="sub-item sub-item-id-<?php echo $sub_id;?>">
						<td class="rating-cell"><span class="label label-success"><?php echo $rating;?></span></td>
						<td class="flag-cell"><span class="flag flag-<?php echo $flag_css;?>"></span><span class="sub-lang"><?php echo $language;?></span></td>
						<td class="td-subtitle">

						<span class="text-muted">subtitle</span><span class="name-subtitle"> <?php echo $sub_title;?></span>
						<?php if( wp_is_mobile()){ echo '<br />'.$btn_download; } ?>
						</td>
						<?php if( ! wp_is_mobile()){ ?>
							<td class="uploader-cell"><span class="uploader"> <?php echo $btn_download;?></span></td>
						<?php } ?>
					</tr>
					<?php

			}
		} ?>

	</table>
	</div>
</div>

<?php } ?>

<?php wp_reset_query(); ?>
<?php if($trailer_html){ ?>
	<div class="row" style="margin:20px auto;">
		<div class="col-md-offset-3 col-md-6 col-xs-12">
			<h2 class="section-title" style="font-size: 18px;">"<?php echo esc_html( get_the_title() ); ?>" Trailer:</h2>
			<div class="embed-responsive embed-responsive-16by9">
			<?php
			echo $trailer_html;?>
		</div>
		</div>
	</div>
<?php } ?>