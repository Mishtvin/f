<?php
/**
 * Template Name: Reviews Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
while ( have_posts() ) : the_post(); ?>   

    <?php page_header(['after' => '<button class="btn review-btn"><span class="text">Оставить отзыв</span></button>']); ?>
    <section class="reviews section-padding pb">
        <div class="container">
            <div class="wrapper article-md">
                <div class="reviews-grid">
                    <div class="line">
                        <?php   
                            global $wpdb;
                            $reviews = $wpdb->get_col("SELECT `id` FROM `init_reviews` WHERE `status` = 1 ORDER BY `id` DESC");

                            if(!empty($reviews)) {
                                foreach($reviews as $id) {
                                    echo review($id);
                                }
                            } else {
                                echo '<div class="empty-block">
                                    <span class="icon icon-error"></span>
                                    <div class="h6">Нет отзывов</div>
                                </div>';
                            }
                        ?>
                    </div>
                </div>

                <button class="btn review-btn large center"><span class="text">Оставить отзыв</span></button>
            </div>
        </div>
    </section>

<?php endwhile;
get_footer();