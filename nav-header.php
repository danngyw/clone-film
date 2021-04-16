<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="<?php echo home_url();?>/"><h1><?php echo $title;?></h1>
					<?php

					$url = get_stylesheet_directory_uri().'/images/misc/logo-small.png';
					if( has_custom_logo() ){
						$custom_logo_id  = get_theme_mod( 'custom_logo' );
						$image 			 = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						$url =  $image[0];
					}
					?>
						<img src="<?php echo $url;?>" alt="<?php echo $title;?>">
					</a>

				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<?php

						$show_link = get_option('show_menu','no');
						if( $show_link == 'yes'){
							if( is_single()  ){
							global $post;
							if( is_singular('film') ){
								$film_source_id = get_post_meta($post->ID,'film_source_id', true);
								$source_url 		= "https://yifysubtitles.org/movie-imdb/tt".$film_source_id;
							} else if( is_singular('subtitle')){
								$sub_slug = get_post_meta($post->ID,'m_sub_slug', true);
								$source_url 	= "https://yifysubtitles.org/subtitles/".$sub_slug;
							}?>
								<li><a rel="nofollow"   href="<?php echo $source_url;?>" target="_blank">Source Post</a></li>
							<?php } else { ?>
								<li><a rel="nofollow"  href="https://yifysubtitles.org/" target="_blank">Source Site</a></li><?php
							}
						}?>

						<li><a href="<?php echo home_url();?>">Login</a></li>
					</ul>
				</div>

			</div>
		</nav>