<?php
get_header();
the_post();
global $post;
$film_id        = $post->post_parent;
$subtitle_id    = $sub_id =  $post_id = $post->ID;
$film           = get_post($film_id);
$thumbnail_url  = get_the_post_thumbnail_url($film_id);
$m_sub_language = get_post_meta($subtitle_id,'m_sub_language', true );
$m_rating_score = get_post_meta($subtitle_id,'m_rating_score', true );

$year_release   = get_post_meta($film_id,'year_release', true);
?>

</div><div class="container">
<ul class="breadcrumb">
<li><a href="/">Home</a></li>
<li><a href="/movie-imdb/tt0245238"><?php echo $film->post_title;;?></a></li>
<li class="active">subtitle</li>
</ul>
<div class="row row-section">
<div class="col-md-3 col-sm-4">
<a class="slide-item-wrap" href="/movie-imdb/tt0245238">

    <img alt="Lost and Delirious" src="<?php echo $thumbnail_url;?>" class="img-responsive"></a>
</div>
<div class="col-md-4 col-md-push-5 col-sm-6 text-center"></div>
<div class="col-md-5 col-md-pull-4 col-sm-8 movie-main-info text-center">
<h2><?php echo $film->post_title;?></h2>
<div class="movie-year"><?php echo $year_release;?></div>
<div class="row">
<div class="col-xs-2">
<div class="vote-column">
<p class="upvote" data-canvote="false" data-hasvoted="false" title="This subtitle is good (click again to undo)">+</p>
<div class="rating-container"><p class="rating"><?php echo $m_rating_score;?></p></div>
<p class="downvote" data-canvote="false" data-hasvoted="false" title="This subtitle is bad (click again to undo)">-</p>
</div>
</div>
<div class="col-xs-10">
<ul class="list-group  text-left">
<li class="list-group-item">
<span class="pull-right" style="padding-right: 40px;"><?php echo $m_sub_language;?><span class="flag flag-" style="position:absolute;right:10px;top:5px;"></span></span>
<span class="text-muted text-uppercase">Language:</span></li>
<li class="list-group-item">
<span class="pull-right"><a href="/user/Ceyx">Ceyx</a></span>
<span class="text-muted text-uppercase">Uploader:</span></li>
</ul>
</div>
<div class="col-xs-12" style="margin-bottom:15px;">
<b><?php the_title();?></b>
<br><br>
<?php the_title();?></b>
</div>
<div class="col-xs-12">
    <?php
    $sub_zip_url = get_post_meta($sub_id,'sub_zip_url', true);
    $sub_zip_url = str_replace( 'http://', 'https://', $sub_zip_url );

    ?>
<a class="btn-icon download-subtitle" href="<?php echo $sub_zip_url;?>"><span class="icon32 download"></span><span class="title">DOWNLOAD SUBTITLE</span></a>
</div>
</div>
</div>
</div>
<div class="row row-section" id="comments" style="margin-top:50px;">
</div>
<div class="row">
<div class="col-md-6 col-md-offset-3 col-xs-12 text-center">
<a href="/login/">login</a> or <a href="/register/">register</a>
</div>
</div>
</div>
<div class="container"><div class="row" style="margin:10px auto;"><div class="col-xs-12" style="margin: 0px auto; text-align: center;"><div style="display:inline-block;max-width:100%;overflow:hidden;"></div></div></div></div>
<footer class="footer">
<div class="container text-center">
<div class="row">
<div class="col-xs-12"><a href="/privacy">privacy</a> | <a href="/legal-information">legal</a> | <a href="/contact">contact</a></div>
<div class="col-xs-12 text-muted">All images and subtitles are copyrighted to their respectful owners unless stated otherwise. This website is not associated with any external links or websites. ©yifysubtitles. </div>
</div>
</div>
</footer>

<div class="modal fade" id="dialog-select-language" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Select favourite languages</h4>
</div>
<div class="modal-body">
<p>Available languages</p>
<ul class="lang-wrap">
<li data-lang-id="1">Albanian</li>
<li data-lang-id="2">Arabic</li>
 <li data-lang-id="18823060">Armenian</li>
<li data-lang-id="20147036">Basque</li>
<li data-lang-id="20181748">Belarusian</li>
<li data-lang-id="3">Bengali</li>
<li data-lang-id="18655663">Big 5 code</li>
<li data-lang-id="20135733">Bosnian</li>
<li data-lang-id="4">Brazilian Portuguese</li>
<li data-lang-id="18655415">Brazillian Portuguese</li>
<li data-lang-id="5">Bulgarian</li>
<li data-lang-id="20147129">Bulgarian/ English</li>
<li data-lang-id="20134947">Burmese</li>
<li data-lang-id="20176716">Cambodian/Khmer</li>
<li data-lang-id="20142782">Catalan</li>
<li data-lang-id="6">Chinese</li>
<li data-lang-id="18654695">Chinese BG code</li>
<li data-lang-id="7">Croatian</li>
<li data-lang-id="8">Czech</li>
<li data-lang-id="9">Danish</li>
<li data-lang-id="10">Dutch</li>
<li data-lang-id="20180418">Dutch/ English</li>
<li data-lang-id="11">English</li>
<li data-lang-id="20153140">English/ German</li>
<li data-lang-id="20159963">Esperanto</li>
<li data-lang-id="18823063">Estonian</li>
<li data-lang-id="12">Farsi/Persian</li>
<li data-lang-id="13">Finnish</li>
<li data-lang-id="14">French</li>
<li data-lang-id="15">German</li>
<li data-lang-id="16">Greek</li>
<li data-lang-id="17">Hebrew</li>
<li data-lang-id="20135827">Hindi</li>
<li data-lang-id="18">Hungarian</li>
<li data-lang-id="18655335">Icelandic</li>
<li data-lang-id="19">Indonesian</li>
<li data-lang-id="20">Italian</li>
<li data-lang-id="21">Japanese</li>
<li data-lang-id="20173512">Kannada</li>
<li data-lang-id="22">Korean</li>
<li data-lang-id="20139400">Kurdish</li>
<li data-lang-id="20147151">Latvian</li>
<li data-lang-id="23">Lithuanian</li>
<li data-lang-id="24">Macedonian</li>
<li data-lang-id="25">Malay</li>
<li data-lang-id="18656940">Malayalam</li>
<li data-lang-id="20137262">Nepali</li>
<li data-lang-id="26">Norwegian</li>
<li data-lang-id="20138338">Pashto</li>
<li data-lang-id="27">Polish</li>
<li data-lang-id="28">Portuguese</li>
 <li data-lang-id="29">Romanian</li>
<li data-lang-id="30">Russian</li>
<li data-lang-id="31">Serbian</li>
<li data-lang-id="20135079">Sinhala</li>
<li data-lang-id="18823351">Slovak</li>
<li data-lang-id="32">Slovenian</li>
<li data-lang-id="33">Spanish</li>
<li data-lang-id="20145757">Sundanese</li>
<li data-lang-id="20192074">Swahili</li>
<li data-lang-id="34">Swedish</li>
<li data-lang-id="20139809">Tagalog</li>
<li data-lang-id="20135325">Tamil</li>
<li data-lang-id="20138175">Telugu</li>
<li data-lang-id="35">Thai</li>
<li data-lang-id="36">Turkish</li>
<li data-lang-id="18656518">Ukrainian</li>
<li data-lang-id="37">Urdu</li>
<li data-lang-id="38">Vietnamese</li>
</ul>
<p>Selected languages</p>
<ul class="lang-wrap selected">
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary" id="save-fav-lang">Save changes</button>
</div>
</div>
</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/typeahead.jquery.js?1"></script>
<script>
$(document).ready(function () {
        var loader = $("#ajaxloader");

        var width = $(window).width();
        Cookies.set('ys-sw', width, { expires: 30, path: '/', domain: '.slav.tv' });
        $(window).resize(function() {
            width = $(window).width();
            Cookies.set('ys-sw', width, { expires: 30, path: '/', domain: '.slav.tv' });
        });

        /*start select language dialog*/
        $('#dialog-select-language').on("click", ".lang-wrap:not(.selected) li", function() {
                $(".lang-wrap.selected").append('<li data-lang-id="'+$( this ).attr("data-lang-id")+'">'+$(this).text()+'</li>');
                $(this).remove();
                save_favourite_languages();
        });
        $('#dialog-select-language').on("click", ".lang-wrap.selected li", function() {
                $(".lang-wrap:not(.selected)").append('<li data-lang-id="'+$( this ).attr("data-lang-id")+'">'+$(this).text()+'</li>');
                $(this).remove();
                save_favourite_languages();
        });

        function save_favourite_languages() {
                var lang = "";
                $('.fav-lng-li').remove();
                $( '.lang-wrap.selected li' ).each(function( index ) {
                        lang = lang + $( this ).attr("data-lang-id") + '-';
                        $('#fav-lng-divider').after('<li class="fav-lng-li"><a href="#" data-lang-id="'+$( this ).attr("data-lang-id")+'">'+$( this ).text()+'</a></li>');
                });
                Cookies.set('ys-lang', lang, { expires: 30, path: '/', domain: '.slav.tv' });
        }

        $('#save-fav-lang').click(function() {
                location.reload();
        });
        /*end select language dialog*/
        $('#qSearch').typeahead({
            hint: true,
            highlight: true,
            minLength: 2
            },
            {
                name: 'rms',
                limit: 15,
                displayKey: 'movie',
                source: function (q, sync, async) {
                    $.ajax('/ajax/search/?mov='+q, {
                            success: function(data, status){  async(data); }
                    });
                }
            }).bind("typeahead:select", function(obj, selected, name) {
                    window.location = '/movie-imdb/' + selected.imdb;
            } );


            toastr.options = {
                "showDuration": "10",
                "hideDuration": "10",
                "timeOut": "3000",
                "extendedTimeOut": "200",
                "showEasing": "linear",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "preventDuplicates": true
            };
    });
</script>
<script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101253065);</script>
<script async src="//static.getclicky.com/js"></script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/101253065ns.gif" /></p></noscript>
</body>
</html>