<?php
get_header();
the_post();
global $post;
$film_id        = $post->post_parent;
$subtitle_id    = $sub_id =  $post_id = $post->ID;
$film           = get_post($film_id);
$thumbnail_url  = get_the_post_thumbnail_url($film_id);
$m_sub_language = get_post_meta($subtitle_id,'m_sub_language', true );
$m_rating_score = get_post_meta($subtitle_id,'m_rating_score', true );

$year_release   = get_post_meta($film_id,'year_release', true);
$film_link      = get_permalink($film_id);
?>

</div><div class="container">
<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="<?php echo $film_link;?>"><?php echo $film->post_title;;?></a></li>
    <li class="active">subtitle</li>
</ul>
<div class="row row-section">
<div class="col-md-3 col-sm-4">
<a class="slide-item-wrap" href="<?php echo $film_link;?>">

    <img alt="Lost and Delirious" src="<?php echo $thumbnail_url;?>" class="img-responsive"></a>
</div>
<div class="col-md-4 col-md-push-5 col-sm-6 text-center"></div>
<div class="col-md-5 col-md-pull-4 col-sm-8 movie-main-info text-center">
<h2><?php echo $film->post_title;?></h2>
<div class="movie-year"><?php echo $year_release;?></div>
<div class="row">
<div class="col-xs-2">
<div class="vote-column">
<p class="upvote" data-canvote="false" data-hasvoted="false" title="This subtitle is good (click again to undo)">+</p>
<div class="rating-container"><p class="rating"><?php echo $m_rating_score;?></p></div>
<p class="downvote" data-canvote="false" data-hasvoted="false" title="This subtitle is bad (click again to undo)">-</p>
</div>
</div>
<div class="col-xs-10">
<ul class="list-group  text-left">
<li class="list-group-item">
<span class="pull-right" style="padding-right: 40px;"><?php echo $m_sub_language;?><span class="flag flag-" style="position:absolute;right:10px;top:5px;"></span></span>
<span class="text-muted text-uppercase">Language:</span></li>
<li class="list-group-item">
<span class="pull-right"><span class="uploader">Slav</span></span>
<span class="text-muted text-uppercase">Uploader:</span></li>
</ul>
</div>
<div class="col-xs-12" style="margin-bottom:15px;">
<b><?php the_title();?></b>
<br><br>
<?php the_title();?></b>
</div>
<div class="col-xs-12">
    <?php
    $sub_zip_url = get_post_meta($sub_id,'sub_zip_url', true);
    $sub_zip_url = str_replace( 'http://', 'https://', $sub_zip_url );


    ?>
<a class="btn-icon download-subtitle" href="<?php echo $sub_zip_url;?>"><span class="icon32 download"></span><span class="title">DOWNLOAD SUBTITLE</span></a>
</div>
</div>
</div>
</div>
<div class="row row-section" id="comments" style="margin-top:50px;">
</div>
<div class="row">
<div class="col-md-6 col-md-offset-3 col-xs-12 text-center">
<a href="/login/">login</a> or <a href="/register/">register</a>
</div>
</div>
</div>
<div class="container"><div class="row" style="margin:10px auto;"><div class="col-xs-12" style="margin: 0px auto; text-align: center;"><div style="display:inline-block;max-width:100%;overflow:hidden;"></div></div></div></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js"></script>
<?php get_footer();?>