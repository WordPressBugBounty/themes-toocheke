<?php
/**
 * Template Name: Latest Manga Chapter Page
 *
 * This is a page template you can use for the latest manga chapter page
 *
 * @package Toocheke
 */
// Get layout and determine if it's traditional

$args = [
    'posts_per_page' => '1',
    'post_type'      => 'manga_chapter',
    'order'          => 'DESC',

];

$manga_chapter_posts = get_posts($args);
if ($manga_chapter_posts) {
    $url = get_permalink($manga_chapter_posts[0]->ID);

    wp_redirect($url, 301);
    exit;
}
