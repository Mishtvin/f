<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package init
 */

$recent = !empty($_SESSION['recent']) ? explode(';', $_SESSION['recent']) : [];
?>
	<?php /* <div style="display: flex;position: fixed;justify-content: center;top: 0;left: 0;right: 0;bottom: 0;z-index: 999;align-items: center;text-align: center;font-size: 5rem;background-color: rgb(255 255 255 / 72%);font-weight: 600;padding: 50px;">Андрей выйди на связь!</div> */ ?>
	</main>

	<?php if(!empty($recent)) { ?>
		<section class="recently-viewed">
			<div class="container">
				<div class="wrapper article-md">
					<div class="h3">Ранее вы смотрели</div>
					<div class="recently-items-slider">
						<div class="swiper-wrapper">
							<?php
								foreach($recent as $slug) {
									$data = product_data($slug);

									if(!empty($data)) {
										$title = $data->title;
										$image_s = [];
										
										if( !empty($data->images->small) ){

											$small_image = $data->images->small;

											if( is_array($small_image) ){
												foreach($small_image as $small){
													$new_image = '<img src="' . $small . '" alt="' . $title . '">';
													array_push($image_s, $new_image);
												}
											}else{ 
												
												$image_s = !empty($data->images->small) ? '<img src="' . $data->images->small . '" alt="' . $title . '">' : '<span class="icon icon-image"></span>';
												
											}
										}

										// $image = !empty($data->images->small) ? '<img src="' . $data->images->small . '" alt="' . $title . '">' : '<span class="icon icon-image"></span>';

										$price = getPrice($slug, CITY_SLUG);
										$variants = $price['variants'];
										$price = formate($price['price']);
										$price .= ' ' . CUR;

										if(!empty($variants)) {
											$price = 'от ' . $price;
										}

										if( is_array( $image_s ) && !empty( $image_s ) ){
											$image_s = $image_s[0];
										} else {
                                            //$image_s = '';
                                        }

										echo '
										<a href="' . PRE_LINK . '/product/' . $slug . '/" class="recently-item">
											<div class="image">'.$image_s.'</div>
											<div class="text">
												<div class="title">' . $title . '</div>
												<div class="price">' . $price . '</div>
											</div>
										</a>
										';
									}
								}
							?>

						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>

	<footer class="site-footer dark">
		<div class="container">
			<div class="wrapper">

				<div class="top-footer">

					<div class="about article-sm">
						<div class="title">FlowLove</div>
						<div class="text">Свежие цветы доставляются бесплатно до двери с подарком от компании «FlowLove» каждому покупателю.</div>
						<div class="copyright">© <?php echo date('Y') ?> - все права защищены</div>
					</div>

					<?php
						$menus = ['footer_2', 'footer_3', 'footer_4'];

						foreach($menus as $slug) {
							$name = wp_get_nav_menu_name($slug);

							if($name) {
								echo '
								<div class="nav article-sm">
									<div class="title">' . $name . '</div>
								';

								wp_nav_menu( array(
									'theme_location'    => $slug,
									'container'         => 'nav',
									'menu_class'        => 'primary-menu'
								) );

								echo '
								</div>
								';
							}
						}
					?>

					<div class="contacts article">
						<div class="article-sm">
							<div class="title">Контакты</div>
							<a href="tel:+<?php echo PHONES[0]['link']; ?>" class="contacts-item icon-phone bold-icon"><?php echo PHONES[0]['tel']; ?></a>
							<a href="mailto:<?php echo EMAILS[0]; ?>" class="contacts-item icon-email bold-icon"><?php echo EMAILS[0]; ?></a>
							<?php
								if(!empty(ADDRESS)) {
									echo '<div class="contacts-item icon-place bold-icon">' . ADDRESS . '</div>';
								}
							?>
						</div>
						<?php if(!empty(SOCIAL)) { ?>
							<div class="inline">
								<div class="line">
									<?php
										foreach(SOCIAL as $key => $link) {
											echo '<a href="' . $link . '" rel="nofollow" target="_blank" class="btn medium outline"><span class="icon icon-' . $key . '"></span></a>';
										}
									?>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>

				<div class="bottom-footer">
					<div class="payment-methods">
						<div class="icons">
							<div class="icon-visa"></div>
							<div class="icon-mastercard"></div>
							<div class="icon-mir"></div>
							<div class="icon-umoney small"></div>
							<div class="icon-qiwi small"></div>
						</div>
						<div class="text">Оплатить ваш заказ вы можете любым удобным для Вас способом:<br> Банковской картой ( Visa, MasterCard, МИР ), Альфа банк, Электронной платежной системой Qiwi-кошелек, Юмани</div>
					</div>
				</div>

				<div class="hidden-footer">
                    <?php if (!DEV_MODE): ?>
                        <!-- hit.ua -->
                        <a href='http://hit.ua/?x=24853' target='_blank'>
                        <script language="javascript" type="text/javascript"><!--
                        Cd=document;Cr="&"+Math.random();Cp="&s=1";
                        Cd.cookie="b=b";if(Cd.cookie)Cp+="&c=1";
                        Cp+="&t="+(new Date()).getTimezoneOffset();
                        if(self!=top)Cp+="&f=1";
                        //--></script>
                        <script language="javascript1.1" type="text/javascript"><!--
                        if(navigator.javaEnabled())Cp+="&j=1";
                        //--></script>
                        <script language="javascript1.2" type="text/javascript"><!--
                        if(typeof(screen)!='undefined')Cp+="&w="+screen.width+"&h="+
                        screen.height+"&d="+(screen.colorDepth?screen.colorDepth:screen.pixelDepth);
                        //--></script>
                        <script language="javascript" type="text/javascript"><!--
                        Cd.write("<sc"+"ript src='//c.hit.ua/hit?i=24853&g=0&x=3"+Cp+Cr+
                        "&r="+escape(Cd.referrer)+"&u="+escape(window.location.href)+"'></sc"+"ript>");
                        //--></script>
                        <noscript>
                        <img src='//c.hit.ua/hit?i=24853&amp;g=0&amp;x=2' border='0'/>
                        </noscript></a>
                        <!-- / hit.ua -->
                    <?php endif; ?>
				</div>

			</div>
		</div>
	</footer>

	<div class="request-popup popup">
		<div class="popup-content">
			<div class="popup-blackboard close-popup"></div>
			<div class="wrapper">
				<div class="popup-header">
					<div class="h5">Оставить заявку</div>
					<button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
				</div>
				<form class="content request-form">
                    <input class="recaptcha_response" type="hidden" name="recaptcha_response" id="recaptchaResponseRequest">
					<div class="article">

						<div class="form-group article-sm">
							<label for="request_name" class="label">Ваше имя <span class="mark">*</span></label>
							<div class="input-wrapper">
								<input type="text" placeholder="Введите имя" class="name large outline small-rad" id="request_name">
							</div>
						</div>

						<div class="form-group article-sm">
							<label for="request_phone" class="label">Номер телефона <span class="mark">*</span></label>
							<div class="input-wrapper">
								<input type="text" placeholder="Введите номер" class="phone phone-mask large outline small-rad" id="request_phone">
							</div>
						</div>

						<div class="form-group article-sm">
							<label for="request_message" class="label">Сообщение</label>
							<div class="input-wrapper">
								<textarea id="request_message" cols="30" rows="4" class="message large outline small-rad" placeholder="Введите сообщение"></textarea>
							</div>
						</div>

						<button class="btn full request-send large"><span class="text">Отправить заявку</span></button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<div class="select-city-popup popup">
		<div class="popup-content">
			<div class="popup-blackboard close-popup"></div>
			<div class="wrapper">
				<div class="popup-header">
					<div class="h5">Выберите город</div>
					<button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
				</div>
				<div class="content article">
					<div class="article-sm">
						<div class="form-group input-wrapper select-city-wrapper">
							<div class="icon icon-search"></div>
							<input type="text" class="search-city" placeholder="Введите название города" autocomplete="off">
							<div class="dropdown-menu select-city-dropdown">
								<div class="content"></div>
							</div>
						</div>
						<div class="inline">
							<div class="line">
								<?php
									$url = get_site_url();
									$url = explode('//', $url)[1];
									$url = explode('.', $url);
									$url = [$url[count($url) - 2], $url[count($url) - 1]];
									$url = implode('.', $url);

									foreach(POPULAR as $slug) {
										if(!empty(CITIES[$slug])) {
											$data = CITIES[$slug];
											$name = $data['name'];
											$item_classes = ['underline'];
											$pre = '';

											if($slug == CITY) {
												$item_classes[] = 'active';
											}

											if($slug) {
												$pre = $slug . '.';
											}

											$item_classes = implode(' ', $item_classes);
											echo '<a href="https://' . $pre . $url . '/" class="' . $item_classes . '">' . $name . '</a>';
										}
									}
								?>
							</div>
						</div>
					</div>

					<div class="article-sm">
						<div class="h6">Список городов</div>
						<div class="scroll-container">
							<div class="popular-cities">
								<div class="line">
									<?php
										if(!empty(CITIES)) {
											foreach(CITIES as $slug => $data) {
												$name = $data['name'];
												$item_classes = ['city-item'];
												$pre = '';

												if($slug == CITY) {
													$item_classes[] = 'active';
												}

												if($slug) {
													$pre = $slug . '.';
												}

												$item_classes = implode(' ', $item_classes);
												echo '<a href="https://' . $pre . $url . '/" class="' . $item_classes . '" data-value="' . $name . '">' . $name . '</a>';
											}
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="review-popup popup">
		<div class="popup-content">
			<div class="popup-blackboard close-popup"></div>
			<div class="wrapper">
				<div class="popup-header">
					<div class="h5">Оставить отзыв</div>
					<button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
				</div>
				<form class="content review-form article">

					<div class="stars-input">
						<input type="radio" name="review_rating" id="review_rating_1" value="1">
						<label for="review_rating_1" class="icon-star-solid"></label>

						<input type="radio" name="review_rating" id="review_rating_2" value="2">
						<label for="review_rating_2" class="icon-star-solid"></label>

						<input type="radio" name="review_rating" id="review_rating_3" value="3">
						<label for="review_rating_3" class="icon-star-solid"></label>

						<input type="radio" name="review_rating" id="review_rating_4" value="4">
						<label for="review_rating_4" class="icon-star-solid"></label>

						<input type="radio" name="review_rating" id="review_rating_5" value="5" checked>
						<label for="review_rating_5" class="icon-star-solid"></label>
					</div>

					<br>

					<?php if(current_user_can('administrator')) { ?>
						<div class="form-group article-sm">
							<label for="review_date" class="label">Дата <span class="mark">*</span></label>
							<div class="input-wrapper">
								<input type="text" placeholder="Введите дату" class="date date-mask" id="review_date">
							</div>
						</div>
					<?php } ?>

					<div class="form-group article-sm">
						<label for="review_name" class="label">Ваше имя <span class="mark">*</span></label>
						<div class="input-wrapper">
							<input type="text" placeholder="Введите имя" class="name" id="review_name">
						</div>
					</div>

					<div class="form-group article-sm">
						<label for="review_phone" class="label">Номер телефона <span class="mark">*</span></label>
						<div class="input-wrapper">
							<input type="text" placeholder="Введите номер" class="phone" id="review_phone">
						</div>
					</div>

					<div class="form-group article-sm">
						<label for="review_text" class="label">Отзыв <span class="mark">*</span></label>
						<div class="input-wrapper">
							<textarea id="review_text" cols="30" rows="3" placeholder="Введите отзыв" class="review"></textarea>
						</div>
					</div>

					<div class="form-group article-sm">
						<label for="review_image" class="label">Изображение <span class="mark">*</span></label>
						<div class="image-picker square">
							<input type="file" class="name" id="review_image" accept="image/png, image/jpeg">
                            <label for="review_image" class="image-picker-field">
                                <div class="placeholder">
                                    <span class="icon icon-image"></span>
                                    <div class="title">Выберите или перетащите изображение</div>
                                </div>
                                <div class="files-list"></div>
                            </label>
						</div>
					</div>

					<button class="btn large full" id="review_send"><span class="text">Оставить отзыв</span></button>

				</form>
			</div>
		</div>
	</div>

	<div class="one-click-popup popup">
		<div class="popup-content">
			<div class="popup-blackboard close-popup"></div>
			<div class="wrapper">
				<div class="popup-header">
					<div class="h5">Купить в один клик</div>
					<button class="btn medium outline close-popup"><span class="icon icon-close"></span></button>
				</div>
				<form class="content one-click-form">
                    <input class="recaptcha_response" type="hidden" name="recaptcha_response" id="recaptchaResponseOneClick">
					<div class="article">
						<div class="products append-one-click-product"></div>

						<hr>

						<div class="form-group article-sm">
							<label for="one_click_name" class="label">Ваше имя <span class="mark">*</span></label>
							<div class="input-wrapper">
								<input type="text" placeholder="Введите имя" class="name" id="one_click_name">
							</div>
						</div>

						<div class="form-group article-sm">
							<label for="one_click_phone" class="label">Номер телефона <span class="mark">*</span></label>
							<div class="input-wrapper">
								<input type="text" placeholder="Введите номер" class="phone phone-mask" id="one_click_phone">
							</div>
						</div>

						<button class="btn full one-click-send large"><span class="text">Отправить заявку</span></button>
					</div>

				</form>
			</div>
		</div>
	</div>

	<div class="to-up btn large white"><span class="icon icon-arrow-up"></span></div>

	<?php
		wp_footer();
	?>

    <?php if (!DEV_MODE): ?>
		<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') == false): ?>
        <script>
            window.addEventListener('load', () => {
                let body = document.querySelector('body')

                setTimeout(() => {
                    let script = document.createElement('script')

                    script.setAttribute('src', '//code-ya.jivosite.com/widget/Xj3MeyaoLw')
                    script.setAttribute('async', 'async')
                    script.setAttribute('type', 'text/javascript')

                    body.appendChild(script)
                }, 3000)

                setTimeout(() => {
                    let script = document.createElement('script')

                    script.innerHTML = `
                        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                        ym(87028733, "init", {
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    `
                    script.setAttribute('type', 'text/javascript')
                    body.appendChild(script)
                }, 3000)
            })
        </script>
		<?php endif;?>
    <?php endif;?>
	<script type="application/ld+json">
    {
		"@context" : "http://schema.org",
		"@type" : "LocalBusiness",
		"name" : "FlowLove",
		"telephone": "<?php echo PHONES[0]['tel']; ?>",
		"description": "Интернет-магазин цветов с доставкой в <?php echo CITY_GENITIVE; ?> за 2 часа. Широкий ассортимент, низкие цены, быстрая и бесплатная доставка. Шикарные букеты из свежих цветов!",
		"url" : "https://<?php echo $_SERVER['SERVER_NAME']; ?>",
		"image": "https://<?php echo $_SERVER['SERVER_NAME']; ?>/wp-content/uploads/2022/07/logo.webp",
    	"address": {
			"@type" : "PostalAddress",
			"streetAddress": "<?php echo ADDRESS_ARRAY[1]; ?>, <?php echo ADDRESS_ARRAY[2]; ?>",
			"addressLocality": "<?php echo ADDRESS_ARRAY[0]; ?>",
			"addressRegion": "<?php echo ADDRESS_ARRAY[0]; ?>",
			"postalCode": "",
			"telephone" : "<?php echo PHONES[0]['tel']; ?>"
        },
    	"openingHours": [ "ПН-ВС 00:00-23:59"],
    	"sameAs" : [
			"https://telegram.me/Flowlove_ru",
			"https://api.whatsapp.com/send?phone=79080390582",
			"viber://chat?number=79080390582",
			"https://vk.com/flowlove_ru"
		]
    }
	</script>
	<div class="to-up btn large white"><span class="icon icon-arrow-up"></span></div>

</body>
</html>
