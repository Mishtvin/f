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
                'type' => 'taxonomy',
                'slug' => 'rozy'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'bukety'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'korziny-s-cvetami'
            ],
            [
                'type' => 'taxonomy',
                'slug' => 'cvety-v-korobke'
            ],
			[
                'type' => 'tag',
                'slug' => 'akcii'
            ]
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
                                        <div class="h2">' . $title . ' в районе '.AREA_NAME.'</div>
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


    <?php
        $blocks = [
            [
                [
                    'type' => 'text',
                    'title' => 'Почему Flowlove - лучший выбор для заказа цветов в районе [area_name]?',
                    'text' => '
                        <ul>
                            <li><b>Большой выбор.</b> Букеты на любой вкус и бюджет. У нас всегда есть что подарить, будь то большой роскошный букет или небольшой симпатичный подарок.</li>
                            <li><b>Удобство заказа.</b> Все заказы на цветы можно оформить напрямую на сайте в несколько кликов, и вам не нужно выходить из дома. Если у вас возникнут вопросы при оформлении заказа, то наша команда клиентского сервиса всегда готова помочь вам по любым вопросам.</li>
                            <li><b>Доставка курьером.</b> Мы осуществляем доставку цветов прямо к двери вашего получателя в районе [area_name]. Курьер быстро и надежно доставит букет цветов в удобное для вас время, и вы можете быть уверены, что подарок прибудет в сохранности.</li>
                        </ul>
                        <p>Мы приглашаем вас воспользоваться нашей услугой и порадовать своих близких в районе [area_name] города Москвы красивым и стильным букетом цветов.</p>
                    ',
                ],
                [
                    'type' => 'image',
                    'url' => '/wp-content/themes/init/img/home-1.webp'
                ],
            ]
        ];

        print_blocks($blocks);
    ?>


<?php
get_footer();