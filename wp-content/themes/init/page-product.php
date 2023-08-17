<?php
/**
 * Template Name: Archive Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];
$url = explode('/', $url);
$url = array_diff($url, array(''));
$length = count($url);
$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
$slug = $url[$length];
$args = [];
$type = '';
$meta_type = '';

if(!empty($_GET['pag'])) {
    $args['start'] = 0;
    $args['page'] = $_GET['pag'];
}
$order = 'new';
$args['order'] = $order;

if($slug != 'product') {
    $taxonomy = taxonomy_data($slug);
    $tag = tag_data($slug);
    $product = product_data($slug);
    $flower = flower_data($slug);

    if(!empty($taxonomy)) {
        if($taxonomy->parent && $taxonomy->parent != $pre_link) {
            fire_404();
        } else {
            $taxonomis = get_taxonomis([
                'parent' => $taxonomy->slug
            ]);
    
            $args['taxonomy'] = $taxonomy->slug;


            $products = get_products($args);

            $title = $taxonomy->title;

            $type = 'archive';
            $meta_type = 'taxonomy';
        }

    } else if ($slug == 'flowers') {
        $flowers = get_flowers();
        $title = 'О цветах';
        $type = 'flowers';
        $meta_type = 'flowers';
    } else if (!empty($flower)) {
        if($pre_link != 'flowers') {
            fire_404();
        } else {
            $args['flower'] = $slug;
            $products = get_products($args);

            $title = $flower->title;
            $type = 'archive';
            $meta_type = 'flower';
        }
    } else if (!empty($tag)) {
        if($tag->parent && $tag->parent != $pre_link) {
            fire_404();
        } else {
            $tags = get_archive_tags([
                'parent' => $tag->slug
            ]);
    
            $args['tag'] = $tag->slug;
            $products = get_products($args);
    
            $title = $tag->title;
            $type = 'archive';
            $meta_type = 'tag';
        }
    } else if (!empty($product)) {
        if($pre_link != 'product') {
            fire_404();
        } else {

            // print_r("<pre>");
            // print_r($product);
            // print_r("</pre>");

            $title = $product->title;
            $description = trim($product->description);
            $taxonomies = product_taxonomies($slug);

            if(in_array('bukety', $taxonomies) || in_array('cvety-v-korobke', $taxonomies) || in_array('korziny-s-cvetami', $taxonomies)) {
                if($description) {
                    $description .= '<br><br>';
                }
                $description .= '<b>Обращаем ваше внимание! На фото представлен эксклюзивный размер, цветочной композиции.   Профессиональные флористы предварительно с вами свяжутся для согласования состава. Также мы можем собрать любой индивидуальный букет или композицию по вашему желанию.</b>';
            } elseif (in_array('syedobnyye-bukety', $taxonomies)) {
                if($description) {
                    $description .= '<br><br>';
                }
                $description .= '<b>Композиция из свежей клубники в шоколаде не всегда может соответствовать изображению на фото, потому что количество ягод может варьироваться в зависимости от их размера и веса, а также от индивидуальных предпочтений заказчика. Однако, мы гарантируем, что каждая ягода будет тщательно отобрана и приготовлена с любовью, чтобы вы получили только самые лучшие впечатления от этого замечательного десерта.</b>';
            }

            $description = $description ? '<div class="description">' . $description . '</div><hr>' : '';
            $tags = product_tags($slug);
            $flowers = product_flowers($slug);
            $price = getPrice($slug, CITY_SLUG, $product);
            $price_block = price_block($slug, '', 'single');

            if( !empty($product->images->large) ){
                $large_image = $product->images->large;
                if(is_array($large_image)){
                    foreach($large_image as $large){
                        $image[] = '<img src="' . $large . '" alt="' . $title . '" id="mainImage">';
                    }
                }else{
                    $image = !empty($product->images->large) ? '<img src="' . $product->images->large . '" alt="' . $title . '" id="mainImage">' : '<div class="icon icon-image"></div>';
                }
            }else{
            
                if( !empty($product->images->full) ){
                    $full_image = $product->images->full;
                    if(is_array($full_image)){
                        foreach($full_image as $full){
                            $image[] = '<img src="' . $full . '" alt="' . $title . '" id="mainImage">';
                        }
                    }else{
                        $image = !empty($product->images->full) ? '<img src="' . $product->images->full . '" alt="' . $title . '" id="mainImage">' : '<div class="icon icon-image"></div>';
                    }
                }

            }
            
            // $image = !empty($product->images->full) ? '<img src="' . $product->images->full . '" alt="' . $title . '" id="mainImage">' : $image;            

            $title .= ' в ' . CITY_GENITIVE;    
            $type = 'single';
            $same = [];
            $variant = '';
            $available = '<div class="available green-theme icon-success">В наличии</div>';

            if(!empty($product->disable)) {    
                $available = '<div class="available red-theme icon-error">Нет в наличии</div>';
            }
            
            if(!empty($taxonomies)) {
                $same = get_products([
                    'taxonomy' => $taxonomies[0],
                    'rand' => true
                ]);
            }

            $raw_recent = !empty($_SESSION['recent']) ? explode(';', $_SESSION['recent']) : [];

            $recent = [$slug];

            foreach($raw_recent as $item) {
                if($item != $slug) {
                    $recent[] = $item;
                }
            }

            $recent = array_slice($recent, 0, 10);
            $recent = implode(';', $recent);

            $tab_taxes = ['toppery', 'otkrytka'];

            if(in_array('nedorogie-czvety', $taxonomies) || in_array('rozy', $taxonomies) || in_array('na-ljuboj-vkus', $taxonomies)) {
                $tab_taxes[] = 'upakovka';
            }

            $is_fav = is_fav($slug);

            $recommendation_items = ['sladosti', 'shariki', 'igrushki'];
            $recommendation = get_products([
                'taxonomy' => $recommendation_items,
                'rand' => true
            ]);

            $meta_type = 'single_product';

            write_session('recent', $recent);
        }
    } else {
        fire_404();
    }
}
else {
    $tax_args = ['exclude' => ['product']];
    $taxonomis = get_taxonomis($tax_args);
    $products = get_products($args);

    $title = get_the_title();
    $type = 'archive';

    $meta_type = 'product';
}

if($type == 'single') {
    get_header(null, [
        'product' => $slug,
        'meta_type' => $meta_type,
    ]);
}
else {

    include_once('catalog/taxonomy-texts.php');

    

    get_header(null, [
        'meta_type' => $meta_type,
    ]);
}

if($type == 'archive') {
    $ids = $products['ids'];
    $pages = $products['pages'];
    $page = $products['page'];
    print_category_rating($slug);
    page_header([
        'title' => $title
    ]);
    ?>
        <section class="archive section-padding pb">
            <div class="container">
                <div class="wrapper article-bg">
                    <?php
                        if(!empty($flower)) {
                            $image = $flower->image ? '<img src="' . $flower->image . '" alt="' . $flower->title . '" loading="lazy">' : '<div class="icon icon-image"></div>';
                            $description = $flower->description;
                            $stats = [];
                            $stat_keys = [
                                'care' => 'Как ухаживать',
                                'reason' => 'Повод',
                                'who' => 'Кому можно дарить',
                            ];

                            foreach($stat_keys as $key => $label) {
                                if(!empty($flower->{$key})) {
                                    $value = $flower->{$key};

                                    $stats[] = '
                                        <div class="stat article-sm">
                                            <div class="label">' . $label . '</div>
                                            <p>' . do_shortcode($value) . '</p>
                                        </div>
                                    '; 
                                }  
                            }

                            if(!empty($stats)) {
                                $stats = implode('', $stats);
                                $stats = '<div class="stats">' . $stats . '</div>';
                            } else {
                                $stats = '';
                            }

                            echo '
                            <div class="flower-info">
                                <div class="image">' . $image . '</div>
                                <div class="article info article-block">
                                    <div class="h5">Описание</div>
                                    ' . do_shortcode($description) . '
                                    <button class="btn large open-popup" data-popup="request-popup"><span class="text">Заказать звонок</span></button>
                                </div>
                                ' . $stats . '
                            </div>
                            ';
                        }

                        if(!empty($taxonomis)) {
                            echo '<div class="categories-grid">';

                            if($slug == 'bukety') {
                                $buketpofoto = product_data('buketpofoto');
                                echo '
                                    <a href="'.$buketpofoto->link.'" class="category">
                                        <div class="image"><img src="'.$buketpofoto->images->medium[0].'" alt="'.$buketpofoto->title.'"></div>
                                        <div class="title">'.$buketpofoto->title.'</div>
                                        <span class="new-badge">Новинка</span>
                                    </a>
                                    ';
                            }
                            foreach($taxonomis as $item) {
                                if($item->slug != 'upakovka' && $item->slug != '14-fevralya') {
                                    echo taxonomy_card($item);
                                }
                            }

                            echo '</div>';
                        } else if (!empty($tags)) {
                            echo '<div class="categories-grid bordered">
                                <div class="line">';

                            foreach($tags as $item) {
                                echo taxonomy_card($item);
                            }

                            echo '
                                </div>
                            </div>';
                        }
                    ?>

                    <?php if(!empty($taxonomy) || !empty($tag) || !empty($flower)) { ?>
                        <div class="catalog">
                            <?php
                                print_products($ids);

                                if($pages != $page) {
                                    echo '<div class="load-more-wrapper"><button class="btn load-more outline-border large" id="load_more" data-page="' . $page . '" data-max="' . $pages . '" data-order="' . $order . '"><span class="text icon-refresh">Показать больше</span></button></div>';
                                }

                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php
        if (!empty(CITY_SLUG) && !empty($about_by_city[CITY_SLUG][$slug])) {
            print_blocks($about_by_city[CITY_SLUG][$slug]);
        } else {
            if(!empty($about[$slug])) {
                print_blocks($about[$slug]);
            }
        }


}
else if ($type == 'flowers') {
    page_header([
        'title' => $title
    ]);
    ?>
        <section class="archive section-padding pb">
            <div class="container">
                <div class="wrapper article-bg">
                    <div class="input-wrapper">
                        <div class="icon icon-search"></div>
                        <input type="text" id="search_flower" placeholder="Введите наименование">
                    </div>

                    <?php
                        if(!empty($flowers)) {
                            echo '<div class="categories-grid">';

                            foreach($flowers as $flower) {
                                $flower_title = $flower->title;
                                $flower_slug = $flower->slug;
                                $flower_image = $flower->image ? '<img src="' . $flower->image . '" alt="' . $flower_title . '" loading="lazy">' : '<div class="icon icon-image"></div>';
                                $count = flower_products($flower_slug);
                                $count = count($count);

                                if($count == 1) {
                                    $count .= ' товар';
                                } else if ($count > 2 && $count < 5) {
                                    $count .= ' товара';
                                } else {
                                    $count .= ' товаров';
                                }

                                echo '
                                <a href="' . PRE_LINK . '/flowers/' . $flower_slug . '/" class="category" data-search="' . mb_strtolower($flower_title). '">
                                    <div class="image">' . $flower_image . '</div>
                                    <div class="title">' . $flower_title . '</div>
                                    <div class="quantity">' . $count . '</div>
                                </a>
                                ';
                            }

                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </section>
    <?php

    if(!empty($about[$slug])) {
        print_blocks($about[$slug]);
    }
}
else if ($type == 'single') {
    if(!isset($image)) { $image = ''; }
?>
    <script>
        window.productID = '<?php echo $slug ?>';
        window.price = <?php echo $price['price']; ?>;
        window.quantity = 1;
        window.cur = '<?php echo CUR; ?>';
    </script>
    
    <div class="bread-wrapper">
        <div class="container">
            <div class="wrapper"><?php echo bread(); ?></div>
        </div>
    </div>
    
    <section class="single section-padding pb bordered">
        <div class="container article-bg">
            <div class="wrapper">
                <div class="single-body">
                    <div class="single-image">
                        <?php if(is_array($image) && count($image) > 1): ?>
                            <div class="product-image-wrapper">
                                <?php if(!empty($image)) { ?>
                                    <div class="product-thumbnails">
                                        <?php
                                            foreach($image as $key => $img) {
                                                $is_active = $key == 0 ? 'active' : '';
                                                echo '<div class="image ' . $is_active . '">' . $img . '</div>';
                                            }
                                        ?>
                                    </div>
                                    <div class="product-main-slider">
                                        <?php
                                            foreach($image as $img) {
                                                echo $img;
                                            }
                                        ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="empty-block">
                                        <div class="icon icon-flower"></div>
                                        <div class="h6">Нет изображении</div>
                                    </div>    
                                <?php } ?>
                            </div>

                        <?php else: ?>
                            <div class="image-wrapper"><?= is_array($image) ? $image[0]: $image; ?></div>
                        <?php endif; ?>

                    </div>
					<?php if(!empty($taxonomies)) {
                foreach($taxonomies as $taxonomy) {
                    $taxonomy = taxonomy_data($taxonomy);
                    $tax_title = $taxonomy->title;
                    $tax_parent = $taxonomy->parent ? $taxonomy->parent . '/' : '';
                    $tax_slug = $taxonomy->slug;
                    $tax_link = '/catalog/' . $tax_parent . $tax_slug . '/';
                    
                    $links[] = '<a class="link" href="' . $tax_link . '">' . $tax_title . '</a>';
                }
            }
             if (isset($links) && strpos($links[count($links) - 1], 'Букеты из клубники') !== false) {
              echo '<style>
			  
			  section.single .wrapper{
			  flex-direction:column;
			  }
			  section.single .wrapper .single-body{
			  width:100%;
			  }
			  
			   div.wrapper > div.single-sidebar.article{
			  width:100%;
			  }
			  @media (min-width:1000px){
			  section.single .wrapper .single-body .single-image{
			  width:53%;
			  }
			  section.single .wrapper .single-body .single-content{
			  width:47%;
			  }
			  section.single .wrapper .single-body .single-image .product-image-wrapper .product-thumbnails .image{
			  height:10rem !important;
			  width:10rem !important;
			  }
			  section.single .wrapper .single-sidebar{
			  overflow:unset;
			  padding-bottom:21rem;
			  }
			  }
			  </style>';               
              //var_dump($links);
             }  
              ?>
                    <div class="single-content article-md">
                        <?php if($slug == 'buketpofoto') { ?>
                            <span class="new-badge">Новинка</span>
                        <? } ?>
                        <div class="article-sm">
                            <h1><?php echo $title; ?></h1>
                            <div class="product-meta">
                                <?php echo $available ?>
                                <div class="rating-wrapper">
                                    <?php echo $product->stars; ?>
                                    <div class="reviews-label"><?php echo $product->reviews_label; ?></div>
                                </div>
                            </div>
                            <noindex>
                                <div class="reviews-label">Купили: <?php $_plural_times = array('раз', 'раза', 'раз'); $rand = rand(200,500); echo $rand .' '. $_plural_times[plural_type($rand)]; ?></div>
                            </noindex>
                        </div>

                        <div class="article">
                            <?php
                                if(in_array('rozy', $taxonomies) && !empty($price['variants'])) {
                                    echo '<div class="h5">Выберите длину роз:</div>';
                                }
                                
                                echo $price_block;

                                if(!empty($product->disable)) {
                                    echo '<button class="btn medium" disabled><span class="text">Нет в наличии</span></button>';
                                } else {
                                    if(!in_array('upakovka', $taxonomies) && !in_array('yagody', $tags)) {
                                        if ($slug == 'buketpofoto') {
                                            echo '<div>Укажите желаемую сумму <input type="number" min="3000" max="9999999" class="florist_price"  name="florist_price" value="'.$price['price'].'" step="100" onfocusout=enforceMinMax(this)></div>';
                                            echo '<div>Ваш комментарий (опишите Ваш букет)<textarea class="florist_comment" name="florist_comment" ></textarea></div>';
                                            echo '<div>Загрузите пример желаемого букета <input type="file" class="florist_file" name="florist_file" accept=".jpg,.png,.webp"></div>';
                                        }
                                        echo '<div class="fields price-wrapper">';
                                        if ($slug != 'buketpofoto') {
                                            echo '<div class="quantity">
                                                        <button class="minus icon-minus"></button>
                                                        <input type="text" class="quantity-input medium calc-price" value="1" data-key="' . $slug . '">
                                                        <button class="plus icon-plus"></button>
                                                    </div>';
                                        }
                                        echo '<button class="btn add-to-cart medium" data-tab-btn="' . $slug . '" data-key="' . $slug . '"><span class="text">В корзину</span></button>';

                                        if ($slug != 'buketpofoto') {
                                            echo '<button class="btn outline medium one-click open-popup" data-popup="one-click-popup" data-key="' . $slug . '"><span class="text">В 1 клик</span></button>';
                                        }

                                        if($is_fav) {
                                            echo '<button class="btn outline add-to-fav active medium" data-slug="' . $slug . '"><span class="icon icon-fav"></span></button>';
                                        } else {
                                            echo '<button class="btn outline add-to-fav medium" data-id="' . $slug . '"><span class="icon icon-fav"></span></button>';
                                        }
    
                                        echo '</div>';
                                    } else {
                                        echo '<div class="warning-block icon-warning orange-theme">Вы не можете купить этот товар отдельно</div>';
                                    }
                                }
                            
                            ?>

                            <div class="per-price">Цена за 1 шт: <span class="append-per-price"></span></div>
                        </div>

                        <?php if (in_array('syedobnyye-bukety', $taxonomies)) {
                            $yagody = get_products(['tag' => 'yagody']);
                            if(!empty($yagody['ids'])) { ?>
                                <div class="additional-products-title">Добавить ягоды</div>
                                <div class="additional-products">
                                    <?php print_additional_products($yagody['ids']); ?>
                                </div>
                            <?php }
                        } ?>

                        <?php if ($tab_taxes) { ?>
                            <div class="additional-products-title">Добавить к букету</div>
                            <div class="tab-taxes">
                                <div class="line">
                                    <?php
                                        foreach($tab_taxes as $taxonomy) {
                                            $taxonomy = taxonomy_data($taxonomy);
                                            $title = $taxonomy->title;
                                            $image = $taxonomy->images->small;
                                            $taxonomy_slug = $taxonomy->slug;

                                            echo '
                                                <div class="tax-tab" data-name="' . $title . '" data-slug="' . $taxonomy_slug . '">
                                                    <div class="image"><img src="' . $image . '" alt="' . $title . '"><div class="spinner"></div></div>
                                                    <div class="title">' . $title . '</div>
                                                </div>
                                            ';
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                            if(current_user_can('administrator')) {
                                echo '
                                    <div class="inline">
                                        <div class="line">
                                            <a class="btn" href="/edit/' . $slug . '/"><span class="text icon-edit">Редактировать</span></a>
                                            <button class="btn delete-product red-theme" data-slug="' . $slug . '"><span class="text icon-trash">Удалить товар</span></button>
                                        </div>
                                    </div>
                                ';
                            }
                        ?>
                    </div>
                </div>

                <div class="single-sidebar article">
                    <div class="h5">Информация</div>

                    <div class="simple-accord">
                        <?php
                            $accords = [];

                            if($description) {
                                $accords[] = [
                                    'title' => 'Описание',
                                    'content' => $description
                                ];
                            }

                            if (in_array('syedobnyye-bukety', $taxonomies)) {
                                $accords[] = [
                                    'title' => 'Рекомендации по хранению',
                                    'content' => ''
                                ];
                            }

                            if(!empty($flowers)) {
                                $line = [];
                                
                                foreach($flowers as $flower_slug) {
                                    $flower_data = flower_data($flower_slug);
                                    $line[] = '<a class="tag hover" href="/flowers/' . $flower_data->slug . '/">' . $flower_data->title . '</a>';
                                }

                                $line = implode('', $line);

                                $accords[] = [
                                    'title' => 'Состав',
                                    'content' => '<div class="tags"><div class="line">' . $line . '</div></div>'
                                ];
                            }

                            $additional = '
                                <ul>
                                    <li>Все доставки осуществляются курьером точно в срок.</li>
                                    <li>После доставки мы предоставляем фотоотчёт с получателем.</li>
                                    <li>Доставка осуществляется в течение 1 часа 30 минут.</li>
                                </ul>
                            ';

                            if(ADDRESS) {
                                $additional .= '<div><b>Адрес магазина</b>: ' . ADDRESS . '</div>';
                            }

                            $accords[] = [
                                'title' => 'Доставка в ' . CITY_GENITIVE,
                                'content' => $additional
                            ];

                            $accords[] = [
                                'title' => 'Способы оплаты в ' . CITY_GENITIVE,
                                'content' => '
                                    <p>Оплатить ваш заказ вы можете любым удобным для Вас способом:</p>
                                    <ul>
                                        <li>Банковской картой ( Visa, MasterCard, МИР ) , Альфа банк</li>
                                        <li>Электронной платежной системой: Qiwi-кошелек, Юмани</li>
                                    </ul>
                                '
                            ];

                            foreach($accords as $key => $accord) {
                                $classes = ['accord-item'];

                                if(!$key) {
                                    $classes[] = 'active';
                                }

                                $classes = implode(' ', $classes);

                                echo '
                                <div class="' . $classes . '">
                                    <div class="accord-header">
                                        <h2 class="title">' . $accord['title'] . '</h2>
                                        <span class="indicator icon-down"></span>
                                    </div>
        
                                    <div class="accord-content article-sm article-block">' . $accord['content'] . '</div>        
                                </div>
                                ';      
                            }
                        ?>
                    </div>

                    <?php if( !in_array('upakovka', $taxonomies) && !in_array('shariki', $taxonomies) && !in_array('igrushki', $taxonomies) && !in_array('otkrytka', $taxonomies) && !in_array('sladosti', $taxonomies) && !in_array('toppery', $taxonomies) ) { ?>
                        <div class="single-sidebar-content-wrapper">
                            <div class="single-sidebar-content article-md">
                                <div class="rating-wrapper">
                                    <?php
                                        global $wpdb;
                                        $lines = [
                                            1 => 0,
                                            2 => 0,
                                            3 => 0,
                                            4 => 0,
                                            5 => 0,
                                        ];

                                        $avarage = 0;
                                        $count = 0;
                                        $reviews = $wpdb->get_col("SELECT `rating` FROM `init_rating` WHERE `product` = '$slug' AND `status` = 'approved' ORDER BY `id` DESC");

                                        if(!empty($reviews)) {
                                            $count = count($reviews);

                                            foreach($reviews as $item) {
                                                $lines[$item]++;
                                                $avarage += $item;
                                            }

                                            $avarage = $avarage / $count;
                                        }

                                        $processed_lines = [];

                                        foreach($lines as $mark => $rating) {
                                            $percents = 0;
                                    
                                            if($rating) {
                                                $percents = ($rating / $count) * 100;
                                            }
                                    
                                            $processed_lines[] = '
                                            <div class="line-wrapper">
                                                <span class="number">' . $mark . '</span>
                                                <span class="line"><div class="progress" style="width: ' . $percents . '%"></div></span>
                                            </div>
                                            ';
                                        }
                                    
                                        $processed_lines = implode('', $processed_lines);

                                        $avarage = number_format($avarage, 1, '.', ' ');
                                    ?>
                                    <div class="left">
                                        <div class="rating"><?php echo $avarage; ?></div>
                                        <div class="reviews"><?php echo $product->reviews_label; ?></div>
                                    </div>

                                    <div class="right"><?php echo $processed_lines; ?></div>
                                </div>

                                <button class="btn center rating-btn open-popup" data-popup="product-review-popup" data-id="<?php echo $slug ?>"><span class="text">Оставить отзыв</span></button>

                                <?php
                                    if(current_user_can('administrator')) {
                                        $reviews = $wpdb->get_col("SELECT `id` FROM `init_rating` WHERE `product` = '$slug' AND `status` IN ('static', 'approved') ORDER BY `id` DESC");
                                    } else {
                                        $reviews = $wpdb->get_col("SELECT `id` FROM `init_rating` WHERE `product` = '$slug' AND `status` = 'approved' ORDER BY `id` DESC");
                                    }
                                    
                                    if(!empty($reviews)) {
                                        echo '
                                            <hr>

                                            <div class="comments-list article-bg">
                                        ';

                                        foreach($reviews as $id) {
                                            echo product_review($id);
                                        }

                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="advantges">
                <div class="item icon-verified">Гарантия сервиса</div>
                <div class="item icon-gift">Подарок от FlowLove</div>
                <div class="item icon-image">Фото с получателем</div>
            </div>
        </div>
    </section>

    <?php
        if(!empty($recommendation)) {
            $recommendation['ids'] = array_splice($recommendation['ids'], 0, 8);
            $structure = [];

            foreach($recommendation['ids'] as $id) {
                $structure[] = product($id, true);
            }

            $structure = implode('', $structure);
    ?>
        <section class="catalog section-padding">
            <div class="container">
                <div class="wrapper article-md">
                    <div class="inline full">
                        <div class="line">
                            <div class="h2 hide-sm">С этим товаром рекомендуют</div>
                            <div class="h2 hide-md hide-lg">Так же рекомендуем</div>
                        </div>
                    </div>
                    <div class="catalog"><?php echo $structure; ?></div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
        if(!empty($same)) {
            $same['ids'] = array_splice($same['ids'], 0, 8);
            $structure = [];

            foreach($same['ids'] as $id) {
                $structure[] = product($id, true);
            }

            $structure = implode('', $structure);
    ?>
        <section class="catalog section-padding">
            <div class="container">
                <div class="wrapper article-md">
                    <div class="inline full">
                        <div class="line">
                            <div class="h2">Вам может понравиться</div>
                        </div>
                    </div>
                    <div class="catalog"><?php echo $structure; ?></div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
        global $wpdb;
        $reviews = $wpdb->get_col("SELECT `id` FROM `init_reviews` WHERE `status` = 1 ORDER BY RAND () DESC LIMIT 6");

        if(!empty($reviews)) {
    ?> 
        <section class="reviews section-padding bordered">
            <div class="container">
                <div class="wrapper article-md">
                    <div class="inline full">
                        <div class="line">
                            <div class="h2 title-with-icon">Наши отзывы</div>
                            <div class="grow"></div>
                            <a href="/reviews/" class="subtitle">Все отзывы</a>
                        </div>
                    </div>

                    <div class="reviews-slider-wrapper">
                        <div class="reviews-slider">
                            <button class="btn arrow prev medium white reviewsSliderPrev"><span class="icon icon-arrow-left small bold-icon"></span></button>

                            <div class="swiper-wrapper">
                                <?php
                                    foreach($reviews as $id) {
                                        echo review($id);
                                    }
                                ?>
                            </div>

                            <button class="btn arrow next medium white reviewsSliderNext"><span class="icon icon-arrow-right small bold-icon"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
        if(!empty($tags) || !empty($taxonomies)) {

            $links = [];
            
            if(!empty($taxonomies)) {
                foreach($taxonomies as $taxonomy) {
                    $taxonomy = taxonomy_data($taxonomy);
                    $tax_title = $taxonomy->title;
                    $tax_parent = $taxonomy->parent ? $taxonomy->parent . '/' : '';
                    $tax_slug = $taxonomy->slug;
                    $tax_link = '/catalog/' . $tax_parent . $tax_slug . '/';
                    
                    $links[] = '<a class="link" href="' . $tax_link . '">' . $tax_title . '</a>';
                }
            }

            if(!empty($tags)) {
                foreach($tags as $tag) {
                    $tag = tag_data($tag);
                    $tag_title = $tag->title;
                    $tag_slug = $tag->slug;
                    $tag_link = '/tags/' . $tag_slug . '/';
    
                    $links[] = '<a class="link" href="' . $tag_link . '">' . $tag_title . '</a>';
                }
            }

            $links = implode('', $links);

            echo '
                <section class="section-padding">
                    <div class="container">
                        <div class="wrapper article-md">
                            <div class="h2">Разделы с похожими товарами:</div>
                            <div class="links-grid">
                                <div class="line">' . $links . '</div>
                            </div>
                        </div>
                    </div>
                </section>
            ';
        }
    ?>

    <div class="product-review-popup popup">
        <div class="popup-content">
            <div class="popup-blackboard close-popup"></div>
            <div class="wrapper">
                <div class="popup-header">
                    <div class="h5">Оставить отзыв о товаре</div>
                    <button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
                </div>
                <?php if(is_user_logged_in()) { ?>
                    <form class="content product-review-form article">

                        <div class="stars-input">
                            <input type="radio" name="product_review_rating" id="product_review_rating_1" value="1">
                            <label for="product_review_rating_1" class="icon-star"></label>

                            <input type="radio" name="product_review_rating" id="product_review_rating_2" value="2">
                            <label for="product_review_rating_2" class="icon-star"></label>

                            <input type="radio" name="product_review_rating" id="product_review_rating_3" value="3">
                            <label for="product_review_rating_3" class="icon-star"></label>

                            <input type="radio" name="product_review_rating" id="product_review_rating_4" value="4">
                            <label for="product_review_rating_4" class="icon-star"></label>

                            <input type="radio" name="product_review_rating" id="product_review_rating_5" value="5" checked>
                            <label for="product_review_rating_5" class="icon-star"></label>
                        </div>

                        <br>

                        <?php if(current_user_can('administrator')) { ?>
                            <div class="form-group article-sm">
                                <label for="product_review_date" class="label">Дата <span class="mark">*</span></label>
                                <div class="input-wrapper">
                                    <input type="text" id="product_review_date" class="date date-mask" placeholder="Введите дату">
                                </div>
                            </div>

                            <div class="form-group article-sm">
                                <label for="product_review_name" class="label">Имя <span class="mark">*</span></label>
                                <div class="input-wrapper">
                                    <input type="text" id="product_review_name" class="name" placeholder="Введите имя">
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group article-sm">
                            <label for="product_review_text" class="label">Отзыв <span class="mark">*</span></label>
                            <div class="input-wrapper">
                                <textarea id="product_review_text" cols="30" rows="3" placeholder="Введите отзыв"
                                    class="review"></textarea>
                            </div>
                        </div>

                        <button class="btn large full" id="product_review_send"><span class="text">Оставить отзыв</span></button>

                    </form>
                <?php } else { ?>
                    <div class="content">
                        <div class="log-in-warning">
                            <div class="icon icon-lock"></div>
                            <div class="title h5">Авторизуйтесь</div>
                            <div class="description">Авторизуйтесь или зарегистрируйтесь<br> чтобы оставить ваш отзыв.</div>
                            <div class="inline center">
                                <div class="line">
                                    <a href="<?php echo PRE_LINK ?>/login/" rel="nofollow" class="btn medium"><span class="text">Авторизация</span></a>
                                    <a href="<?php echo PRE_LINK ?>/register/" rel="nofollow" class="btn medium theme-outline"><span class="text">Регистрация</span></a>
                                </div>
                            </div>
                        </div>
                    </div>    
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="rec-popup popup large">
        <div class="popup-content">
            <div class="popup-blackboard close-popup"></div>
            <div class="wrapper">
                <div class="popup-header">
                    <div class="h5 popup-title"></div>
                    <button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
                </div>
                <div class="content">
                    <div class="catalog very-small expanded">

                    </div>
                </div>  
            </div>
        </div>
    </div>

<?php
}
get_footer();
