		<footer class="footer"><br>
			<div class="container text-center">
				<div class="row">
					<div class="col-xs-12"><a href="/about" rel="nofollow">ABOUT</a> | <a href="/privacy">PRIVACY</a> | <a href="/legal">LEGAL</a> | <a href="/dmca">DMCA</a> | <a href="/contact">CONTACT</a></div>
					<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©Roty. </div>
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
		do_action('wp_footer'); ?>
	</body>
</html>