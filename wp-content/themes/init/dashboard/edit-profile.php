<?php
/**
 * Template Name: Edit Profile Page
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
                <div class="dashboard-content article-md">
                    <div class="inputs-line">
                        <div class="line">
                            
                            <div class="form-group article-sm">
                                <label class="label" for="edit_name">Имя:</label>
                                <input name="name" class="large outline" id="edit_name" type="text" value="<?php echo USER['first_name']; ?>" placeholder="Введите имя" autocomplete="disabled">
                            </div>

                            <div class="form-group article-sm">
                                <label class="label" for="edit_surname">Фамилия:</label>
                                <input name="surname" class="large outline" id="edit_surname" type="text" value="<?php echo USER['last_name']; ?>" placeholder="Введите фамилию" autocomplete="disabled">
                            </div>

                            <div class="form-group article-sm">
                                <label class="label" for="edit_phone">Номер телефона:</label>
                                <input name="phone" id="edit_phone" type="tel" class="phone-mask large outline" value="+<?php echo USER['login']; ?>">
                            </div>

                            <div class="form-group article-sm">
                                <label class="label" for="edit_email">E-mail:</label>
                                <input name="email" class="email large outline" id="edit_email" type="email" value="<?php echo USER['email']; ?>" placeholder="Введите E-mail">
                            </div>

                            <div class="form-group article-sm">
                                <label class="label" for="edit_password">Новый пароль:</label>
                                <input name="password" class="large outline" id="edit_password" type="password" placeholder="Введите новый пароль" autocomplete="new-password">
                            </div>

                            <div class="form-group article-sm">
                                <label class="label" for="edit_password_confirm">Подтвердите пароль:</label>
                                <input name="password_confirm" class="large outline" id="edit_password_confirm" type="password" placeholder="Подтвердите новый пароль" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <button class="btn large" id="save_edit"><span class="text">Сохранить изменения</span></button>
                </div>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();