<?php
/**
 * Template Name: My Orders Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */
if( !is_user_logged_in() ){
    wp_redirect( '/login/' );
}

get_header();
page_header();

while ( have_posts() ) : the_post();
?> 
    <section class="dashboard section-padding pb">
        <div class="container">
            <div class="wrapper">
                <?php dashboard_sidebar(); ?>
                <div class="dashboard-content article">
                    <?php user_orders(); ?>
                </div>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();