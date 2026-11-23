<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Toocheke
 */

get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$show_post_thumbnail =  $home_layout == 'alt-1' || $home_layout == 'alt-2' || $home_layout == 'alt-3';
set_query_var('show_post_thumbnail', $show_post_thumbnail);
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
				<!--SHOW FEATURED IMAGE-->
                  <div id="left-col">
					<!--SHOW FEATURED IMAGE-->
				<?php if ( is_singular() && has_post_thumbnail() && $show_post_thumbnail) { ?>
	<div class="page-hero" style="background-image: url('<?php esc_attr(the_post_thumbnail_url("full")); ?>')">
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</div>
	
                <?php 
                }
                ?>
				<!--../SHOW FEATURED IMAGE-->
                     <div id="left-content">
					 <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			toocheke_post_nav();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		                        <!--END CONTENT-->
                              </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->           
              
<?php
get_sidebar();
get_footer();