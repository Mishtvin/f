<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/*
* Plugin Name: init.kz - Options Plugins
* Description: Все модули, настройки, опции сайта и т.д.
* Version: 1.0
* Author: init.kz
* Author URI: https://init.kz
*/

// Создаем константы
define('INIT_DIR', plugin_dir_path(__FILE__));
define('INIT_URL', plugin_dir_url(__FILE__));

$plugin_settings = array(
    "post_type"     => false,
    "columns"       => false,
    "content_page"  => true,
    "cart"          => false,
    "orders"        => true,
    "dashboard"     => true,
    "mail"          => false,
    "smsc"          => false,
    "reviews"       => true,
    "settings"      => false,
);

// Подключаем скрипты
function my_style_admin(){
    wp_enqueue_style( "style-admin", INIT_URL . 'assets/css/admin.css');
	wp_enqueue_script( 'custom-page-script', INIT_URL . 'assets/js/custom-page.js', array('jquery') );
}
add_action('admin_enqueue_scripts', 'my_style_admin');


// Подключаем файлы

// Настройки интернет магазина
// require INIT_DIR.'include/settings/settings.php';

// Send Mail
require INIT_DIR.'include/sendmail/smtp.php';           	    // Подключаем SMTP от Mail.ru

if($plugin_settings["post_type"]){
    // Произвольные типы записей
    require INIT_DIR.'include/post-type.php';
}

if($plugin_settings["columns"]){
    // Произвольные колонки в админке
    require INIT_DIR.'include/columns.php';
}

if($plugin_settings["content_page"]){
    // Функции контента
    require INIT_DIR.'include/content-page.php';
}

if($plugin_settings["cart"]){
    // Фукнции корзины
    require INIT_DIR.'include/cart/functions.php';
}

if($plugin_settings["mail"]){
    require INIT_DIR.'include/sendmail/functions.php';           // Добавление писем в базу
    require INIT_DIR.'include/sendmail/sendmail.php';           	// "Новые" письма в Админ панели
    require INIT_DIR.'include/sendmail/processed.php';           // "Обработанные" письма в Админ панели
    require INIT_DIR.'include/sendmail/deleted.php';           	// "Удаленные" письма в Админ панели
}

if($plugin_settings["orders"]){
    require INIT_DIR.'include/orders/functions.php';             // Добавление заказов в базу
    require INIT_DIR.'include/orders/orders.php';           	    // "Новые" заказы в Админ панели
    require INIT_DIR.'include/orders/processed.php';             // "Обработанные" заказы в Админ панели
    require INIT_DIR.'include/orders/deleted.php';           	// "Удаленные" заказы в Админ панели
}

if($plugin_settings["reviews"]){
    require INIT_DIR.'include/reviews/functions.php';
    require INIT_DIR.'include/reviews/reviews.php';
    require INIT_DIR.'include/reviews/processed.php';
    require INIT_DIR.'include/reviews/deleted.php';
}

if($plugin_settings["dashboard"]){
    // Dashboard
    require INIT_DIR.'include/dashboard/dashboard.php';           	// Функции авторизации
    require INIT_DIR.'include/dashboard/login.php';           	// Функции авторизации
    require INIT_DIR.'include/dashboard/register.php';           // Функции регистрации
    require INIT_DIR.'include/dashboard/edit-profile.php';       // Функции редактирования профиля
    require INIT_DIR.'include/dashboard/restore.php';           	// Функции восстановление пароля
}

if($plugin_settings["smsc"]){
    // Dashboard
    require INIT_DIR.'include/smsc/functions.php';           	// Функции авторизации
    require INIT_DIR.'include/smsc/smsc_api.php';           	// Функции авторизации
}

if($plugin_settings["settings"]){
    // Settings Admin page
    // require INIT_DIR.'include/sendmail/sendmail.php';          // Система заявок в Админ панели
    require INIT_DIR.'include/settings/settings.php';           	 // Добавление страниц настроек в Админ панель
}