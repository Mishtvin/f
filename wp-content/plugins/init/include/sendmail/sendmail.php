<?php

	// Создаем страницу и добавляем пункт в меню
	add_action('admin_menu', 'add_page_mail');
	function add_page_mail(){

		global $wpdb;
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_custom_mail` WHERE `status` = 0" );

		$page = add_menu_page( 
			'Письма по сайту', 
			$count ? sprintf('Заявки <span class="awaiting-mod">%d</span>', $count) : 'Заявки', 
			'edit_others_posts',
			'mail', // URL
			'mail_page_output', 
			'dashicons-email', // Иконка в меню
			25 
		);

		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_mail_scripts' );
	}

	$page_name = 'mail';

	// Подключаем Custom Скрипты
	function admin_mail_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/mail.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	// Функционал страницы
	function mail_page_output(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Письма клиентов",
		);
	
		$labels = array( 'id', 'user_name', 'method', 'phone' );

		page_output( 'mail', $settings, $labels, 0 );

	}
