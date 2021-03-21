<?php

require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;

$site_url = "https://yifysubtitles.org/";
$site_url = "https://yifysubtitles.org/";
// $html = file_get_contents($site_url);

// $dom = new DOMDocument();

// @$dom->loadHTML($html);

// $dom->saveHTML();

// $uls = $dom->getElementsByTagName('ul');
// echo '<p> UL </p>';


$html = new Document(file_get_contents($site_url));

//$html = file_get_html( $site_url );

$list = $html->find('.col-md-8 ul.media-list');
$i = 1;
foreach($list->find('li') as $li) {

    $aa      = $li->getElementByTagName('a');
    $fiml_slug = $aa->getAttribute("href");

    $title = $li->find('h3');

    $id = explode("/movie-imdb/tt", $fiml_slug);
    $film_id = $id[1];

    $img            = $li->getElementByTagName('img');
    $thumbnail_url  = $img->getAttribute("src");

    $year           = $li->find(".movinfo-section",0);
    $year           = $year->text();
    $year           = substr($year, 0, 4);

    $length = $li->find(".movinfo-section",1);
    $length = $length->text();
    $length = substr($length, 0, -3);

    $imdb = $li->find(".movinfo-section",2);
    $imdb = $imdb->text();
    $imdb_score = substr($imdb, 0, -4);

    $film_desc = $li->find(".movie-desc");
    $film_excerpt = $film_desc->text();
    $t = is_film_imported($film_id);

    if(!$t ){
        $args['post_excerpt']         = $film_excerpt;
        $args['source_thumbnail_url'] = $thumbnail_url;
        $args[FILM_SOURCE_ID]         = $film_id;
        $args['post_title']           = $title->text();
        $args['year_release']         = $year;
        $args['length_time']          = $length;
        $args['imdb_score']           = $imdb_score;
        import_film($args);
    }
    $i ++;
}

function manually_update_filmd_detail($film_id ){
    $film_id = 526;
    $source_id = get_post_meta($film_id,'film_source_id', true);
    $movie_url = "https://yifysubtitles.org/movie-imdb/tt".$source_id;
    var_dump($movie_url);


    $html   = new Document(file_get_contents($movie_url));
    $movie_desc = $html->find(".movie-desc");
    $movie_content = $movie_desc->text();
    $args['post_content'] = $movie_content;
    $args['ID'] = $film_id;
    wp_update_post($args);

    $thumbnail = $html->find(".img-responsive");

    var_dump($thumbnail);
}
add_action('wp_footer','manually_update_filmd_detail', 99);