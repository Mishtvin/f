<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
page_header();
?>

<section class="news section-padding pb">
    <div class="container">
        <div class="wrapper article-md">
            <div class="news-archive-body">
                <div class="news-grid">
                    <div class="line">
                        <?php
                            if ( have_posts() ) :

                            while ( have_posts() ) : the_post();

                                get_template_part( 'template-parts/content', get_post_type() );

                            endwhile;

                            the_posts_pagination(array(
                                'end_size'     => 1,     // количество страниц на концах
                                'mid_size'     => 1,     // количество страниц вокруг текущей,
                                'prev_text'    => '<span class="icon-arrow-left"></span>',
                                'next_text'    => '<span class="icon-arrow-right"></span>',
                            ));

                            else :

                            get_template_part( 'template-parts/content', 'none' );

                            endif;
                        ?>
                    </div>
                </div>
            </div>
            <?php get_sidebar('news'); ?>
        </div>
    </div>
</section>

<?php
get_footer();
