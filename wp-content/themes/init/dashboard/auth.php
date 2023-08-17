<?php
/**
 * Template Name: Auth page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

if(is_user_logged_in()) {
    if(current_user_can('administrator')) {
        wp_redirect('/dashboard/');
    } else {
        wp_redirect(PRE_LINK . '/');
    }
}

$url = $_SERVER['REQUEST_URI'];
$parts = [];
$url = explode('/', $url);

foreach($url as $item) {
    if($item) {
        $parts[] = $item;
    }
}

$length = count($parts);
$slug = $parts[$length - 1];

get_header();
while ( have_posts() ) : the_post();

if($slug == 'register') { ?>
    <section class="auth register-page">
        <div class="container">
            <div class="wrapper">
                <div class="auth-form large">
                    <form class="article">
                        <div class="auth-text article-mc">
                            <h1>Регистрация</h1>
                            <p class="sm-text">Если у вас уже есть аккаунт - <a href="<?php echo PRE_LINK ?>/login/">авторизуйтесь</a>.</p>
                        </div>

                        <div class="inputs-line">
                            <div class="line">

                                <div class="form-group article-sm">
                                    <label for="register_firstname" class="label">Имя:</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_firstname" placeholder="Введите имя">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_lastname" class="label">Фамилия:</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_lastname" placeholder="Введите фамилию">
                                    </div>
                                </div>

                                <?php /* 
                                <div class="form-group article-sm">
                                    <label for="register_phone" class="label">Номер телефона:</label>
                                    <div class="input-wrapper">
                                        <input type="tel" id="register_phone" class="phone-mask">
                                    </div>
                                </div>
                                */ ?>

                                <div class="form-group article-sm full">
                                    <label for="register_email" class="label">Email:</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="register_email" class="email" placeholder="Введите Email">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_password" class="label">Пароль:</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="register_password" placeholder="Введите пароль">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="register_password_confirm" class="label">Подтвердите пароль:</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="register_password_confirm" placeholder="Подтвердите пароль">
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
                                <label for="register_accert">Я согласен с <a href="<?php echo PRE_LINK ?>/privacy-policy/">политикой конфиденциальности</a>.</label>
                            </div>
                        </div>

                        <button class="btn full" id="register_send" type="button"><span class="text">Зарегистрироваться</span></button>
                    </form>           
                </div>
            </div>
        </div>
    </section>  
<?php } else if ($slug == 'restore') {
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
?>
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
                                <label for="restore_password" class="label">Пароль:</label>
                                <div class="input-wrapper">
                                    <input type="password" id="restore_password" placeholder="Пароль">
                                </div>
                            </div>

                            <div class="form-group article-sm">
                                <label for="restore_password_confirm" class="label">Подтвердите пароль:</label>
                                <div class="input-wrapper">
                                    <input type="password" id="restore_password_confirm" placeholder="Подтвердите пароль">
                                </div>
                            </div>

                            <input type="hidden" id="token" value="<?php echo $token; ?>">
                            <button class="btn full" id="new_password_send" type="button"><span class="text">Отправить</span></button>
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
                                <p class="sm-text">Впервые на сайте? <a href="/register/">Зарегистрируйтесь</a>.</p>
                            </div>

                            <div class="form-group article-sm">
                                <div class="input-wrapper">
                                    <input type="text" id="restore_phone_or_email" placeholder="Email или телефон">
                                </div>
                            </div>

                            <button class="btn full" id="restore_send" type="button"><span class="text">Отправить</span></button>
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
<?php } else { ?>
    <section class="auth login-page">
        <div class="container">
            <div class="wrapper">
                <form class="auth-form article">
                    <div class="auth-text article-mc">
                        <h1>Авторизация</h1>
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
                                <div class="show-password icon-show"></div>
                            </div>
                        </div>

                        <div class="inline full">
                            <div class="line">
                                <div class="input-wrapper with-checkbox">
                                    <div class="checkbox">
                                        <input type="checkbox" id="remember">
                                        <label for="remember" class="icon-check"></label>
                                    </div>
                                    <label for="remember">Запомнить меня</label>
                                </div>
                                <div class="grow"></div>
                                <a href="<?php echo PRE_LINK; ?>/restore/">Забыли пароль</a>
                            </div>
                        </div>
                    </div>

                    <button class="btn full" id="login_send"><span class="text">Войти</span></button>

                    <?php /*<div class="or"><span class="text">Или продолжить через</span></div>*/ ?>
                </form>
            </div>
        </div>
    </section> 
<?php }

endwhile;
get_footer();