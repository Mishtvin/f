<?php 

function editProfile(){
    global $wpdb;
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $surname = $data['surname'];
    $phone = $data['phone'];
    $email = $data['email'];
    $full_name = $name . ' ' . $surname;
    $user_id = get_current_user_id();
    $errors = [];

    $phone_check = $wpdb->get_var("SELECT ID FROM init_users WHERE user_login = '$phone' AND ID != $user_id");
    $email_check = $wpdb->get_var("SELECT ID FROM init_users WHERE user_email = '$email' AND ID != $user_id");

    if($phone_check){
        $errors['edit_phone'] = 'Номер телефона уже занят';
    }

    if($email_check){
        $errors['edit_email'] = 'Email уже занят';
    }

    if(empty($errors)){
        $wpdb->update(
            'init_users',
            [
                'user_login' => $phone,
                'user_email' => $email,
            ],
            [
                'ID' => $user_id
            ]
        );

        $fields = array(
            'ID'            => $user_id,
            'first_name'    => $name,
            'last_name'     => $surname,
            'nickname'      => $full_name,
            'display_name'  => $full_name
        );

        if(!empty($data['password'])){
            $password = $data['password'];
            $fields['user_pass'] = $password;
        }

        wp_update_user($fields);
    }else{
        echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }

    die();
}
add_action('wp_ajax_editProfile', 'editProfile');
add_action('wp_ajax_nopriv_editProfile', 'editProfile');