<?php
/**
 * The template for displaying volume page content, reader if querystring value is set
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Toocheke
 */
get_header();
$show_sidebar = false;
if (isset($_GET['reader']) && $_GET['reader'] === 'true') {
    get_template_part('template-parts/content', 'singlemangavolumereader');
}
else{
    $show_sidebar = true;
    get_template_part('template-parts/content', 'singlemangavolume');
}

if($show_sidebar){
    get_sidebar();
}
get_footer();

