<?php

function send_mail(){
    $fields = array('user_name', 'phone', 'message', 'method', 'date', 'status');
    get_request($fields, 'init_custom_mail', 0, $_POST['data']);
}
add_action('wp_ajax_send_mail', 'send_mail');
add_action('wp_ajax_nopriv_send_mail', 'send_mail');

// Функция Удаление писем со сменой статуса
function mail_delete_callback(){

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
		$wpdb->query( "UPDATE `init_custom_mail` SET `status` = 2 WHERE `id` IN ($stringID)" );
        
        // Выводим правильное уведомление
        if($countID > 1){
            echo "Выбранные письма удалены";
        }else{
            echo "Выбраное письмо удалено";
        }
    }

    wp_die();
}
add_action('wp_ajax_mail_delete', 'mail_delete_callback');
add_action('wp_ajax_nopriv_mail_delete', 'mail_delete_callback');

// Функция Удаление писем с корзины
function mail_trash_delete_callback() {

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
		$wpdb->query( "DELETE FROM `init_custom_mail` WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_mail_trash_delete', 'mail_trash_delete_callback');
add_action('wp_ajax_nopriv_mail_trash_delete', 'mail_trash_delete_callback');

// Функция Восстановление писем с корзины
function mail_recover_callback() {

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
		$wpdb->query( "UPDATE `init_custom_mail` SET `status` = 0 WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_mail_recover', 'mail_recover_callback');
add_action('wp_ajax_nopriv_mail_recover', 'mail_recover_callback');

// Обработка писем для AJAX
function mail_process_callback() {

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
        $wpdb->query( "UPDATE `init_custom_mail` SET `status` = 1 WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные письма обработаны";
		}else{
			echo "Выбранное письмо обработано";
		}
    }

	wp_die();
}
add_action('wp_ajax_mail_process', 'mail_process_callback');
add_action('wp_ajax_nopriv_mail_process', 'mail_process_callback');