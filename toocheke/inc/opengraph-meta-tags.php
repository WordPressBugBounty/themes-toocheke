<?php
/**
 * Open Graph meta tags (og:title, og:description, og:image) for Toocheke.
 *
 * Also outputs og:type, og:url, and og:site_name -- the other properties
 * the Open Graph spec itself requires for a valid, complete set of tags.
 * Without those, title/description/image alone are of limited use to
 * link-preview crawlers (Facebook, Discord, Slack, etc.).
 *
 * IMPORTANT: This intentionally does nothing if a popular SEO plugin known
 * to already output its own Open Graph tags is active (Yoast, Rank Math,
 * All in One SEO, SEOPress, The SEO Framework, Slim SEO) -- see
 * toocheke_seo_plugin_handles_opengraph(). Two sets of og: tags on the same
 * page is worse than none, since crawlers generally aren't guaranteed to
 * pick the "right" one when a property is duplicated.
 *
 * @package Toocheke
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('toocheke_seo_plugin_handles_opengraph')):
    /**
     * True if a popular SEO plugin that outputs its own Open Graph tags is
     * currently active.
     *
     * This is deliberately a broad "is the plugin active" check rather than
     * "did the site owner turn on that plugin's social/OG settings" --
     * checking each plugin's specific settings would be far more fragile
     * and version-dependent to maintain, and the safe default when in
     * doubt is to not risk adding a second, possibly conflicting, set of
     * og: tags alongside an already-active SEO plugin's own.
     */
    function toocheke_seo_plugin_handles_opengraph()
    {
        $detected = (
            defined('WPSEO_VERSION')                    // Yoast SEO
            || defined('RANK_MATH_VERSION')              // Rank Math
            || class_exists('RankMath')
            || defined('AIOSEO_VERSION')                 // All in One SEO
            || class_exists('AIOSEO\\Plugin\\AIOSEO')
            || defined('SEOPRESS_VERSION')                // SEOPress
            || defined('THE_SEO_FRAMEWORK_VERSION')       // The SEO Framework
            || defined('SLIM_SEO_VERSION')                 // Slim SEO
            || function_exists('slim_seo')
        );

        /**
         * Filters whether a conflicting SEO plugin was detected -- lets a
         * child theme or site owner override this, e.g. for a plugin not
         * in the list above, or to force Toocheke's own tags on regardless.
         *
         * @param bool $detected
         */
        return apply_filters('toocheke_seo_plugin_handles_opengraph', $detected);
    }
endif;

if (! function_exists('toocheke_truncate_for_meta')):
    /**
     * Strips tags, collapses whitespace, and truncates plain text to a hard
     * character limit for use in a meta description.
     */
    function toocheke_truncate_for_meta($text, $max_chars = 200)
    {
        $text = wp_strip_all_tags((string) $text);
        $text = trim(preg_replace('/\s+/', ' ', $text));

        if ('' === $text) {
            return '';
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen($text) <= $max_chars) {
                return $text;
            }
            return rtrim(mb_substr($text, 0, $max_chars)) . '…';
        }

        if (strlen($text) <= $max_chars) {
            return $text;
        }
        return rtrim(substr($text, 0, $max_chars)) . '...';
    }
endif;

if (! function_exists('toocheke_get_latest_comic_id')):
    /**
     * ID of the most recently published comic, respecting the same
     * Toocheke -> Options -> Ordering setting used elsewhere in the theme.
     * Used for the home page's og:image when "Your homepage displays" is
     * set to latest posts rather than a static front page.
     */
    function toocheke_get_latest_comic_id()
    {
        $comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';

        $latest = get_posts([
            'post_type'      => 'comic',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'orderby'        => 'post_date',
            'order'          => $comic_order,
            'fields'         => 'ids',
        ]);

        return ! empty($latest) ? (int) $latest[0] : 0;
    }
endif;

if (! function_exists('toocheke_get_meta_image_url')):
    /**
     * Resolves the og:image URL for a given post ID.
     *
     * Priority order:
     *   1. The comic's saved social share image (comicscout_social_share_image_id
     *      meta field), if set -- this lets a comic have a dedicated,
     *      hand-picked share image distinct from its featured image.
     *   2. The post's featured image, if it has one.
     *   3. The site icon, if set.
     *   4. Empty string if none of the above resolve.
     */
    function toocheke_get_meta_image_url($post_id)
    {
        if ($post_id) {
            $social_share_image_id = (int) get_post_meta($post_id, 'comicscout_social_share_image_id', true);
            if ($social_share_image_id) {
                $image = wp_get_attachment_image_src($social_share_image_id, 'full');
                if ($image) {
                    return $image[0];
                }
            }
        }

        if ($post_id && has_post_thumbnail($post_id)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
            if ($image) {
                return $image[0];
            }
        }

        if (has_site_icon()) {
            return get_site_icon_url();
        }

        return '';
    }
endif;

if (! function_exists('toocheke_get_meta_description_for_post')):
    /**
     * Builds the og:description for a singular post, following a different
     * field-priority fallback chain per post type. Every branch is
     * truncated to 200 characters.
     *
     * - comic: comic-hovertext -> excerpt -> transcript -> blog post editor
     *   field ("comic_blog_post_editor")
     * - manga_series / manga_volume / manga_chapter: the "notes" field
     * - everything else (regular posts, pages, etc.): excerpt, else the
     *   post content
     */
    function toocheke_get_meta_description_for_post($post_id)
    {
        $post_type = get_post_type($post_id);

        if ('comic' === $post_type) {
            $hovertext = trim((string) get_post_meta($post_id, 'comic-hovertext', true));
            if ('' !== $hovertext) {
                return toocheke_truncate_for_meta($hovertext);
            }

            // 'raw' context avoids running the value through the
            // `post_excerpt` filter, which can make an unset excerpt look
            // non-empty if anything else on the site hooks that filter --
            // 'raw' reads the literal, unfiltered database value.
            $excerpt = trim((string) get_post_field('post_excerpt', $post_id, 'raw'));
            if ('' !== $excerpt) {
                return toocheke_truncate_for_meta($excerpt);
            }

            $transcript = trim((string) get_post_meta($post_id, 'transcript', true));
            if ('' !== $transcript) {
                return toocheke_truncate_for_meta($transcript);
            }

            $blog_content = trim((string) get_post_meta($post_id, 'comic_blog_post_editor', true));
            if ('' !== $blog_content) {
                return toocheke_truncate_for_meta($blog_content);
            }

            return '';
        }

        if (in_array($post_type, ['manga_series', 'manga_volume', 'manga_chapter'], true)) {
            $notes = trim((string) get_post_meta($post_id, 'notes', true));
            return '' !== $notes ? toocheke_truncate_for_meta($notes) : '';
        }

        // Regular posts, pages, and anything else not covered above.
        $excerpt = trim((string) get_post_field('post_excerpt', $post_id, 'raw'));
        if ('' !== $excerpt) {
            return toocheke_truncate_for_meta($excerpt);
        }

        return toocheke_truncate_for_meta(get_post_field('post_content', $post_id, 'raw'));
    }
endif;

if (! function_exists('toocheke_output_opengraph_meta_tags')):
    /**
     * Prints the Open Graph meta tags into <head>. Handles singular posts
     * (any post type), the home page (static front page or latest-posts
     * mode), and every other view -- archives, search results, and 404s.
     * Only feeds and wp-admin are excluded outright.
     */
    function toocheke_output_opengraph_meta_tags()
    {
        if (is_admin() || is_feed()) {
            return;
        }

        if (toocheke_seo_plugin_handles_opengraph()) {
            return;
        }

        $title       = '';
        $description = '';
        $image       = '';
        $og_type     = 'website';
        $url         = home_url('/');

        if (is_singular()) {
            $post_id = get_queried_object_id();
            if (! $post_id) {
                return;
            }

            $title       = get_the_title($post_id);
            $image       = toocheke_get_meta_image_url($post_id);
            $description = toocheke_get_meta_description_for_post($post_id);
            $og_type     = ('post' === get_post_type($post_id)) ? 'article' : 'website';
            $url         = get_permalink($post_id);
        } elseif (is_front_page()) {
            $title   = get_bloginfo('name');
            $tagline = get_bloginfo('description');
            $description = $tagline ? toocheke_truncate_for_meta($tagline) : '';

            if ('page' === get_option('show_on_front')) {
                // Static front page -- use its own featured image.
                $front_page_id = (int) get_option('page_on_front');
                $image = toocheke_get_meta_image_url($front_page_id);
            } else {
                // "Your latest posts" mode -- use the latest comic's
                // featured image (falls back to the site icon on its own
                // if that comic has none, or if there's no comic at all).
                $latest_comic_id = toocheke_get_latest_comic_id();
                $image = $latest_comic_id
                    ? toocheke_get_meta_image_url($latest_comic_id)
                    : (has_site_icon() ? get_site_icon_url() : '');
            }
        } else {
            // Archives (post type, taxonomy, author, date), search results,
            // and 404s.
            if (is_404()) {
                $title = get_bloginfo('name');
            } else {
                $title = wp_strip_all_tags(get_the_archive_title());

                if ('' === $title && is_search()) {
                    /* translators: %s: search query */
                    $title = sprintf(__('Search Results for: %s', 'toocheke'), get_search_query());
                }

                if ('' === $title) {
                    $title = get_bloginfo('name'); // Fallback if nothing else resolved.
                }
            }

            $tagline     = get_bloginfo('description');
            $description = $tagline ? toocheke_truncate_for_meta($tagline) : '';

            // Taxonomy/date/author archives generally won't resolve to a
            // single post with its own featured image, but check anyway in
            // case get_queried_object_id() does point at one (e.g. a custom
            // post-type archive some setups treat as its own "page"), and
            // fall back to the site icon otherwise.
            $queried_id = get_queried_object_id();
            $image = ($queried_id && has_post_thumbnail($queried_id))
                ? toocheke_get_meta_image_url($queried_id)
                : (has_site_icon() ? get_site_icon_url() : '');

            // Current full URL, built the standard WP way rather than
            // reading $_SERVER directly.
             $url = home_url(add_query_arg(array(), wp_unslash($_SERVER['REQUEST_URI'])));
        }

        if ('' === $title) {
            return;
        }

        echo "\n" . '<!-- Toocheke Open Graph meta tags -->' . "\n";
        printf('<meta property="og:type" content="%s" />' . "\n", esc_attr($og_type));
        printf('<meta property="og:site_name" content="%s" />' . "\n", esc_attr(get_bloginfo('name')));
        printf('<meta property="og:url" content="%s" />' . "\n", esc_url($url));
        printf('<meta property="og:title" content="%s" />' . "\n", esc_attr($title));

        if ('' !== $description) {
            printf('<meta property="og:description" content="%s" />' . "\n", esc_attr($description));
        }

        if ('' !== $image) {
            printf('<meta property="og:image" content="%s" />' . "\n", esc_url($image));
        }
    }
endif;
add_action('wp_head', 'toocheke_output_opengraph_meta_tags', 1);
