<?php
require_once TEMPLATEPATH."/vendor/autoload.php";
use FastSimpleHTMLDom\Document;

$oldest      = isset($_REQUEST['ipage']) ? (int) $_REQUEST['ipage']: 0;
for ($page = $oldest; $page >= 0; $page--) {

    $site_url   = "https://yifysubtitles.org/browse/page-".$page;
    $ul_css     = "ul.media-list";
    $crawl_log  = "Crawl page {$page} to import film. ";
    $home_page  =  "https://yifysubtitles.org/";
    if($page == 0){
        $crawl_log  = "Crawl home page to import film. ";
        $ul_css     = ".col-md-8 ul.media-list";
        $site_url   = "https://yifysubtitles.org/";
    }

    $html = NULL;

    $html = new Document(file_get_contents($site_url));

    $list = $html->find($ul_css);
    $count = 0;
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
            $movie_genre     = $li->find(".movie-genre",0);
            $movie_genre     = $movie_genre->text();
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
            $args['movie_genre']           = $movie_genre;

            if( function_exists('import_film') ){
              import_film($args);
            }
            unset($args);
            $count ++;
        } // import a film done.
        unset($li);
        $li = NULL;

    } // end for find li
    $crawl_log.="Imported {$count} Films. URL Crawl:".$site_url;
    crawl_log($crawl_log);
    $html = NULL;
    $list = NULL;
    unset($html);
    unset($list);
    $new_page = $page - 1;
    $url = home_url().'/?act=import&ipage='.$new_page;

    if ( ! headers_sent() ) {
        //crawl_log('Redirect to new page: '.$url);
        wp_redirect($url);
        // header("Location: $url");
        exit;
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0;url=$url\">\r\n";
    }

}