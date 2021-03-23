<?php

get_header();
the_post();
global $post;
$film = $post;
$thumbnail_url = get_the_post_thumbnail_url($film->ID);
$year_release  = get_post_meta($film->ID,'year_release', true);
$length_time  = get_post_meta($film->ID,'length_time', true);
$imdb_score  = get_post_meta($film->ID,'imdb_score', true);
$hour = 0;
$minutes = $length_time;
if($length_time > 60){
	$hours = round($length_time/60);
	$minutes = $length_time - $hours*60;
}

?>
<div class="container" itemscope="" itemtype="http://schema.org/Movie">
<ul class="breadcrumb">
<li><a href="<?php echo home_url();?>">Home</a></li>
<li class="active"><?php the_title();?></li>
</ul>
<div class="row">
<div class="col-xs-12 text-center">
<h2 class="movie-main-title"><?php the_title();?> (<?php echo $year_release;?>)</h2>
<div class="movie-genre">Drama, Romance</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-sm-6">
<a class="slide-item-wrap" itemprop="url" href="/movie-imdb/tt12988016"><img itemprop="image" alt="<?php the_title();?>" src="<?php echo $thumbnail_url;?>" class="img-responsive"></a>
</div>
<div class="col-md-4 col-md-push-5 col-sm-6"></div>
<div class="col-md-5 col-md-pull-4 col-sm-12 movie-main-info text-center">
<div style="margin:10px auto;">
<div id="circle-score-year" class="circliful" data-dimension="100" data-text="<?php echo $year_release;?>" data-info="year" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="50" data-total="50" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;">
	<span class="circle-text" style="line-height: 100px; font-size: 22px;"><?php echo $year_release;?></span>
	<span class="circle-info" style="line-height: 125px;">year</span><canvas id="circle-score-year_canvas" width="100" height="100"></canvas></div>
<div id="circle-score-length" class="circliful" data-dimension="100" data-text="1h 37m" data-info="length" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="28" data-total="60" data-animationstep="20" data-fontsize="18" data-width="5" style="width: 100px;">
	<span class="circle-text" style="line-height: 100px; font-size: 18px;"><?php if( $hours) echo $hours.'h '; echo $minutes;?>min</span>
	<span class="circle-info" style="line-height: 125px;">length</span><canvas id="circle-score-length_canvas" width="100" height="100"></canvas>
</div>
<div id="circle-score-imdb" class="circliful" data-dimension="100" data-text="6.9" data-info="IMDB" data-fgcolor="green" data-bgcolor="#2c2f32" data-part="6.9" data-total="10" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;"><span class="circle-text" style="line-height: 100px; font-size: 22px;">6.9</span><span class="circle-info" style="line-height: 125px;">IMDB</span><canvas id="circle-score-imdb_canvas" width="100" height="100"></canvas></div>
<div id="circle-score-tomatoes" class="circliful" data-dimension="100" data-text="N/A" data-info="Tomato" data-fgcolor="#505050" data-bgcolor="#2c2f32" data-part="0" data-total="100" data-animationstep="20" data-fontsize="22" data-width="5" style="width: 100px;"><span class="circle-text" style="line-height: 100px; font-size: 22px;">N/A</span><span class="circle-info" style="line-height: 125px;">Tomato</span><canvas id="circle-score-tomatoes_canvas" width="100" height="100"></canvas></div>
</div>
<div class="movie-actors">Jana Kramer, Brandon Quinn, Charlene Tilton, Tim Reid<br></div>
<div class="movie-desc"><?php the_content();?></div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-sm-6 text-center"></div>
<div class="col-md-6 text-center"></div>
<div class="row row-section">
<div class="col-md-3 col-sm-6">
<ul class="list-group text-left">
<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">Company:</span></li>
<li class="list-group-item"><span class="pull-right">NR</span> <span class="text-muted text-uppercase">Rated:</span></li>
<li class="list-group-item"><span class="pull-right"><a href="https://www.imdb.com/title/tt12988016/">IMDB link</a></span> <span class="text-muted text-uppercase">IMDB:</span></li>
</ul>
</div>
<div class="col-md-3 col-sm-6">
<ul class="list-group text-left">
<li class="list-group-item"><span class="pull-right">2020-11-07</span> <span class="text-muted text-uppercase">Released:</span></li>
<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">DVD Release:</span></li>
<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">Box office:</span></li>
</ul>
</div>
<div class="col-md-6 col-sm-12">
<ul class="list-group text-left">
<li class="list-group-item"><span class="pull-right">N/A</span> <span class="text-muted text-uppercase">Writer:</span></li>
<li class="list-group-item"><span class="pull-right">Brian Herzlinger</span> <span class="text-muted text-uppercase">Director:</span></li>
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
<th>rating</th>
<th>language</th>
<th>release</th>
<th>other</th>
<th>uploader</th>
</tr>
</thead>
<tbody>
<tr data-id="307074">
<td class="rating-cell"><span class="label">0</span></td>
<td class="flag-cell"><span class="flag flag-"></span><span class="sub-lang">English</span></td>
<td>
<a href="/subtitles/a-welcome-home-christmas-2020-english-yify-307074"><span class="text-muted">subtitle</span> A.Welcome.Home.Christmas.2020.Lifetime.WEBRip.X264-Solar</a>
</td>
<td class="other-cell"></td>
<td class="uploader-cell"><a href="/user/M_I_S">M_I_S</a></td>
</tr>
<tr data-id="307155">
<td class="rating-cell"><span class="label">0</span></td>
<td class="flag-cell"><span class="flag flag-"></span><span class="sub-lang">English</span></td>
<td>
<a href="/subtitles/a-welcome-home-christmas-2020-english-yify-307155"><span class="text-muted">subtitle</span> A.Welcome.Home.Christmas.2020.1080p.WEBRip.x264.AAC-[YTS.MX]</a>
</td>
<td class="other-cell"><span class="hi-subtitle" title="hearing impaired"></span></td>
<td class="uploader-cell"><a href="/user/SubPortal">SubPortal</a></td>
</tr>
<tr data-id="307156">
 <td class="rating-cell"><span class="label">0</span></td>
<td class="flag-cell"><span class="flag flag-"></span><span class="sub-lang">English</span></td>
<td>
<a href="/subtitles/a-welcome-home-christmas-2020-english-yify-307156"><span class="text-muted">subtitle</span> A.Welcome.Home.Christmas.2020.1080p.WEBRip.x264.AAC-[YTS.MX]</a>
</td>
<td class="other-cell"></td>
<td class="uploader-cell"><a href="/user/SubPortal">SubPortal</a></td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="row" style="margin:20px auto;">
<div class="col-md-offset-3 col-md-6 col-xs-12">
<h4 class="section-title">Trailer:</h4>
<div class="embed-responsive embed-responsive-16by9">
<iframe id="video-iframe" allowfullscreen="allowfullscreen" class="embed-responsive-item" src="//www.youtube.com/embed/adIya-YXgoc?rel=0&amp;hd=1"></iframe>
</div>
</div>
</div>
</div>

<?php
get_footer();
