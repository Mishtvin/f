<?php

	// Создаем страницу "Обработанные заявки" и добавляем пункт в меню
	add_action('admin_menu', 'status_processed_submenu_page');

	function status_processed_submenu_page() {
		$page = add_submenu_page(
			'orders',
			'Обработанные заявки',
			'Обработанные',
			'edit_others_posts',
			'orders-processed',
			'processed_page_callback'
		); 
	
		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_processed_scripts' );
	}

	// Подключаем Custom Скрипты
	function admin_processed_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/orders.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	// Функционал страницы
	function processed_page_callback(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Заказы клиентов",
		);

		$labels = array( 'id', 'name', 'phone', 'price', 'date' );

		page_output( 'orders', $settings, $labels, 1 );

	}
