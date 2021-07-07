<?php
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


$list = explode(",", $movie_genre);
$first_genre = $list[0];


$term_genre = get_term_by('name',$first_genre, 'genre');
$genre_link = '';

if( $term_genre ){
	$genre_link = "<li><a href='".get_term_link($term_genre,'genre')."'>{$term_genre->name}</a></li>";
} else if( isset($list[1] ) ){
	if( !empty($list[1]) ){
		$term_genre = get_term_by('name',$list[1] , 'genre');
		if($term_genre){
			$genre_link = "<li><a href='".get_term_link($term_genre,'genre')."'>{$term_genre->name}</a></li>";
		}
	}

}

$imdb_link 		= get_post_meta($film_id, 'imdb_link', true);
$director 		= get_post_meta($film_id, 'director', true);
$dvd_release 	= get_post_meta($film_id, 'dvd_release', true);
$box_office 	= get_post_meta($film_id, 'box_office', 'N/A');
$released 		= get_post_meta($film_id, 'released', true);
$rated 			= get_post_meta($film_id, 'rated', true);
$company 		= get_post_meta($film_id, 'company', true);
$writer 		= get_post_meta($film_id, 'writer', true);
$website 		= get_post_meta($film_id, 'website', true);
?>
<div class="row">
	<div class="col-xs-12 text-center">
	<h1 class="movie-main-title"><?php the_title();?> (<?php echo $year_release;?>)</h1>
	<div class="movie-genre">
		<?php
		$i 	= 0; $total = count($list)-1; $html = '';
		foreach ($list as $text) {

			$genre = get_term_by( 'slug', $text, 'genre' );
			if($genre ){
				$html.='<a href="'.get_term_link($genre,'genre').'">'.$genre->name.'</a>';
			}
			if($i < $total){
				$html.=", ";
			} $i++;
		}
		echo $html; ?>
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
				<li class="list-group-item"><span class="pull-right">
					<?php
						function convert_name($str) {
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/(\“|\”|\?|\‘|\’|\,|\!|\%||\:|\&|\,|\%|\;|\.|#8217)/", '', $str);
		$str = preg_replace("/( )/", '-', $str);
		return $str;
	}		

			
				
echo '<a target="_blank" rel="nofollow" href="https://www.amazon.com/gp/search?ie=UTF8&tag=roty09-20&linkCode=ur2&linkId=3539f1ef63605267668f709586174a03&camp=1789&creative=9325&index=instant-video&keywords='.esc_html( get_the_title()).'"><img src="/wp-content/themes/filmsV2/images/buy_amazon.gif" alt="buy amazon" title="buy amazon" /></a>';
					?>
					
					</span> <span class="text-muted text-uppercase">Subscribe and Watch:</span></li>
				<li class="list-group-item"><span class="pull-right"><?php if($box_office) echo $box_office; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Box office:</span></li>
			</ul>
		</div>
		<div class="col-md-6 col-sm-12">
			<ul class="list-group text-left">
				<li class="list-group-item"><span class="pull-right">  <?php if($writer) echo $writer; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Writer:</span></li>
				<li class="list-group-item"><span class="pull-right"><?php if($director) echo $director; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Director:</span></li>
				<li class="list-group-item"><span class="pull-right"><?php if($website) echo $website; else echo 'N/A';?></span> <span class="text-muted text-uppercase">Website:</span></li>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-4" style="margin:20px auto;"></div>
	<div class="col-md-4 col-sm-12 col-xs-12 text-center" style="margin:20px auto;">
	</div>
</div>