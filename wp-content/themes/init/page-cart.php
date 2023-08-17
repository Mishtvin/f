<?php
/**
 * Template Name: Cart Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
page_header();
if (isset($_SESSION['cart_florist_comment']) && !empty($_SESSION['cart_florist_comment'])) {
    $florist_comment = $_SESSION['cart_florist_comment'];
} else {
    $florist_comment = '';
}
?>
    <section class="cart section-padding pb">
        <div class="container">
            <div class="wrapper">

                <div class="cart-body article-bg">
                    

                    <?php if(!is_user_logged_in()) { ?>
                        <div class="message-block">
                            <div class="avatar icon-gift"></div>
                            <div class="message-block-content">
                                <div class="title">Бесплатный промокод</div>
                                <div class="text">Зарегистрируйтесь на сайте и получите персональный промокод на <b>скидку 5%</b></div>
                                <div class="text"><a href="/login"><?= __('Войти/Регистрация', 'init'); ?></a></div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="cart-products-block article-md">
                        
                        <div class="inline full">
                            <div class="line">
                                <div class="h2 block-title">Товары в корзине <div class="count cart-quantity"><?php echo CART['quantity'] ?></div></div>
                                <div class="grow hide-sm hide-md"></div>
                                <button class="btn outline medium clear-cart-btn hide-sm hide-md"><span class="text icon-error">Очистить корзину</span></button>
                            </div>
                        </div>

                        <div class="products cart-products">
                            <?php echo CART['cartItems'] ?>
                        </div>
                    </div>

                    <form class="checkout-form article-md">
                        <div class="h2">Форма заявки</div>
                        <input class="recaptcha_response" type="hidden" name="recaptcha_response" id="recaptchaResponseCart">
                        <div class="inputs-line">
                            <div class="line">
                                <div class="form-group article-sm full">
                                    <label for="order_name" class="label">Ваше имя <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Введите имя" class="name" id="order_name" value="">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_phone" class="label">Номер телефона <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Номер телефона" class="phone phone-mask" id="order_phone" value="">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_email" class="label">Email <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Введите email" class="email" id="order_email" value="">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_recipient_name" class="label">Имя получателя <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Имя получателя" class="recipient_name" id="order_recipient_name">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_recipient_phone" class="label">Номер получателя <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Номер получателя" class="recipient_phone phone-mask" id="order_recipient_phone">
                                    </div>
                                </div>

                                <div class="form-group article-sm full">
                                    <label for="order_address" class="label">Адрес доставки <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Адрес доставки" class="address" id="order_address">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_date" class="label">Дата доставки <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Дата доставки" class="date-mask delivery_date" id="order_date">
                                    </div>
                                </div>

                                <div class="form-group article-sm">
                                    <label for="order_time" class="label">Время доставки <span class="mark">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" placeholder="Время доставки" class="time-mask delivery_time" id="order_time">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="h6">Детали заказа</div>

                        <div class="inputs-line">
                            <div class="line">
                                <div class="form-group article-sm full">
                                    <label for="order_postcard" class="label">Текст для открытки (необязательно)</label>
                                    <div class="input-wrapper">
                                        <textarea id="order_postcard" cols="30" rows="3" class="resize postcard" placeholder="Текст для открытки" style="height: 104px;"></textarea>
                                    </div>
                                </div>

                                <div class="form-group article-sm full">
                                    <label for="order_message" class="label">Примечания к заказу (необязательно)</label>
                                    <div class="input-wrapper">
                                        <textarea id="order_message" cols="30" rows="3" class="resize message" placeholder="Примечания к заказу" style="height: 104px;"><?php echo $florist_comment; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="order-btn btn full"><span class="text">Оформить заказ</span></button>
                    </form>
                </div>

                <div class="cart-sidebar article">
                    <div class="h2">Ваш заказ</div>
                    <div class="params">
                        <div class="item">
                            <div class="title">Количество товаров</div>
                            <div class="value"><span class="cart-quantity"><?php echo CART['quantity'] ?></span> шт.</div>
                        </div>
                        <div class="item">
                            <div class="title">Стоимость</div>
                            <div class="value"><span class="cart-old-price"><?php echo formate(CART['oldPrice']) ?></span> <?php echo CUR ?></div>
                        </div>
                        <div class="item">
                            <div class="title">Скидка</div>
                            <div class="value"><span class="cart-discount"><?php echo formate(CART['discountVal']) ?></span> <?php echo CUR ?></div>
                        </div>
                        <div class="item">
                            <div class="title">Доставка <span class="underline open-popup" data-popup="select-city-popup"><?php echo CITY; ?></span></div>
                            <div class="value">Бесплатно</div>
                        </div>
                        <div class="item total">
                            <div class="title">Итого</div>
                            <div class="value"><span class="cart-price"><?php echo formate(CART['price']) ?></span> <?php echo CUR ?></div>
                        </div>
                    </div>
                    <hr>

                    <div class="article-sm">
                        <div class="h5">Промокод</div>
                        <div class="promo-wrapper"><?php echo CART['promoForm'] ?></div>
                    </div>
                    <hr>

                    <div class="article-sm">
                        <div class="h5">Способ оплаты</div>
                        <div class="text-grey">Оплатить ваш заказ вы можете любым удобным для Вас способом: Банковской картой ( Visa, MasterCard, МИР ), Альфа банк, Электронной платежной системой Qiwi-кошелек, Юмани</div>
                    </div>
                    <hr>

                    <div class="article-sm">
                        <div class="text">Ваши личные данные будут использоваться для обработки ваших заказов, упрощения вашей работы с сайтом и для других целей, описанных в нашей <a href="<?php echo PRE_LINK ?>/privacy-policy/">политика конфиденциальности</a>.</div>
                    </div>
    
                    <button class="btn order-btn full large"><span class="text">Оформить заказ</span></button>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
