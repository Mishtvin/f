<?php

// function register(){
//     global $wpdb;
    
//     $data = json_decode(file_get_contents('php://input'), true); 
//     $firstName = clearName($data['firstName']);
//     $lastName = clearName($data['lastName']);
//     $phone = $data['phone'];
//     $fullName = $firstName . ' ' . $lastName;
//     $email = strtolower($data['email']);
//     $password = $data['password'];
//     $errors = [];

//     $checkPhone = $wpdb->get_var("SELECT ID FROM init_users WHERE user_login = '$phone'");
//     $checkEmail = $wpdb->get_var("SELECT ID FROM init_users WHERE user_email = '$email'");

//     if($checkPhone){
//         $errors['register_phone'] = 'Номер телефона уже занят';
//     }

//     if($checkEmail){
//         $errors['register_email'] = 'Email уже занят';
//     }

//     if(!empty($errors)){

//         echo json_encode([
//             'res' => 'error',
//             'fields' => $errors
//         ]);

//     }else{
//         $userdata = [
//             'user_login'           => $phone,          
//             'user_email'           => $email,     
//             'display_name'         => $fullName,      
//             'first_name'           => $firstName,     
//             'last_name'            => $lastName,       
//             'user_pass'            => $password
//         ];
        
//         $user_id = wp_insert_user( $userdata );

//         wp_set_current_user( $user_id, $email );
//         wp_set_auth_cookie( $user_id );
//         do_action( 'wp_login', $email );

//         echo json_encode([
//             'res' => 'success'
//         ]);
//     }

//     die();
// }
// add_action('wp_ajax_register', 'register');
// add_action('wp_ajax_nopriv_register', 'register');

function register(){
    global $wpdb;
    
    $data = json_decode(file_get_contents('php://input'), true); 
    $firstName = clearName($data['firstName']);
    $lastName = clearName($data['lastName']);
    $fullName = $firstName . ' ' . $lastName;
    $email = strtolower($data['email']);
    $phone = $email;
    $password = $data['password'];
    $errors = [];

    $checkPhone = $wpdb->get_var("SELECT ID FROM init_users WHERE user_login = '$phone'");
    $checkEmail = $wpdb->get_var("SELECT ID FROM init_users WHERE user_email = '$email'");

    if($checkPhone){
        $errors['register_phone'] = 'Номер телефона уже занят';
    }

    if($checkEmail){
        $errors['register_email'] = 'Email уже занят';
    }

    if(!empty($errors)){

        echo json_encode([
            'res' => 'error',
            'fields' => $errors
        ]);

    }else{
        $userdata = [
            'user_login'           => $phone,          
            'user_email'           => $email,     
            'display_name'         => $fullName,      
            'first_name'           => $firstName,     
            'last_name'            => $lastName,       
            'user_pass'            => $password
        ];
        
        $user_id = wp_insert_user( $userdata );

        wp_set_current_user( $user_id, $email );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $email );

        $token = "5563634112:AAHe6RqGnRuLdcIwBYCbOF7_MnEXpNjjWsc";
        $chat_id = "-605209845";

        $message = [$fullName, $email];
        $message = implode("\n", $message);
        $message = urlencode(trim($message));

        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}","r");

        echo json_encode([
            'res' => 'success'
        ]);
    }

    die();
}
add_action('wp_ajax_register', 'register');
add_action('wp_ajax_nopriv_register', 'register');

?>
