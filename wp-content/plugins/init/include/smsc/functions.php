<?php

class SendSms {

    // массив для хранения ошибок
    public $error_container = array();

    public function __construct( $data ) {
        $this->phone    = $data['phone'];
        $this->type     = $data['type'];
    }

    public function send() {
        
        include_once "smsc_api.php";

        $type = $this->type;

        if( $type == "register" ){

            $user_phone = $this->phone;

            if( $user_phone ){

                global $wpdb;
                $user_data = $wpdb->get_results( "SELECT * FROM `init_users_sms_code` WHERE `phone` = '$user_phone' AND `type` = '$type' ORDER BY `id` DESC" );
                
                $check = 1;
                $user_data_id = "";

                // Если номер в базе
                if( $user_data ){
                    
                    $user_data = $user_data[0];

                    date_default_timezone_set('Asia/Almaty');
                    $format = 'Y-m-d H:i:s';
                    $user_data_id = $user_data->id;
                    $date = $user_data->date;
                    $code = $user_data->code;
                    // Минимальное время для повторной отправки СМС кода
                    $min_time = 120;

                    // print_r( $date );

                    $curent_date = DateTime::createFromFormat($format, date($format));
                    $curent_date = date_format($curent_date, $format);
                    
                    if( strtotime($curent_date) - strtotime($date) < $min_time ){
                        $delay = $min_time - ( strtotime($curent_date) - strtotime($date) );
                        echo json_encode( array( 'result' => 'success', 'delay' => $delay ) );
                        $check = 0;
                    }
                    
                }

                if( $check ){
                    
                    $code = mt_rand(1000, 9999);                    

                    // Отправка SMS
                    $send = send_sms( $user_phone, $code . " - код подтверждения Вашего телефона.");

                    $wpdb->replace( 'init_users_sms_code', array( 
                        'id'        => $user_data_id,
                        'phone'     => $user_phone,
                        'type'      => $type,
                        'code'      => $code,
                        'hash_key'  => generate_hash_key()
                    ) );

                    echo json_encode( array('result' => 'success' ) );

                }
            }

        }
        
        if( $type == "restore" ){

            $user_phone = $this->phone;

            if( $user_phone ){

                global $wpdb;
                $user_data = $wpdb->get_results( "SELECT * FROM `init_users_sms_code` WHERE `phone` = '$user_phone' AND `type` = '$type' ORDER BY `id` DESC" );
                
                $check = 1;
                $user_data_id = "";

                // Если номер в базе
                if( $user_data ){
                    
                    $user_data = $user_data[0];

                    date_default_timezone_set('Asia/Almaty');
                    $format = 'Y-m-d H:i:s';
                    $user_data_id = $user_data->id;
                    $date = $user_data->date;
                    // Минимальное время для повторной отправки СМС кода
                    $min_time = 120;

                    // print_r( $date );

                    $curent_date = DateTime::createFromFormat($format, date($format));
                    $curent_date = date_format($curent_date, $format);
                    
                    if( strtotime($curent_date) - strtotime($date) < $min_time ){
                        $delay = $min_time - ( strtotime($curent_date) - strtotime($date) );
                        echo json_encode( array( 'result' => 'success', 'type' => 'phone', 'delay' => $delay ) );
                        $check = 0;
                    }
                    
                }

                if( $check ){
                    
                    $code = mt_rand(1000, 9999);

                    // Отправка SMS
                    $send = send_sms( $user_phone, $code . " - код для смены пароля на сайте " . home_url() );

                    $wpdb->replace( 'init_users_sms_code', array( 
                        'id'        => $user_data_id,
                        'phone'     => $user_phone,
                        'type'      => $type,
                        'code'      => $code,
                        'hash_key'  => generate_hash_key()
                    ) );

                    echo json_encode( array('result' => 'success', 'type' => 'phone' ) );

                }
            }

        }

    }

}


?>