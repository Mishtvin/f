<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package init
 */

$url = get_site_url();
$length = substr_count($url, '.');

if($length == '2') {
	$url = explode('://', $url);
	$url = explode('.', $url[1]);
	$slug = $url[0];

	if(empty(CITIES[$slug])) {
		status_header(404);
		die();
	}
}

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('?', $request);
$request = $exploded[0];
$last_char = substr($request, -1);
$url = explode('?', $request);
$url = $url[0];
$url = explode('/', $url);
$url = array_diff($url, array(''));
$length = count($url);
$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
$slug = !empty($url[$length]) ? $url[$length] : '';

if($slug == 'products') {
	wp_redirect('/product/', 301);
}

if($last_char != '/' && !is_404()) {
	$request .= '/';

	if(!empty($exploded[1])) {
		$request .= '?' . $exploded[1];
	}

	wp_redirect($request, 301);
}

$show = false;

$pages = [
	'product',
	'about',
	'how',
	'delivery-and-payment',
	'return',
	'warranty',
	'contacts',
	'reviews',
];

if(is_front_page()) {
	$show = true;
} elseif($slug == 'chereshnya' || $slug == 'ezhevika' || $slug == 'golubika' || $slug == 'malina') {
    $show = false;
}
else if (is_archive() || is_single()) {
	$show = true;
} else if (strpos($_SERVER['REQUEST_URI'], 'metro-') !== false) {
	$show = true;
} else if (strpos($_SERVER['REQUEST_URI'], 'area-') !== false) {
    $show = true;
} else {
	foreach($pages as $page) {
		if(is_page($page)) {
			$show = true;
		}
	}
}

if(!$show) {
	define('META_NOINDEX', '	<meta name="robots" content="noindex">');
} else {
	define('META_NOINDEX', '');
}

$found = false;
$tag = '';
$product_slug = !empty($args['product']) ? $args['product'] : '';
$meta_type = !empty($args['meta_type']) ? $args['meta_type'] : '';

if(is_tax()) {
	$tag = 'catalog';
} else if (strpos($_SERVER['REQUEST_URI'], 'metro-') !== false) {
	$tag = 'metro';
} else if (strpos($_SERVER['REQUEST_URI'], 'area-') !== false) {
    $tag = 'area';
} else if (is_single()) {
	$tag = 'single';
} else if (is_archive()) {
    $tag = 'product';
}else if (is_archive()) {
	$tag = 'product';
} else if (is_front_page()) {
	$tag = 'front';
} else {
	$id = get_the_ID();
	$tag = basename(get_permalink($id));
}

if($meta_type && strpos($_SERVER['REQUEST_URI'], 'metro-') === false) {
	$tag = $meta_type;
} elseif ($meta_type && strpos($_SERVER['REQUEST_URI'], 'area-') === false) {
    $tag = $meta_type;
}

$check = !empty(PAGE_META[$tag]);

if($check) {
	$meta = [];

	$item_data = PAGE_META[$tag]['default'];
	$page_title = do_shortcode($item_data['title']);
	$description = do_shortcode($item_data['description']);
	$page_title = str_replace('"', '&quot;', $page_title);
	$description = str_replace('"', '&quot;', $description);

    if($tag == 'taxonomy') {
        $taxonomy_text_data = taxonomy_text_data($slug);
        if($taxonomy_text_data) {
            if(!empty($taxonomy_text_data->meta_title)) {
                $page_title = do_shortcode($taxonomy_text_data->meta_title);
            }
            if(!empty($taxonomy_text_data->meta_description)) {
                $description = do_shortcode($taxonomy_text_data->meta_description);
            }
        }
    }

	$modified = get_the_modified_date(DATE_W3C);

	$url = 'https://' . $_SERVER['SERVER_NAME'];

	if($_SERVER['REQUEST_URI'] != '/') {
		$url .= $_SERVER['REQUEST_URI'];
	} else {
		$url .= '/';
	}

	$image = 'https://' . $_SERVER['SERVER_NAME']. '/wp-content/themes/init/img/about-1.webp';
	$image_w = 900;
	$image_h = 900;
	$type = 'image/webp';

	$meta[] = '	<meta name="description" content="' . $description . '" />';
	$meta[] = '';

	if(!empty(META_NOINDEX)) {
		$meta[] = META_NOINDEX;
		$meta[] = '';
	}

	$meta[] = '	<meta property="og:locale" content="ru_RU" />';
	$meta[] = '	<meta property="og:type" content="website" />';
	$meta[] = '	<meta property="og:title" content="' . $page_title . '" />';
	$meta[] = '	<meta property="og:description" content="' . $description . '" />';
	$meta[] = '	<meta property="og:url" content="' . $url . '" />';
	$meta[] = '	<meta property="og:site_name" content="' . $_SERVER['SERVER_NAME'] . '" />';
//	$meta[] = '	<meta property="article:modified_time" content="' . $modified . '" />';
	$meta[] = '	<meta property="og:image" content="' . $image . '" />';
	$meta[] = '	<meta property="og:image:width" content="' . $image_w . '" />';
	$meta[] = '	<meta property="og:image:height" content="' . $image_h . '" />';
	$meta[] = '	<meta property="og:image:type" content="' . $type . '" />';
	$meta[] = '	<meta property="twitter:card" content="summary_large_image" />';
	$meta[] = '	<meta property="twitter:title" content="' . $page_title . '" />';
	$meta[] = '	<meta property="twitter:description" content="' . $description . '" />';
	$meta[] = '	<meta property="twitter:image" content="' . $image . '" />';
	$meta[] = "\n";

	$meta = implode("\n", $meta);

	define('TITLE', $page_title);
	define('DESCRIPTION', $description);
	define('META', $meta);

	function custom_document_title( $page_title ) {
		return TITLE;
	}
	add_filter( 'pre_get_document_title', 'custom_document_title', 10 );

	add_action( 'wp_head', 'append_head_meta', 1 );
	function append_head_meta(){
		echo META;
	}
} else {
	$meta = [];
	$page_title = get_the_title() . ' | Доставка цветов';

	$modified = get_the_modified_date(DATE_W3C);

	$url = 'https://' . $_SERVER['SERVER_NAME'];

	if($_SERVER['REQUEST_URI'] != '/') {
		$url .= $_SERVER['REQUEST_URI'];
	} else {
		$url .= '/';
	}

	$image = 'https://' . $_SERVER['SERVER_NAME']. '/wp-content/themes/init/img/about-1.webp';
	$image_w = 900;
	$image_h = 900;
	$type = 'image/webp';

	$meta[] = '';

	if(!empty(META_NOINDEX)) {
		$meta[] = META_NOINDEX;
		$meta[] = '';
	}

	$meta[] = '	<meta property="og:locale" content="ru_RU" />';
	$meta[] = '	<meta property="og:locale:alternate" content="en_US" />';
	$meta[] = '	<meta property="og:type" content="website" />';
	$meta[] = '	<meta property="og:title" content="' . $page_title . '" />';
	$meta[] = '	<meta property="og:url" content="' . $url . '" />';
	$meta[] = '	<meta property="og:site_name" content="' . $_SERVER['SERVER_NAME'] . '" />';
	$meta[] = '	<meta property="og:image" content="' . $image . '" />';
	$meta[] = '	<meta property="og:image:width" content="' . $image_w . '" />';
	$meta[] = '	<meta property="og:image:height" content="' . $image_h . '" />';
	$meta[] = '	<meta property="og:image:type" content="' . $type . '" />';
	$meta[] = '	<meta property="twitter:card" content="summary_large_image" />';
	$meta[] = '	<meta property="twitter:title" content="' . $page_title . '" />';
	$meta[] = '	<meta property="twitter:image" content="' . $image . '" />';
	$meta[] = "\n";

	$meta = implode("\n", $meta);
	
	define('TITLE', $page_title);
	define('DESCRIPTION', '');
	define('META', $meta);

	function custom_document_title( $page_title ) {
		return TITLE;
	}
	add_filter( 'pre_get_document_title', 'custom_document_title', 10 );

	add_action( 'wp_head', 'append_head_meta', 1 );
	function append_head_meta(){
		echo META;
	}
}

/////

define('CART', cartInfo(CITY_SLUG));
define('FAV', favInfo());

$cart = CART['cart'];
$filtred_cart = new stdClass();

if(!empty($cart)) {
    foreach($cart as $item) {
        $item['title'] = str_replace('"', '\"',$item['title']);
        $filtred_cart->{$item['slug']} = $item;
    }
}

$additionalClasses = [];

if(is_page('cart') || is_page('success')) {
	$additionalClasses[] = 'grey';
}

$additionalClasses = implode(' ', $additionalClasses);

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/init/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/init/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="194x194" href="/wp-content/themes/init/favicons/favicon-194x194.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/wp-content/themes/init/favicons/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/init/favicons/favicon-16x16.png">
	<link rel="manifest" href="/wp-content/themes/init/favicons/site.webmanifest">
	<link rel="mask-icon" href="/wp-content/themes/init/favicons/safari-pinned-tab.svg" color="#ea47bf">
	<link rel="shortcut icon" href="/wp-content/themes/init/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#ea47bf">
	<meta name="msapplication-TileImage" content="/wp-content/themes/init/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="/wp-content/themes/init/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') == false): ?>
    <script async src="https://www.google.com/recaptcha/api.js?render=6Le6nHUkAAAAAInNvruFlH4CFiikb9QiriPNxFOR"></script>
	<?php endif; ?>
	<?php wp_head(); ?>

	<?php
		$canonical = get_site_url() . $_SERVER['REQUEST_URI'];
		$canonical = explode('?', $canonical);
		$canonical = $canonical[0];

		if(strpos($canonical, '/page/') || is_paged()) {
			$canonical = explode('page', $canonical);
			$canonical = $canonical[0];
		}

		echo '<link rel="canonical" href="' . $canonical . '" />' . "\n";

		if(is_front_page() || is_page('reviews')) {
			echo '	';
			print_rating(get_the_ID());
		}

		if($product_slug) {
			echo '	';
			print_product_rating($product_slug);
		}
	?>

	<script>
		window.userId = <?php echo USER['id']; ?>;
		window.username = '<?php echo USER['user_name']; ?>';
		window.minPrice = <?php echo get_min_price() ?>;
		window.cur = '<?php echo CUR ?>';
		window.city = '<?php echo CITY_SLUG ?>';
		window.cart = <?php echo wp_json_encode($filtred_cart)?>;
		window.promo = <?php echo wp_json_encode(CART['promo']) ?>;
	</script>

    <?php if (!DEV_MODE): ?>
		<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') == false): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-9TVFM4ZC73"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());
        gtag("config", "G-9TVFM4ZC73");
        </script>
        <!-- Google tag (gtag.js) -->

        <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5N2MGDT');</script>
        <!-- End Google Tag Manager -->
		<?php endif; ?>
    <?php endif; ?>
</head>

<body <?php body_class($additionalClasses); ?>>
<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') == false): ?>
	<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5N2MGDT"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>	
	<header id="masthead" class="site-header">
		<div class="top-header hide-md hide-sm">
			<div class="container">
				<div class="wrapper">
					<div class="left-block">
						<div class="select-city open-popup" data-popup="select-city-popup">
							<div class="icon bold-icon icon-place"></div>
							<div class="current"><?php echo CITY; ?></div>
							<div class="arrow bold-icon icon-down"></div>
						</div>

						<?php
							wp_nav_menu( array(
								'theme_location'    => 'top',
								'container'         => 'nav',
								'menu_class'        => 'primary-menu'
							) );
						?>
					</div>

					<div class="right-block">
						<?php if(!empty(SOCIAL)) { ?>
							<div class="social">
								<?php
									foreach(SOCIAL as $key => $link) {
										echo '<a href="' . $link . '" rel="nofollow" target="_blank" class="icon-' . $key . '"></a>';
									}
								?>
							</div>
						<?php } ?>

						<div class="actions">
							<?php if(current_user_can('administrator')) { ?>
								<a href="<?php echo PRE_LINK ?>/dashboard/" class="icon-avatar bold-icon action">Личный кабинет</a>
							<?php } else { ?>
								<a href="<?php echo PRE_LINK ?>/dashboard/" class="icon-lock bold-icon action"><?= __('Войти/Регистрация', 'init'); ?></a>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="middle-header hide-md hide-sm">
			<div class="container">
				<div class="wrapper">
					<div class="logo-wrapper">
						<?php the_logo(); ?>
					</div>

					<?php get_search_form(); ?>

					<div class="open-popup btn" data-popup="request-popup">Заказать звонок</div>

					<div class="phone-block">
						<div class="phone-wrapper">
                            <?php get_template_part('template-parts/header/phones', 'desktop'); ?>
                        </div>
					</div>

					<div class="actions">
						<a href="<?php echo PRE_LINK ?>/fav/" data-count="<?php echo FAV['quantity'] ?>" class="fav-btn fav-quantity-data icon-fav"></a>
						<a href="<?php echo PRE_LINK ?>/cart/" data-count="<?php echo CART['quantity'] ?>" class="cart-btn icon-cart cart-quantity-data"></a>
					</div>
				</div>
			</div>
		</div>

		<div class="bottom-header hide-md hide-sm">
			<div class="container">
				<div class="wrapper">
					<?php
						wp_nav_menu( array(
							'theme_location'    => 'primary',
							'container'         => 'nav',
							'menu_class'        => 'primary-menu'
						) );
					?>
				</div>
			</div>
		</div>

		<div class="mobile-header hide-lg">
			<div class="container">
				<div class="wrapper">
					<div class="mobile-menu-btn">
						<span></span>
						<span></span>
						<span></span>
					</div>
					
					<?php the_logo() ?>

					<div class="right-block">
						<div class="city open-popup" data-popup="select-city-popup"><span class="icon icon-place"></span><span class="name"><?php echo CITY; ?></span></div>
						<div class="actions">
							<div class="icon-search toggle-search"></div>
							<a href="<?php echo PRE_LINK ?>/cart/" data-count="<?php echo CART['quantity'] ?>" class="cart-btn icon-cart cart-quantity-data"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="search-wrapper">
			<div class="container">
				<div class="wrapper">
					<?php get_search_form() ?>
				</div>
			</div>
		</div>
	</header>

	<div class="fixed-header hide-md hide-sm">
		<div class="container">
			<div class="wrapper">
				<div class="logo-wrapper">
					<?php the_logo(); ?>
				</div>

				<?php get_search_form(); ?>

				<div class="phone-block">
					<div class="phone-wrapper">
                        <?php get_template_part('template-parts/header/phones', 'desktop'); ?>
					</div>
				</div>

				<div class="actions">
					<a href="<?php echo PRE_LINK ?>/fav/" data-count="<?php echo FAV['quantity'] ?>" class="fav-btn fav-quantity-data icon-fav"></a>
					<a href="<?php echo PRE_LINK ?>/cart/" data-count="<?php echo CART['quantity'] ?>" class="cart-btn icon-cart cart-quantity-data"></a>
				</div>
			</div>
		</div>
	</div>

	<?php /* ?>
	<div class="fixed-btns">
		<a href="<?php echo PRE_LINK ?>/cart/" class="icon-cart"></a>
		<a href="<?php echo PRE_LINK ?>/fav/" class="icon-fav"></a>
	</div>
	<?php */ ?>

	<div class="mobile-menu hide-lg">
		<div class="mobile-menu-wrapper">

			<div class="mobile-menu-body">
				<div class="sep"></div>
				<div class="contacts article">
					<div class="h5">Контактные данные</div>
					<div class="article-sm">
                        <?php get_template_part('template-parts/header/phones', 'mobile'); ?>
						<a href="mailto:<?php echo EMAILS[0]; ?>" class="contacts-item icon-email bold-icon"><?php echo EMAILS[0]; ?></a>
						<?php
							if(!empty(ADDRESS)) {
								echo '<div class="contacts-item icon-place bold-icon">' . ADDRESS . '</div>';
							}
						?>
						<div class="open-popup btn" data-popup="request-popup">Заказать звонок</div>
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
				<div class="sep"></div>
				<?php

					if(is_user_logged_in()) {
						echo '<nav>';
						dashboard_menu();
						echo '</nav>';
						echo '<div class="sep"></div>';
					}

					wp_nav_menu( array(
						'theme_location'    => 'mobile',
						'container'         => 'nav',
						'menu_class'        => 'primary-menu'
					) );
				?>
				<div class="sep"></div>
				<nav>
					<ul>
						<li class="item open-popup" data-popup="select-city-popup"><span class="icon icon-place"></span> <?php echo CITY; ?></li>
						<?php if(!is_user_logged_in()) { ?>
						<li><a href="<?php echo PRE_LINK ?>/login/"><span class="icon icon-avatar"></span> <?= __('Войти/Регистрация', 'init'); ?></a></li>
						<?php } ?>
						<li><a href="<?php echo PRE_LINK ?>/cart/"><span class="icon icon-cart"></span> Корзина <div class="count cart-quantity"><?php echo CART['quantity'] ?></div></a></li>
						<li><a href="<?php echo PRE_LINK ?>/fav/"><span class="icon icon-fav"></span> Избранные <div class="count fav-quantity"><?php echo FAV['quantity'] ?></div></a></li>
					</ul>
				</nav>
				<div class="sep"></div>
			</div>

		</div>
	</div>

	<div class="push-notifications"></div>

	<main id="content" class="site-content">