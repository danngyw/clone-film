<?php
get_header();
the_post();
global $post, $film_id;
$film 			= $post;
$film_id 		= $post_id = $post->ID;
$movie_genre  	= get_post_meta($film_id,'movie_genre', true);
$list = explode(",", $movie_genre);
$first_genre = $list[0];

$term_genre = get_term_by('name',$first_genre, 'genre');
$genre_link = '';

if( $term_genre ){
	$genre_link = "<li><a href='".get_term_link($term_genre,'genre')."'>{$term_genre->name}</a></li>";
} else if( isset($list[1] ) ){
	if( !empty($list[1]) ){
		$term_genre = get_term_by('name',$list[1] , 'genre');
		if($term_genre){
			$genre_link = "<li><a href='".get_term_link($term_genre,'genre')."'>{$term_genre->name}</a></li>";
		}
	}

}?>
<div class="container" itemscope="" itemtype="http://schema.org/Movie">
	<ul class="breadcrumb">
		<li><a href="<?php echo home_url();?>">Home</a></li>
		<?php echo $genre_link;?> <li class="active"><?php the_title();?></li>
	</ul>
	<?php get_template_part('template/film','detail');?>
	<?php get_template_part('template/list','subtitles');?>

</div>

<?php get_footer(); ?>