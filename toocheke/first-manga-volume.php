<?php
/**
 * Template Name: First Manga Volume Page
 *
 * This is a page template you can use for the first manga volume page
 *
 * @package Toocheke
 */
// Get layout and determine if it's traditional

$args = [
    'posts_per_page' => '1',
    'post_type'      => 'manga_volume',
    'order'          => 'ASC',

];

$manga_volume_posts = get_posts($args);
if ($manga_volume_posts) {
    $url = get_permalink($manga_volume_posts[0]->ID);

    wp_redirect($url, 301);
    exit;
}
