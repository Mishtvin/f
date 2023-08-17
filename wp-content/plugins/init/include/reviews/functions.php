<?php

function add_reviews(){

    $fields = array('name', 'phone', 'rating', 'review', 'status');
    get_request($fields, 'init_reviews', 0, $_POST['data'], '');

    die();
}
add_action('wp_ajax_add_reviews', 'add_reviews');
add_action('wp_ajax_nopriv_add_reviews', 'add_reviews');

function add_reply(){

    global $wpdb;

    $data = $_POST['data'];
    
    $add_reply = $wpdb->insert(
        'init_replies',
        array(
            'reply'   => $data['reply'],
        ),
        array( '%s' )
    );

    $reply_id = $wpdb->insert_id;

    // Если нет ошибок сообщаем об успехе
    if( $add_reply ){

        $add_reply = $wpdb->insert(
            'init_reviews_replies',
            array(
                'reply_id'   => $reply_id,
                'review_id'   => $data['id']
            ),
            array( '%d', '%d' )
        );

        if($add_reply){
            $reply = $wpdb->get_row( "SELECT * FROM `init_replies` WHERE `id` = '$reply_id'" );
            $id = $reply->id;
            $date = mysql2date( "j F Y", $reply->date );
            $text = $reply->reply;

            $structure = '
                <div class="reply" data-id="' . $reply_id . '">
                    <div class="content">
                        <div class="top">

                            <div class="user">
                                <div class="avatar">А</div>
                                <div class="about">
                                    <div class="date">' . $date . '</div>
                                    <div class="name">Администратор</div>
                                </div>
                            </div>

                            <div class="buttons">
                                <div class="edit-reply icon-edit"></div>
                                <div class="remove-reply icon-trash"></div>
                            </div>

                        </div>

                        <div class="bottom">
                            <div class="text">
                                <p>' . $text . '</p>
                            </div>
                        </div>

                    </div>
                </div>
            ';
            
            echo $structure;

        }

    }else{
        echo json_encode(array('result' => 'error'));
    }

    die();
}
add_action('wp_ajax_add_reply', 'add_reply');
add_action('wp_ajax_nopriv_add_reply', 'add_reply');

function edit_reply(){

    global $wpdb;

    $data = $_POST['data'];
    $id = $data['id'];
    $val = $data['val'];
    
    $edit_reply = $wpdb->update( 
        'init_replies',
        array( 'reply' => $val),
        array( 'ID' => $id ),
        array( '%s' ),
        array( '%d' )
    );

    $reply_id = $wpdb->insert_id;

    // Если нет ошибок сообщаем об успехе
    if( $edit_reply ){
        echo json_encode(array('result' => 'success'));
    }else{
        echo json_encode(array('result' => 'error'));
    }

    die();
}
add_action('wp_ajax_edit_reply', 'edit_reply');
add_action('wp_ajax_nopriv_edit_reply', 'edit_reply');

function remove_reply(){

    global $wpdb;

    $id = $_POST['id'];
    
    $remove_reply = $wpdb->delete(
        'init_replies',
        array( 'ID' => $id ),
        array( '%d' )
    );

    $remove_reply = $wpdb->delete(
        'init_reviews_replies',
        array( 'reply_id' => $id ),
        array( '%d' )
    );

    die();
}
add_action('wp_ajax_remove_reply', 'remove_reply');
add_action('wp_ajax_nopriv_remove_reply', 'remove_reply');

function add_answer(){

    global $wpdb;

    $data = $_POST['data'];
    
    $add_answer = $wpdb->insert(
        'init_answers',
        array(
            'answer'   => $data['answer'],
            'email'   => $data['email'],
        ),
        array( '%s' )
    );

    $answer_id = $wpdb->insert_id;

    // Если нет ошибок сообщаем об успехе
    if( $add_answer ){

        $add_answer = $wpdb->insert(
            'init_mail_answers',
            array(
                'answer_id'   => $answer_id,
                'mail_id'   => $data['id']
            ),
            array( '%d', '%d' )
        );

        if($add_answer){
            $mailsend = wp_mail($data['email'], 'Вопрос на сайте dve-palochky.kz', $data['answer']);
            
            $answer = $wpdb->get_row( "SELECT * FROM `init_answers` WHERE `id` = '$answer_id'" );
            $id = $answer->id;
            $date = mysql2date( "j F Y", $answer->date );
            $text = $answer->answer;
            $email = $answer->email;

            $structure = '
                <div class="answer" data-id="' . $answer_id . '">
                    <div class="content">
                        <div class="top">

                            <div class="user">
                                <div class="avatar">А</div>
                                <div class="about">
                                    <div class="date">' . $date . '</div>
                                    <div class="name">Администратор</div>
                                </div>
                            </div>

                            <div class="to-email">' . $email . '</div>

                        </div>

                        <div class="bottom">
                            <div class="text">
                                <p>' . $text . '</p>
                            </div>
                        </div>

                    </div>
                </div>
            ';
            
            echo $structure;

        }

    }else{
        echo json_encode(array('result' => 'error'));
    }

    die();
}
add_action('wp_ajax_add_answer', 'add_answer');
add_action('wp_ajax_nopriv_add_answer', 'add_answer');

// Функция Удаление отзывов со сменой статуса
function reviews_delete_callback(){

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
		$wpdb->query( "UPDATE `init_reviews` SET `status` = 2 WHERE `id` IN ($stringID)" );
        
        // Выводим правильное уведомление
        if($countID > 1){
            echo "Выбранные отзывы удалены";
        }else{
            echo "Выбранный отзыв удален";
        }
    }

    wp_die();
}
add_action('wp_ajax_reviews_delete', 'reviews_delete_callback');
add_action('wp_ajax_nopriv_reviews_delete', 'reviews_delete_callback');

// Функция Удаление отзывов с корзины
function reviews_trash_delete_callback() {

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
		$wpdb->query( "DELETE FROM `init_reviews` WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_reviews_trash_delete', 'reviews_trash_delete_callback');
add_action('wp_ajax_nopriv_reviews_trash_delete', 'reviews_trash_delete_callback');

// Функция Восстановление отзывов с корзины
function reviews_recover_callback() {

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
		$wpdb->query( "UPDATE `init_reviews` SET `status` = 0 WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные заявки удалены";
		}else{
			echo "Выбранная заявка удалена";
		}
    }

	wp_die();
}
add_action('wp_ajax_reviews_recover', 'reviews_recover_callback');
add_action('wp_ajax_nopriv_reviews_recover', 'reviews_recover_callback');

// Обработка отзывов для AJAX
function reviews_process_callback() {

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
        $wpdb->query( "UPDATE `init_reviews` SET `status` = 1, `date_processing` = CURRENT_TIME WHERE `id` IN ($stringID)" );
		
		// Выводим правильное уведомление
		if($countID > 1){
			echo "Выбранные отзывы обработаны";
		}else{
			echo "Выбранный отзыв обработан";
		}
    }

	wp_die();
}
add_action('wp_ajax_reviews_process', 'reviews_process_callback');
add_action('wp_ajax_nopriv_reviews_process', 'reviews_process_callback');