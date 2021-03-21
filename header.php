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
		<meta property="og:image" content="http://www.yifysubtitles.org/images/screenshots/screenshot01.jpg" />
		<meta property="fb:admins" content="1" />
		<meta property="fb:app_id" content="1" />
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,800italic,800' rel='stylesheet' type='text/css'>
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/owl.carousel.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.carousel.min.css" rel="stylesheet" type="text/css" />
<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.theme.default.min.css" rel="stylesheet" type="text/css" />
<script>
    $(document).ready(function() {
            var loader = $("#ajaxloader");

            $(".owl-carousel").owlCarousel({
                    items : 3,
                    autoplay:true,
                    autoplayHoverPause:true,
                    	autoplayTimeout:5000,
                    loop: true,
                    responsive : {
                            0 : {
                                    items : 1,
                            },
                            // breakpoint from 480 up
                            480 : {
                                    items : 2,
                            },
                            // breakpoint from 768 up
                            768 : {
                                    items : 3,
                            },
                            992 : {
                                    items : 4,
                            },
                            // breakpoint from 1200 up
                            1200 : {
                                    items : 5,
                            }
                    }
            });
    });
    </script>



	</head>
	<body <?php body_class(); ?>>
	<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
		<a class="navbar-brand" href="<?php echo home_url();?>"><h1>Subtitles for YIFY movie </h1><img src="https://yifysubtitles.org/images/misc/yifysubtitles-logo-small.png" alt="YIFYSubtitles"></a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li>
			<a href="https://yifysubtitles.org/" target="_blank">Source Site</a>
			</li>
				<li>
				<a href="/login">Login</a>
				</li>
			</ul>
		</div>

	</div>
	</nav>

	<div class="container">
	<div class="row">
	<div class="col-lg-6 col-lg-offset-3 col-xs-12" style="margin-bottom:20px">
	<form role="search" action="/search">
	<div class="input-group">
	<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input type="text" class="form-control tt-hint" data-provide="typeahead" autocomplete="off" autofocus="" readonly="" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(24, 40, 52);"><input type="text" class="form-control tt-input" id="qSearch" placeholder="Search" name="q" data-provide="typeahead" autocomplete="off" autofocus="" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;open sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-rms"></div></div></span>
	<div class="input-group-btn">
	<button class="btn btn-link" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	</div>
	</div>
	</form>
	</div>
	</div>
	</div>