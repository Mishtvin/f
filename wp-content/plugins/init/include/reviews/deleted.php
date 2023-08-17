<?php

	// Создаем страницу "Обработанные заявки" и добавляем пункт в меню
	add_action('admin_menu', 'reviews_status_deleted_submenu_page');

	function reviews_status_deleted_submenu_page() {
		$page = add_submenu_page(
			'reviews',
			'Удаленные отзывы',
			'Удаленные',
			'edit_others_posts',
			'reviews-deleted',
			'reviews_deleted_page_callback'
		); 
	
		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_reviews_deleted_scripts' );
	}

	// Подключаем Custom Скрипты
	function admin_reviews_deleted_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/reviews.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	function reviews_deleted_page_callback(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Отзывы клиентов",
		);

		$labels = array( 'id', 'name', 'rating', 'phone', 'date' );

		page_output( 'reviews', $settings, $labels, 2 );

	}
