<?php

require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;


$latest_time_crawl = (int) get_option('latest_time_crawl', 0 );
if( time() - $latest_time_crawl < 30 ){
    // film_log('Exit because has just crawed site. Latest craw time is: '.$latest_time_crawl);
    return 1;
}



$page = (int) get_option('latest_page_crawl', 1239);

$page = $page -1;

film_log('crawl page :'.$page);

$site_url = "https://yifysubtitles.org/browse/page-".$page;
$html = new Document(file_get_contents($site_url));

$list = $html->find('ul.media-list');
$i = 1;
foreach($list->find('li') as $li) {

    $link      = $li->getElementByTagName('a');
    $fiml_slug = $link->getAttribute("href");



    $id = explode("/movie-imdb/tt", $fiml_slug);
    $source_id = $id[1];
    $exist  = is_film_imported($source_id);

    if( !$exist ){

        $title = $li->find('h3');
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



        $args['post_excerpt']         = $film_excerpt;
        $args['source_thumbnail_url'] = $thumbnail_url;
        $args[FILM_SOURCE_ID]         = $source_id;
        $args['post_title']           = $title->text();
        $args['year_release']         = $year;
        $args['length_time']          = $length;
        $args['imdb_score']           = $imdb_score;
        $args['movie_actors']         = $movie_actors;
        $args['movie_type']           = $movie_type;
        if( function_exists('import_film') ){
            import_film($args);
        }
    }
    $i ++;
}
film_log('save_latest_page_crawal:'.$page);
update_option('latest_page_crawl', $page);
update_option('latest_time_crawl', time() );
