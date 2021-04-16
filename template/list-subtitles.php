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
?>
<div class="row">
	<h4 class="section-title"> &nbsp; All subtitles:</h4>
	<br><br>
	<div class="table-responsive">
	<table class="table other-subs">
		<thead><tr><th>Rating</th><th>Language</th><th>Release</th><th>Uploader</th></tr></thead><?php

		if($query->have_posts()){
			while ($query->have_posts()) {
				$query->the_post();
				global $post;
				$subtitle_id = $sub_id =  $post->ID;
				$m_sub_language = get_post_meta($subtitle_id,'m_sub_language', true );
				$m_rating_score = (int) get_post_meta($subtitle_id, 'm_rating_score', true );
				$flag_css 		= get_flag_css($m_sub_language);

				?>
				<tr data-id="<?php echo $post->ID;?>" class="sub-item sub-item-id-<?php echo $sub_id;?>">
					<td class="rating-cell"><span class="label label-success"><?php echo $m_rating_score;?></span></td>
					<td class="flag-cell"><span class="flag flag-<?php echo $flag_css;?>"></span><span class="sub-lang"><?php echo $m_sub_language;?></span></td>
					<td class="td-subtitle">
					<a href="<?php the_permalink();?>"><span class="text-muted">subtitle</span> <?php the_title();?></a>
					</td>

					<td class="uploader-cell"><span class="uploader">&nbsp; &nbsp;Slav</span></td>
				</tr>
				<?php
			}
		} ?>

	</table>
	</div>
</div>
<?php wp_reset_query(); ?>
<?php if($trailer_html){ ?>
	<div class="row" style="margin:20px auto;">
		<div class="col-md-offset-3 col-md-6 col-xs-12">
			<h4 class="section-title">Trailer:</h4>
			<div class="embed-responsive embed-responsive-16by9">
			<?php
			echo $trailer_html;?>
			</div>
		</div>
	</div>
<?php } ?>