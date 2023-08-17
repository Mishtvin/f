<?php
/**
 * Template Name: Login Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

if( is_user_logged_in() ){
    wp_redirect( '/dashboard/' );
}

get_header();

?>  

<?php while ( have_posts() ) : the_post(); ?>

    <section class="auth login-page">
        <div class="container">
            <div class="wrapper">
                <form class="auth-form article">
                    <div class="auth-text article-mc">
                        <h1><?php the_title(); ?></h1>
                        <p class="sm-text text-grey">Впервые на сайте? <a href="/register/">Зарегистрируйтесь</a>.</p>
                    </div>

                    <div class="form-group article-sm">
                        <div class="input-wrapper">
                            <input type="text" id="login_phone_or_email" placeholder="Email или телефон">
                        </div>
                    </div>

                    <div class="article-sm">
                        <div class="form-group article-sm">
                            <div class="input-wrapper">
                                <input type="password" id="login_password" placeholder="Пароль">
                            </div>
                        </div>
                    </div>

                    <div class="inline full grey-text">
                        <div class="line">
                            <div class="input-wrapper with-checkbox">
                                <div class="checkbox">
                                    <input type="checkbox" id="remember">
                                    <label for="remember" class="icon-check"></label>
                                </div>
                                <label for="remember">Запомнить меня</label>
                            </div>
                            <div class="grow"></div>
                            <a href="/restore/">Забыл пароль</a>
                        </div>
                    </div>

                    <button class="btn full" id="login_send"><span class="text">Войти</span></button>

                    <?php /*<div class="or"><span class="text">Или продолжить через</span></div>*/ ?>
                </form>
            </div>
        </div>
    </section>       

<?php endwhile; ?>

<?php
get_footer();
