<?php
/**
 * Template part for thumbnail-list archive of comics, grouped by series
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
?>
<?php if (have_posts()): ?>
     <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
      <hr/>
      <?php
//for each series, show all posts
$series_args = array(
    'post_type' => 'series',
    'nopaging' => true,
    'orderby' => 'post_date',
    'order' => 'ASC',
    'post_status' => 'publish',
);
$series_query = new WP_Query($series_args);
if ($series_query->have_posts()):

    while ($series_query->have_posts()): $series_query->the_post();
        $series_id = get_the_ID();
        $series_name = get_the_title();
        $series_comics_args = array(
            'post_type' => 'comic',
            'order' => $comic_order,
            'nopaging' => true,
            'post_parent' => $series_id,
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );
        $series_comics_query = new WP_Query($series_comics_args);

        if ($series_comics_query->have_posts()) {
            echo '<h3>' . wp_kses_data($series_name) . '</h3>';
            set_query_var('series_id', $series_id);
            set_query_var('latest_collection_id', 0);
            ?>
<ul id="comic-list">
      <?php

/* Start the Loop */
while ($series_comics_query->have_posts()): $series_comics_query->the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    get_template_part('template-parts/content', 'comiclistitem');

endwhile;
?>
</ul>
            <?php
            wp_reset_postdata();
            ?>
			  <p>&nbsp;</p>
			  <?php
        } // if ($series_comics_query->have_posts()
    endwhile;
    $series_query = null;
    wp_reset_postdata();
endif;
?>

<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>
