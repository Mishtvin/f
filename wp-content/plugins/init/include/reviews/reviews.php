<?php

	// Создаем страницу Заявки и добавляем пункт в меню
	add_action('admin_menu', 'add_page_reviews');
	function add_page_reviews(){

		global $wpdb;
		
		$reviews_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_reviews` WHERE `status` = 0" );

		$page = add_menu_page( 
			'Отзывы', // Title страницы
			$reviews_count ? sprintf('Отзывы <span class="awaiting-mod">%d</span>', $reviews_count) : 'Отзывы', // Название в меню
			'edit_others_posts',
			'reviews', // URL
			'reviews_page_output', 
			'dashicons-format-status', // Иконка в меню
			25 
		);

		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_reviews_scripts' );
	}

	
	// Выводим счетчик в админбар
	add_action('wp_before_admin_bar_render', 'admin_bar_reviews_count');
	function admin_bar_reviews_count() {
		global $wp_admin_bar;
		global $wpdb;
		
		$reviews_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_reviews` WHERE `status` = 0" );
		
		$wp_admin_bar->add_menu(array(
			'id' => 'admin_bar_reviews_count',
			'title' => $reviews_count ? sprintf('Отзывы <span class="awaiting-mod">%d</span>', $reviews_count) : 'Отзывы',
			'href' => '/wp-admin/admin.php?page=reviews'
		));
	}


	// Подключаем Custom Скрипты
	function admin_reviews_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/reviews.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}


	// Функционал страницы
	function reviews_page_output(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Отзывы клиентов",
		);

		$labels = array( 'id', 'name', 'rating', 'phone', 'date' );

		page_output( 'reviews', $settings, $labels, 0 );

	}
