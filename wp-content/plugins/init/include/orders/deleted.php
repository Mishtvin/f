<?php

	// Создаем страницу "Обработанные заявки" и добавляем пункт в меню
	add_action('admin_menu', 'status_deleted_submenu_page');

	function status_deleted_submenu_page() {
		$page = add_submenu_page(
			'orders',
			'Удаленные заявки',
			'Удаленные',
			'edit_others_posts',
			'orders-deleted',
			'deleted_page_callback'
		); 
	
		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_deleted_scripts' );
	}

	// Подключаем Custom Скрипты
	function admin_deleted_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/orders.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	// Функционал страницы
	function deleted_page_callback(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Заказы клиентов",
		);

		$labels = array( 'id', 'name', 'phone', 'price', 'date' );

		page_output( 'orders', $settings, $labels, 2 );

	}
