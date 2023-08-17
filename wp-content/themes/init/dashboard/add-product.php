<?php
/**
 * Template Name: Add Product Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */
if( !current_user_can('administrator') ){
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
                    <?php productEditor() ?>
                </div>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();