<?php
/**
 * Template part for thumbnail-list archive of comics, segmented by year
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
$comic_order_asc = ('ASC' === strtoupper($comic_order));
?>
<?php if (have_posts()): ?>
     <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
      <hr/>
      <?php
$archive_args = array(
	'post_type' => 'comic',
	'type' => 'yearly',
);
?>
<ul id="archive-menu">
			<?php wp_get_archives($archive_args); ?>
		</ul>

<ul id="comic-list">
      <?php

set_query_var('latest_collection_id', 0);
set_query_var('series_id', null);

/* Start the Loop */
while (have_posts()): the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    get_template_part('template-parts/content', 'comiclistitem');

endwhile;
?>
</ul>

 <!-- Start Pagination -->
 <?php
the_posts_navigation(
    array(
        'prev_text' => $comic_order_asc ? __('Newer comics', 'toocheke') : __('Older comics', 'toocheke'),
        'next_text' => $comic_order_asc ? __('Older comics', 'toocheke') : __('Newer comics', 'toocheke'),
        'screen_reader_text' => __('Posts navigation', 'toocheke'),
    )
);

?>
<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>
