<?php
    /**
     * Template part for displaying posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package Toocheke
     */
	$show_post_thumbnail =	get_query_var('show_post_thumbnail') ? get_query_var('show_post_thumbnail') : false;
    $blog_landing_page = is_page_template( 'blog.php' );

?>

<article id="post-<?php esc_attr(the_ID()); ?>" <?php wp_kses_data((string) post_class()); ?>>
<?php if ( is_home() || is_archive() || $blog_landing_page || (is_singular() && (!has_post_thumbnail() || !$show_post_thumbnail))  ) { ?>
	<header class="entry-header">
		<?php
            if ( is_singular('post') ) :
                    the_title('<h1 class="entry-title">', '</h1>');
                else:
                    the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
                endif;

                if ('post' === get_post_type()):
            ?>
			<div class="entry-meta">
				<?php
                    toocheke_posted_on();
                        toocheke_posted_by();
                    ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php }
    ?>
<?php
    if (is_archive() || $blog_landing_page ) {
        toocheke_post_thumbnail();
    }

?>


	<div class="entry-content">
		<?php
    if ( is_archive() || $blog_landing_page ) {
        // Show excerpt on archive pages and blog landing page
        the_excerpt();
    } else {
        // Show full content otherwise
        the_content( sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Read More<span class="screen-reader-text"> "%s"</span>', 'toocheke'),
                [
                    'span' => [
                        'class' => [],
                    ],
                ]
            ),
            get_the_title()
        ) );

        wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'toocheke'),
            'after'  => '</div>',
        ]);
    }
    ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php toocheke_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
