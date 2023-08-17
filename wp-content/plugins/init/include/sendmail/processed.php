<?php

	// Создаем страницу "Обработанные заявки" и добавляем пункт в меню
	add_action('admin_menu', 'mail_status_processed_submenu_page');

	function mail_status_processed_submenu_page() {
		$page = add_submenu_page(
			'mail',
			'Обработанные письма',
			'Обработанные',
			'edit_others_posts',
			'mail-processed',
			'mail_processed_page_callback'
		); 
	
		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_mail_processed_scripts' );
	}

	// Подключаем Custom Скрипты
	function admin_mail_processed_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/mail.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	// Функционал страницы
	function mail_processed_page_callback(){
	
		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Письма клиентов",
		);
	
		$labels = array( 'id', 'user_name', 'method', 'phone' );

		page_output( 'mail', $settings, $labels, 1 );	
		
	}
