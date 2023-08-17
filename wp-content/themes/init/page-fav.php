<?php
/**
 * Template Name: Fav Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
while ( have_posts() ) : the_post(); ?>   

    <?php page_header(); ?>
    <section class="fav section-padding pb">
        <div class="container">
            <div class="wrapper fav-append catalog"><?php echo FAV['items_structure']; ?></div>
        </div>
    </section>

<?php endwhile;
get_footer();