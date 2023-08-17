<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package init
 */

get_header();
page_header();

?>

<section class="news section-padding pb">
    <div class="container">
        <div class="wrapper article-md">
            <div class="news-archive-body article-md">
                <div class="article-block article bordered">
                    <?php
                        the_post_thumbnail();
                        the_content();
                    ?>
                </div>
                <div class="single-meta bordered">
                    <div class="date">Дата публикации: <?php echo get_the_date('d M Y'); ?> г.</div>
                    <div class="inline">
                        <div class="line">
                            <a href="https://vk.com/share.php?url=<?php the_permalink(); ?>&title=<?php echo urlencode(get_the_title()); ?>&description=<?php echo urlencode(get_the_excerpt()); ?>&image=<?php echo get_the_post_thumbnail_url(); ?>&noparse=true" class="btn medium outline" target="_blank"><span class="icon icon-vk"></span></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="btn medium outline" target="_blank"><span class="icon icon-facebook"></span></a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php the_permalink(); ?>&via=TWITTER-HANDLE" class="btn medium outline" target="_blank"><span class="icon icon-twitter"></span></a>
                        </div>
                    </div>
                </div>
                <div class="inline full">
                    <div class="line">
                        <div class="h5">Также рекомендуем прочитать</div>
                        <div class="grow"></div>
                        <a href="<?php echo PRE_LINK ?>/news/" class="subtitle">Смотреть все</a>
                    </div>
                </div>

                <div class="news-rec-slider">
                    <div class="swiper-wrapper">
                        <?php
                            $args = array(
                                'post_type'         => 'news',
                                'post_status'       => 'publish',
                                'posts_per_page'    => 8,
                                'post__not_in'      => array(get_the_id()),
                                'order'             => 'rand'
                            );

                            $query = new WP_Query($args);
                            
                            if ( $query->have_posts() ) :
                                while ( $query->have_posts() ) : $query->the_post();

                                get_template_part( 'template-parts/content', 'news' );

                            endwhile;
                            
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
