<?php
/**
 * Template part for displaying manga layout home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

$hide_all_manga_series_section  = get_theme_mod( 'hide_all_manga_series_setting', false );
$hide_popular_series_section    = get_theme_mod( 'hide_popular_manga_series_setting', false );
$hide_popular_volumes_section   = get_theme_mod( 'hide_popular_manga_volumes_setting', false );
$hide_popular_chapters_section  = get_theme_mod( 'hide_popular_manga_chapters_setting', false );

?>

<div id="manga-series-container" class="row">

    <!--START LEFT COL-->
    <div class="col-lg-8">
        <div id="left-col">
            <div id="left-content">

                <!--HOME TOP WIDGET START-->
                <?php dynamic_sidebar( 'home-left-top' ); ?>
                <!--HOME TOP WIDGET END-->

                <!-- Manga Index Sections -->

                <?php if ( ! $hide_all_manga_series_section ) : ?>
                <!-- Render All Series Grid -->
                <div id="manga-all-series-wrapper">

                    <h2 id="manga-series-header">
                        <?php echo ( esc_html( get_theme_mod( 'manga_series_setting' ) ) !== '' )
                            ? esc_html( get_theme_mod( 'manga_series_setting' ) )
                            : esc_html__( 'Manga Series', 'toocheke' ); ?>
                    </h2>

                    <form id="manga-series-filter-form" class="manga-series-filter-form">

                        <div class="filter-field">
                            <label for="publisher"><?php esc_html_e( 'Publisher:', 'toocheke' ); ?></label>
                            <select name="publisher" id="publisher">
                                <option value=""><?php esc_html_e( 'All Publishers', 'toocheke' ); ?></option>
                                <?php
                                $publishers = get_terms( [ 'taxonomy' => 'manga_publisher', 'hide_empty' => true ] );
                                if ( ! is_wp_error( $publishers ) ) {
                                    foreach ( $publishers as $publisher ) {
                                        $selected = ( isset( $_GET['publisher'] ) && $_GET['publisher'] === $publisher->slug ) ? ' selected' : '';
                                        printf(
                                            '<option value="%s"%s>%s</option>',
                                            esc_attr( $publisher->slug ),
                                            $selected,
                                            esc_html( $publisher->name )
                                        );
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="filter-field">
                            <label for="genre"><?php esc_html_e( 'Genre:', 'toocheke' ); ?></label>
                            <select name="genre" id="genre">
                                <option value=""><?php esc_html_e( 'All Genres', 'toocheke' ); ?></option>
                                <?php
                                $genres = get_terms( [ 'taxonomy' => 'manga_genre', 'hide_empty' => true ] );
                                if ( ! is_wp_error( $genres ) ) {
                                    foreach ( $genres as $genre ) {
                                        $selected = ( isset( $_GET['genre'] ) && $_GET['genre'] === $genre->slug ) ? ' selected' : '';
                                        printf(
                                            '<option value="%s"%s>%s</option>',
                                            esc_attr( $genre->slug ),
                                            $selected,
                                            esc_html( $genre->name )
                                        );
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="filter-field">
                            <button type="submit" class="btn-sm btn-danger btn">
                                <?php esc_html_e( 'Filter', 'toocheke' ); ?>
                            </button>
                        </div>

                    </form>

                    <hr class="toocheke-hr manga-hr" />

                    <!-- Populated by manga-filter.js -->
                    <div id="manga-series-grid" class="manga-grid-list-container"></div>

                    <!-- IntersectionObserver watches this to trigger next page load -->
                    <div id="manga-series-sentinel"></div>

                    <!-- Loading indicator -->
                    <div id="manga-series-loading" style="display:none; text-align:center; padding: 1rem;">
                        <span class="manga-button-spinner"></span>
                        <?php esc_html_e( 'Loading...', 'toocheke' ); ?>
                    </div>

                </div>
                <!-- ./Render All Series Grid -->
                <?php endif; ?>

                <?php if ( ! $hide_popular_series_section ) : ?>
                <!-- Render Popular Series Grid -->
                <div id="manga-popular-series-wrapper">
                    <?php
                    $query_pop_series = new WP_Query( [
                        'post_type'      => 'manga_series',
                        'posts_per_page' => 4,
                        'orderby'        => 'meta_value_num',
                        'meta_key'       => '_post_like_count',
                        'order'          => 'DESC',
                    ] );

                    get_template_part( 'template-parts/content', 'indexmangagrid', [
                        'query'         => $query_pop_series,
                        'section_id'    => 'manga-popular-series-header',
                        'section_title' => ( esc_html( get_theme_mod( 'manga_popular_series_setting' ) ) !== '' )
                            ? esc_html( get_theme_mod( 'manga_popular_series_setting' ) )
                            : esc_html__( 'Popular Series', 'toocheke' ),
                    ] );
                    ?>
                </div>
                <!-- ./Render Popular Series Grid -->
                <?php endif; ?>

                <?php if ( ! $hide_popular_volumes_section ) : ?>
                <!-- Render Popular Volumes Grid -->
                <div id="manga-popular-volumes-wrapper">
                    <?php
                    $query_pop_volumes = new WP_Query( [
                        'post_type'      => 'manga_volume',
                        'posts_per_page' => 4,
                        'orderby'        => 'meta_value_num',
                        'meta_key'       => '_post_like_count',
                        'order'          => 'DESC',
                    ] );

                    get_template_part( 'template-parts/content', 'indexmangagrid', [
                        'query'         => $query_pop_volumes,
                        'section_id'    => 'manga-popular-volumes-header',
                        'section_title' => ( esc_html( get_theme_mod( 'manga_popular_volumes_setting' ) ) !== '' )
                            ? esc_html( get_theme_mod( 'manga_popular_volumes_setting' ) )
                            : esc_html__( 'Popular Volumes', 'toocheke' ),
                    ] );
                    ?>
                </div>
                <!-- ./Render Popular Volumes Grid -->
                <?php endif; ?>

                <?php if ( ! $hide_popular_chapters_section ) : ?>
                <!-- Render Popular Chapters Grid -->
                <div id="manga-popular-chapters-wrapper">
                    <?php
                    $query_pop_chapters = new WP_Query( [
                        'post_type'      => 'manga_chapter',
                        'posts_per_page' => 4,
                        'orderby'        => 'meta_value_num',
                        'meta_key'       => '_post_like_count',
                        'order'          => 'DESC',
                    ] );

                    get_template_part( 'template-parts/content', 'indexmangagrid', [
                        'query'         => $query_pop_chapters,
                        'section_id'    => 'manga-popular-chapters-header',
                        'section_title' => ( esc_html( get_theme_mod( 'manga_popular_chapters_setting' ) ) !== '' )
                            ? esc_html( get_theme_mod( 'manga_popular_chapters_setting' ) )
                            : esc_html__( 'Popular Chapters', 'toocheke' ),
                    ] );
                    ?>
                </div>
                <!-- ./Render Popular Chapters Grid -->
                <?php endif; ?>
                <!-- ./Manga Index Sections -->

                <!--HOME BOTTOM WIDGET START-->
                <?php dynamic_sidebar( 'home-left-bottom' ); ?>
                <!--HOME BOTTOM WIDGET END-->

            </div><!--./ left-content-->
        </div><!--./ left-col-->
    </div><!--./ col-lg-8-->
    <!--END LEFT COL-->