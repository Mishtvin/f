<?php
/**
 * Template Name: Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
$day_product = 'czvety-v-korobke-povod-dlya-poczeluya';
?>  

<?php while ( have_posts() ) : the_post(); ?>   

<?php endwhile; ?>

    <?php
        $first_col = [
            [
                //'image' => '/wp-content/themes/init/img/rozy.webp',
				'image' => '/wp-content/uploads/2022/100/roses.webp',
                'alt' => 'Розы',
                'subtitle' => 'Категория',
                'title' => 'Розы',
                'link' => PRE_LINK . '/catalog/rozy/'
            ],
            [
                'image' => '/wp-content/themes/init/img/bukety.webp',
                'alt' => 'Букеты',
                'subtitle' => 'Категория',
                'title' => 'Букеты',
                'link' => PRE_LINK . '/catalog/bukety/'
            ],
        ];

        $last_col = [
            [
                //'image' => '/wp-content/themes/init/img/raznye-czvety.webp',
				'image' => '/wp-content/uploads/2022/100/flowers.webp',
                'alt' => 'Разные цветы',
                'subtitle' => 'Категория',
                'title' => 'Разные цветы',
                'link' => PRE_LINK . '/catalog/na-ljuboj-vkus/'
            ],
            [
                //'image' => '/wp-content/themes/init/img/czvety-v-korobke.webp',
				'image' => '/wp-content/uploads/2022/100/flowersinbox.webp',
                'alt' => 'Цветы в коробке',
                'subtitle' => 'Категория',
                'title' => 'Цветы в коробке',
                'link' => PRE_LINK . '/catalog/cvety-v-korobke/'
            ],
        ];

        $main_slider = [
            [
                'type' => 'slide',
//                 'background' => '/wp-content/themes/init/img/14-fevralya.webp',
                 'background' => '/wp-content/themes/init/img/fs.webp',
//                 'background' => '/wp-content/themes/init/img/8-marta.webp',
				 //'background' => '/wp-content/uploads/2022/100/frame.webp',
                //'background' => '/wp-content/uploads/2022/11/den-materi.webp',
                // 'background' => '/wp-content/uploads/2022/10/den-uchitelya.jpg',
//                'subtitle' => '"FlowLove" - Доставка цветов',
                'title' => 'Доставка цветов в ' . CITY_GENITIVE,
//                'title' => 'Компания Flowlove <br> поздравляет всех <br> <span style="color: #ff4465;font-size: 2.0rem;">с Международным женским днем!</span>' ,
//                'title' => 'Компания Flowlove <br> поздравляет всех <br> <span style="color: #ff4465;">с Днем Святого Валентина!</span> ' ,
                //'text' => 'Компания Flow Love поздравляет с Днем матери. И дарит <mark style="padding: 0px 4px 2px;">скидку на все товары 10%</mark>. Успейте поздравить своих любимых мам и бабушек!',
                 'text' => 'Свежие цветы доставляются бесплатно до двери с подарком от компании «FlowLove» каждому покупателю.',
//                 'text' => 'Оформите заказ на букет до 8 марта<br> и получите скидку <span style="color: #ff4465;font-weight: 600;font-size: 2.0rem;">5%</span> по промокоду <span class="main-banner-promo">FLOWLOVE</span>',
//                 'text' => 'Оформите заказ на букет до 14 февраля и получите скидку 5% по промокоду <span class="main-banner-promo">FLOWLOVE</span>',
                // 'text' => 'Компания Flow Love<br> Поздравляет всех преподавателей с днем учителя. Для вас мы дарим скидку на весь ассортимент <strong>10% только до 6 октября</strong>, успейте порадовать своих родных и близких, с бесплатной круглосуточный доставкой.',
//                 'btns' => [
//                     [
//                         'link' => PRE_LINK . '/product/',
//                         'text' => 'Перейти в каталог',
//                     ]
//                 ]
            ]
        ];
    ?>
    <section class="first-slide">
        <div class="container">
            <div class="wrapper">

                <?php if(!empty($main_slider)) { ?>
                    <div class="main-slider">
                        <div class="swiper-wrapper">
                            <?php
                                foreach($main_slider as $slide) {
                                    $type = $slide['type'];
                                    $background = !empty($slide['background']) ? '<div class="bg"><img src="' . $slide['background'] . '"></div>' : '';
                                    $content = [$background];

                                    if($type == 'slide') {
                                        $subtitle = !empty($slide['subtitle']) ? '<div class="category">' . $slide['subtitle'] . '</div>' : '';
                                        $title = !empty($slide['title']) ? '<div class="title">' . $slide['title'] . '</div>' : '';
                                        $text = !empty($slide['text']) ? '<div class="description">' . $slide['text'] . '</div>' : '';
                                        $btns_line = [];

                                        if(!empty($slide['btns'])) {
                                            foreach($slide['btns'] as $btn_data) {
                                                $classes = ['btn'];
                                                $type = !empty($btn_data['type']) ? $btn_data['type'] : '';
                                                $btn_text = !empty($btn_data['text']) ? $btn_data['text'] : '';
        
                                                if($type) {
                                                    $classes[] = $type;
                                                }
        
                                                $classes = implode(' ', $classes);
        
                                                if(!empty($btn_data['link'])) {
                                                    $url = !empty($btn_data['link']) ? $btn_data['link'] : '';
        
                                                    $btn = '<a href="' . $url . '" class="' . $classes . '"><span class="text">' . $btn_text . '</span></a>';
                                                } else {
                                                    $btn = '<button class="' . $classes . '"><span class="text">' . $btn_text . '</span></button>';
                                                }

                                                $btns_line[] = $btn;
                                            }
                                        }
                                        
                                        if(!empty($btns_line)) {
                                            $btns_line = implode('', $btns_line);
                                            $btns_line = '<div class="inline"><div class="line">' . $btns_line . '</div></div>';
                                        } else {
                                            $btns_line = '';
                                        }

                                        $wrapper = [$subtitle, $title, $text, $btns_line];
                                        $wrapper = implode('', $wrapper);
                                        $wrapper = '<div class="content">' . $wrapper . '</div>';
                                        $content[] = $wrapper;
                                    } else if ($type == 'product') {
                                        $product = product_data($product);
                                    }

                                    $content = implode('', $content);

                                    echo '<div class="slide">' . $content . '</div>'; //Здесь включаем slide dark, когда текст нужен тёмный
                                }
                            ?>

                            <!-- <div class="slide">
                                <div class="bg">
                                    <img src="/wp-content/themes/init/img/room.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="category">Категория товара</div>
                                    <div class="title">Тестовый товар</div>
                                    <div class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae maiores vel perferendis.</div>
                                    <div class="meta">
                                        <ul class="star-rating">
                                            <li class="star active icon-star-solid"></li>
                                            <li class="star active icon-star-solid"></li>
                                            <li class="star active icon-star-solid"></li>
                                            <li class="star active icon-star-solid"></li>
                                            <li class="star icon-star-solid"></li>
                                        </ul>
                                        <div class="vendor">Арт: 128442А</div>
                                    </div>
                                    <div class="price-block">
                                        <div class="current-price">11 900 <?php echo CUR; ?></div>
                                        <div class="old-price">14 300 <?php echo CUR; ?></div>
                                    </div>

                                    <div class="inline">
                                        <div class="line">
                                            <a href="#" class="btn"><span class="text">Подробнее</span></a>
                                            <button class="btn white"><span class="icon icon-cart"></span></button>
                                            <button class="btn white"><span class="icon icon-fav"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="image"><img src="/wp-content/themes/init/img/category.png" alt="Тестовый товар"></div>
                            </div> -->
                        </div>

                        <?php if(count($main_slider) > 1) { ?>
                            <button class="btn arrow prev medium white mainSliderPrev"><span class="icon icon-arrow-left small bold-icon"></span></button>
                            <button class="btn arrow next medium white mainSliderNext"><span class="icon icon-arrow-right small bold-icon"></span></button>
                            <div class="main-slider-pagination"></div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if(!empty($first_col)) { ?>
                    <div class="col dark">
                        <?php
                            foreach($first_col as $data) {
                                $image = !empty($data['image']) ? $data['image'] : '';
                                $alt = !empty($data['alt']) ? $data['alt'] : '';
                                $subtitle = !empty($data['subtitle']) ? $data['subtitle'] : '';
                                $title = !empty($data['title']) ? $data['title'] : '';
                                $link = !empty($data['link']) ? $data['link'] : '';

                                echo '
                                <a href="' . $link . '" class="banner">
                                    <div class="image">
                                        <img src="' . $image . '" alt="' . $alt . '">
                                    </div>
                                    <div class="banner-content">
                                        <div class="category">' . $subtitle . '</div>
                                        <div class="title">' . $title . '</div>
                                    </div>
                                </a>
                                ';
                            }
                        ?>
                    </div>
                <?php } ?>

                <?php if(!empty($last_col)) { ?>
                    <div class="col dark">
                        <?php
                            foreach($last_col as $data) {
                                $image = !empty($data['image']) ? $data['image'] : '';
                                $alt = !empty($data['alt']) ? $data['alt'] : '';
                                $subtitle = !empty($data['subtitle']) ? $data['subtitle'] : '';
                                $title = !empty($data['title']) ? $data['title'] : '';
                                $link = !empty($data['link']) ? $data['link'] : '';

                                echo '
                                <a href="' . $link . '" class="banner">
                                    <div class="image">
                                        <img src="' . $image . '" alt="' . $alt . '">
                                    </div>
                                    <div class="banner-content">
                                        <div class="category">' . $subtitle . '</div>
                                        <div class="title">' . $title . '</div>
                                    </div>
                                </a>
                                ';
                            }
                        ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>

    <section class="categories section-padding bordered">
        <div class="container">
            <div class="wrapper article-md">
                
                <div class="inline full">
                    <div class="line">
                        <div class="h2">Категории</div>
                        <div class="grow"></div>
                        <a href="/product/" class="subtitle">Смотреть все</a>
                    </div>
                </div>
                
                <div class="categories-grid">
                    <?php
                        $taxonomis = get_taxonomis([
                            'exclude' => ['upakovka','14-fevralya', 'product']
                        ]);

                        if(!empty($taxonomis)) {
                            foreach($taxonomis as $item) {
                                echo taxonomy_card($item);
                            }
                        }
                    ?>
                </div>

            </div>
        </div>
    </section>

    <?php
        $items = [
//            [
//                'type' => 'tag',
//                'slug' => '8-marta'
//            ],
            [
                'type' => 'taxonomy',
                'slug' => 'nedorogie-czvety'
            ],
			[
                'type' => 'tag',
                'slug' => 'akcii'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'orhidei-v-gorshkah'
            ],
            [
                'type' => 'tag',
                'slug' => 'novinki'
            ],
            [
                'type' => 'tag',
                'slug' => 'hity-prodazh'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'rozy'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'na-ljuboj-vkus'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'bukety'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'cvety-v-korobke'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'korziny-s-cvetami'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'podarki-i-dekor'
            ],
            [
                'type' => 'tag',
                'slug' => 'den-rozhdeniya'
            ],
            [
                'type' => 'tag',
                'slug' => 'izvinenie'
            ],
            [
                'type' => 'tag',
                'slug' => 'podarochnye-nabory'
            ],
            [
                'type' => 'tag',
                'slug' => 'v-roddom'
            ],
        ];

        $print_day_product = ceil(count($items) / 2) - 1;
        $ids = [];

        foreach($items as $index => $item) {
            $slug = $item['slug'];
            $type = $item['type'];

            $link = [];

            if($type == 'tag') {
                $data = tag_data($slug);
                $link[] = 'tags';

                $products = get_products([
                    'tag' => $slug,
                    'rand' => 1
                ]);
            } else {
                $data = taxonomy_data($slug);
                $link[] = 'catalog';

                $products = get_products([
                    'taxonomy' => $slug,
                    'rand' => 1
                ]);
            }

            if($data->parent) {
                $link[] = $data->parent;
            }

            $link[] = $data->slug;

            $link = implode('/', $link);
            $link = '/' . $link . '/';

            $title = $data->title;

            if($index == $print_day_product) {
                $day_product = $ids[array_rand($ids)];
                $product = product_data($day_product);
        
                if(!empty($product)) {
                    $price = getPrice($day_product, CITY_SLUG, $product);
                    $price_block = price_block($day_product, $price, 'day');
                ?> 
                    <script>
                        window.productID = '<?php echo $product->slug ?>';
                        window.price = <?php echo $price['price']; ?>;
                        window.quantity = 1;
                        window.cur = '<?php echo CUR; ?>';
                    </script>
                    <section class="day-product section-padding bordered">
                        <div class="container">
                            <div class="wrapper article-md">
                                <div class="inline full">
                                    <div class="line">
                                        <div class="h2 title-with-icon">Товар дня</div>
                                        <div class="grow"></div>
                                        <a href="<?php echo PRE_LINK; ?>/product/" class="subtitle">Весь каталог</a>
                                    </div>
                                </div>
            
                                <div class="product-wrapper per-price">
                                    <a href="<?php echo $product->link ?>" class="image">
                                    <?php
                                    if(is_array($product->images->large)) {
                                        $today_image = $product->images->large[0];
                                    } else {
                                        $today_image = $product->images->large;
                                    }
                                    ?>
                                        <?php echo $today_image ? '<img src="' . $today_image . '" alt="' . $product->title . '">' : '<div class="icon icon-image"></div>' ?>
                                    </a>
                                    <div class="product-info article price-wrapper">
                                        <div class="article-sm">
                                            <a href="<?php echo $product->link ?>" class="title h2"><?php echo $product->title; ?></a>
            
                                            <?php echo $product->description ? '<div class="description">' . $product->description . '</div>' : ''; ?>
            
                                            <div class="product-meta">
                                                <div class="available green-theme icon-success">В наличии</div>
                                                <?php echo $product->stars ?>
                                            </div>
                                        </div>
            
                                        <?php echo $price_block; ?>
            
                                        <div class="fields">
                                            <div class="fields-wrapper">
                                                <div class="quantity">
                                                    <button class="minus">-</button>
                                                    <input type="text" class="quantity-input" data-key="<?php echo $day_product; ?>" value="1">
                                                    <button class="plus">+</button>
                                                </div>
            
                                                <button class="btn add-to-cart" data-tab-btn="<?php echo $day_product; ?>" data-key="<?php echo $day_product; ?>"><span class="text">В корзину</span></button>
                                            </div>
            
                                            <button class="btn full theme-outline one-click open-popup" data-popup="one-click-popup" data-key="<?php echo $day_product; ?>"><span class="text">Купить в 1 клик</span></button>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php }
            }

            if(!empty($data)) {
                $ids = array_merge($ids, $products['ids']);
                $products = array_slice($products['ids'], 0, 8);
                $structure = [];

                foreach($products as $id) {
                    $structure[] = product($id);
                }

                $structure = implode('', $structure);

                if ($title == "Учительнице"){
                    $title = "День учителя";
                }

                echo '
                    <section class="section-padding bordered">
                        <div class="container">
                            <div class="wrapper article-md">
                                <div class="inline full">
                                    <div class="line">
                                        <div class="h2">' . $title . '</div>
                                        <div class="grow"></div>
                                        <a href="' . $link . '" class="subtitle">Смотреть все</a>
                                    </div>
                                </div>
                                <div class="catalog">' . $structure . '</div>
                            </div>
                        </div>
                    </section>
                ';
            }
        }
    ?>

    <section>
        <div class="container all-bm article information-block">
            <div class="row">
                <h2 class="h1 large">Салон цветов в городе <?php echo CITY; ?></h2>
            </div>
            <div class="row">
                Рады приветствовать Вас в цветочном магазине FlowLove в <?php echo CITY_GENITIVE; ?>! Мы с удовольствием доставим Вам и Вашим близким прекрасные букеты и подарки. Осуществляем бесплатную круглосуточную доставку 24/7!
            </div>
        </div>
    </section>

    <section>
        <div class="container all-bm article information-block">
            <div class="row">
                <h2 class="h1 large">Стоимость и сроки доставки цветов в городе <?php echo CITY; ?></h2>
            </div>
            <div class="row">
            Магазин FlowLove доставляет Ваши заказы по городу <?php echo CITY; ?> в течение 2 часов с момента заказа,  доставка в пределах города бесплатна. Перед отправой мы обязательно пришлём фото для согласованя и только после одобрения отправим Ваш заказ адресату.
            </div>
        </div>
    </section>


    <?php /*
    <section class="best-deals section-padding bordered">
        <?php
            $tags = ['hity-prodazh', 'novinki', 'akcii'];
            $tabs = [];

            foreach($tags as $tag) {
                $data = tag_data($tag);

                if(!empty($data)) {
                    $tag_products = get_products([
                        'tag' => $tag
                    ]);
                    $tag_products['ids'] = array_slice($tag_products['ids'], 0, 5);
                    
                    if(!empty($tag_products)) {
                        $tabs[$tag] = [
                            'slug' => $tag,
                            'name' => $data->title,
                            'products' => $tag_products['ids'],
                        ];
                    }
                }
            }
        ?>

        <div class="container">
            <div class="wrapper article-md">

                <div class="inline full">
                    <div class="line">
                        <div class="h2">Лучшие предложения</div>
                        <div class="grow"></div>
                        <div class="tabs catalog-tabs">
                            <?php
                                $index = 0;
                                foreach($tabs as $slug => $data) {
                                    $tab_classes = ['tab', 'best-deals-tab'];
                                    $name = $data['name'];

                                    if(!$index) {
                                        $tab_classes[] = 'active';
                                    }

                                    $tab_classes = implode(' ', $tab_classes);

                                    echo '<div class="' . $tab_classes . '" data-key="' . $slug . '">' . $name . '</div>';

                                    $index++;
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="best-deals-content">
                    <?php
                        $index = 0;
                        foreach($tabs as $slug => $data) {
                            $style = '';
                            $name = $data['name'];
                            $products = $data['products'];

                            if($index) {
                                $style = 'style="display: none"';
                            }

                            echo '<div class="catalog" data-key="' . $slug . '" ' . $style . '>';

                            foreach($products as $id) {
                                echo product($id);
                            }

                            echo '</div>';

                            $index++;
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    */ ?>

    <?php /* ?>
    <section class="section-padding home-news bordered">
        <div class="container">
            <div class="wrapper article-md">
                <div class="inline full">
                    <div class="line">
                        <div class="h2 title-with-icon">Последние новости</div>
                        <div class="grow"></div>
                        <a href="/news/" class="subtitle">Все новости</a>
                    </div>
                </div>

                <div class="news-slider">
                    <div class="swiper-wrapper">
                        <?php
                            $args = array(
                                'post_type'         => 'news',
                                'post_status'       => 'publish',
                                'posts_per_page'    => 5,
                            );

                            $query = new WP_Query($args);
                            
                            if ( $query->have_posts() ) :
                                while ( $query->have_posts() ) : $query->the_post();

                                get_template_part( 'template-parts/content', 'news' );

                            endwhile;
                            
                            endif;
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php */ ?>

    <?php
        global $wpdb;
        $reviews = $wpdb->get_col("SELECT `id` FROM `init_reviews` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 6");

        if(!empty($reviews)) {
    ?> 
        <section class="reviews section-padding bordered">
            <div class="container">
                <div class="wrapper article-md">
                    <div class="inline full">
                        <div class="line">
                            <div class="h2 title-with-icon">Отзывы о покупке цветов в г. <?php echo CITY; ?></div>
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

    <?php if (in_array(CITY_SLUG,NEIGHBORING_CITIES)) { ?>
        <section>
            <div class="container all-bm article information-block neighboring-cities">
                <div class="row">
                    <h2 class="h1 large">Мы также работаем в городах</h2>
                </div>
                <div class="row neighboring-cities-items">
                    <?php
                    $url = get_site_url();
                    $url = explode('//', $url)[1];
                    $url = explode('.', $url);
                    $url = [$url[count($url) - 2], $url[count($url) - 1]];
                    $url = implode('.', $url);
                    foreach(NEIGHBORING_CITIES as $slug) {
                        if(!empty(CITIES[$slug])) {
                            $data = CITIES[$slug];
                            $name = $data['name'];
                            $item_classes = ['underline'];
                            $pre = '';

                            if($slug == CITY_SLUG) {
                                continue;
                            }

                            if($slug) {
                                $pre = $slug . '.';
                            }

                            $item_classes = implode(' ', $item_classes);
                            echo '<a href="https://' . $pre . $url . '/" class="' . $item_classes . '">' . $name . '</a> ';
                        }
                    } ?>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php if (!CITY_SLUG) { ?>
    <section>
        <div class="container all-bm article information-block neighboring-cities">
            <div class="row">
                <h2 class="h1 large">Доставляем на все станции метро</h2>
            </div>
            <div class="row neighboring-cities-items">
                <?php
                $metro_array = get_metro();
                $url = get_site_url();
                $url = explode('//', $url)[1];
                $url = explode('.', $url);
                $url = [$url[count($url) - 2], $url[count($url) - 1]];
                $url = implode('.', $url);
                foreach($metro_array as $slug => $metro) {
                    $name = $metro[0];
                    $m_url = $metro[1];
                    echo '<a class="underline" href="/metro-' . $m_url . '/">' . $name . '</a> ';
                } ?>
            </div>
        </div>
    </section>
    <?php } ?>

    <?php if (!CITY_SLUG) { ?>
        <section>
            <div class="container all-bm article information-block neighboring-cities">
                <div class="row">
                    <h2 class="h1 large">Доставляем по всем районам Москвы</h2>
                </div>
                <div class="row neighboring-cities-items">
                    <?php
                    $areas_array = get_areas();
                    $url = get_site_url();
                    $url = explode('//', $url)[1];
                    $url = explode('.', $url);
                    $url = [$url[count($url) - 2], $url[count($url) - 1]];
                    $url = implode('.', $url);
                    foreach($areas_array as $slug => $area) {
                        $name = $area[0];
                        $a_url = $area[1];
                        echo '<a class="underline" href="/area-' . $a_url . '/">' . $name . '</a> ';
                    } ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
        $blocks = [
            [
                [
                    'type' => 'text',
                    'title' => 'Заказать доставку цветов в [city_genitive]',
                    'text' => '<p>Цветы &ndash; один из самых распространенных и приятных подарков для женщин. Казалось бы, это несколько разноцветных или монотонных растений, собранных в один букет, но сколько радости он может подарить. И у каждой женщины&nbsp;свои предпочтения. Благо сейчас флористика в [city_genitive] развита на таком уровне, что удается покрывать все дамские запросы. Мужчинам остается выбрать из большого&nbsp;ассортимента&nbsp;и заказать классический букет из цветов или интересный вариант из клубники и свежих растений.</p>
<p>Однако, перед теми, кто уже окончательно выбрал подарок, встает другая&nbsp;задача: &ldquo;Каким образом букет лучше доставить своей любимой?&rdquo; Стараясь ответить на вопрос, возникает два основных варианта развития событий: &ldquo;Купить цветы лично или заказать доставку в [city_genitive]?&rdquo; Здесь конечно ситуация у всех индивидуальная, но мы, опираясь на наш опыт работы, можем заявить, что вариант с доставкой цветов в [city_genitive], как минимум, более удобен, а также имеет преимущества перед самостоятельной покупкой букета в магазине.</p>',
                ],
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-1.webp'
                ],
            ],
            [
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-2.webp'
                ],
                [
                    'type' => 'text',
                    'title' => 'Почему лучше заказать доставку цветов, чем покупать их самому?',
                    'text' => '<p>Проработав немалое время и доставив много&nbsp;заказов в [city_genitive] и остальных городах России, мы смогли четко для себя определить несколько факторов, по которым считаем доставку&nbsp;более удобной и выгодной. Предлагаем и вам с ними ознакомиться:</p>
<ul>
<li><strong>Экономия времени.&nbsp;</strong>Вы можете вызвать курьера, оставшись при этом дома с близкими или заказать букет, находясь на работе, чтобы не посещать цветочный магазин. Такой способ сэкономит вам время.&nbsp;</li>
<li><strong>Скорость доставки&nbsp;товаров&nbsp;</strong>нашими курьерами не позволит вам разочароваться. Время, которое пройдет от оставленной на нашем сайте заявки до итогового получения букета, не превышает 30 минут, вне зависимости от того, где именно в [city_genitive] вы находитесь. Привезем ваши цветы точно в срок!</li>
<li><strong>Доставка абсолютно бесплатна.&nbsp;</strong>Наша компания, в отличие от других цветочных компаний в [city_genitive], не устанавливает цену на доставку. Не важно, заказали ли вы один небольшой букет или цветы в коробке с большим плюшевым медведем, доставка в любой дом или офис в [city_genitive] ничего не стоит.</li>
</ul>',
                ],
            ],
            [
                [
                    'type' => 'text',
                    'title' => '',
                    'text' => '
                    <ul>
<li><strong>Огромный ассортимент,&nbsp;</strong>которого нет ни в одной цветочной лавке, также является&nbsp;преимуществом при заказе через доставку. Ассортимент букетов из цветов и клубники, а также других подарков в нашем каталоге&nbsp;настолько велик, что располагать такой магазин пришлось бы в огромном помещении с постоянно высокой проходимостью. На аренду такого помещения нам бы пришлось тратить большие деньги, а значит и сами цветы стоили бы намного дороже. Сейчас же все растения&nbsp;находятся в одном из складов в [city_genitive], откуда удобно развозить букеты во все районы и поддерживать температурный режим.&nbsp;</li>
<li><strong>Необычные букеты, </strong>о которых не раз спрашивали наши клиенты появились в каталоге. Мы предлагаем в подарок букеты из клубники и другие сладкие композиции на выбор.</li>
<li><strong>Функциональность&nbsp;</strong>нашего сервиса открывает перед вами множество возможностей, недоступных или крайне неудобных при осуществлении самостоятельной покупки цветов в [city_genitive]. Например, вы можете заказать доставку не только в течение&nbsp;полутора часов, но и на любые другие дату или время. Также, при оформлении заказа на дом, можно указать, чтобы курьер не раскрывал имя заказчика (то есть вас), таким образом сделав приятный комплимент или признание девушки в роли тайного незнакомца. Оплата заказа происходит различным способом&nbsp;(можно уточнить во время оплаты самого заказа или&nbsp;у менеджера на сайте).</li>
</ul>',
                ],
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-3.webp'
                ],
            ],
            [
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-6.webp'
                ],
                [
                    'type' => 'text',
                    'title' => '',
                    'text' => '
                    <ul>
<li><strong>Работаем круглосуточно.&nbsp;</strong>Придется сильно постараться, чтобы найти магазин цветов в [city_genitive], работающий в ночное время, ведь людей, готовых самостоятельно прийти ночью за цветами, очень мало. Мы же доставляем цветы в [city_genitive], а значит желающих заказать их ночью достаточно для круглосуточной работы. Время доставки ночью из-за отсутствия пробок будет несколько меньше.</li>
<li><strong>Заказывайте из любого места.&nbsp;</strong>Ваше присутствие при получении не обязательно. У нас есть много клиентов, которые радуют своих дам цветами, будучи в дальней командировке или где-либо еще. Такой подарок особенно неожиданный, поэтому положительные эмоции при его получении многократно увеличиваются.</li>
<li><strong>Гарантия получения.&nbsp;</strong>Если вас лично не будет дома при доставке цветов, то можете не переживать на этот счет. Наш курьер&nbsp;сделает фотоотчет с цветами и получателем, а затем отправит его на ваш телефон. Если никого не окажется дома (так иногда бывает при сюрпризах), то мы оформим бесплатную доставку цветов повторно.</li>
</ul>',
                ],
            ],
            [
                [
                    'type' => 'text',
                    'title' => 'Выводы',
                    'text' => '
<p>Это часть самых распространенных опций, выполнение которых мы гарантируем каждому своему клиенту. Надеемся мы смогли донести до вас основной принцип доставки цветов и букетов. Главная&nbsp;цель нашей компании -&nbsp;максимальное упрощение процесса выбора подарка, его заказа и транспортировки до конечного получателя. Мы тщательно продумали систему категорий и поиска конкретных растений&nbsp;или других декоративных товаров и их оформлений и&nbsp;постарались сделать самый быстрый сервис по заказу и доставке букетов&nbsp;в Москве&nbsp;и в&nbsp;других городах России. Удостовериться в этом можно просто почитав много&nbsp;положительных отзывов&nbsp;в специальном разделе. Отзыв может оставить каждый, заказывавший цветы, букеты из клубники и другие подарки в нашем магазине. Мы изучаем каждый из них и стараемся учесть все пожелания.</p>
<p>Выбор и заказ букетов -&nbsp;достаточно непростая&nbsp;задача, особенно когда&nbsp;цветы покупались самостоятельно. Однако, спрос на доставку&nbsp;букетов&nbsp;в силу своей выгоды постепенно набирает обороты. Реже встречаются лавки, способные&nbsp;предложить большой&nbsp;ассортимент цветов и удовлетворить запросы покупателя. Выбор же цветов через интернет происходит&nbsp;быстрее&nbsp;и удобнее, а выгодные условия доставки заставляют все чаще делать свой выбор в пользу этого&nbsp;способа. Надеемся этот материал помог разобраться в выборе между доставкой цветов и самостоятельной их покупкой, а мы&nbsp;постараемся предоставить вам цветы и букеты, которые понравятся и впечатлят ваших любимых женщин.</p>',
                ],
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-5.webp'
                ],
            ],
        ];

        print_blocks($blocks);
    ?>


<?php
get_footer();