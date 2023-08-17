<?php   

    function restore_check(){
        global $wpdb;
        $data = $_POST['data'];
        $data = json_decode(file_get_contents('php://input'), true);

        if(strrpos($login, '@') === false){
            $login = preg_replace('/[^0-9]/m', '', $login);
            $length = strlen($login);

            if(mb_substr($login, 0, 1) == '8'){
                $login = '7' . mb_substr($login, 1, $length - 1);
            }else if($length == 10){
                $login = '7' . $login;
            }
        }

        $user_data = $wpdb->get_row("SELECT ID, user_email FROM init_users WHERE user_login = '$login' OR user_email = '$login'");

        if(!empty($user_data)){
            $user_id = $user_data->ID;
            $user_email = $user_data->user_email;
            $token = bin2hex(random_bytes(20));
            $mail_title = 'Восстановление пароля';

            $wpdb->delete(
                'init_restore',
                [ 'user_id' => $user_id ]
            );

            $wpdb->insert(
                'init_restore',
                [
                    'user_id' => $user_id,
                    'token' => $token
                ]
            );

            $link = get_home_url() . '/restore/?token=' . $token;
            $mail = '<tr><td><p>Ссылка на восстановление пароля: <a href="' . $link . '">' . $link . '</a>. Ссылка действует 24 часа</p></td></tr>';
            $mail = init_mail_template($mail_title, $mail);

            $headers = array(
                'content-type: text/html'
            );        
            
            wp_mail($user_email, $mail_title, $mail, $headers);

            echo json_encode([
                'res' => 'success'
            ]);
        }else{
            echo json_encode([
                'res' => 'error',
                'fields' => [
                    'restore_phone_or_email' => 'Вы ввели неверный номер или email'
                ]
            ]);
        }

        die();
    }
    add_action('wp_ajax_restore_check', 'restore_check');
	add_action('wp_ajax_nopriv_restore_check', 'restore_check');

    function restore_send(){
        global $wpdb;
        $data = $_POST['data'];
        $token = $data['token'];
        $password = $data['password'];

        $restore_data = $wpdb->get_row("SELECT * FROM init_restore WHERE token = '$token'");
    
        if(!empty($restore_data)) {
            $date = strtotime($restore_data->date);
            $now = strtotime(wp_date('d.m.Y H:i:s'));
            $diff = round(($now - $date)/3600, 1);

            if($diff < 24) {
                $allow_restore = true;
                $user_id = $restore_data->user_id;

                wp_set_password( $password, $user_id );

                $wpdb->delete(
                    'init_restore',
                    [ 'user_id' => $user_id ]
                );

                echo json_encode([
                    'res' => 'success'
                ]);
            } else {
                echo json_encode([
                    'res' => 'error',
                    'fields' => [
                        'restore_password' => 'Ссылка на восстановление устарела'
                    ]
                ]);
            }
        }else{
            echo json_encode([
                'res' => 'error',
                'fields' => [
                    'restore_password' => 'Ссылка на восстановление устарела'
                ]
            ]);
        }

        die();
    }
    add_action('wp_ajax_restore_send', 'restore_send');
	add_action('wp_ajax_nopriv_restore_send', 'restore_send');
