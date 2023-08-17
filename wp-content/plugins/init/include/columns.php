<?php 
/* 
* Колонки в админ панели
*/

add_filter( 'manage_product_posts_columns', 'add_photo_column', 4 );
add_filter( 'manage_product_posts_columns', 'add_product_column', 4 );
add_action( 'manage_product_posts_custom_column', 'fill_product_column', 5, 2 );
add_filter( 'manage_edit-product_sortable_columns', 'product_sort_term' );
add_action( 'pre_get_posts', 'product_orderby_term' );

// Создаем колонку "Фото"
function add_photo_column( $columns ){
	$num = 1;

	$new_columns = array(
		'photo'     => 'Фото',
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// Создаем колонку "Цена и Старая цена"
function add_product_column( $columns ){
	$num = 3;

	$new_columns = array(
		'price'             => 'Цена',
		'old_price'         => 'Старая цена',
		'menu_delivery'     => 'Меню доставки',
		'menu_restaurant'   => 'Меню ресторана',
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// заполняем колонку "Таксономии" данными
function fill_product_column( $colname, $post_id ){

    // Фото
	if( $colname === 'photo' ){
        ?>
            <a href="<?php echo get_edit_post_link( get_the_ID() ); ?>">
                <?php the_post_thumbnail( array(60, 60) ); ?>
            </a>
        <?php
    }
    
    // Цена
    if( $colname === 'price' ){
        echo get_post_meta( $post_id, 'price', true ) . " тг.";
	}
    
    // Старая цена
    if( $colname === 'old_price' ){
        echo get_post_meta( $post_id, 'old_price', true ) . " тг.";
	}
    
    // Меню доставки
    if( $colname === 'menu_delivery' ){
        $terms_delivery = get_the_terms($post_id, 'delivery');
        if( is_array( $terms_delivery ) ){
            foreach( $terms_delivery as $term_delivery ){
                echo '<a href="edit.php?post_type=product&amp;taxonomy=' . $term_delivery->taxonomy . '&amp;term='. $term_delivery->slug .'">'. $term_delivery->name .'</a>';
            }
        }
	}
    
    // Меню ресторана
    if( $colname === 'menu_restaurant' ){
        $terms_restaurant = get_the_terms($post_id, 'restaurant');
        if( is_array( $terms_restaurant ) ){
            foreach( $terms_restaurant as $term_restaurant ){
                echo '<a href="edit.php?post_type=product&amp;taxonomy=' . $term_restaurant->taxonomy . '&amp;term='. $term_restaurant->slug .'">'. $term_restaurant->name .'</a>';
            }
        }
	}

}


// Делаем колонку "Срок публикации" сортируемой
function product_sort_term( $columns ) {

	$columns['price']           = 'price';
    $columns['old_price']       = 'old_price';
    
	return $columns;

}

// Меняем запрос
function product_orderby_term( $query ) {

	if( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if( 'price' == $orderby ) {
		$query->set('meta_key','price');
		$query->set('orderby','meta_value');
    }
    
    if( 'old_price' == $orderby ) {
		$query->set('meta_key','old_price');
		$query->set('orderby','meta_value');
	}

}