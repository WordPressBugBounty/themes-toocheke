<?php
/**
 * Template Name: Comic Characters Template
 *
 * Template for displaying comic character thumbnails with links to the first comic in the character.
 *
 * @package toocheke
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col) ?>">
                  <div id="left-col">
                     <div id="left-content">

			<section>
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('Characters', 'toocheke');?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
                <?php
/**
 * Get latest six characters of comics. If there are no characters or characters with no comics, don't display.
 */
//setup paging
//Get total number of active characters
$series_id = isset($_GET['sid']) ? absint($_GET['sid']) : 0;
$character_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$characters_per_page = 60;
$paged_offset = ($character_paged - 1) * $characters_per_page;

$order_args = array(
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => 'character-order',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => 'character-order',
            'compare' => 'EXISTS',
        ),
    ),
);

if ($series_id) {
    $series_comic_ids = get_posts(array(
        'post_type' => 'comic',
        'post_parent' => $series_id,
        'post_status' => 'publish',
        'fields' => 'ids',
        'nopaging' => true,
    ));
    $series_characters = $series_comic_ids ? wp_get_object_terms($series_comic_ids, 'comic_characters', $order_args) : array();
    if (is_wp_error($series_characters)) {
        $series_characters = array();
    }
    $total_active_characters = count($series_characters);
    $paged_characters_list = array_slice($series_characters, $paged_offset, $characters_per_page);
} else {
    $total_active_characters = count(get_categories(array('taxonomy' => 'comic_characters')));
    $paged_characters_list = get_categories(array_merge($order_args, array(
        'taxonomy' => 'comic_characters',
        'style' => 'none',
        'hide_empty' => false,
        'show_count' => 0,
        'number' => $characters_per_page,
        'paged' => $character_paged,
        'offset' => $paged_offset,
    )));
}
$total_number_of_pages = ceil($total_active_characters / $characters_per_page);

if ($paged_characters_list) {
    ?>
	<div id="character-wrapper" class="row">

		<?php

    foreach ($paged_characters_list as $character) {
        $term_id = absint($character->term_id);
        $thumb_id = get_term_meta($term_id, 'character-image-id', true);
        $character_name = $character->name;
        $character_description = $character->description;
        $term_link = get_term_link($term_id);
        if ($series_id && !is_wp_error($term_link)) {
            $term_link = add_query_arg('sid', $series_id, $term_link);
        }
        $has_comics = $series_id || $character->count > 0;
        ?>
<div class="col-md-6 mb-4">
<div class="card">

<!-- Card image -->
<?php if ($has_comics): ?>
  <a class="character-thumb-link" href="<?php echo esc_url($term_link); ?>">
<?php endif; ?>

<?php
if (!empty($thumb_id)) {
    $term_img = wp_get_attachment_url($thumb_id);
    printf(wp_kses_data('%1$s'), '<img src="' . esc_url($term_img) . '" />');
} else {
    ?>
    <img src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
    <?php
}
?>

<?php if ($has_comics): ?>
  </a>
<?php endif; ?>

<!-- Card content -->
<div class="card-body">

  <!-- Title -->
 <!-- Title -->
<?php if ($has_comics): ?>
  <h4 class="card-title"><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($character_name); ?></a></h4>
<?php else: ?>
  <h4 class="card-title"><?php echo esc_html($character_name); ?></h4>
<?php endif; ?>
  <!-- Text -->
  <div class="card-text"><?php echo wp_kses(wpautop($character_description), toocheke_allowed_html()) ?></div>
  <?php if($has_comics):?>
  <div class="card-link"><a class="btn btn-danger" href="<?php echo esc_url($term_link);?>">View Archive</a></div>
  <?php endif;?>
</div>

</div>
<!-- Card -->
</div>
<!-- col-md-4 -->
<?php
}

// Reset Post Data
    wp_reset_postdata();

    ?>



	</div>
	<div class="row">
	<div class="col-md-12">
	<hr/>

   <!-- Start Pagination -->
   <?php
// Set up paginated links.
    $big = 999999999; // need an unlikely integer
    $links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $total_number_of_pages,
        'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
        'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    ));

    if ($links):

    ?>

<div class="paginate-links">

            <?php echo wp_kses($links, array(
        'a' => array(
            'href' => array(),
            'class' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
    )); ?>

		</div><!--/ .navigation -->
    <?php
endif;
    ?>
 <!-- End Pagination -->
	</div>
	</div>
	<?php
} //end if
?>
				</div><!-- .page-content -->
			</section>

		                 <!--END CONTENT-->
						 </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->

<?php
get_sidebar();
get_footer();
