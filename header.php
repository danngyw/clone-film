<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '|', true, 'right' );?></title>
		<?php
		// $title 			= get_bloginfo('name');
		// $description 	= get_bloginfo('description');
		wp_head(); ?>
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo home_url();?>" />
		<meta property="og:image" content="<?php echo get_stylesheet_directory_uri();?>/images/screenshots/screenshot01.jpg" />

		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,800italic,800' rel='stylesheet' type='text/css'>
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.theme.default.min.css" rel="stylesheet" type="text/css" />
		<?php
		if( is_home() || is_front_page() ){?>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/owl.carousel.min.js"></script>

			<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.carousel.min.css" rel="stylesheet" type="text/css" />
			<script>
				(function($){
				     $(document).ready(function() {
			            var loader = $("#ajaxloader");

			            $(".owl-carousel").owlCarousel({
			                items : 3,
			                loop:true,
						    margin:10,
						    autoplay:true,
						    autoplayTimeout:5000,
						    autoplayHoverPause:true,

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
			    })(jQuery);
		    </script>
		<?php } ?>

	</head>
	<body <?php body_class(); ?>>
		<?php get_template_part('nav','header');?>
		<?php get_search_form();?>