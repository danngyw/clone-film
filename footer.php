		<footer class="footer"><br>
			<div class="container text-center">
				<div class="row">
					<div class="col-xs-12"><a href="/about" rel="nofollow">ABOUT</a> | <a href="/privacy" rel="nofollow">PRIVACY</a> | <a href="/legal" rel="nofollow">LEGAL</a> | <a href="/dmca" rel="nofollow">DMCA</a> | <a href="/contact" rel="nofollow">CONTACT</a></div>
					<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©YTS Subtitles. </div>
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
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(82212241, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/82212241" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->	

</body>
</html>