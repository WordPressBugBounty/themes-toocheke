<?php
if (!is_active_sidebar('right-sidebar')) {
    return;
}

// Resolve series ID regardless of how we got here
$series_id = null;

if ( is_singular('series') ) {
    $series_id = get_the_ID();
} elseif ( isset( $_GET['sid'] ) && absint( $_GET['sid'] ) ) {
    $series_id = absint( $_GET['sid'] );
}

$series_sidebar_content = $series_id 
    ? get_post_meta( $series_id, 'series_sidebar_content', true ) 
    : '';
?>
    <!--START SIDEBAR-->
<div class="col-lg-4">
    <div id="side-bar" class="secondary">
        <?php
        if ( $series_sidebar_content ) {
            echo '<section>';
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $series_sidebar_content;
            echo '</section>';
        } else {
            dynamic_sidebar('right-sidebar');
        }
        ?>
    </div>
</div>
<!--END SIDEBAR-->