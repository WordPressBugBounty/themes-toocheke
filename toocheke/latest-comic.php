<?php
/**
 * Template Name: Latest Comic Page
 *
 * This is a page template you can use for the latest comic page
 *
 * @package Toocheke
 */
// Get layout and determine if it's traditional
$home_layout     = get_theme_mod('home_layout_setting', 'default');
$non_traditional = ['default', 'alt-3', 'alt-5'];
$is_traditional  = ! in_array($home_layout, $non_traditional, true);
$series_id       = null;

$args = [
    'posts_per_page' => '1',
    'post_type'      => 'comic',
    'order'          => 'DESC',
];

// If traditional, filter by the configured series
if ($is_traditional) {
    $series_id = get_option('toocheke-traditional-home-series');

    if (! empty($series_id)) {
        $args['post_parent'] = (int) $series_id; // ensure integer
    }
}

$comic_posts = get_posts($args);
if ($comic_posts) {
    $url = get_permalink($comic_posts[0]->ID);

    if ($is_traditional && ! empty($series_id)) {
        $url = add_query_arg('sid', $series_id, $url);
    }

    wp_redirect($url, 301);
    exit;
}
