<?php

	// Создаем страницу Заявки и добавляем пункт в меню
	add_action('admin_menu', 'add_page_orders');
	function add_page_orders(){

		global $wpdb;
		
		$orders_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_custom_orders` WHERE `status` = 0" );

		$page = add_menu_page( 
			'Заявки по сайту', // Title страницы
			$orders_count ? sprintf('Заявки <span class="awaiting-mod">%d</span>', $orders_count) : 'Заявки', // Название в меню
			'edit_others_posts',
			'orders', // URL
			'orders_page_output', 
			'dashicons-index-card', // Иконка в меню
			4 
		);

		// Используем зарегистрированную страницу для загрузки скрипта
		add_action( 'load-' . $page, 'admin_orders_scripts' );
	}

	// Выводим счетчик в админбар
	add_action('wp_before_admin_bar_render', 'admin_bar_orders_count');
	function admin_bar_orders_count() {
		global $wp_admin_bar;
		global $wpdb;
		
		$orders_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_custom_orders` WHERE `status` = 0" );
		
		$wp_admin_bar->add_menu(array(
			'id' => 'admin_bar_order_count',
			'title' => $orders_count ? sprintf('Заявки <span class="awaiting-mod">%d</span>', $orders_count) : 'Заявки',
			'href' => '/wp-admin/admin.php?page=orders'
		));
	}

	// Подключаем Custom Скрипты
	function admin_orders_scripts() {
		wp_enqueue_style( 'admin-styles', INIT_URL . '/assets/css/orders.css');
		wp_enqueue_style( 'admin-global-styles', INIT_URL . '/assets/css/global.css');
		wp_enqueue_style( 'admin-custom-styles', INIT_URL . '/assets/css/custom-page.css');
		wp_enqueue_style( 'admin-icons-styles', INIT_URL . '/assets/css/icons.css');
	}

	// Функционал страницы
	function orders_page_output(){

		$settings = array(
			'sidebar'		=>	0,
			'filters'		=>	0,
			'block_title'	=>	"Заказы клиентов",
		);

		$labels = array( 'id', 'name', 'phone', 'price', 'date' );

		page_output( 'orders', $settings, $labels, 0 );

	}
