<?php
/**
 * Template Name: Page demo
*/
require_once "vendor/autoload.php";
use FastSimpleHTMLDom\Document;
get_header();
?>
<div class="container">




		<?php //get_template_part('template/latest','movies');?>





		<div class="row"><div class="col-xs-12"><hr><div id="taboola-below-article-thumbnails"></div></div></div>


	<div class="row">
	<div class="col-md-8">

			<h4 class="section-title">Recently added movies</h4>

	 	<?php  get_recent_films();?>

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

