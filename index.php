
<?php

get_header();
$paged = get_query_var('paged');

$class_class = "col-md-8";
$show_sidebar = 1;
if($paged > 1){
	$show_sidebar = 0;
	$css_class = "col-sm-12";
}
?>
<div class="container">
	<?php
	if( is_home() || is_front_page() ){?>


		<?php get_template_part('template/latest','movies');?>
		<?php
		// $file_store = WP_CONTENT_DIR.'/log.css';
		// $myfile = fopen($file_store, "r") or die("Unable to open file!");
		// echo nl2br(file_get_contents($file_store ));
		// fclose($myfile);
		?>

	<?php  } ?>

	<?php if( is_home() || is_front_page() ){?>
		<div class="row"><div class="col-xs-12"><hr><div id="taboola-below-article-thumbnails"></div></div></div>
	<?php } ?>

	<div class="row">

	<div class="<?php echo $css_class;?>">
		<?php if( is_home() || is_front_page() ){?>
			<h4 class="section-title">Recently added movies</h4>
		<?php } ?>
	 	<?php get_recent_films();?>

	</div>
	<?php if($show_sidebar) get_sidebar();?>
	</div>
</div>
<?php get_footer();


//foreach($html->find('ul.media-list') as $ul)
//{
       // foreach($ul->find('li') as $li)
       // {
       //  	var_dump($li);
       // }
//}


// https://github.com/dimabdc/PHP-Fast-Simple-HTML-DOM-Parser/blob/master/README.md


//$html = $dom->saveHTML($data);

//https://github.com/dimabdc/PHP-Fast-Simple-HTML-DOM-Parser