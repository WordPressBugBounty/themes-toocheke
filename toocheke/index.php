<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
get_header();

// Theme & option settings
$display_multiple_series = get_option('toocheke-display-multiple-series') === '1';
$display_infinite_scroll = get_option('toocheke-infinite-scroll') === '1';
$home_layout             = get_theme_mod('home_layout_setting', 'default');
$display_manga_layout    = in_array($home_layout, ['alt-6', 'alt-7'], true);

// Template selection
if ($display_infinite_scroll) {
    get_template_part('template-parts/content', 'indexinfinitescroll');
} elseif ($display_manga_layout) {
    get_template_part('template-parts/content', 'indexmanga');
} elseif ($display_multiple_series) {
    get_template_part('template-parts/content', 'indexmultipleseries');
} else {
    get_template_part('template-parts/content', 'indexsingleseries');
}



get_sidebar();
get_footer();
