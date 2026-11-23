<?php
/**
 * Template part for displaying comic
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
  $collection_comic_order = get_option('toocheke-collection-first-comic') ? get_option('toocheke-collection-first-comic') : 'DESC';
?>
<?php
$series_id = null;
if (is_singular('series')) {
    $series_id = get_the_ID();
}
$collection_args = array(
    'parent' => 0,
    'taxonomy' => 'collections',
    'style' => 'none',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'nopaging' => true,
    'meta_query' => array(
        array(
            'key' => 'collection-order',
            'type' => 'NUMERIC',
        )),
    'show_count' => 0,
);

$collections_list = get_categories($collection_args);
if ($collections_list) {
    ?>
<!-- Carousel Collections -->
<div id="collections-owl-carousel-wrapper">
<div col="row">
<div id="collections-carousel" class="owl-carousel">
 <?php $counter = 0;?>
<?php foreach ($collections_list as $collection) {
        /**
         * Get latest post for this collection
         */
        $args = array(
            'post_parent' => $series_id,
            'posts_per_page' => 1,
            'post_type' => 'comic',
            'order' => $collection_comic_order,
            "tax_query" => array(
                array(
                    'taxonomy' => "collections",
                    'field' => 'term_id',
                    'terms' => $collection->term_id,
                ),
            ),
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );
        $first_comic_query = new WP_Query($args);

        $first_comic_link = '';
        if ($first_comic_query->have_posts()) {
            $first_comic_query->the_post();
            $first_comic_link = add_query_arg(array('sid' => $series_id, 'col' => $collection->term_id), get_post_permalink());
            wp_reset_postdata();
        }

        // Decide where this collection thumbnail should link to
        $link_to_archive = get_option('toocheke-collection-archive-link') && 1 == get_option('toocheke-collection-archive-link');

        if ($link_to_archive) {
            $archive_link = get_term_link($collection);
            $link_url = (!is_wp_error($archive_link)) ? $archive_link : $first_comic_link;
        } else {
            $link_url = $first_comic_link;
        }

        printf(wp_kses_data('%1$s'), '<div title="' . esc_attr($collection->name) . '" id="col' . esc_attr($collection->term_id) . '" data-index="' . wp_kses_data($counter) . '">');
        printf(wp_kses_data('%1$s'), '<a href="' . esc_url($link_url) . '">');
        $term_id = absint($collection->term_id);
        $thumb_id = get_term_meta($term_id, 'collection-image-id', true);

        if (!empty($thumb_id)) {
            $term_img = wp_get_attachment_url($thumb_id);
            printf(wp_kses_data('%1$s'), '<img class="collection-cover" src="' . esc_url($term_img) . '" />');
        }
        echo '</a></div>';
    $counter++;
    } //end foreach
    // Reset Post Data
    wp_reset_postdata();
    ?>

</div><!--end owl-carousel-->
</div><!--end row-->
<!--Swipe Icon-->
<div id="swipe-instructions">
    <hr/>
<i>Swipe from left to right for more comic collections.</i>
</div>
<div id="swipe-wrapper">
<div class="stage">
  <div class="swipe">
  <i class="fas fa-long-arrow-alt-left"></i>
  <i class="fas fa-hand-point-up"></i>
    <i class="fas fa-long-arrow-alt-right"></i>
  </div>
</div>
</div>
<hr/>
<!--End Swipe Icon-->
</div><!-- end collections-owl-carousel-wrapper -->
<?php } //endif   $collections_list  ?>
