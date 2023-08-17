<?php 

    define('TO_EMAIL', 'frockstar@bk.ru');
    
    //SMTP
    function send_smtp_email( $phpmailer ) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = 'ssl://smtp.mail.ru';
        $phpmailer->SMTPAuth   = true;						// Включение/отключение шифрования
        $phpmailer->Port       = 465;
        $phpmailer->Username   = 'zakaz@flowlove.ru';
        $phpmailer->Password   = 'qz4bjcdmaWfh7ve92V2c';
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->From       = 'zakaz@flowlove.ru';
        $phpmailer->FromName   = 'FlowLove.ru';
    }
    add_action( 'phpmailer_init', 'send_smtp_email' );

    function change_name($name) {
        return 'FlowLove.ru';
    }
    add_filter('wp_mail_from_name','change_name');


    function change_email($email) {
        return 'zakaz@flowlove.ru';
    }
    add_filter('wp_mail_from','change_email');