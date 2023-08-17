<?php
/**
 * Template Name: Register Page
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

    <section class="auth register-page">
        <div class="container">
            <div class="wrapper">
                <div class="auth-form large">
                    <form class="article">
                        <div class="auth-text article-mc">
                            <h1><?php the_title(); ?></h1>
                            <p class="sm-text text-grey">Уже есть аккаунт? <a href="/login/">Войдите</a>.</p>
                        </div>

                        <div class="inputs-line">
                            <div class="line">

                                <div class="form-group article-sm">
                                    <label for="register_firstname" class="label">Ваше имя</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_firstname" placeholder="Введите имя" class="large">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_lastname" class="label">Ваша фамилия</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_lastname" placeholder="Введите фамилию" class="large">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_phone" class="label">Номер телефона</label>
                                    <div class="input-wrapper">
                                        <input type="tel" id="register_phone" placeholder="Номер телефона" class="large phone-mask">
                                    </div>
                                </div>


                                <div class="form-group article-sm">
                                    <label for="register_email" class="label">Email</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_email" placeholder="Введите email" class="email large">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_password" class="label">Пароль</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="register_password" placeholder="Введите пароль" class="large">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_password_confirm" class="label">Повторите пароль</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="register_password_confirm" placeholder="Повторите пароль" class="large">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper with-checkbox">
                                <div class="checkbox">
                                    <input type="checkbox" id="register_accert">
                                    <label for="register_accert" class="icon-check"></label>
                                </div>
                                <label for="register_accert">Я согласен с <a href="/privacy-policy/">политикой конфиденциальности</a>.</label>
                            </div>
                        </div>

                        <button class="btn full" id="register_send"><span class="text">Зарегистрироваться</span></button>
                    </form>              
                </div>
            </div>
        </div>
    </section>          

<?php endwhile; ?>

<?php
get_footer();
