<?php
/**
 * Template Name: Dashboard Page
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

                    <div class="dashboard-welcome" style="background-image: url('/wp-content/themes/init/img/dashboard.jpg')">
                        <div class="content article">
                            <div class="article-sm">
                                <div class="tag blur">Онлайн магазин цветов</div>
                                <div class="h4">Добро пожаловать,<br><?php echo USER['user_name']; ?></div>
                            </div>

                            <div class="block-text article-sm"><?php the_content(); ?></div>

                            <div class="inline">
                                <div class="line">
                                    <a href="<?php echo PRE_LINK ?>/product/" class="btn"><span class="text">Перейти в каталог</span></a>
                                    <a href="<?php echo PRE_LINK ?>/dashboard/my-orders/" class="btn theme-outline hide-sm"><span class="text">Мои заказы</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="message-block">
                        <div class="avatar icon-gift"></div>
                        <div class="message-block-content">
                            <div class="title">FlowLove</div>
                            <div class="text">Ваш персональный промокод на <b>скидку 5%</b></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();