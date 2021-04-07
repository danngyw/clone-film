<?php

get_header();
the_post();
global $post;
$film 			= $post;
$film_id 		= $post_id = $post->ID;
$thumbnail_url 	= get_the_post_thumbnail_url($film->ID);
$year_release  	= get_post_meta($film->ID,'year_release', true);
$length_time  	= (int) get_post_meta($film->ID,'length_time', true);
$imdb_score  	= get_post_meta($film->ID,'imdb_score', true);
$movie_actors  	= get_post_meta($film->ID,'movie_actors', true);
$movie_genre  	= get_post_meta($film->ID,'movie_genre', true);

$hour = 0;
$minutes = $length_time;
$hours = 0;
$length = $length_time.'m';
if($length_time > 60){
	$hours = round($length_time/60);
	$minutes = $length_time - $hours*60;

	$length = $hours.'h'.$minutes.'m';
}

$imdb_link 	= get_post_meta($film_id, 'imdb_link', true);
$director 	= get_post_meta($film_id, 'director', true);
$dvd_release= get_post_meta($film_id, 'dvd_release', true);
$released 	= get_post_meta($film_id, 'released', true);
$rated 		= get_post_meta($film_id, 'rated', true);
$company 	= get_post_meta($film_id, 'company', true);
$writer 	= get_post_meta($film_id, 'writer', true);


?>
<div class="container" itemscope="" itemtype="http://schema.org/Movie">
<ul class="breadcrumb">
<li><a href="<?php echo home_url();?>">Home</a></li>
<li class="active"><?php the_title();?></li>
</ul>
<div class="row">
	<div class="col-xs-12 text-center">
	<h2 class="movie-main-title"><?php the_title();?> (<?php echo $year_release;?>)</h2>
	<div class="movie-genre">
		<?php

		$list = explode(",", $movie_genre);
		$i 	= 0;
		$total = count($list)-1;
		$html = '';
		foreach ($list as $text) {

			$genre = get_term_by( 'slug', $text, 'genre' );
			if($genre ){
				$html.='<a href="'.ger_term_link($genre).'">'.$genre->name.'</a>';
			}
			if($i < $total){
				$html.=",";
			}
			$i++;
		}
		echo $html;

		 ?>


		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 col-sm-6">
	<a class="slide-item-wrap" itemprop="url" href="#"><img itemprop="image" alt="<?php the_title();?>" src="<?php echo $thumbnail_url;?>" class="img-responsive"></a>
	</div>
	<div class="col-md-4 col-md-push-5 col-sm-6"></div>
	<div class="col-md-5 col-md-pull-4 col-sm-12 movie-main-info text-center">
	<div style="margin:10px auto;">

		<div id="circle-score-year" class="circliful" data-dimension="100" data-text="<?php echo $year_release;?>" data-info="year" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="50" data-total="50" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;">

		</div>

		<div id="circle-score-length" class="circliful" data-dimension="100" data-text="<?php echo $length;?> " data-info="length" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="31" data-total="60" data-animationstep="20" data-fontsize="18" data-width="5" style="width: 100px;">

		</div>
		<div id="circle-score-imdb" class="circliful" data-dimension="100" data-text="<?php echo $imdb_score;?>" data-info="IMDB" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="<?php echo $imdb_score;?>" data-total="10" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;">

		</div>

		<div id="circle-score-tomatoes" class="circliful" data-dimension="100" data-text="N/A" data-info="Tomato" data-fgcolor="#505050" data-bgcolor="#2c2f32" data-part="0" data-total="100" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;">
		</div>
	</div>
	<div class="movie-actors"><?php echo $movie_actors;?><br></div>
	<div class="movie-desc"><?php the_content();?></div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 col-sm-6 text-center"></div>
	<div class="col-md-6 text-center"></div>
	<div class="row row-section">
		<div class="col-md-3 col-sm-6">
			<ul class="list-group text-left">
				<li class="list-group-item"><span class="pull-right"> <?php if($company) echo $company; else echo 'N/A';?> </span> <span class="text-muted text-uppercase">Company:</span></li>
				<li class="list-group-item"><span class="pull-right">  <?php if($rated) echo $rated; else echo 'NR';?></span> <span class="text-muted text-uppercase">Rated:</span></li>
				<li class="list-group-item"> <span class="pull-right"><?php echo $imdb_link;?></span> <span class="text-muted text-uppercase">IMDB:</span></li>
			</ul>
		</div>
		<div class="col-md-3 col-sm-6">
			<ul class="list-group text-left">
				<li class="list-group-item"><span class="pull-right"> <?php if($released) echo $released; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Released:</span></li>
				<li class="list-group-item"><span class="pull-right"><?php if($dvd_release) echo $dvd_release; else echo 'N/A';?></span> <span class="text-muted text-uppercase">DVD Release:</span></li>
				<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">Box office:</span></li>
			</ul>
		</div>
		<div class="col-md-6 col-sm-12">
			<ul class="list-group text-left">
				<li class="list-group-item"><span class="pull-right">  <?php if($writer) echo $writer; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Writer:</span></li>
				<li class="list-group-item"><span class="pull-right"><?php if($director) echo $director; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Director:</span></li>
				<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">Website:</span></li>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-4" style="margin:20px auto;"></div>
	<div class="col-md-4 col-sm-12 col-xs-12 text-center" style="margin:20px auto;">
	</div>
</div>
<div class="row">
<h4 class="section-title">All subtitles:</h4>
<br><br>
<div class="table-responsive">
<table class="table other-subs">
	<thead>
	<tr>
		<th>Rating</th><th>Language</th><th>Release</th><th>Uploader</th>
	</tr>
	</thead>
<tbody>
<?php
$args = array(
	'post_type' => 'subtitle',
	'post_parent' => $film_id,
	'post_status' =>'publish',
	'posts_per_page' => -1,
);
wp_reset_query();
$query  = new WP_Query($args);
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
}
wp_reset_query();
$trailer_html = get_post_meta($post_id,'trailer_html', true);
?>


</tbody>
</table>
</div>
</div>
<?php if($trailer_html){?>
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
</div>

<?php
get_footer();

