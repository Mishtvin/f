<?php

function add_order(){
    $fields = array('user_name', 'phone', 'email', 'comment', 'message', 'services', 'date', 'status');
    $message = array('Заявка на сайте', array('user_name', 'phone', 'method', 'date'));
	$message = '';
    get_request($fields, 'init_orders', 0, $_POST['data'], $message);

    die();
}
add_action('wp_ajax_add_order', 'add_order');
add_action('wp_ajax_nopriv_add_order', 'add_order');

// Функция Удаление заявок со сменой статуса
function orders_delete_callback() {

    // Подключаем глобальную переменую для "Базы Данных"
    global $wpdb;

    // Проверка если нет не одной галочки
    if( isset( $_POST['string_id'] ) ){
		
		// Получаем строку с ID
        $stringID = $_POST['string_id'];
		
		// Преобразуем в массив
		$array = explode(',', $stringID);
		
		// Узнаем колличество ID
		$countID = count($array);
        
        // Удаление с базы
		$wpdb->query( "UPDATE `init_orders` SET `status` = 2 WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_orders_delete', 'orders_delete_callback');
add_action('wp_ajax_nopriv_orders_delete', 'orders_delete_callback');

// Функция Удаление заявок с корзины
function orders_trash_delete_callback() {

    // Подключаем глобальную переменую для "Базы Данных"
    global $wpdb;

    // Проверка если нет не одной галочки
    if( isset( $_POST['string_id'] ) ){
		
		// Получаем строку с ID
        $stringID = $_POST['string_id'];
		
		// Преобразуем в массив
		$array = explode(',', $stringID);
		
		// Узнаем колличество ID
		$countID = count($array);
        
        // Удаление с базы
		$wpdb->query( "DELETE FROM `init_orders` WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_orders_trash_delete', 'orders_trash_delete_callback');
add_action('wp_ajax_nopriv_orders_trash_delete', 'orders_trash_delete_callback');

// Функция Восстановление заявок с корзины
function orders_recover_callback() {

    // Подключаем глобальную переменую для "Базы Данных"
    global $wpdb;

    // Проверка если нет не одной галочки
    if( isset( $_POST['string_id'] ) ){
		
		// Получаем строку с ID
        $stringID = $_POST['string_id'];
		
		// Преобразуем в массив
		$array = explode(',', $stringID);
		
		// Узнаем колличество ID
		$countID = count($array);
        
        // Восстановление с базы
		$wpdb->query( "UPDATE `init_orders` SET `status` = 0 WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_orders_recover', 'orders_recover_callback');
add_action('wp_ajax_nopriv_orders_recover', 'orders_recover_callback');

// Обработка заявки для AJAX
function orders_process_callback() {

    // Подключаем глобальную переменую для "Базы Данных"
    global $wpdb;
    
    // Проверка если нет не одной галочки
    if( isset( $_POST['string_id'] ) ){
		
		// Получаем строку с ID
        $stringID = $_POST['string_id'];
		
		// Преобразуем в массив
		$array = explode(',', $stringID);
		
		// Узнаем колличество ID
        $countID = count($array);
        
        // Удаление с базы
        $wpdb->query( "UPDATE `init_orders` SET `status` = 1, `date_processing` = CURRENT_TIME WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заказы обработаны";
		}else{
			echo "Выбранный заказ обработан";
		}
    }

	wp_die();
}
add_action('wp_ajax_orders_process', 'orders_process_callback');
add_action('wp_ajax_nopriv_orders_process', 'orders_process_callback');

// Обработка заявки для AJAX
function change_field() {

    // Подключаем глобальную переменую для "Базы Данных"
    global $wpdb;
    
    $id = $_POST['id'];
    $field = $_POST['field'];
    $val = trim($_POST['val']);

    $wpdb->query( "UPDATE `init_orders` SET `$field` = '$val' WHERE `id` = '$id'" );

    wp_die();

}
add_action('wp_ajax_change_field', 'change_field');
add_action('wp_ajax_nopriv_change_field', 'change_field');