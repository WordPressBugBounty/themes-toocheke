<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Toocheke
 */

if ( ! function_exists( 'toocheke_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function toocheke_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			'',
			''
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'toocheke' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' .  wp_kses_data($posted_on). '</span>'; 

	}
endif;

if ( ! function_exists( 'toocheke_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function toocheke_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'toocheke' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . wp_kses_data($byline) . '</span>'; 

	}
endif;

if ( ! function_exists( 'toocheke_entry_footer' ) ) :
    function toocheke_entry_footer() {
        if ( 'post' === get_post_type() ) {
            $categories_list = get_the_category_list( esc_html__( ', ', 'toocheke' ) );
            if ( $categories_list ) {
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'toocheke' ) . '</span>', wp_kses_data( $categories_list ) );
            }
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'toocheke' ) );
            if ( $tags_list ) {
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'toocheke' ) . '</span>', wp_kses_data( $tags_list ) );
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<div class="comments-link">';

            // Build the comment link with optional ?sid= for comics with a parent
            $comment_link = get_comments_link();

            if ( 'comic' === get_post_type() ) {
                $parent_id = wp_get_post_parent_id( get_the_ID() );
                if ( $parent_id ) {
                    $fragment = '';
                    if ( strpos( $comment_link, '#' ) !== false ) {
                        list( $comment_link, $fragment ) = explode( '#', $comment_link, 2 );
                        $fragment = '#' . $fragment;
                    }
                    $comment_link = add_query_arg( 'sid', $parent_id, $comment_link ) . $fragment;
                }
            }

            $comments_number = get_comments_number();
            if ( $comments_number == 0 ) {
                $link_text = __( 'Leave a Comment', 'toocheke' );
            } elseif ( $comments_number == 1 ) {
                $link_text = __( '1 Comment', 'toocheke' );
            } else {
                $link_text = sprintf( __( '%s Comments', 'toocheke' ), number_format_i18n( $comments_number ) );

            }

            printf(
                '<a href="%s" class="btn btn-danger btn-xs">%s</a>',
                esc_url( $comment_link ),
                esc_html( $link_text )
            );

            echo '</div>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'toocheke' ),
                    array( 'span' => array( 'class' => array() ) )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if ( ! function_exists( 'toocheke_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function toocheke_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail('full'); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;
