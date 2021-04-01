<html>
	<head>
		<?php do_action('wp_head');?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>YIFY Subtitles - subtitles for YIFY movies</title>
		<meta name="description" content="Subtitles for YIFY movies. Subtitles in any language for your favourite YIFY films.">
		<meta name="keywords" content="subtitle, movie, yify">
		<meta property="og:title" content="YIFYSubtitles.org - ultimate subtitles source" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.yifysubtitles.org" />
		<meta property="og:image" content="<?php echo get_stylesheet_directory_uri();?>/images/screenshots/screenshot01.jpg" />
		<meta property="fb:admins" content="1" />
		<meta property="fb:app_id" content="1" />
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,800italic,800' rel='stylesheet' type='text/css'>
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">


		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.theme.default.min.css" rel="stylesheet" type="text/css" />

	</head>
	<body <?php body_class(); ?>>
		<div id="ajaxloader" class="spinner-top-holder" style="display:none;">
			<div class="spinner">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="<?php echo home_url();?>"><h1>Subtitles for YIFY movie </h1>
					<img src="<?php echo get_stylesheet_directory_uri();?>/images/misc/logo-small.png" alt="YIFYSubtitles"></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right"><?php
						if(is_single()){
							global $post;
							$film_source_id = get_post_meta($post->ID,'film_source_id', true);
							$source_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;?>
							<li><a href="<?php echo $source_url;?>" target="_blank">Source Post</a></li>
						<?php } else { ?>
							<li><a href="https://yifysubtitles.org/" target="_blank">Source Site</a></li><?php
						}?>
						<li><a href="<?php echo home_url();?>">Login</a></li>
					</ul>
				</div>

			</div>
		</nav>
		<?php get_search_form();?>
