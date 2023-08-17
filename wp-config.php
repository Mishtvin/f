<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', "flowlove" );

/** Имя пользователя базы данных */
define( 'DB_USER', "admin" );

/** Пароль к базе данных */
define( 'DB_PASSWORD', "admin" );

/** Имя сервера базы данных */
define( 'DB_HOST', "localhost" );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

define('WP_HOME', 'https://' . $_SERVER['SERVER_NAME']);
define('WP_SITEURL', 'https://' . $_SERVER['SERVER_NAME']);

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Q<5}dkT0t>b3F>;)D4^AqayA<Ky:7|*z0?XH~KS]Y1d0v,sq |zor&0i&,iSy}_h' );
define( 'SECURE_AUTH_KEY',  'i&D_)ka.`(GM>T,JxA]vB8$n9l?bP^Eu])EvBlL<T c}MCv-|C[qp`OTq`hT_(+(' );
define( 'LOGGED_IN_KEY',    '0 jk^gqr,]rb8iV#E-f:4Q22GxPd$$*:n@m)|P@GE0=!zI7p>9!n(R.A`6&e5.0{' );
define( 'NONCE_KEY',        'WyykoToU%u$p^ONpVab/PJ<dPDKJ)Jb@I%+(].GL4cs91U]{43gt,vre$$Tc[w c' );
define( 'AUTH_SALT',        'h}bs-zWhM{;TFjvhXki)Ss&5<IQ&M~*_g0ZFS:%D6N}HNjH)y/Qi`4]}xU1b}0w9' );
define( 'SECURE_AUTH_SALT', '(Yn/u*-0k{q2as=hJP>)=hF(s5c%Sc5:d Gj%8;*5eqQ=b{ynw9`GH-AcihZ$.BV' );
define( 'LOGGED_IN_SALT',   'oGE[}8o.qRFJ`IC6y|5T}+yc#e#h]-0X-lqOV}i6]JhEVz#~ne?V|foCQu/:Yf~j' );
define( 'NONCE_SALT',       't{G,X@y0JtE-colKIVw7tFu[gU,_nkEAG<8$!C|?j|o>g!l+<BLITM*MB`.O2ZI{' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'init_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
ini_set('display_errors','off');
ini_set('display_startup_errors','off');
ini_set('error_reporting', E_ERROR );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );
define('DEV_MODE', false );

define('NOTIFICATION_EMAIL', 'info@FlowLove.ru');

define('TELEGRAM_TOKEN_1', '5255597900:AAFvAjTDRgUwJiVm4Bjw7SsajJzuIzD7xOU');
define('TELEGRAM_CHAT_ID_1', '-792535958');

define('TELEGRAM_TOKEN_2', '5713074950:AAGC3SHzO6LgydzifEJU_jlX7y8FEDWryMc');
define('TELEGRAM_CHAT_ID_2', '-683598395');

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */
error_reporting(0);
ini_set('display_errors', 'Off');
/** Абсолютный путь к директории WordPress. */
define( 'WP_SITEURL', 'http://localhost/wordpress/' );
define( 'AUTH_KEY', 'Q<5}dkT0t>b3F>;)D4^AqayA<Ky:7|*z0?XH~KS]Y1d0v,sq |zor&0i&,iSy}_h' );
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
