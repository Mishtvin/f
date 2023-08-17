<?php
/**
 * Template Name: Success Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */
global $wpdb;

$type = !empty($_GET['type']) ? $_GET['type'] : 'simple';
$token = !empty($_SESSION['last_order_token']) ? $_SESSION['last_order_token'] : '';

if($token) {
    $order = $wpdb->get_row("SELECT * FROM init_orders WHERE token = '$token'");

    if(empty($order)) {
        $type = 'simple';
    }
} else {
    $type = 'simple';
}

get_header();
while ( have_posts() ) : the_post();

if($type == 'simple') {
?>  
    <section class="success section-padding">
        <div class="container">
            <div class="wrapper article">
                <div class="icon icon-success"></div>

                <div class="article-sm">
                    <h1 class="h4"><?php the_title(); ?></h1>
                    <div class="content article-sm grey-text">
                        <?php the_content(); ?>
                    </div>
                </div>

                <a href="<?php echo PRE_LINK ?>/" class="btn outline"><span class="text">На главную</span></a>
            </div>
        </div>
    </section>

<?php }else { ?>
    <?php page_header(); ?>
    <section class="bill section-padding pb">
        <div class="container">
            <div class="wrapper article-bg">
                <div class="article-sm bordered">
                    <div class="h5">Спасибо за заказ</div>
                    <p>Ваш заказ был принят. Наши менеджеры свяжутся с вами в ближайшее время.</p>
                    <p>Если у вас возникнут какие-то вопросы, пожалуйста, позвоните по телефону
                    <?php foreach (PHONES as $phone): ?>
                        <a href="tel:<?= $phone['link']?>"><?=$phone['tel']?></a>
                    <? endforeach; ?>
                    </p>
                </div>
                <?php
                    if(!empty($order)) {
                        $id = $order->id;
                        $phone = $order->phone;
                        $email = $order->email;
                        $address = $order->address;
                        $price = $order->price;
                        $quantity = $order->quantity;
                        $products = getProducts($order->products);
                        $date = date('d.m.Y H:i', strtotime($order->date));
                        $status = $order->status;
                        $title_classes = $status ? 'icon-success green-theme' : 'icon-time orange-theme';
            
                        $info = [
                            'id' => 'ID',
                            'price' => 'Стоимость',
                            'discount' => 'Скидка',
                            'promo' => 'Промокод',
                            'price' => 'Стоимость',
                            'quantity' => 'Количество',
                            'date' => 'Дата',
                            'phone' => 'Номер телефона',
                            'email' => 'Email',
                            'address' => 'Адрес',
                        ];
            
                        $items = [];
            
                        foreach($info as $key => $label) {
                            $value = $order->{$key};
            
                            if($value) {
                                if($key == 'date') {
                                    $value = date('d.m.Y (H:i)', strtotime($value));
                                }else if($key == 'price') {
                                    $value = formate($value) . ' ' . CUR;
                                }else if($key == 'discount') {
                                    $value = $value . '%';
                                }else if($key == 'quantity') {
                                    $value = $value . ' шт.';
                                }else if($key == 'id') {
                                    $value = '#' . $value;
                                }
            
                                $items[] = '
                                <div class="article-mc text-item">
                                    <div class="label">' . $label . '</div>
                                    <div class="text">' . $value . '</div>
                                </div>
                                ';
                            }
            
                        }
            
                        $items = implode('', $items);
            
                        if($items) {
                            $items = '
                            <div class="article">
                                <div class="h6">Информация</div>
                                <div class="inline large">
                                    <div class="line">' . $items . '</div>
                                </div>
                            </div>
                            ';
                        }
    
                        echo $items;
    
                        echo '<hr><div class="products outline">' . $products . '</div>';
                    }
                ?>
            </div>
        </div>
    </section>
<?php }
endwhile;
get_footer();