
<?php
require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;
get_header();
?>
<div class="container">
	<?php
	if( is_home() || is_front_page() ){?>


		<?php // get_template_part('template/latest','movies');?>
		<?php
		$file_store = WP_CONTENT_DIR.'/log.css';
		$myfile = fopen($file_store, "r") or die("Unable to open file!");
		echo nl2br(file_get_contents($file_store ));
		fclose($myfile);
	?>

	<?php  } ?>

	<?php if( is_home() || is_front_page() ){?>
		<div class="row"><div class="col-xs-12"><hr><div id="taboola-below-article-thumbnails"></div></div></div>
	<?php } ?>

	<div class="row">
	<div class="col-md-8">
		<?php if( is_home() || is_front_page() ){?>
			<h4 class="section-title">Recently added movies</h4>
		<?php } ?>
	 	<?php // get_recent_films();?>

	</div>
	<?php get_sidebar();?>
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