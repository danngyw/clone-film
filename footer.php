<?php
do_action('wp_footer');
?>
		<footer class="footer">
			<div class="container text-center">
				<div class="row">
					<div class="col-xs-12"><a href="/privacy">privacy</a> | <a href="/legal-information">legal</a> | <a href="/contact">contact</a></div>
					<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©yifysubtitles. </div>
				</div>
			</div>
		</footer>
		<?php if(  is_singular( 'film') ) {  ?>
	    	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/assets/jquery.circliful.js"></script>
	    	<script>
	    		(function($){
				    $(document).ready(function() {
				        var loader = $("#ajaxloader");

				        $("#circle-score-year").circliful({
				        });
				        $("#circle-score-length").circliful({

				        });

				        $("#circle-score-imdb").circliful({

				        });
				        $("#circle-score-tomatoes").circliful({

				        });
				    });
				})(jQuery);
			</script>

	    <?php } ?>

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

	</body>
</html>