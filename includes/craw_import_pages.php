<?php

require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;


$page = rand(2, 1238);
$page = 8;

$site_url = "https://yifysubtitles.org/browse/page-".$page;
$html = new Document(file_get_contents($site_url));

$list = $html->find('ul.media-list');
$i = 1;
foreach($list->find('li') as $li) {

    $aa      = $li->getElementByTagName('a');
    $fiml_slug = $aa->getAttribute("href");

    $title = $li->find('h3');

    $id = explode("/movie-imdb/tt", $fiml_slug);
    $film_id = $id[1];

    $img            = $li->getElementByTagName('img');
    $thumbnail_url  = $img->getAttribute("src");


    $movie_type     = $li->find(".movie-genre",0);
    $movie_type     = $movie_type->text();

    $movie_actors   = $li->find(".movie-actors",0);
    $movie_actors   = $movie_actors->text();


    $year   = $li->find(".movinfo-section",0);
    $year   = $year->text();
    $year   = substr($year, 0, 4);

    $length = $li->find(".movinfo-section",1);
    $length = $length->text();
    $length = substr($length, 0, -3);

    $imdb = $li->find(".movinfo-section",2);
    $imdb = $imdb->text();
    $imdb_score = substr($imdb, 0, -4);

    $film_desc = $li->find(".movie-desc");
    $film_excerpt = $film_desc->text();
    $t  = is_film_imported($film_id);

    if(!$t ){
        $args['post_excerpt']         = $film_excerpt;
        $args['source_thumbnail_url'] = $thumbnail_url;
        $args[FILM_SOURCE_ID]         = $film_id;
        $args['post_title']           = $title->text();
        $args['year_release']         = $year;
        $args['length_time']          = $length;
        $args['imdb_score']           = $imdb_score;
        $args['movie_actors']         = $movie_actors;
        $args['movie_type']             = $movie_type;

        import_film($args);
    }
    $i ++;
}
