<?php

// Добавление товара в корзину
function add_to_cart(){

    $data = $_POST['data'];

    $id         = (int)$data['id'];
    $quantity   = (int)$data['quantity'];

    // Получаем цену товара
    $price = get_post_meta($id, 'price');

    if ( !isset( $_SESSION['cart'] ) ) {

        $cart = array(
            $id => $quantity
        );

    } else {

        $cart = json_decode( $_SESSION['cart'] );

        if( isset( $cart->$id ) ){
            $cart->$id = $cart->$id + $quantity;
        }else{
            $cart->$id = $quantity;
        }

    }

    $cart = json_encode($cart);
    $_SESSION['cart'] = $cart;

    cart_mobile();

    die();
}
add_action('wp_ajax_add_to_cart', 'add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart');


// Обновление колличества товара
function update_cart_product(){

    if( isset( $_POST['data'] ) && isset( $_SESSION['cart'] ) ){

        $data   = $_POST['data'];
        $id     = $data['id'];
        $count  = $data['quantity'];

        $cart = json_decode( $_SESSION['cart'] );

        if( $count ){
            $cart->$id = $count;
        }else{
            $cart = (array)$cart;
            unset($cart[$id]);
        }

        if( !empty( $cart ) ){

            $cart = json_encode($cart);
            $_SESSION['cart'] = $cart;
            print_r( $cart );

        }else{

            unset( $_SESSION['cart'] );
            session_destroy();

        }

    }

    die();

}
add_action('wp_ajax_update_cart_product', 'update_cart_product');
add_action('wp_ajax_nopriv_update_cart_product', 'update_cart_product');

// Удаление продукта с корзины
function del_cart_product(){

    if( isset( $_POST['id'] ) ){

        $id = $_POST['id'];        

        if ( isset( $_SESSION['cart'] ) ) {

            $cart = json_decode( $_SESSION['cart'] );
            $filter = (array)$cart;
            $id_dop = array();
                                                
            $query = new WP_Query( array(
                'post_type' => 'product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'delivery',
                        'field'    => 'slug',
                        'terms'    => 'dopolnitelnye-zakazy'
                    )
                ),
                'posts_per_page' => -1,
            ) );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) { $query->the_post();
                    $the_id = get_the_ID();
                    array_push($id_dop, $the_id);
                }
            }
            // Возвращаем оригинальные данные поста. Сбрасываем $post.
            wp_reset_postdata();            

            foreach($filter as $item_id => $count ){
                
                if(in_array($item_id, $id_dop)){
                    unset($filter[$item_id]);
                }

            }
            unset( $cart->$id );
            unset( $filter[$id] );

            $cart = json_encode($cart);
            
            if(!empty($filter)){
                $_SESSION['cart'] = $cart;
            }else{   
                unset( $_SESSION['cart'] );
                session_destroy();
            } 

        }

    }

    die();
}
add_action('wp_ajax_del_cart_product', 'del_cart_product');
add_action('wp_ajax_nopriv_del_cart_product', 'del_cart_product');

// Обновление виджета корзины
function cart_widget(){

    if ( isset( $_SESSION['cart'] ) ) { 

		$cart = json_decode( $_SESSION['cart'] );
		$array_cart = (array)$cart;
		$count_product = array_sum($array_cart);

		$total_price_all = 0;
		$quantity_all = 0;

		foreach( $cart as $post_id => $quantity ){

			$price = get_post_meta($post_id, 'price', true);
			$total_price = (int)$price * (int)$quantity;

			// Суммирование всех товаров
			$total_price_all    = $total_price_all + $total_price;

		}

		$data = array(
			'total_price_all'	=> $total_price_all,
			'count_product'		=> $count_product,
		);

	}else{
		$data = 0;
    }
    
    $data = json_encode( $data );

	print_r( $data );

    die();

}
add_action('wp_ajax_cart_widget', 'cart_widget');
add_action('wp_ajax_nopriv_cart_widget', 'cart_widget');

// Обновление виджета в мобильной версии
function cart_mobile(){

    if ( isset( $_SESSION['cart'] ) ) {
        
        $get_product = json_decode( $_SESSION['cart'] );

        $get_product = (array)$get_product;

        $total_price_all = 0;
        $quantity_all = 0;
                            
        foreach( $get_product as $post_id => $quantity ){

            $post = get_post($post_id);

            $term = get_the_terms( $post_id, "delivery" );
            $term = $term[0];

            $image = get_the_post_thumbnail_url($post_id, 'thumbnail');

            $price = get_post_meta($post_id, 'price', true);
            $total_price = (int)$price * (int)$quantity;

            // Суммирование всех товаров
            $total_price_all    = $total_price_all + $total_price;
            $quantity_all       = $quantity_all + $quantity;
            
        ?>

        <div class="table-item" data-id="<?php echo $post_id; ?>">
            <div class="about">
                <div class="image" style="background-image: url( '<?php echo $image; ?>' )"></div>
                <div class="name">
                    <a href="<?php echo get_post_permalink( $post_id ); ?>" class="title"><?php echo $post->post_title; ?></a>
                    <a href="/delivery/<?php echo $term->slug; ?>" class="category"><?php echo $term->name; ?></a>
                    <div class="mobile-price">
                        <span>Цена:</span>
                        <span><?php echo $price; ?></span><small> тг.</small>
                    </div>
                </div>
            </div>
            <div class="quantity">
                <button class="cart-quantity-minus"><span>–</span></button>
                <input type="text" readonly class="cart-quantity-input product-quantity quantity-mask" data-min="1" value="<?php echo $quantity; ?>">
                <button class="cart-quantity-plus"><span>+</span></button>
            </div>
            <div class="price" data-name="Цена"><span><?php echo $price; ?></span><small> тг.</small></div>
            <div class="total" data-name="Итог"><span><?php echo $total_price; ?></span><small> тг.</small></div>
            <div class="remove"><div class="remove-item icon-close-bold"></div></div>
        </div>

        <?php } ?>

    <?php } ?>
    <div class="empty icon-cart">Корзина пуста</div>
    <?php 
}