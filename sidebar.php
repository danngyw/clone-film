<div class="col-md-4">
		<h4 class="section-title">Popular</h4>
		<ul class="media-list" itemscope="" itemtype="http://schema.org/Movie">
			<li class="media media-movie-clickable mmc-tiny">
			<div class="media-left media-middle"> <a href="/movie-imdb/tt3281548" itemprop="url"> <img class="media-object" src="https://img.yts.mx/assets/images/movies/little_women_2019/small-cover.jpg" alt="Little Women" height="42" itemprop="image"> </a> </div>
			<div class="media-body">
			 <a href="/movie-imdb/tt3281548">
			<h5 class="media-heading" itemprop="name">Little Women (2019)</h5>
			<small itemprop="genre">Drama, Romance</small>
			</a>
			</div>
			</li>
		</ul>
		<h4 class="section-title">Genre</h4>
		<ul class="list-group row default-list">
		<?php
		$terms = get_terms( array(
		    'taxonomy' => 'genre',
		    'hide_empty' => false,
		) );
		if ( !empty($terms) ) :

		    foreach( $terms as $term ) {
		    	$link = get_term_link($term,'genre');
		     	echo '<li class="list-group-item col-xs-4"><a href="'.$link.'">'.$term->name.'</a></li>';
			}
	    endif;?>
		</ul>
		<!-- <h4 class="section-title">Language</h4>
		<ul class="list-group row default-list">
			<li class="list-group-item col-xs-6"><a href="/language/albanian">Albanian</a></li>
			<li class="list-group-item col-xs-6"><a href="/language/arabic">Arabic</a></li>
			<li class="list-group-item col-xs-6"><a href="/language/bengali">Bengali</a></li>

		</ul> -->
	</div>