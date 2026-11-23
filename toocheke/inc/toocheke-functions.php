<?php
    /**
 * Toocheke functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage toocheke
 */

    //Load theme functions
    //require_once trailingslashit( get_template_directory() ) . 'inc/template-functions.php';
    /**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */
    if (! function_exists('toocheke_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function toocheke_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Toocheke, use a find and replace
         * to change 'toocheke' to the name of your theme in all the template files.
         */
        load_theme_textdomain('toocheke', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus([
            'primary' => esc_html__('Primary', 'toocheke'),
        ]);

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('toocheke_custom_background_args', [
            'default-color' => 'f5f5f5',
            'default-image' => '',
        ]));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', [
            'height'      => 45,
            'width'       => 45,
            'flex-width'  => true,
            'flex-height' => false,
        ]);

    }
    endif;
    add_action('after_setup_theme', 'toocheke_setup');

    /**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
    if (! function_exists('toocheke_content_width')):
    function toocheke_content_width()
    {
        // This variable is intended to be overruled from themes.
        // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        $GLOBALS['content_width'] = apply_filters('toocheke_content_width', 1140);
    }
    endif;
    add_action('after_setup_theme', 'toocheke_content_width', 0);
    /**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
    if (! function_exists('toocheke_add_editor_styles')):
    function toocheke_add_editor_styles()
    {
        add_editor_style(get_stylesheet_uri());
    }
    endif;
    add_action('init', 'toocheke_add_editor_styles');
    /**
 * Enqueue scripts and styles.
 */
    if (! function_exists('toocheke_scripts')):
    function toocheke_scripts()
    {
        wp_enqueue_style('bs-css', get_template_directory_uri() . '/dist/css/bootstrap.min.css');
        wp_enqueue_style('bs-smartmenus', get_template_directory_uri() . '/dist/css/jquery.smartmenus.bootstrap-4.css');

        wp_enqueue_style('toocheke-font-awesome', get_template_directory_uri() . '/fonts/font-awesome/css/all.min.css', [], wp_get_theme()->get('Version'));

        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/dist/css/owl.carousel.min.css');
        wp_enqueue_style('owl-theme-default', get_template_directory_uri() . '/dist/css/owl.theme.default.min.css');

        wp_register_style('google-font-hind', '//fonts.googleapis.com/css?family=Hind:regular,medium,bold,bolditalic,semibold', [], null, 'all');
        wp_enqueue_style('google-font-hind');

        wp_enqueue_style('toocheke-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

        wp_enqueue_script('popper', get_template_directory_uri() . '/src/js/popper.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/src/js/owl.carousel.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('tether', get_template_directory_uri() . '/src/js/tether.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/src/js/bootstrap.min.js', ['jquery'], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('skip-link-focus-fix', get_template_directory_uri() . '/src/js/skip-link-focus-fix.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('jquery-smartmenus', get_template_directory_uri() . '/src/js/jquery.smartmenus.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('jquery-smartmenus-bs4', get_template_directory_uri() . '/src/js/jquery.smartmenus.bootstrap-4.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('clipboard', get_template_directory_uri() . '/src/js/clipboard.min.js', [], wp_get_theme()->get('Version'), true);

        wp_enqueue_script('toocheke-functions', get_template_directory_uri() . '/src/js/functions.js', [], wp_get_theme()->get('Version'), true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
    endif;
    add_action('wp_enqueue_scripts', 'toocheke_scripts');
    /*
 * Register required plugins
 */
    // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
    require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

    add_action('tgmpa_register', 'toocheke_register_required_plugins');
    /*
 * Register the required plugins for this theme.
 */
    if (! function_exists('toocheke_register_required_plugins')):
    function toocheke_register_required_plugins()
    {
        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = [

            // Include the Toocheke plugin bundled with a theme.
            [
                'name'         => 'Toocheke Companion',
                'slug'         => 'toocheke-companion',
                                         //'source'             => 'https://downloads.wordpress.org/plugin/toocheke-companion.zip', // The plugin source.
                'required'     => false, // If false, the plugin is only 'recommended' instead of required.
                'version'      => '',    // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                'external_url' => '',    // If set, overrides default API URL and points to an external URL.
                'is_callable'  => '',    // If set, this callable will be be checked for availability to determine if a plugin is active.
            ],

        ];

        /*
         * Array of configuration settings. Amend each line as needed.
         *
         */
        $config = [
            'id'           => 'toocheke',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                         // Default absolute path to bundled plugins.
            'menu'         => 'toocheke-install-plugins', // Menu slug.
            'has_notices'  => true,                       // Show admin notices or not.
            'dismissable'  => true,                       // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => false,                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                      // Automatically activate plugins after installation or not.
            'message'      => '',                         // Message to output right before the plugins table.

        ];

        tgmpa($plugins, $config);
    }
    endif;

    //Comic Carousel Starts here
    /**
 * Comic Carousel
 */
    if (! function_exists('toocheke_load_comic_carousel')):
    function toocheke_load_comic_carousel($collection_id)
    {
        set_query_var('collection_id', $collection_id);
        get_template_part('template-parts/content', 'comiccarousel');

    }
    endif;
    //Comic Carousel Ends here

    /* ========================================================================================================================

Comments

======================================================================================================================== */

    /**
 * Post Publish Date.
 */
    function toocheke_get_day_name($timestamp)
    {

    $date = date('M d, Y', $timestamp);

    if ($date == date('M d, Y')) {
        $date = 'Today';
    } else if ($date == date('M d, Y', strtotime("-1 days"))) {
        $date = 'Yesterday';
    }
    return $date;
    }
    /**
 * Home Layout
 */

    // Update CSS within in Admin
    function toocheke_render_home_layout_styles()
    {
    wp_register_style('toocheke-home-custom-style', false);
    wp_enqueue_style('toocheke-home-custom-style');
    $home_layout = get_theme_mod('home_layout_setting', 'default');
    switch ($home_layout) {
        case 'default':
        case 'alt-5':
        case 'alt-6':
            return;
        case 'alt-1':
            $hide_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#latest-comic';
            break;
        case 'alt-2':
            $hide_object_selector = '.jumbotron, #main-content-row, .post, #content .col-lg-4';
            $show_object_selector = '#latest-comic';
            break;
        case 'alt-3':
            $hide_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#collections-owl-carousel-wrapper';
            break;
        case 'alt-4':
            $hide_object_selector = '#comic-archive-list, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#latest-comic';
            break;
        case 'alt-7':
            $hide_object_selector = '.jumbotron';
            $show_object_selector = '';
            break;
        default:
            $hide_object_selector = '#latest-comic';
            $show_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
    }

    $home_custom_css = "
		@media (min-width: 992px){
			#content{
				margin-top: 60px !important;
			}
	}
	@media (max-width: 991px){
		main {
			margin-top: 0px;
		}
		#content{
			margin-top: 35px !important;
		}
}

		{$hide_object_selector} {
			display: none !important;
				}
				{$show_object_selector} {
					display: block !important;
						}
				";
    wp_add_inline_style('toocheke-home-custom-style', $home_custom_css);
    }
    add_action('wp_enqueue_scripts', 'toocheke_render_home_layout_styles');
    /**
 * Comic Layout
 */

    // Update CSS within in Admin

    function toocheke_render_comic_layout_styles()
    {
    wp_register_style('toocheke-custom-style', false);
    wp_enqueue_style('toocheke-custom-style');
    $image_width = '100';
    $display     = 'block';
    $layout      = get_theme_mod('comic_layout_setting', 'default');
    if ('default' === $layout) {
        return;
    }
    switch ($layout) {
        case 'two':
            $image_width = '49';
            $display     = 'inline-block';

            break;
        case 'three':
            $image_width = '32';
            $display     = 'inline-block';
            break;
        case 'four':
            $image_width = '25';
            $display     = 'inline-block';
            break;
        default:
            $image_width = '100';
            $display     = 'block';
    }

    $custom_css = "
		@media (min-width: 990px){
		#comic img {
			max-width: {$image_width}% !important;
			width: {$image_width}% !important;
            height: auto !important;
            display:  {$display} !important;
                }
                #comics-carousel img {
                    max-width: 100% !important;
                    width: 100% !important;
                }
            }";
    wp_add_inline_style('toocheke-custom-style', $custom_css);
    }
    add_action('wp_enqueue_scripts', 'toocheke_render_comic_layout_styles');
    /**
 * Render series background image and color
 */
    function toocheke_render_series_background_styles()
    {
    $series_id  = 0;
    $custom_css = '';
    if (is_singular('series')) {
        $series_id = get_the_ID();
    }
    if (is_singular('comic')) {
        $series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;
    }
    if ($series_id > 0) {
        if (is_singular('series') || is_singular('comic')) {
            wp_register_style('toocheke-series-custom-style', false);
            wp_enqueue_style('toocheke-series-custom-style');
            if (get_post_meta($series_id, 'series_hero_image_id', true)) {
                $series_hero_id  = get_post_meta($series_id, 'series_bg_image_id', true);
                $series_bg_url   = wp_get_attachment_image_url($series_hero_id, 'full', false);
                $custom_css     .= '
                body{
                    background-image: url("' . $series_bg_url . '") !important;
                    background-position: left top;
                    background-size: auto;
                    background-repeat: repeat;
                    background-attachment: scroll;
                }
                ';
            }
            if (get_post_meta($series_id, 'series_bg_color', true)) {
                $bg_color    = get_post_meta($series_id, 'series_bg_color');
                $custom_css .= '
                body{
                    background-color: ' . $bg_color[0] . ' !important;
                }
                ';
            }
        }
    }
    if (strlen($custom_css) > 0) {
        wp_add_inline_style('toocheke-series-custom-style', $custom_css);
    }

    }
    add_action('wp_enqueue_scripts', 'toocheke_render_series_background_styles');
    /**
 * Get Series Link
 */
    if (! function_exists('toocheke_get_series_link')):
    function toocheke_get_series_link($id)
    {
        //global $post;
        $permalink = esc_url(get_permalink($id));
        $series    = get_post($id);
        if ($series == null) {
            return;
        }

        $title            = esc_attr($series->post_title);
        $series_link_html = '<a id="footer-series-link" href="' . $permalink . '" title="' . $title . '" >' . $title . '</a>';
        return $series_link_html;
    }
    endif;
    /**
 * Get Comic Link
 */
    if (! function_exists('toocheke_get_comic_link')):
    function toocheke_get_comic_link($order, $font, $collection_id, $display_default_button = null, $image_button = null, $series_id = null)
    {
        //global $post;
        $current_permalink = esc_url(get_permalink());
        $placeholder       = $GLOBALS['post'];
        $image_button_url  = null !== $image_button && strlen($image_button) > 0 ? get_option('toocheke-' . $image_button . '-button') : "";
        $button            = $display_default_button ? '<i class="fas fa-lg fa-step-' . $font . '"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
        $args              = [
            'post_parent' => $series_id,
            'post_type'   => 'comic',
            'numberposts' => 1,
            'offset'      => 0,
            'orderby'     => 'post_date',
            'order'       => $order,
            'post_status' => 'publish'];
        if ($collection_id > 0) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'collections',
                    'field'    => 'term_id',
                    'terms'    => $collection_id,
                ],
            ];
        }

        $sorted_posts = get_posts($args);
        $permalink    = esc_url(get_permalink($sorted_posts[0]->ID));
        if ($permalink == $current_permalink) {
            if (get_option('toocheke-always-show-nav-buttons') && 1 == get_option('toocheke-always-show-nav-buttons')) {
                return '<a  href="javascript:;" class="disabled" tabindex="-1" aria-disabled="true" onclick="return false;">' . $button . '</a>';
            } else {
                return "";
            }
        }

        $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($sorted_posts[0]->ID)) : get_permalink($sorted_posts[0]->ID));
        //add series id parameter
        if ($series_id) {
            $permalink = add_query_arg('sid', $series_id, $permalink);
        }
        if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
            $permalink = $permalink . '#main';
        }
        $title            = esc_attr($sorted_posts[0]->post_title);
        $post             = $placeholder;
        $font             = esc_attr($font);
        $latest_link_html = '<a href="' . $permalink . '" title="' . $title . '" >' . $button . '</a>';
        return $latest_link_html;
    }
    endif;
    if (! function_exists('toocheke_adjacent_comic_link')):
    function toocheke_adjacent_comic_link($current_post_id, $current_publish_date, $collection_id, $direction, $display_default_button = null, $series_id = null)
    {

        $nextID = $next_title = $next_link = $prevID = $prev_title = $prev_link = null;

        $current_formatted_publish_date = $current_publish_date->format('Y-m-d H:i:s');
        $siblings                       = toocheke_get_comic_siblings(1, $current_formatted_publish_date, $series_id, $direction, $collection_id);
        switch ($direction) {
            case 'next':
                if (! empty($siblings)) {
                    $nextID     = $siblings[0]->ID;
                    $next_title = $siblings[0]->post_title;
                    $next_link  = get_permalink($nextID);
                }

                break;
            case 'previous':
                if (! empty($siblings)) {
                    $prevID     = $siblings[0]->ID;
                    $prev_title = $siblings[0]->post_title;
                    $prev_link  = get_permalink($prevID);
                }
                break;
            default:
        }

        $image_button_url = null !== $direction && strlen($direction) > 0 ? get_option('toocheke-' . $direction . '-button') : "";

        // Return information
        if ($direction == 'next' and ! empty($nextID)):
            $button    = $display_default_button ? '<i class="fas fa-lg fa-chevron-right" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($nextID)) : get_permalink($nextID));
            //add series id parameter
            if ($series_id) {
                $permalink = add_query_arg('sid', $series_id, $permalink);
            }
            if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
                $permalink = $permalink . '#main';
            }
            $link_html = '<a class="' . $direction . '-comic" href="' . $permalink . '" title="' . $next_title . '" >' . $button . '</a>';

        elseif ($direction == 'previous' and ! empty($prevID)):
            $button    = $display_default_button ? '<i class="fas fa-lg fa-chevron-left" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($prevID)) : get_permalink($prevID));
            //add series id parameter
            if ($series_id) {
                $permalink = add_query_arg('sid', $series_id, $permalink);
            }
            if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
                $permalink = $permalink . '#main';
            }
            $link_html = '<a class="' . $direction . '-comic" href="' . $permalink . '" title="' . $prev_title . '" >' . $button . '</a>';

        else:
            if (get_option('toocheke-always-show-nav-buttons') && 1 == get_option('toocheke-always-show-nav-buttons')) {
                $button = '';

                if ($direction == 'next'):
                    $button = $display_default_button ? '<i class="fas fa-lg fa-chevron-right" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
                elseif ($direction == 'previous'):
                    $button = $display_default_button ? '<i class="fas fa-lg fa-chevron-left" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
                endif;

                $link_html = '<a href="javascript:;" class="' . $direction . '-comic disabled" >' . $button . '</a>';
            } else {
                return false;
            }
        endif;
        return $link_html;
    }
    endif;
    if (! function_exists('toocheke_get_comic_siblings')):
    function toocheke_get_comic_siblings($limit = 1, $date = '', $series_id = null, $direction = null, $collection_id = 0)
    {
        global $wpdb;

        $limit = absint($limit);
        if (! $limit || ! in_array($direction, ['next', 'previous'], true)) {
            return;
        }

        $operator = 'next' === $direction ? '>' : '<';
        $order    = 'next' === $direction ? 'ASC' : 'DESC';
        $join     = '';
        $where    = '';
        $args     = [];

        if ($series_id && 0 == $collection_id) {
            $where .= ' AND p.post_parent = %d';
            $args[] = (int) $series_id;
        } elseif (! $series_id && $collection_id > 0) {
            $join   = " LEFT JOIN $wpdb->term_relationships AS t ON p.ID = t.object_id";
            $where .= ' AND t.term_taxonomy_id = %d';
            $args[] = (int) $collection_id;
        }

        $args[] = $date;
        $args[] = $limit;

        $sql = $wpdb->prepare("SELECT p.post_title, p.post_date, p.ID FROM $wpdb->posts p $join WHERE p.post_type = 'comic' AND p.post_status = 'publish'$where AND p.post_date $operator %s ORDER BY p.post_date $order LIMIT %d", $args);

        return $wpdb->get_results($sql);
    }

    endif;
    if (! function_exists('toocheke_get_next_comic_link')):
    function toocheke_get_next_comic_link($current_post_id, $collection_id, $series_id = null)
    {
        $permalink  = '';
        $next_title = '';
        // Info
        $postIDs = [];

        $args = [
            'post_parent' => $series_id,
            'post_type'   => 'comic',
            'nopaging'    => true,
            'offset'      => 0,
            'orderby'     => 'post_date',
            'order'       => 'ASC',
            'post_status' => 'publish'];

        if ($collection_id > 0) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'collections',
                    'field'    => 'term_id',
                    'terms'    => $collection_id,
                ],
            ];
        }

        $comic_posts = get_posts($args);

        // Get post IDs
        foreach ($comic_posts as $thepost):
            $postIDs[] = $thepost->ID;
        endforeach;

        // Get prev and next post ID
        $currentIndex = array_search($current_post_id, $postIDs);

        if ($currentIndex < count($comic_posts) - 1) {
            $nextID     = $postIDs[$currentIndex + 1];
            $next_title = esc_attr($comic_posts[$currentIndex + 1]->post_title);
        }

        // Return information
        if (! empty($nextID)):
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($nextID)) : get_permalink($nextID));
            //add series id parameter
            if ($series_id) {
                $permalink = add_query_arg('sid', $series_id, $permalink);
            }

        endif;
        return [$permalink, $next_title];
    }
    endif;
    /**
 * Get Comic Number
 */
    function toocheke_get_comic_number()
    {
    global $post;
    $comic_number = "#" . get_post_meta($post->ID, 'incr_number', true);
    return wp_kses_data($comic_number);
    }

    /**
 * Generate Comic Link
 */
    function toocheke_get_random_comic()
    {

    $random_args         = ['post_type' => 'comic', 'posts_per_page' => 1, 'orderby' => 'rand'];
    $random_comics_query = new WP_Query($random_args);
    while ($random_comics_query->have_posts()): $random_comics_query->the_post();
        $link = '<a href="' . esc_url(get_the_permalink()) . '" title="' . esc_attr(get_the_title()) . '" ><i class="fas fa-lg fa-random"></i></a>';
    endwhile;
    wp_reset_postdata();
    return $link;
    }
    /**
 * Get Random Comic Link
 */
    function toocheke_random_comic_url($title = 'Random Post')
    {
    // Get the URL of a random post and format it as a clickable link
    $posts = get_posts('post_type=comic&orderby=rand&numberposts=1');
    foreach ($posts as $post) {
        $link = esc_url(get_permalink($post));
    }
    // Return the link to wherever this function is called
    return $link;
    }

    /**
 * Custom post type specific rewrite rules
 * @return wp_rewrite Rewrite rules handled by WordPress
 */
    function toocheke_rewrite_rules($wp_rewrite)
    {
    // Here we're hardcoding the CPT in, article in this case
    $rules             = toocheke_generate_date_archives('comic', $wp_rewrite);
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
    return $wp_rewrite;
    }
    add_action('generate_rewrite_rules', 'toocheke_rewrite_rules');

    /**
 * Generate date archive rewrite rules for comic
 * @param  string $cpt slug of the custom post type
 * @return rules       returns a set of rewrite rules for WordPress to handle
 */
    function toocheke_generate_date_archives($cpt, $wp_rewrite)
    {
    $rules        = [];
    $slug_archive = false;

    $post_type = get_post_type_object($cpt);
    if (! empty($post_type)) {
        $slug_archive = $post_type->has_archive;
    }
    if ($slug_archive === false) {
        return $rules;
    }
    if ($slug_archive === true) {
        // Here's my edit to the original function, let's pick up
        // custom slug from the post type object if user has
        // specified one.
        $slug_archive = $post_type->rewrite['slug'];
    }

    $dates = [
        [
            'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
            'vars' => ['year', 'monthnum', 'day'],
        ],
        [
            'rule' => "([0-9]{4})/([0-9]{1,2})",
            'vars' => ['year', 'monthnum'],
        ],
        [
            'rule' => "([0-9]{4})",
            'vars' => ['year'],
        ],
    ];

    foreach ($dates as $data) {
        $query = 'index.php?post_type=' . $cpt;
        $rule  = $slug_archive . '/' . $data['rule'];

        $i = 1;
        foreach ($data['vars'] as $var) {
            $query .= '&' . $var . '=' . $wp_rewrite->preg_index($i);
            $i++;
        }

        $rules[$rule . "/?$"]                               = $query;
        $rules[$rule . "/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query . "&feed=" . $wp_rewrite->preg_index($i);
        $rules[$rule . "/(feed|rdf|rss|rss2|atom)/?$"]      = $query . "&feed=" . $wp_rewrite->preg_index($i);
        $rules[$rule . "/page/([0-9]{1,})/?$"]              = $query . "&paged=" . $wp_rewrite->preg_index($i);
    }
    return $rules;
    }
    /**
 * Generate allowed html tags for wp_kses()
 */
    function toocheke_allowed_html()
    {

    $allowed_tags = [
        'a'          => [
            'id'    => [],
            'class' => [],
            'href'  => [],
            'rel'   => [],
            'title' => [],
        ],
        'abbr'       => [
            'title' => [],
        ],
        'b'          => [],
        'blockquote' => [
            'cite' => [],
        ],
        'cite'       => [
            'title' => [],
        ],
        'code'       => [],
        'del'        => [
            'datetime' => [],
            'title'    => [],
        ],
        'dd'         => [],
        'div'        => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'dl'         => [],
        'dt'         => [],
        'em'         => [],
        'h1'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'h2'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'h3'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'h4'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'h5'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'h6'         => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'i'          => [
            'class' => [],
        ],
        'iframe'     => [
            'scrolling'   => [],
            'seamless'    => [],
            'height'      => [],
            'frameborder' => [],
            'width'       => [],
        ],
        'img'        => [
            'alt'    => [],
            'class'  => [],
            'height' => [],
            'src'    => [],
            'width'  => [],
        ],
        'li'         => [
            'class' => [],
        ],
        'ol'         => [
            'class' => [],
        ],
        'p'          => [
            'class' => [],
        ],
        'q'          => [
            'cite'  => [],
            'title' => [],
        ],
        'span'       => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'strike'     => [],
        'strong'     => [],
        'ul'         => [
            'class' => [],
        ],
        'style'      => [

        ],
        'svg'        => [
            'fill'    => [],
            'viewbox' => [],
            'role'    => [],
            'xmlns'   => [],
        ],
        'path'       => [
            'd'     => [],
            'fill'  => [],
            'role'  => [],
            'xmlns' => [],
        ],
    ];

    return $allowed_tags;
    }
    /* Get Comic Image */
    function toocheke_catch_that_image()
    {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
    if ($output) {
        $first_img = $matches[1][0];
    }

    if (empty($first_img)) {
        $first_img = esc_attr(get_stylesheet_directory_uri() . '/dist/img/default-thumbnail-image.png');
    }
    return $first_img;
    }
    function toocheke_catch_that_image_alt($comic)
    {
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $comic->post_content, $matches);
    if ($output) {
        $first_img = $matches[1][0];
    }

    if (empty($first_img)) {
        $first_img = esc_attr(get_stylesheet_directory_uri() . '/dist/img/default-thumbnail-image.png');
    }
    return $first_img;
    }

    /* Register Post Views */
    function toocheke_get_post_views($postID)
    {
    $count_key = 'post_views_count';
    $count     = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
    }
    /**
 * View counting for singular Comic/Manga Chapter pages is now handled
 * entirely by the Toocheke Companion plugin (see
 * toocheke_universal_set_post_views() and toocheke_ajax_record_post_view()
 * in class-toocheke-companion-frontend-display.php), which as of Companion
 * 2.2 tracks views via localStorage + a small AJAX call rather than a
 * cookie set per post. The old cookie-per-post approach here and in the
 * plugin accumulated one cookie per comic a visitor viewed, which could
 * grow request headers past a host's size limit and cause
 * "431 Request Header Fields Too Large" errors after enough page views.
 *
 * This theme still owns the decision of *when* to also track a view on
 * the homepage (when it's configured to show the latest comic), since
 * that's a theme-specific display choice the plugin has no way to know
 * about on its own. That case is preserved below via a filter the plugin
 * exposes for exactly this purpose.
 */
    add_filter('toocheke_companion_view_tracking_post_id', 'toocheke_home_latest_comic_view_tracking_id');

    function toocheke_home_latest_comic_view_tracking_id($post_id)
    {
    if (! (is_front_page() || is_home())) {
        return $post_id; // Not on the homepage -- leave as-is.
    }

    $home_layout = get_theme_mod('home_layout_setting', 'default');
    if (! in_array($home_layout, ['alt-1', 'alt-2', 'alt-4'], true)) {
        return $post_id; // This layout doesn't show a trackable comic.
    }

    $comic_order  = get_option('toocheke-comics-order', 'DESC');
    $latest_comic = get_posts([
        'order'          => $comic_order,
        'post_type'      => 'comic',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids', // More efficient than retrieving full post objects
    ]);

    return ! empty($latest_comic) ? $latest_comic[0] : $post_id;
    }

    /**
 * Handline infinite scroll for comic archive on home page
 */
    /**
 * Javascript for Load More
 *
 */
    function toocheke_load_more_js()
    {

    if (! is_home()) {
        return;
    }

    $args = [
        'url' => admin_url('admin-ajax.php'),
    ];

    wp_enqueue_script('toocheke-load-more', get_template_directory_uri() . '/src/js/load-more.js', ['jquery'], wp_get_theme()->get('Version'), true);
    wp_localize_script('toocheke-load-more', 'toochekeloadmore', $args);

    }
    add_action('wp_enqueue_scripts', 'toocheke_load_more_js');

    /**
 * AJAX Load More
 *
 */
    function toocheke_ajax_load_more()
    {
    $comic_order         = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
    $args['order']       = $comic_order;
    $args['orderby']     = 'post_date';
    $args                = isset($_POST['query']) ? array_map('esc_attr', sanitize_text_field(wp_unslash($_POST['query']))) : [];
    $args['post_type']   = isset($args['post_type']) ? esc_attr(sanitize_text_field(wp_unslash($args['post_type']))) : 'comic';
    $args['paged']       = isset($_POST['page']) ? esc_attr(sanitize_text_field(wp_unslash($_POST['page']))) : 2;
    $args['post_status'] = 'publish';

    ob_start();
    $loop = new WP_Query($args);
    if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();
            get_template_part('template-parts/content', 'infinitescrollcomic');
        endwhile;endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success($data);
    wp_die();
    }
    add_action('wp_ajax_toocheke_ajax_load_more', 'toocheke_ajax_load_more');
    add_action('wp_ajax_nopriv_toocheke_ajax_load_more', 'toocheke_ajax_load_more');

    /**
 * First Term
 * Helper Function
 */
    function toocheke_helper_first_term($taxonomy, $field)
    {
    $terms = get_the_terms(get_the_ID(), $taxonomy);

    if (empty($terms) || is_wp_error($terms)) {
        return false;
    }

    // If there's only one term, use that
    if (1 == count($terms)) {
        $term = array_shift($terms);
    } else {
        $term = array_shift($list);
    }

    // Output
    if ($field && isset($term->$field)) {
        return $term->$field;
    } else {
        return $term;
    }

    }

    /**
 * Check if default buttons should be displayed
 */
    function toocheke_display_default_buttons()
    {
    if (get_option('toocheke-comics-navigation') && 1 == get_option('toocheke-comics-navigation')) {
        return true;
    } else {
        if (get_option('toocheke-first-button') || get_option('toocheke-previous-button') || get_option('toocheke-next-button') || get_option('toocheke-latest-button') || get_option('toocheke-facebook-button') || get_option('toocheke-twitter-button') || get_option('toocheke-tumblr-button') || get_option('toocheke-reddit-button') || get_option('toocheke-copy-button')) {
            return false;
        } else {
            return true;
        }
    }
    }
    /**
 * Chapter navigation functions
 */
    if (! function_exists('toocheke_get_previous_comic')):
    function toocheke_get_previous_comic($in_chapter = false)
    {
        return toocheke_get_adjacent_comic(true, $in_chapter);
    }
    endif;
    if (! function_exists('toocheke_get_previous_comic_permalink')):
    function toocheke_get_previous_comic_permalink()
    {
        $prev_comic = toocheke_get_previous_comic(false);
        if (is_object($prev_comic) && isset($prev_comic->ID)) {
            return get_permalink($prev_comic->ID);
        }
        return false;
    }
    endif;
    /*
if (!function_exists('toocheke_get_previous_comic_in_chapter_permalink')):
function toocheke_get_previous_comic_in_chapter_permalink()
{
$prev_comic = toocheke_get_previous_comic(true);
if (is_object($prev_comic) && isset($prev_comic->ID)) {
return get_permalink($prev_comic->ID);
}
//    Go to last comic of previous chapter if possible.

$chapter = toocheke_get_adjacent_chapter(true, $prev_comic->ID);
if (is_object($chapter)) {
$terminal = toocheke_get_chapter_comic_post($chapter->term_id, false);
return !empty($terminal) ? get_permalink($terminal->ID) : false;
}

return false;
}
endif;
 */
    if (! function_exists('toocheke_get_next_comic')):
    function toocheke_get_next_comic($in_chapter = false)
    {
        return toocheke_get_adjacent_comic(false, $in_chapter);
    }
    endif;
    if (! function_exists('toocheke_get_next_comic_permalink')):
    function toocheke_get_next_comic_permalink()
    {
        $next_comic = toocheke_get_next_comic(false);
        if (is_object($next_comic) && isset($next_comic->ID)) {
            return get_permalink($next_comic->ID);
        }
        return false;
    }
    endif;
    /*
if (!function_exists('toocheke_get_next_comic_in_chapter_permalink')):
function toocheke_get_next_comic_in_chapter_permalink()
{
$next_comic = toocheke_get_next_comic(true);
if (is_object($next_comic) && isset($next_comic->ID)) {
return get_permalink($next_comic->ID);
}
// go to first comic of next chapter if possible

$chapter = toocheke_get_adjacent_chapter(false, $next_comic->ID);
if (is_object($chapter)) {
$terminal = toocheke_get_chapter_comic_post($chapter->term_id, true);
return !empty($terminal) ? get_permalink($terminal->ID) : false;
}

return false;
}
endif;
 */
    // 0 means get the first of them all, no matter chapter, otherwise 0 = this chapter.
    if (! function_exists('toocheke_get_chapter_comic_post')):
    function toocheke_get_chapter_comic_post($chapterID = 0, $first = true)
    {

        $sortOrder = $first ? "asc" : "desc";

        if (! empty($chapterID)) {
            $chapter      = get_term_by('id', $chapterID, 'chapters');
            $chapter_slug = $chapter->slug;
            $args         = [
                'chapters'       => $chapter_slug,
                'order'          => $sortOrder,
                'posts_per_page' => 1,
                'post_type'      => 'comic',
            ];
        } else {
            $args = [
                'order'          => $sortOrder,
                'posts_per_page' => 1,
                'post_type'      => 'comic',
            ];
        }

        $terminalComicQuery = new WP_Query($args);

        $terminalPost = false;
        if ($terminalComicQuery->have_posts()) {
            $terminalPost = reset($terminalComicQuery->posts);
        }
        return $terminalPost;
    }
    endif;
    /**
 * Retrieve adjacent post link.
 *
 */
    if (! function_exists('toocheke_get_adjacent_comic')):
        function toocheke_get_adjacent_comic($previous = true, $in_same_chapter = false, $taxonomy = 'comic')
        {
            global $post, $wpdb;
            if (empty($post)) {
                return null;
            }

            $join = '';

            if ($in_same_chapter) {
                $join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

                $chapt_array = wp_get_object_terms($post->ID, 'chapters', ['fields' => 'ids']);
                if (! empty($chapt_array) && is_array($chapt_array)) {
                    $join .= " AND tt.taxonomy = 'chapters' AND tt.term_id IN (" . implode(',', array_map('absint', $chapt_array)) . ")";
                }
            }

            $adjacent = $previous ? 'previous' : 'next';
            $order    = $previous ? 'DESC' : 'ASC';

            $default_where = $previous
                ? $wpdb->prepare("WHERE p.post_date < %s AND p.post_type = %s AND p.post_status = 'publish'", $post->post_date, $post->post_type)
                : $wpdb->prepare("WHERE p.post_date > %s AND p.post_type = %s AND p.post_status = 'publish'", $post->post_date, $post->post_type);

            $where = apply_filters("get_{$adjacent}_{$taxonomy}_where", $default_where, $in_same_chapter);
            $sort  = apply_filters("get_{$adjacent}_{$taxonomy}_sort", "ORDER BY p.post_date $order LIMIT 1");

            $query_key = "adjacent_{$taxonomy}_{$post->ID}_{$previous}_{$in_same_chapter}";
            $result    = wp_cache_get($query_key, 'counts');
            if (false !== $result) {
                return $result;
            }

            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
            if (null === $result) {
                $result = '';
            }

            wp_cache_set($query_key, $result, 'counts');
            return $result;
        }
    endif;
    if (! function_exists('toocheke_get_adjacent_chapter')):
    function toocheke_get_adjacent_chapter($prev = false, $comic_id = null, $series_id = null)
    {
        if (! get_the_terms($comic_id, 'chapters')) {
            return false;
        }
        $current_chapter = get_the_terms($comic_id, 'chapters')[0];

        /* if (is_array($current_chapter)) {$current_chapter = reset($current_chapter);} else {return;}

        // cache the calculation of the desired chapter - workaround for bug with w3 total cache's object cache
        $current_chapter_order = wp_cache_get('toocheke_current_order_' . $current_chapter->slug);
        if (false === $current_chapter_order) {

        $current_chapter_order = (int) get_term_meta($current_chapter->term_id, 'chapter-order', true);
        //$current_chapter_order = $current_chapter->chapter-order;
        wp_cache_set('toocheke_current_order_' . $current_chapter->slug, $current_chapter_order);
        } */

        $current_chapter_id = $current_chapter->term_id;

        //create array for searching
        $all_chapters_args = [
            'orderby'    => 'meta_value_num',
            'order'      => 'ASC',
            'meta_query' => [
                [
                    'key'  => 'chapter-order',
                    'type' => 'NUMERIC',
                ]],
            'hide_empty' => 1,
        ];

        $all_chapters_array      = get_terms('chapters', $all_chapters_args);
        $filtered_chapters_array = [];
        if ($all_chapters_array) {
            //handle chapters array creation in case there is a series
            foreach ($all_chapters_array as $chapter) {
                $chapter_comic_args = [
                    'posts_per_page'         => 1,
                    'post_parent'            => $series_id,
                    'post_type'              => 'comic',
                    'orderby'                => 'post_date',
                    'order'                  => 'ASC',
                    "tax_query"              => [
                        [
                            'taxonomy' => "chapters", // use the $tax you define at the top of your script
                            'field'    => 'term_id',
                            'terms'    => $chapter->term_id, // use the current term in your foreach loop
                        ],
                    ],
                    'no_found_rows'          => true,
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                ];
                $chapter_comic_query = new WP_Query($chapter_comic_args);
                if ($chapter_comic_query->have_posts()) {
                    $filtered_chapters_array[] = $chapter;
                }
            }

            if ($filtered_chapters_array) {
                // Lets get all the term id's from the array of term objects
                $chapter_ids = wp_list_pluck($filtered_chapters_array, 'term_id');
                //echo '<pre>'; print_r($chapter_ids); echo '</pre>';

                /**
                 * We now need to locate the position of the current chapter amongst the $chapters_ids array. \
                 * This way, we can now know which chapters are adjacent to the current one
                 */
                $current_chapter_index = array_search($current_chapter_id, $chapter_ids);

                // Set default variables to hold the next and previous chapters
                $previous_chapter = null;
                $next_chapter     = null;

                $previous_chapter_index = $prev && $current_chapter_index >= 0 ? $current_chapter_index - 1 : null;
                $next_chapter_index     = ! $prev && $current_chapter_index < intval(count($chapter_ids) - 1) ? $current_chapter_index + 1 : null;

                // Get the previous chapter

                if ($previous_chapter_index > -1) {
                    $previous_chapter = $filtered_chapters_array[$previous_chapter_index];
                }

                // Get the next chapter
                if ($next_chapter_index) {
                    $next_chapter = $filtered_chapters_array[$next_chapter_index];
                }

                //return the chapter
                if ($prev) {
                    return $previous_chapter ? $previous_chapter : false;
                } else {
                    return $next_chapter ? $next_chapter : false;
                }

                //echo  $current_chapter_index;
                //echo '<pre>'; print_r($term_ids); echo '</pre>';
            } else {
                return false;
            }
        }

    }
    endif;
    if (! function_exists('toocheke_get_previous_chapter')):
    function toocheke_get_previous_chapter($series_id = null, $comic_id = null)
    {

        $chapter = toocheke_get_adjacent_chapter(true, $comic_id, $series_id);

        if (is_object($chapter)) {

            $child_args = [
                'post_parent' => $series_id,
                'numberposts' => 1,
                'post_type'   => 'comic',
                'orderby'     => 'post_date',
                'order'       => 'ASC',
                'post_status' => 'publish',
                'chapters'    => $chapter->slug,
            ];
            $chapter_posts = get_posts($child_args);
            if (is_array($chapter_posts)) {
                $chapter_posts = reset($chapter_posts);
                $permalink     = get_permalink($chapter_posts->ID);

                if ($series_id) {
                    $permalink = add_query_arg('sid', $series_id, $permalink);
                }

                return $permalink;
            }

        }

        return false;
    }
    endif;
    if (! function_exists('toocheke_get_next_chapter')):
    function toocheke_get_next_chapter($series_id = null, $comic_id = null)
    {
        $chapter = toocheke_get_adjacent_chapter(false, $comic_id, $series_id);
        if (is_object($chapter)) {
            $child_args = [
                'post_parent' => $series_id,
                'numberposts' => 1,
                'post_type'   => 'comic',
                'orderby'     => 'post_date',
                'order'       => 'ASC',
                'post_status' => 'publish',
                'chapters'    => $chapter->slug,
            ];
            $chapter_posts = get_posts($child_args);
            if (is_array($chapter_posts)) {
                $chapter_posts = reset($chapter_posts);
                $permalink     = get_permalink($chapter_posts->ID);

                if ($series_id) {
                    $permalink = add_query_arg('sid', $series_id, $permalink);
                }

                return $permalink;
            }
        }
        return false;
    }
    endif;
    /**
 * Replace comic images
 *
 */
    if (! function_exists('toocheke_wrap_content_img')):
    function toocheke_wrap_content_img($content)
    {
        // Don't run in admin interface
        if (is_admin()) {
            return $content;
        }

        if (get_post_type() == 'post') {
            return $content;
        }
        $home_layout   = get_theme_mod('home_layout_setting', 'default');
        $is_comic_home = $home_layout == 'alt-1' || $home_layout == 'alt-4';
        $comic_layout  = get_option('toocheke-comic-layout-devices');
        $is_responsive = $comic_layout === '1' ? true : false;
        $is_comic      = 'comic' == get_post_type();
        if ((is_singular('comic') || ($is_comic_home && is_home() && $is_comic)) && $is_responsive) {
            // convert images
            $content = toocheke_picture_wrapper($content, false);
        }

        // return the processed content
        return $content;
    }
    endif;

    add_filter('the_content', 'toocheke_wrap_content_img');
    if (! function_exists('toocheke_wrap_meta_content_img')):
    function toocheke_wrap_meta_content_img($metadata, $post_id, $meta_key, $single)
    {
        // Don't run in admin interface
        if (is_admin()) {
            return $metadata;
        }

        if (get_post_type($post_id) == 'post') {
            return $metadata;
        }

        // Get list of filter
        global $wp_current_filter;
        $filter_key = count($wp_current_filter) - 2;
        // Check if this filter is inside itself
        if (isset($wp_current_filter[$filter_key]) && 'get_post_metadata' === $wp_current_filter[count($wp_current_filter) - 2]) {
            return $metadata;
        }

        $home_layout   = get_theme_mod('home_layout_setting', 'default');
        $is_comic_home = $home_layout == 'alt-1' || $home_layout == 'alt-4';
        $comic_layout  = get_option('toocheke-comic-layout-devices');
        $is_responsive = $comic_layout === '1' ? true : false;
        if ((is_singular('comic') || ($is_comic_home && is_home())) && $is_responsive) {
            // get meta content
            if (isset($meta_key) && ('desktop_comic_editor' == $meta_key || 'desktop_comic_2nd_language_editor' == $meta_key || 'mobile_comic_2nd_language_editor' == $meta_key)) {
                remove_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 10);
                $current_meta = get_post_meta($post_id, $meta_key, true);
                add_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 10, 4);
                // convert images
                $is_desktop   = 'desktop_comic_editor' == $meta_key || 'desktop_comic_2nd_language_editor' == $meta_key;
                $current_meta = toocheke_picture_wrapper($current_meta, $is_desktop);
                //added do_shortcode to handle cases where shortcodes like captions may be present
                return do_shortcode($current_meta);
            }
        }

        // Return original if the check does not pass
        return $metadata;

    }
    endif;

    add_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 999, 4);
    if (! function_exists('toocheke_picture_wrapper')):
    function toocheke_picture_wrapper($dom_content, $is_desktop = true)
    {
        if (empty($dom_content) || false === stripos($dom_content, '<img')) {
            return $dom_content;
        }

        $img_blank  = get_stylesheet_directory_uri() . '/dist/img/blank.gif';
        $media_main = $is_desktop ? '(min-width: 1200px)' : '(max-width: 1199px)';
        $media_alt  = $is_desktop ? '(max-width: 1199px)' : '(min-width: 1200px)';

        return preg_replace_callback(
            '/<img\b(?:[^>"\']|"[^"]*"|\'[^\']*\')*>/i',
            function ($matches) use ($img_blank, $media_main, $media_alt) {
                if (! preg_match('/\ssrc\s*=\s*(?:"([^"]*)"|\'([^\']*)\')/i', $matches[0], $src_match)) {
                    return $matches[0];
                }
                $img_src = '' !== $src_match[1] ? $src_match[1] : ($src_match[2] ?? '');
                if ('' === $img_src) {
                    return $matches[0];
                }
                return '<picture>'
                    . '<source media="' . $media_main . '" srcset="' . esc_attr($img_src) . '">'
                    . '<source media="' . $media_alt . '" srcset="' . esc_url($img_blank) . '">'
                    . $matches[0]
                    . '</picture>';
            },
            $dom_content
        );
    }
    endif;
    if (! function_exists('toocheke_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     *
     * @global WP_Post|null $post The current post.
     */
    function toocheke_post_nav()
    {
        global $post;
        if (! $post) {
            return;
        }

        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
        $next     = get_adjacent_post(false, '', false);
        if (! $next && ! $previous) {
            return;
        }
        ?>
		<nav class="container navigation post-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e('Post navigation', 'toocheke'); ?></h2>
			<div class="d-flex nav-links justify-content-between">
				<?php
                    if (get_previous_post_link()) {
                                previous_post_link('<span class="nav-previous">%link</span>', _x('<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'toocheke'));
                            }
                            if (get_next_post_link()) {
                                next_post_link('<span class="nav-next">%link</span>', _x('%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'toocheke'));
                            }
                        ?>
			</div><!-- .nav-links -->
		</nav><!-- .post-navigation -->
		<?php
            }
            }
            add_action('init', 'toocheke_random_add_rewrite');
            if (! function_exists('toocheke_random_add_rewrite')) {
                function toocheke_random_add_rewrite()
                {
                    global $wp;
                    $wp->add_query_var('random');
                    $wp->add_query_var('sid');
                    add_rewrite_rule('random/?$', 'index.php?random=1', 'top');
                }
            }

            add_action('template_redirect', 'toocheke_random_template');
            if (! function_exists('toocheke_random_template')) {
                /**
                 * Handles the /random/ URL.
                 *
                 * Two deliberate hardening changes here, both aimed at the same
                 * problem: this URL being repeatedly hit by bots/scrapers can put real
                 * load on a server, since the original version ran a fresh
                 * `ORDER BY RAND()` query (an expensive full-table sort that gets
                 * slower as the comic archive grows) on every single request. This
                 * mirrors the identical fix applied to Toocheke Companion's own
                 * fallback copy of this same function (used for sites on a
                 * non-Toocheke theme).
                 *
                 * 1. If the site owner has turned off "Do you want to display the
                 *    random button?" (toocheke-random-navigation) entirely, there's no
                 *    legitimate reason for this URL to still work -- a real 404 is
                 *    returned instead of processing the redirect. This is checked
                 *    directly here, rather than only conditionally registering the
                 *    rewrite rule, since rewrite rules are cached and only regenerate
                 *    on a flush -- checking here takes effect immediately the moment
                 *    the setting is saved, with no flush-timing gap.
                 *
                 * 2. Even when the button IS enabled, the eligible comic ID list is
                 *    cached for a few minutes and picked from with PHP's array_rand()
                 *    instead of re-querying MySQL with ORDER BY RAND() on every hit. A
                 *    burst of requests within that window -- whether a bot flood or
                 *    just a lot of real visitors -- shares one cheap lookup instead of
                 *    each paying for its own full-table sort. New comics can take up
                 *    to the cache lifetime to enter the pool; see
                 *    toocheke_invalidate_random_comic_cache() below, which clears it
                 *    immediately on publish/delete so that wait is only relevant if
                 *    that hook somehow doesn't fire.
                 */
                function toocheke_random_template()
                {
                    if (get_query_var('random') != 1) {
            return;
                    }

                    if (! get_option('toocheke-random-navigation')) {
            toocheke_force_random_404();
            return;
                    }

                    $sid = absint(get_query_var('sid'));

                    $cache_key = 'toocheke_random_ids_' . ($sid > 0 ? $sid : 'all');
                    $ids       = get_transient($cache_key);

                    if (false === $ids) {
            $args = [
                'post_type'      => 'comic',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ];
            if ($sid > 0) {
                $args['post_parent'] = $sid;
            }
            $ids = get_posts($args);
            set_transient($cache_key, $ids, 5 * MINUTE_IN_SECONDS);
                    }

                    if (empty($ids)) {
            toocheke_force_random_404();
            return;
                    }

                    $random_id = $ids[array_rand($ids)];
                    $link      = get_permalink($random_id);

                    // Append sid to the permalink if provided
                    if ($sid > 0) {
            $link = add_query_arg('sid', $sid, $link);
                    }
                    if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
            $link = $link . '#main';
                    }

                    wp_redirect($link, 307);
                    exit;
                }
            }

            if (! function_exists('toocheke_invalidate_random_comic_cache')) {
                /**
                 * Clears the cached random-comic ID list(s) used by
                 * toocheke_random_template() so a newly published (or
                 * unpublished/deleted) comic is reflected immediately rather than
                 * waiting out the cache lifetime. Clears both the site-wide pool and,
                 * if the comic belongs to a series, that series' own pool.
                 */
                function toocheke_invalidate_random_comic_cache($post_id)
                {
                    if ('comic' !== get_post_type($post_id)) {
            return;
                    }

                    delete_transient('toocheke_random_ids_all');

                    $series_id = (int) wp_get_post_parent_id($post_id);
                    if ($series_id > 0) {
            delete_transient('toocheke_random_ids_' . $series_id);
                    }
                }
            }
            add_action('save_post_comic', 'toocheke_invalidate_random_comic_cache');
            add_action('deleted_post', 'toocheke_invalidate_random_comic_cache');

            if (! function_exists('toocheke_force_random_404')) {
                /**
                 * Standard WP pattern for deliberately forcing a 404 response from a
                 * template_redirect-hooked function.
                 */
                function toocheke_force_random_404()
                {
                    global $wp_query;
                    $wp_query->set_404();
                    status_header(404);
                    nocache_headers();
                }
            }

            if (! function_exists('toocheke_random_robots_disallow')) {
                /**
                 * Adds a Disallow rule for /random/ to WordPress's own virtual
                 * robots.txt (only takes effect if the site owner hasn't uploaded a
                 * physical robots.txt file of their own). This only ever helps
                 * well-behaved crawlers (Google, Bing, etc.) that actually respect
                 * robots.txt -- it does nothing against a bot that ignores it, but
                 * it's a free, safe way to stop legitimate crawlers from wasting crawl
                 * budget on a redirect-only URL with no content of its own to index.
                 */
                function toocheke_random_robots_disallow($output, $public)
                {
                    if ('1' === (string) $public) {
            $output .= "Disallow: /random\n";
            $output .= "Disallow: /random/\n";
                    }
                    return $output;
                }
            }
            add_filter('robots_txt', 'toocheke_random_robots_disallow', 10, 2);
            add_filter('the_content_more_link', 'toocheke_modify_read_more_link');
            if (! function_exists('toocheke_modify_read_more_link')) {
                function toocheke_modify_read_more_link()
                {
                    return '<a class="btn-more btn btn-danger btn-sm" href="' . get_permalink() . '">Read More</a>';
                }
            }

            add_filter('excerpt_more', 'toocheke_excerpt_more');
            if (! function_exists('toocheke_excerpt_more')) {
                function toocheke_excerpt_more()
                {
                    global $post;
                    if (get_post_type() !== 'series') {
            return '<br/><a class="btn-more btn btn-danger btn-sm" href="' . get_permalink($post->ID) . '">Read More</a>';
                    }

                }
            }

            if (! function_exists('toocheke_strip_p_around_single_image')) {
                function toocheke_strip_p_around_single_image($content)
                {
                    if (get_post_type() !== 'comic') {
            return $content; // only apply to comics
                    }

                    // This regex finds <p> tags that contain only an <img> (optionally wrapped in whitespace)
                    $content = preg_replace(
            '/<p>\s*(<img [^>]+>)\s*<\/p>/i',
            '$1',
            $content
                    );

                    return $content;
                }
            }

            add_filter('the_content', 'toocheke_strip_p_around_single_image', 20);

            function toocheke_filter_comic_archive_by_parent($query)
            {

                // Only modify the main query on the comic archive
                if (! is_admin() && $query->is_main_query() && is_post_type_archive('comic')) {

                    // Check for ?sid=123 in the URL
                    if (isset($_GET['sid']) && is_numeric($_GET['sid'])) {

            $parent_id = intval($_GET['sid']);

            // Apply parent filtering
            $query->set('post_parent', $parent_id);
                    }

                    // If sid is NOT provided → do nothing (default archive)
                }
            }
            add_action('pre_get_posts', 'toocheke_filter_comic_archive_by_parent');

            /**
             * content-comicarchivethumbnail.php, content-comicarchivetext.php,
             * content-comicarchivegallery.php, and the yearly variants all loop
             * over the main query directly with have_posts()/the_post() rather
             * than building their own WP_Query (unlike the chapters/collections/
             * series templates, which already pass 'order' => $comic_order into
             * their own secondary queries). That means toocheke-comics-order has
             * to be applied here, before the main query runs.
             *
             * Covers two cases:
             * 1. The default /comic/ post-type archive (thumbnail-list,
             *    plain-text-list, gallery, and yearly-* when no year is in the
             *    URL yet).
             * 2. An actual year/month/day archive, e.g. /2014/?post_type=comic.
             */
            function toocheke_comic_archive_order($query)
            {
                if (is_admin() || ! $query->is_main_query()) {
                    return;
                }

                $post_type = $query->get('post_type');
                $is_comic_date_archive = $query->is_date() && ('comic' === $post_type || (is_array($post_type) && in_array('comic', $post_type, true)));

                if (! is_post_type_archive('comic') && ! $is_comic_date_archive) {
                    return;
                }

                $comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
                $query->set('orderby', 'post_date');
                $query->set('order', $comic_order);
            }
            add_action('pre_get_posts', 'toocheke_comic_archive_order');

            /**
             * Manga filter
             */
            function toocheke_enqueue_manga_filter_assets()
            {
                $home_layout          = get_theme_mod('home_layout_setting', 'default');
                $display_manga_layout = in_array($home_layout, ['alt-6', 'alt-7'], true);

                if (! (is_home() || is_front_page()) || ! $display_manga_layout) {
                    return;
                }

                wp_enqueue_script(
                    'toocheke-manga-filter',
                    get_template_directory_uri() . '/src/js/manga-filter.js',
                    [],
                    wp_get_theme()->get('Version'),
                    true
                );

                wp_localize_script('toocheke-manga-filter', 'toochekeMangaFilter', [
                    'restUrl'     => esc_url_raw(rest_url('toocheke/v1/manga-series')),
                    'filterLabel' => __('Filter', 'toocheke'),
                    'noResults'   => __('No series found.', 'toocheke'),
                    'loadingText' => __('Loading...', 'toocheke'),
                ]);
            }

            add_action('wp_enqueue_scripts', 'toocheke_enqueue_manga_filter_assets');
            /**
             * Backward-compatibility shim only. Some child themes call this function
             * directly, and removing it entirely would cause a fatal error on those
             * sites. View counting for comic/manga_chapter pages is now handled
             * entirely by Toocheke Companion 2.2+ (required), independently of whether
             * this function is called. This function intentionally does nothing --
             * calling it here as well would double-count every view.
             */
            function toocheke_set_post_views($postID)
            {
                // Intentionally empty -- see docblock above.
            }
            function toocheke_restore_wpautop_for_classic_content($content)
            {
                if (! has_blocks($content) && ! has_filter('the_content', 'wpautop')) {
                    add_filter('the_content', 'wpautop');
                }
                return $content;
            }
            add_filter( 'the_content', 'toocheke_restore_wpautop_for_classic_content', 8 );
            /**
             * Open Graph meta tags (og:title, og:description, og:image).
             * Skips itself automatically if a popular SEO plugin is active --
             * see the file for details.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/opengraph-meta-tags.php';
            /**
             * Implement the Custom Header feature.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/custom-header.php';

            /**
             * Custom template tags for this theme.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/template-tags.php';
            /**
             * Customizer additions.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/customizer.php';

            /**
             * Widgets File.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/widgets.php';

            /**
             * Boostrap Navwalker File.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

            /**
             * Boostrap Comment Walker File.
             */
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require get_template_directory() . '/inc/bootstrap-comment-walker.php';

            /**
             * Load Jetpack compatibility file.
             */
            if (defined('JETPACK__VERSION')) {
                // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
                require get_template_directory() . '/inc/jetpack.php';
            }
            /**
             * Guttenberg Support.
             */

/* ========================================================================
   Continue Reading navigation link

   Mirrors how Toocheke Premium adds its Patreon menu button: only hooked
   when the corresponding "Navigation Bar" Customizer toggle is checked, and
   appended to the primary nav via the wp_nav_menu_items filter so it works
   regardless of what menu items the site owner has configured, without
   needing to touch the menu itself.
   ======================================================================== */
if (! function_exists('toocheke_add_continue_reading_nav_item')) {
    function toocheke_add_continue_reading_nav_item($items)
    {
        if (! shortcode_exists('toocheke-continue-reading')) {
            return $items;
        }

        $button = do_shortcode('[toocheke-continue-reading class="nav-link btn btn-danger btn-xs btn-nav-continue-reading"]');

        if ('' === trim($button)) {
            return $items;
        }

        return $items . '<li class="nav-item menu-item continue-reading-item">' . $button . '</li>';
    }
}

if (get_theme_mod('continue_reading_menu_setting') != '') {
    add_filter('wp_nav_menu_items', 'toocheke_add_continue_reading_nav_item');
}
