<?php
/**
 * Template Name: Restore Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

if( is_user_logged_in() ){
    wp_redirect( '/dashboard/' );
}

$allow_restore = false;

if(!empty($_GET['token'])) {
    $token = $_GET['token'];
    $restore_data = $wpdb->get_row("SELECT * FROM init_restore WHERE token = '$token'");
    
    if(!empty($restore_data)) {
        $date = strtotime($restore_data->date);
        $now = strtotime(wp_date('d.m.Y H:i:s'));
        $diff = round(($now - $date)/3600, 1);
        if($diff < 24) {
            $allow_restore = true;
        }
    }
}

get_header();
?>  

<?php while ( have_posts() ) : the_post(); ?>

    <section class="auth restore-page">
        <div class="container">
            <div class="wrapper">
                <div class="auth-form">
                    <?php if($allow_restore) { ?>
                        <form class="article">
                            <div class="auth-text article-sm">
                                <h1 class="h5">Новый пароль</h1>
                            </div>

                            <div class="form-group article-sm">
                                <label for="restore_password" class="label">Пароль</label>
                                <div class="input-wrapper">
                                    <input type="password" id="restore_password" placeholder="Введите пароль">
                                </div>
                            </div>

                            <div class="form-group article-sm">
                                <label for="restore_password_confirm" class="label">Повторите пароль</label>
                                <div class="input-wrapper">
                                    <input type="password" id="restore_password_confirm" placeholder="Повторите пароль">
                                </div>
                            </div>

                            <input type="hidden" id="token" value="<?php echo $token; ?>">
                            <button class="btn full" id="new_password_send"><span class="text">Отправить</span></button>
                        </form> 
                        <div class="auth-success article-sm">
                            <div class="icon icon-success"></div>
                            <div class="article-mc">
                                <div class="h5">Пароль изменён</div>
                                <div class="text">Вы будете перенаправлены на страницу авторизации через 5 секунд</div>
                            </div>
                        </div> 

                    <?php }else{ ?> 
                        <form class="article">
                            <div class="auth-text article-sm">
                                <h1 class="h5"><?php the_title(); ?></h1>
                                <p class="sm-text text-grey">Вспомнили пароль? <a href="/login/">Войдите</a>.</p>
                            </div>

                            <div class="form-group article-sm">
                                <div class="input-wrapper">
                                    <input type="text" id="restore_phone_or_email" placeholder="Email или телефон">
                                </div>
                            </div>

                            <button class="btn full" id="restore_send"><span class="text">Отправить</span></button>
                        </form> 
                        <div class="auth-success article-sm">
                            <div class="icon icon-email"></div>
                            <div class="article-mc">
                                <div class="h5">Проверьте почту</div>
                                <div class="text">Вам на почту было выслано письмо</div>
                            </div>
                        </div> 
                    <?php } ?>               
                </div>
            </div>
        </div>
    </section>          

<?php endwhile; ?>

<?php
get_footer();
