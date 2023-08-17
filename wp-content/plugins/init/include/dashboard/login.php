<?php

    function login(){ 
        global $wpdb;

        $data = json_decode(file_get_contents('php://input'), true);
        $login = preg_replace('/[^a-z0-9-_@.]/m', '', strtolower($data['login']));
        $password = $data['password'];
        $remember = !empty($data['remember']) ? $data['remember'] : 0;

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
            $sign = wp_signon([
                'user_login'    => $login,
                'user_password' => $password,
                'remember'      => $remember,
            ]);

            if ( is_wp_error($sign) ) {
                echo json_encode([
                    'res' => 'error',
                    'fields' => [
                        'login_password' => 'Вы ввели неверный пароль'
                    ]
                ]);
            }else{
                echo json_encode([
                    'res' => 'success',
                    'user_id' => $user_data->ID,
                    'user_email' => $user_data->user_email,
                ]);
            }
        }else{
            echo json_encode([
                'res' => 'error',
                'fields' => [
                    'login_phone_or_email' => 'Вы ввели неверный номер или email'
                ]
            ]);
        }

        die();
    }
    add_action('wp_ajax_login', 'login');
    add_action('wp_ajax_nopriv_login', 'login');

    
    function redirect_login_page() {  
        $url = '/login/';
        $page_viewed = basename($_SERVER['REQUEST_URI']);

        if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {  
            wp_redirect( site_url($url) );  
            exit;  
        }  
        if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            wp_redirect( site_url($url) );
            exit;
        }
    }
    add_action('init','redirect_login_page');


    function logout_redirect(){
        $url = '/login/';
        wp_safe_redirect( site_url( '/login/' ) );
        exit;
    }
    add_action( 'wp_logout', 'logout_redirect', 5 );


    function logout_function(){
        wp_logout();
        exit;
    }
    add_action('wp_ajax_logout_function', 'logout_function');
    add_action('wp_ajax_nopriv_logout_function', 'logout_function');