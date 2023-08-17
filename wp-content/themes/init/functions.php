<?php
/**
 * init functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package init
 */
// Регистрация сессии
// Отключить отображение всех ошибок и предупреждений
error_reporting(0);
ini_set('display_errors', 0);

function register_session(){

	if( !session_id() ){
		session_start();
		session_write_close();
	}
}
add_action('init', 'register_session');

// Удаление сессии
function destroy_session() {
    if ( session_id() ) {
        session_destroy();
    }
}
add_action( 'wp_logout', 'destroy_session' );

function write_session($key, $value) {
	session_start();
	$_SESSION[$key] = $value;
	session_write_close();
}

function unset_session($key) {
	session_start();
	unset($_SESSION[$key]);
	session_write_close();
}
/////

define('PAGE_META', [
	'front' => [
		'default' => [
			'title' => 'Доставка цветов в город [city] | Купить цветы в [city_genitive] круглосуточно',
			'description' => 'Интернет-магазин цветов с доставкой в [city_genitive] за 2 часа. Широкий ассортимент, низкие цены, быстрая и бесплатная доставка. Шикарные букеты из свежих цветов!',
		],
	],
	'product' => [
		'default' => [
			'title' => 'Товары | Доставка цветов в [city_genitive]',
			'description' => ''
		]
	],
	'flowers' => [
		'default' => [
			'title' => 'О цветах | Доставка цветов в [city_genitive]',
			'description' => ''
		]
	],
	'taxonomy' => [
		'default' => [
			'title' => '[taxonomy] | Купить цветы недорого в [city_genitive]',
			'description' => 'Купить [taxonomy] в [city_genitive] | Цветы недорого в Интернет Магазине - FlowLove',
		]
	],
    'metro' => [
        'default' => [
            'title' => 'Доставка цветов и букетов в р-н метро [metro_name] - от компании FlowLove',
            'description' => 'Доставка букетов и цветов к станции метро [metro_name]. Доставка в течение 2 часов, низкие цены, быстрая и бесплатная доставка. Шикарные букеты из свежих цветов!',
        ]
    ],
    'area' => [
        'default' => [
            'title' => 'Доставка цветов и букетов в район [area_name] города Москвы - от компании FlowLove',
            'description' => '
            Доставка букетов и цветов в район [area_name] города Москвы. Доставка в течение 2 часов, низкие цены, быстрая и бесплатная доставка. Шикарные букеты из свежих цветов!',
        ]
    ],
	'tag' => [
		'default' => [
			'title' => '[tag] | Купить цветы недорого в [city_genitive]',
			'description' => 'Купить [tag] в [city_genitive] | Цветы недорого в Интернет Магазине - FlowLove',
		]
	],
	'single_product' => [
		'default' => [
			'title' => 'Купить [product] в [city_genitive] за [price] | Быстрая доставка цветов',
			'description' => '[product_description]',
		]
	],
	'about' => [
		'default' => [
			'title' => 'О магазине FlowLove.ru в [city_genitive], низкие цены.',
			'description' => 'О магазине FlowLove.ru в [city_genitive]. Большой опыт во флористике, индивидуальный подход. Доставка, самовывоз.'
		]
	],
	'delivery-and-payment' => [
		'default' => [
			'title' => 'Доставка и оплата цветов в [city_genitive], магазин FlowLove.ru',
			'description' => 'Доставка и оплата цветов в [city_genitive], интернет-магазин FlowLove.ru. Доставка в точный срок, оплата наличными, картой, через интернет.'
		]
	],
	'return' => [
		'default' => [
			'title' => 'Возврат и замена букета - интернет-магазин FlowLove.ru в [city_genitive]',
			'description' => 'Возврат и замена букета - интернет-магазин FlowLove.ru в [city_genitive]. Индивидуальный подход к покупателям, рассмотрение и решение всех проблем.'
		]
	],
	'warranty' => [
		'default' => [
			'title' => 'Гарантия на высокое качество цветов от FlowLove.ru в [city_genitive]',
			'description' => 'Гарантия на высокое качество цветов в [city_genitive], цветочный интернет-магазин FlowLove.ru. Доставка свежих растений на дом.'
		]
	],
	'contacts' => [
		'default' => [
			'title' => 'Контакты | Контактная информация - Интернет магазин цветов в [city_genitive]',
			'description' => 'Контактная информация интернет магазина с доставкой цветов FlowLove в [city_genitive]. Работаем круглосуточно'
		]
	],
	'reviews' => [
		'default' => [
			'title' => 'Отзывы клиентов о нашем магазине цветов в [city_genitive]',
			'description' => 'Отзывы клиентов о доставке цветов от FlowLove и о нашей компании. Доставка свежих цветов до дома в [city_genitive]'
		]
	],
	'flower' => [
		'default' => [
			'title' => '[flower_title] в [city_genitive]',
			'description' => '[flower_description]',
		]
	],
    'how' => [
        'default' => [
            'title' => 'Как оформить заказ | Доставка цветов в [city_genitive]',
            'description' => '',
        ]
    ]
]);

/////

add_rewrite_tag( '%city%', '([^/]+)', 'city=' );

$get_cities = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/cities.json';
$get_cities = file_get_contents($get_cities);
define('RAW_CITIES', $get_cities);
$get_cities = json_decode(RAW_CITIES, true);

define('CITIES', $get_cities);
define('POPULAR', [
	'',
	'spb',
	'novosibirsk',
	'ekaterinburg',
	'kazan',
	'nizhniy-novgorod',
	'chelyabinsk',
	'samara',
	'omsk',
	'rostov-na-donu',
]);
define('NEIGHBORING_CITIES', [
    '',
    'sergiev-posad',
    'yaroslavl',
    'kostroma',
    'ivanovo',
    'suzdal',
    'vladimir',
    'aprelevka',
    'balashiha',
    'beloozersky',
    'bronnitsy',
    'vidnoe',
    'voskresensk',
    'golicino',
    'dedovsk',
    'dzerzhinsky',
    'dmitrov',
    'dolgoprudnyi',
    'dubna',
    'egorevsk',
    'zhukovsky',
    'zvenigorod',
    'ivanteevka',
    'istra',
    'kashira',
    'klim',
    'kolomna',
    'kotelniki',
    'krasnoarmeysk',
    'krasnogorsk',
    'krasnoznamensk',
    'kurovskoe',
    'lobnya',
    'lukhovitsy',
    'lytkarino',
    'lyubertsy',
    'mozhajsk',
    'mytishchi',
    'naro-fominsk',
    'odincovo',
    'ozeri',
    'orekhovo-zuevo',
    'pavlovskij-posad',
    'podolsk',
    'pushkino',
    'ramenskoe',
    'reutov',
    'sergiev-posad',
    'serpuhov',
    'staraya-kupavna',
    'stupino',
    'fryazino',
    'khimki',
    'chekhov',
    'elektrogorsk',
    'electrostal',
    'yakhroma',
]);
//define('MIN_PRICE', 1500);


define( 'PHONES', get_option( 'phones', [
	[
		'tel' => '+7 987 319-88-04',
		'link'	=> unmask_phone('+7 987 319-88-04')
	]
] ) );

function get_min_price() {
    $minPrice = (int) get_option('min_price');

    return $minPrice ?? 1500;
}

function get_cities() {
	echo json_encode(CITIES);
	die();
}
add_action('wp_ajax_get_cities', 'get_cities');
add_action('wp_ajax_nopriv_get_cities', 'get_cities');

function get_city_slug() {
	$url = get_site_url();
	$url = explode('://', $url);
	$url = explode('.', $url[1]);
	$slug = $url[0];

	$res = '';

	if(!empty(CITIES[$slug])) {
		$res = $slug;
	}

	return $res;
}

function get_city() {
	$slug = get_city_slug();
	$res = CITIES['']['name'];

	if(!empty(CITIES[$slug])) {
		$res = CITIES[$slug]['name'];
	}

	return $res;
}

function get_city_genitive() {
	$slug = get_city_slug();
	$res = CITIES['']['genitive'];

	if(!empty(CITIES[$slug])) {
		$res = CITIES[$slug]['genitive'];
	}

	return $res;
}

function get_metro_info() {
    if (str_contains($_SERVER['REQUEST_URI'], 'metro-') !== false) {
        $metro_url = str_replace('metro-','', $_SERVER['REQUEST_URI']);
        $metro_url = str_replace('/','', $metro_url);
        $metro_array = get_metro();
        $current_metro = $metro_array[$metro_url];
        return $current_metro;
    } else {
        return false;
    }
}

function get_metro_name() {
    $data = get_metro_info();
    return $data[0];
}
function get_metro_slug() {
    $data = get_metro_info();
    return $data[1];
}

function get_area_info() {
    if (str_contains($_SERVER['REQUEST_URI'], 'area-') !== false) {
        $area_url = str_replace('area-','', $_SERVER['REQUEST_URI']);
        $area_url = str_replace('/','', $area_url);
        $area_array = get_areas();
        $current_area = $area_array[$area_url];
        return $current_area;
    } else {
        return false;
    }
}

function get_area_name() {
    $data = get_area_info();
    return $data[0];
}
function get_area_slug() {
    $data = get_area_info();
    return $data[1];
}

function get_address() {
	$slug = get_city_slug();
	$res = '';

	if(!empty(CITIES[$slug])) {
		$res = !empty(CITIES[$slug]['address']) ? CITIES[$slug]['address'] : '';
	}

	return $res;
}

function get_address_array() {
	$slug = get_city_slug();
	$res = '';

	if(!empty(CITIES[$slug])) {
		$res = !empty(CITIES[$slug]['address']) ? CITIES[$slug]['address'] : '';
		$res = explode(',', $res);
	}

	return $res;
}

function get_domain() {
	$url = $_SERVER['SERVER_NAME'];
	$url = explode('.', $url);
	$length = count($url);
	$url = implode('.', [$url[$length - 2], $url[$length - 1]]);

	return $url;
}
$metro_info = get_metro_info();
define('CITY', get_city());
define('CITY_GENITIVE', get_city_genitive());
define('CITY_SLUG', get_city_slug());
if (str_contains($_SERVER['REQUEST_URI'], 'metro-') !== false) {
    define('METRO_NAME', get_metro_name());
    define('METRO_SLUG', get_metro_slug());
}
if (str_contains($_SERVER['REQUEST_URI'], 'area-') !== false) {
    define('AREA_NAME', get_area_name());
    define('AREA_SLUG', get_area_slug());
}
define('ADDRESS', get_address());
define('ADDRESS_ARRAY', get_address_array());
define('DOMAIN', get_domain());

add_shortcode( 'store_address', function() {
	if(!empty(ADDRESS)) {
		return '<div><b>Адрес магазина</b>: ' . ADDRESS . '</div>';
	}
});

// if(CITY_SLUG) {
// 	$pre_link = '/' . CITY_SLUG;
// } else {
// 	$pre_link = '';
// }
$pre_link = '';

define('PRE_LINK', $pre_link);

add_shortcode( 'city', 'get_city' );
add_shortcode( 'city_genitive', 'get_city_genitive' );
add_shortcode( 'city_slug', 'get_city_slug' );
add_shortcode( 'metro_slug', 'get_metro_slug' );
add_shortcode( 'metro_name', 'get_metro_name' );
add_shortcode( 'area_slug', 'get_area_slug' );
add_shortcode( 'area_name', 'get_area_name' );
add_shortcode( 'address', 'get_address' );
add_shortcode( 'domain', 'get_domain' );

//////

add_shortcode('taxonomy', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$taxonomy = taxonomy_data($slug);

	return $taxonomy->title;
});

add_shortcode('tag', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$tag = tag_data($slug);

	return $tag->title;
});

//////

add_shortcode('product', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$product = product_data($slug);

	return $product->title;
});

add_shortcode('flower_title', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$flower = flower_data($slug);

	return !empty($flower->meta_title) ? do_shortcode($flower->meta_title) : '';
});

add_shortcode('flower_description', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$flower = flower_data($slug);

	return !empty($flower->meta_description) ? do_shortcode($flower->meta_description) : '';
});

add_shortcode('product_description', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$product = product_data($slug);
	$string = ['Заказать [product] в [city_genitive]'];
	$flowers = product_flowers($slug);
	$description = $product->description;

	if(!empty($flowers)) {
		$row = [];

		foreach($flowers as $flower_slug) {
			$flower_data = flower_data($flower_slug);
			$row[] = $flower_data->title;
		}

		$row = implode(', ', $row);

		$string[] = $row;
	}

	if (!empty($description)) {
		$description = str_replace("\n", ' ', $description);
		$description = strip_tags($description);
		$string[] = $description;
	}

	if(count($string) > 1) {
		$string[0] .= '.';
	}

	$string[] = '🌹 Купить недорогие и свежие цветы в магазине FlowLove 💐';
	$string = implode(' ', $string);

	$string = do_shortcode($string);

	if(mb_strlen($string) > 240) {
		$string = mb_substr($string, 0, 240);
		$string .= '...';
	}

	return $string;
});

add_shortcode('price', function() {
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$length = count($url);
	$pre_link = !empty($url[$length - 1]) ? $url[$length - 1] : '';
	$slug = $url[$length];
	$product = product_data($slug);
	$price = getPrice($slug, CITY_SLUG, $product);

	return formate($price['price']) . ' ' . CUR;
});

//////

define('CUR', 'руб.');

function getTaxProducts() {
	$data = json_decode(file_get_contents('php://input'), true);
	$slug = $data['slug'];
	$city = $data['city'];

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->taxonomy_products;

	if(!empty($products->{$slug})) {
		$products = $products->{$slug};

		foreach($products as $product) {
			echo product($product, true);
		}
	}

	die();
}
add_action('wp_ajax_getTaxProducts', 'getTaxProducts');
add_action('wp_ajax_nopriv_getTaxProducts', 'getTaxProducts');

function get_taxonomis($args = []) {
	$parent = isset($args['parent']) ? $args['parent'] : '';
	$exclude = isset($args['exclude']) ? $args['exclude'] : '';
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->taxonomies;
	$filtred = [];

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->taxonomy_products;

	if($parent == 'all') {
		$filtred = $data;
	} else if ($parent) {
		foreach($data as $item) {
			$item->count = !empty($products->{$item->slug}) ? count($products->{$item->slug}) : 0;

			if($item->parent == $parent) {
				$filtred[] = $item;
			}
		}
	} else {
		foreach($data as $item) {
			$item->count = !empty($products->{$item->slug}) ? count($products->{$item->slug}) : 0;

			if($item->parent == '') {
				$filtred[] = $item;
			}
		}
	}

	if($exclude) {
		$new = [];

		foreach($filtred as $item) {
//			if($item->slug != $exclude) {
			if(!in_array($item->slug,$exclude)) {
				$new[] = $item;
			}
		}

		$filtred = $new;
	}

	return $filtred;
}

function get_archive_tags($args = []) {
	$parent = isset($args['parent']) ? $args['parent'] : '';
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tags.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->tags;
	$filtred = [];

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tag-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->tag_products;

	if($parent == 'all') {
		$filtred = $data;
	} else if ($parent) {
		foreach($data as $item) {
			$item->count = !empty($products->{$item->slug}) ? count($products->{$item->slug}) : 0;

			if($item->parent == $parent) {
				$filtred[] = $item;
			}
		}
	} else {
		foreach($data as $item) {
			$item->count = !empty($products->{$item->slug}) ? count($products->{$item->slug}) : 0;

			if($item->parent == '') {
				$filtred[] = $item;
			}
		}
	}

	return $filtred;
}

function taxonomy_data($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->taxonomies;
	$result = '';

	if(!empty($data->{$slug})) {
		$result = $data->{$slug};

		$root = '/wp-content/themes/init/catalog/images/catalog/';
		$path = $_SERVER['DOCUMENT_ROOT'] . $root;

		$images = new stdClass();

		$formates = ['.webp', '.jpeg', '.jpg', '.png'];
		$image_search = [
			'full' => '-full',
			'large' => '-large',
			'medium' => '-medium',
			'small' => '-thumbnail',
		];

		foreach($image_search as $key => $value) {
			$images->{$key} = '';

			foreach($formates as $ex) {
				$file = $path . $slug . $value . $ex;

				if(file_exists($file)) {
					$images->{$key} = $root . $slug . $value . $ex;
					break;
				}
			}
		}

		$result->images = $images;
	}

	return $result;
}

function taxonomy_text_data($slug) {
    $file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
    $data = file_get_contents($file);
    $data = json_decode($data);
    $data = $data->taxonomies;
    $result = '';

    if(!empty($data->{$slug})) {
        $result = $data->{$slug};
    }

    return $result;
}

function tag_data($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tags.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->tags;
	$result = '';

	if(!empty($data->{$slug})) {
		$result = $data->{$slug};

		$root = '/wp-content/themes/init/catalog/images/tag/';
		$path = $_SERVER['DOCUMENT_ROOT'] . $root;

		$images = new stdClass();

		$formates = ['.webp', '.jpeg', '.jpg', '.png'];
		$image_search = [
			'full' => '-full',
			'large' => '-large',
			'medium' => '-medium',
			'small' => '-thumbnail',
		];

		foreach($image_search as $key => $value) {
			$images->{$key} = '';

			foreach($formates as $ex) {
				$file = $path . $slug . $value . $ex;

				if(file_exists($file)) {
					$images->{$key} = $root . $slug . $value . $ex;
					break;
				}
			}
		}

		$result->images = $images;
	}

	return $result;
}

function product_tags($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-tags.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->product_tags;

	return !empty($products->{$slug}) ? $products->{$slug} : [];
}

function get_products($args = []) {
	$taxonomy = !empty($args['taxonomy']) ? $args['taxonomy'] : '';
	$rand = !empty($args['rand']) ? $args['rand'] : false;
	$order = !empty($args['order']) ? $args['order'] : false;
	$flower = !empty($args['flower']) ? $args['flower'] : '';
	$tag = !empty($args['tag']) ? $args['tag'] : '';
	$search = !empty($args['search']) ? mb_strtolower($args['search']) : '';
	$page = !empty($args['page']) ? intval($args['page']) : 1;
    $count = !empty($args['posts_per_page']) ? $args['posts_per_page'] : get_option( 'posts_per_page' );
	$start = $page - 1;
	$start = $start * $count;

	if(isset($args['start'])) {
		$start = $args['start'];
	}

	if(!empty($taxonomy)) {
		$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json';
		$data = file_get_contents($file);
		$data = json_decode($data);
		$data = $data->taxonomy_products;

		if(is_array($taxonomy)) {
			$results = [];

			foreach($taxonomy as $tax) {
				$items = !empty($data->{$tax}) ? $data->{$tax} : [];
				$results = array_merge($results, $items);
			}

		} else {
			$results = !empty($data->{$taxonomy}) ? $data->{$taxonomy} : [];
		}
	} else if ($flower) {
		$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/flower-products.json';
		$data = file_get_contents($file);
		$data = json_decode($data);
		$data = $data->flower_products;
		$results = !empty($data->{$flower}) ? $data->{$flower} : [];
	} else if($tag) {
		$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tag-products.json';
		$data = file_get_contents($file);
		$data = json_decode($data);
		$data = $data->tag_products;
		$results = !empty($data->{$tag}) ? $data->{$tag} : [];
	} else {
		$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products.json';
		$data = file_get_contents($file);
		$data = json_decode($data);
		$results = $data->products;
	}

	if($search) {
		$search = preg_replace('/[^а-яА-Я0-9№]/mu', '', $search);
		$filtred = [];

		foreach($results as $slug) {
		    if($slug == 'chereshnya' || $slug == 'ezhevika' || $slug == 'golubika' || $slug == 'malina') {
		        continue;
            }
			$data = product_data($slug, true);
			if (!empty($data->title)) {
                $title = preg_replace('/[^а-яА-Я0-9№]/mu', '', $data->title);
                $title = mb_strtolower($title);

                if(!empty($title) && $title == $search || mb_strripos($title, $search) !== false) {
                    $filtred[] = $slug;
                }
            }
		}

		$results = $filtred;
	}

	if($rand) {
		shuffle($results);
	}

    if ($order === 'new') {
        $results = array_reverse($results);
    }

	$pages = ceil(count($results) / $count);

	if(isset($args['start'])) {
		$count = ($page - $start) * $count;
	}

	$results = array_slice($results, $start, $count);

	$data = [
		'pages' => $pages,
		'page' => $page,
		'ids' => $results,
	];

	return $data;
}

function product_taxonomies($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-taxonomies.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->product_taxonomies;

	return !empty($products->{$slug}) ? $products->{$slug} : [];
}

function print_products($products) {
	foreach($products as $product) {
	    if($product == 'buketpofoto') {
	        continue;
        }
		echo product($product);
	}
}
function print_additional_products($products) {
    foreach($products as $product) {
        if($product == 'buketpofoto') {
            continue;
        }
        echo additional_product($product, true);
    }
}

function taxonomy_card($taxonomy) {
	$slug = $taxonomy->slug;
	$data = taxonomy_data($slug);
	$title = $taxonomy->title;
	$parent = $taxonomy->parent ? $taxonomy->parent . '/' : '';
	$count = $taxonomy->count;
	$image = !empty($data->images->medium) ? '<img src="' . $data->images->medium . '" loading="lazy" alt="' . $title . '" />' : '<div class="icon icon-image"></div>';
    if($count == 0) {
        return false;
    }
	if($count == 1) {
		$count .= ' товар';
	} else if ($count > 2 && $count < 5) {
		$count .= ' товара';
	} else {
		$count .= ' товаров';
	}

	return '
	<a href="' . PRE_LINK . '/catalog/' . $parent . $slug . '/" class="category">
		<div class="image">' . $image . '</div>
		<div class="title">' . $title . '</div>
		<div class="quantity">' . $count . '</div>
	</a>
	';
}

function product_data($slug, $simple = false, $to_array = false) {
	$slug = explode('.', $slug);
	$variant = !empty($slug[1]) ? $slug[1] : 0;
	$slug = $slug[0];
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products/' . $slug . '.json';

	if(file_exists($file)) {
		$data = file_get_contents($file);
		$data = json_decode($data, $to_array);

		if(!$simple) {
			global $wpdb;
			$root = '/wp-content/themes/init/catalog/images/products/';
			$path = $_SERVER['DOCUMENT_ROOT'] . $root;

			$images = new stdClass();

			$formates = ['.webp', '.jpeg', '.jpg', '.png'];
			$key_num = [0,1,2,3,4,5,6,7,8,9];
			$image_search = [
				'full' => '-full',
				'large' => '-large',
				'medium' => '-medium',
				'small' => '-thumbnail',
			];

			foreach($image_search as $key => $value) {
				$images->{$key} = [];

				foreach($formates as $ex) {

					foreach($key_num as $numk){
						$file_num = $path . $slug . '-' . $numk . $value . $ex;

						if(file_exists($file_num)){
							$images->{$key}[] = $root . $slug . '-' . $numk . $value . $ex;
						}
					}

					$file = $path . $slug . $value . $ex;

					if(file_exists($file)) {

						$images->{$key} = $root . $slug . $value . $ex;
						break;
					}
				}
			}

			$data->images = $images;

			$data->link = PRE_LINK . '/product/' . $slug . '/';

			$rating = 0;
			$reviews = 0;

			$rating_data = $wpdb->get_row("SELECT AVG(rating) as rating, COUNT(rating) as count FROM `init_rating` WHERE `product` = '$slug' AND `status` = 'approved'");

			if(!empty($rating_data)) {
				$rating = $rating_data->rating;
				$reviews = $rating_data->count;
			}

			$stars = [];

			for($i = 1; $i < 6; $i++) {
				if($rating >= $i) {
					$stars[] = '<li class="star active icon-star-solid"></li>';
				} else {
					$stars[] = '<li class="star icon-star-solid"></li>';
				}
			}

			$stars = implode('', $stars);
			$stars = '<ul class="star-rating">' . $stars . '</ul>';

			$data->rating = $rating;
			$data->reviews = $reviews;
			$data->stars = $stars;

			if($reviews == 1) {
				$data->reviews_label = "$reviews отзыв";
			} else if ($reviews > 1 && $reviews < 5) {
				$data->reviews_label = "$reviews отзыва";
			} else {
				$data->reviews_label = "$reviews отзывов";
			}
		}
	} else {
		$data = '';
	}

	return $data;
}

function getPrice($slug, $city = '', $data = '') {
	$slug = explode('.', $slug);
	$selected = !empty($slug[1]) ? (int)$slug[1] : 0;
	$slug = $slug[0];
	$product_taxonomies = product_taxonomies($slug);
	$sizes = [];

	if(in_array('rozy', $product_taxonomies) || in_array('bukety', $product_taxonomies)) {
		$sizes = [
			'малый' => [30, 55],
			'средний' => [35, 55],
			'большой' => [43, 55],
			'эксклюзивный' => [55, 55],
		];
	} else if (in_array('cvety-v-korobke', $product_taxonomies) || in_array('korziny-s-cvetami', $product_taxonomies)) {
		$sizes = [
			'малый' => [25, 40],
			'средний' => [30, 40],
			'большой' => [35, 40],
			'эксклюзивный' => [43, 40],
		];
	}

	if(!$data) {
		$data = product_data($slug);
	}

	$result = [
		'price' => 0,
		'old_price' => 0,
		'economy' => 0,
		'variants' => [],
		'type' => 'static',
		'selected' => $selected,
		'selectedKey' => '',
		'sizes' => $sizes
	];

	$price = (int)$data->price;
	$old_price = (int)$data->old_price;

	if(!empty($data->prices->{$city})) {
		$price =(int) $data->prices->{$city}->price;
		//$old_price = (int)$data->prices->{$city}->old_price;
	}

	if(!empty($data->variants)) {
		$result['type'] = 'min';

		$price = 0;
		$old_price = 0;

		$index = 0;
		foreach($data->variants as $key => $item) {
			$item_price = (int)$item->price;

			if(!empty($item->prices->{$city})) {
				$item_price = (int)$item->prices->{$city}->price;
			}

			if($index == $selected) {
				$price = $item_price;
				$result['selectedKey'] = $key;
			}

			$result['variants'][$key] = $item_price;
			$index++;
		}

	}

	$result['price'] = (int)$price;
	$result['old_price'] = (int)$old_price;

	if($old_price) {
		$result['economy'] = (int)$old_price - (int)$price;
	}

	return $result;
}

function product($slug, $add_to_cart = false) {
	$data = product_data($slug);

	if(!empty($data)) {
		$city = get_city_slug();
		$title = $data->title;
		$description = trim($data->description);
		$description = $description ? '<div class="description"><div class="content">' . $description . '</div></div>' : '';
		$price = getPrice($slug, $city, $data);
		$price_block = price_block($slug, $price, 'card');
		$link = PRE_LINK . '/product/' . $slug . '/';

		if( !empty($data->images->large) ){
			$large_image = $data->images->large;
			if(is_array($large_image)){
				foreach($large_image as $large){
					$image[] = '<img src="' . $large . '" alt="' . $title . '" loading="lazy">';
				}
			}else{
				$image = !empty($data->images->large) ? '<img src="' . $data->images->large . '" loading="lazy" alt="' . $title . '" />' : '<div class="icon icon-image"></div>';
			}
		} else {
			$image = '';
		}

		$is_fav = is_fav($slug) ? ' active' : '';
		$economy = $price['economy'] ? '<div class="tag orange solid small">Экономия: ' . formate($price['economy']) . ' ' . CUR . '</div>' : '';
		$tags = [];
		$taxonomies = product_taxonomies($slug);
		$available = '<div class="available green-theme icon-success">В наличии</div>';

		$btn = $add_to_cart ? '<div class="btn large add-to-cart" data-key="' . $slug . '"><span class="text">В корзину</span></div>' : '<a href="' . $link . '" class="btn large"><span class="text">В корзину</span></a>';
		$mobile_btn = $add_to_cart ? '<div class="btn add-to-cart" data-key="' . $slug . '"><span class="text">В корзину</span></div>' : '<a href="' . $link . '" class="btn"><span class="text">В корзину</span></a>';

		$one_click = '<button class="btn one-click large outline open-popup" data-popup="one-click-popup" data-key="' . $slug . '"><span class="text">В 1 клик</span></button>';
		$mobile_one_click = '<button class="btn one-click outline open-popup" data-popup="one-click-popup" data-key="' . $slug . '"><span class="text">В 1 клик</span></button>';

		if(!empty($data->disable)) {
			$btn = '<a href="' . $link . '" class="btn large"><span class="text">Подробнее</span></a>';
			$mobile_btn = '<a href="' . $link . '" class="btn"><span class="text">Подробнее</span></a>';

			$one_click = '<button class="btn one-click large outline" disabled><span class="text">В 1 клик</span></button>';
			$mobile_one_click = '<button class="btn one-click outline" disabled><span class="text">В 1 клик</span></button>';

			$available = '<div class="available red-theme icon-error">Нет в наличии</div>';
		}

		if($economy) {
			$tags[] = $economy;
		}

		if(!empty($tags)) {
			$tags = implode('', $tags);
			$tags = '<div class="tags"><div class="line">' . $tags . '</div></div>';
		} else {
			$tags = '';
		}

		if( !in_array('upakovka', $taxonomies) && !in_array('shariki', $taxonomies) && !in_array('igrushki', $taxonomies) && !in_array('otkrytka', $taxonomies) && !in_array('sladosti', $taxonomies) && !in_array('toppery', $taxonomies) ) {
			$stars = $data->stars;
		} else {
			$stars = '';
		}

		if(is_array($image)){
			$image = $image[0];
		}

		$structure = '
		<div class="product price-wrapper">
			' . $tags . '
			<button class="btn small medium add-to-fav fav-btn white' . $is_fav . '" data-id="' . $slug . '">
				<span class="icon icon-fav bold-icon"></span>
			</button>
			<div class="image-wrapper">
				<a href="' . $link . '" class="image">' . $image . '</a>
				' . $description . '
			</div>

			<div class="content-wrapper">
				<div class="product-meta">
					' . $available . '
					' . $stars . '
				</div>
				<a href="' . $link . '" class="title">' . $title . '</a>
				' . $price_block . '
				<div class="mobile-actions hide-lg hide-md">
					' . $mobile_btn . $mobile_one_click . '
				</div>
			</div>

			<div class="actions">
				' . $btn . $one_click . '
			</div>
		</div>
		';

		return $structure;
	}
}

function additional_product($slug, $add_to_cart = false) {
    $data = product_data($slug);

    if(!empty($data)) {
        $city = get_city_slug();
        $title = $data->title;
        $price = getPrice($slug, $city, $data);
        $price_block = price_block($slug, $price, 'card');
        $link = PRE_LINK . '/product/' . $slug . '/';

        if( !empty($data->images->large) ){
            $large_image = $data->images->large;
            if(is_array($large_image)){
                foreach($large_image as $large){
                    $image[] = '<img src="' . $large . '" alt="' . $title . '" loading="lazy">';
                }
            }else{
                $image = !empty($data->images->large) ? '<img src="' . $data->images->large . '" loading="lazy" alt="' . $title . '" />' : '<div class="icon icon-image"></div>';
            }
        } else {
            $image = '';
        }



        $taxonomies = product_taxonomies($slug);


        $btn = $add_to_cart ? '<div class="btn large add-to-cart" data-key="' . $slug . '"><span class="text">В корзину</span></div>' : '<a href="' . $link . '" class="btn large"><span class="text">В корзину</span></a>';
        $mobile_btn = $add_to_cart ? '<div class="btn add-to-cart" data-key="' . $slug . '"><span class="text">В корзину</span></div>' : '<a href="' . $link . '" class="btn"><span class="text">В корзину</span></a>';

        if(!empty($data->disable)) {
            $btn = '<a href="' . $link . '" class="btn large"><span class="text">Подробнее</span></a>';
            $mobile_btn = '<a href="' . $link . '" class="btn"><span class="text">Подробнее</span></a>';

        }


        if(is_array($image)){
            $image = $image[0];
        }

        $structure = '
		<div class="product price-wrapper add-to-cart" data-key="' . $slug . '">
			<div class="image-wrapper">
				' . $image . '
			</div>

			<div class="content-wrapper">
				<div class="title">' . $title . '</div>
				' . $price_block . '

			</div>
		</div>
		';

        return $structure;
    }
}

function formate($number){
	$number = intval($number);
	return number_format($number, 0, '', ' ');
}

function loadMore() {
	$data = json_decode(file_get_contents('php://input'), true);
	$search = !empty($data['search']) ? $data['search'] : '';
	$page = (int)$data['page'];
    $order = !empty($data['order']) ? $data['order'] : false; // new, rand
	$url = $data['url'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_diff($url, array(''));
	$slug = end($url);

	if($slug != 'products') {
		$taxonomy = taxonomy_data($slug);
		$tag = tag_data($slug);

		if(!empty($taxonomy)) {
			$products = get_products([
				'taxonomy' => $taxonomy->slug,
				'page' => $page,
				'search' => $search,
				'order' => $order,
			]);
		} else if (!empty($tag)) {
			$products = get_products([
				'tag' => $tag->slug,
				'page' => $page,
				'search' => $search,
                'order' => $order,
			]);
		} else {
			$slug = '';
			$products = get_products([
				'page' => $page,
				'search' => $search,
                'order' => $order,
			]);
		}
	} else {
		$slug = '';
		$products = get_products([
			'page' => $page,
			'search' => $search,
            'order' => $order,
		]);
	}

	if(!empty($products['ids'])) {
		print_products($products['ids']);
	}

	die();
}

add_action('wp_ajax_loadMore', 'loadMore');
add_action('wp_ajax_nopriv_loadMore', 'loadMore');

add_rewrite_rule('^catalog/([^/]+)/?', 'index.php?pagename=product', 'top');
add_rewrite_rule('^product/([^/]+)/?', 'index.php?pagename=product', 'top');
add_rewrite_rule('^tags/([^/]+)/?', 'index.php?pagename=product', 'top');
add_rewrite_rule('^flowers/([^/]+)/?', 'index.php?pagename=product', 'top');
add_rewrite_rule('^flowers/?', 'index.php?pagename=product', 'top');
add_rewrite_rule('^edit/?', 'index.php?pagename=edit', 'top');

add_rewrite_rule('login', 'index.php?pagename=auth', 'top');
add_rewrite_rule('register', 'index.php?pagename=auth', 'top');
add_rewrite_rule('restore', 'index.php?pagename=auth', 'top');

function fire_404() {
	global $wp_query;
	$wp_query->set_404();

	status_header( 404 );
	get_template_part( 404 );
	die();
}

/////

function dashboard_menu_items() {
	$data = [];
	$options = [
		[
			'icon' => 'avatar',
			'slug' => '',
			'name' => 'Личный кабинет'
		],
		[
			'icon' => 'edit',
			'slug' => 'edit-profile',
			'name' => 'Редактировать профиль'
		],
		[
			'icon' => 'history',
			'slug' => 'my-orders',
			'name' => 'Мои заказы'
		],
	];

	if(current_user_can('administrator')) {
		$options[] = [
			'icon' => 'cart',
			'slug' => 'add-product',
			'name' => 'Добавить товар'
		];
		 $options[] = [
        'icon' => 'cart',
        'slug' => 'update-prices',
        'name' => 'Обновить цены'
    ];
	}

	foreach($options as $item) {
		$name = $item['name'];
		$icon = $item['icon'];
		$slug = $item['slug'];
		$check_slug = $slug ? $slug : 'dashboard';
		$is_active = is_page($check_slug) ? ' class="active"' : '';
		$link = PRE_LINK . '/dashboard/';

		if($slug) {
			$link .= $slug . '/';
		}

		$data[] = '<li class="menu-item"><a href="' . $link . '"' . $is_active . '><span class="icon icon-' . $icon . '"></span><span class="text">' . $name . '</span></a></li>';
	}

	$data[] = '<li class="menu-item"><a href="' . wp_logout_url() . '"><span class="icon icon-error"></span><span class="text">Выйти</span></a></li>';
	$data = implode('', $data);
	return $data;
}

function dashboard_menu() {
	$data = '<ul>' . dashboard_menu_items() . '</ul>';

	echo $data;
}

function dashboard_sidebar(){
?>
	<div class="dashboard-sidebar hide-md hide-sm">
		<div class="user-block article">
			<div class="current-user">
				<div class="avatar"><?php echo mb_substr(USER['user_name'], 0, 1); ?></div>
				<div class="text">
					<div class="name"><?php echo USER['user_name']; ?></div>
					<div class="phone"><?php echo USER['email']; ?></div>
				</div>
			</div>
			<nav><?php dashboard_menu(); ?></nav>
		</div>
	</div>
<?php
}

function user_orders() {
	$user_id = USER['id'];
	$structure = [];

	global $wpdb;
	$orders = $wpdb->get_results("SELECT * FROM `init_orders` WHERE `user_id` = $user_id AND `status` != 2");

	if(!empty($orders)) {
		foreach($orders as $order){
			$id = $order->id;
			$address = $order->address;
			$quantity = $order->quantity;
			$products = getProducts($order->products, true);
			$price = $order->price;
			$date = date('d.m.Y H:i', strtotime($order->date));
			$status = $order->status;
			$title_classes = $status ? 'icon-success green-theme' : 'icon-time orange-theme';

			$info = [
				'name' => 'Имя',
				'phone' => 'Номер телефона',
				'email' => 'Email',
				'recipient_phone' => 'Номер получателя',
				'address' => 'Адрес',
				'delivery' => 'Дата доставки',
				'postcard' => 'Текст для открытки',
				'message' => 'Примечания к заказу',
				'promo' => 'Промокод',
				'discount' => 'Скидка',
			];

			$items = [];

			foreach($info as $key => $label) {
				$value = $order->{$key};

				if($value) {
					if($key == 'delivery') {
						$value = date('d.m.Y (H:i)', strtotime($value));
					}else if($key == 'discount'){
						$value = $value . '%';
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
				<div class="inline large">
					<div class="line">' . $items . '</div>
				</div>
				';
			}

			$structure[] = '
			<div class="order-item">
				<div class="order-top">
					<div class="content article">
						<div class="title h5 ' . $title_classes . '">Заказ #' . $id . '</div>
						<div class="inline">
							<div class="line">

								<div class="article-mc">
									<div class="label bm">Стоимость</div>
									<div class="h6">' . formate($price) . '₽</div>
								</div>

								<div class="sep"></div>

								<div class="article-mc">
									<div class="label bm">Количество</div>
									<div class="h6">' . $quantity . ' шт.</div>
								</div>

								<div class="sep"></div>

								<div class="article-mc">
									<div class="label bm">Дата</div>
									<div class="h6">' . $date . '</div>
								</div>

							</div>
						</div>
					</div>
					<button class="btn outline toggle-order"><span class="icon icon-down"></span></button>
				</div>
				<div class="order-dropdown article-md">
					' . $items . '
					<div class="products">' . $products . '</div>

				</div>
			</div>
			';
		}
	}

	if(empty($structure)){
		$structure[] = '
			<div class="empty-block">
				<span class="icon icon-inbox"></span>
				<h5>У вас пока нет заказов</h5>
			</div>
		';
	}

	$structure = implode('', $structure);
	echo $structure;
}

/////

function favInfo() {
	$fav = !empty($_SESSION['fav']) ? explode(';', $_SESSION['fav']) : [];
	$items = favItems();

	$data = [
		'fav' => $fav,
		'quantity' => count($fav),
		'items_structure' => $items['structure'],
		'items_data' => $items['data'],
	];
	return $data;
}

function axiosFavInfo() {
	echo json_encode(favInfo());

	die();
}
add_action('wp_ajax_axiosFavInfo', 'axiosFavInfo');
add_action('wp_ajax_nopriv_axiosFavInfo', 'axiosFavInfo');

function removeFromFav($id) {
	$fav = !empty($_SESSION['fav']) ? explode(';', $_SESSION['fav']) : [];
	$search = array_search($id, $fav);

	if($search !== false) {
		unset($fav[$search]);
	}

	if(!empty($fav)) {
		write_session('fav', implode(';', $fav));
	} else {
		unset_session('fav');
	}
}

function axiosRemoveFromFav() {
	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'];

	removeFromFav($id);

	die();
}
add_action('wp_ajax_axiosRemoveFromFav', 'axiosRemoveFromFav');
add_action('wp_ajax_nopriv_axiosRemoveFromFav', 'axiosRemoveFromFav');

function favItems() {
	$fav_items = [];
	$items_data = [];
	$fav = !empty($_SESSION['fav']) ? explode(';', $_SESSION['fav']) : [];
	$city = get_city_slug();

	if(!empty($fav)) {

		foreach($fav as $item_id) {
			$fav_items[] = product($item_id);
		}

	}

	if(empty($fav_items)) {
		$fav_items[] = '
			<div class="empty-block">
				<div class="icon icon-fav"></div>
				<h6>Нет избранных</h6>
			</div>
		';
	}

	$fav_items = implode("\n", $fav_items);
	return [
		'structure' => $fav_items,
		'data' => $items_data
	];
}

function is_fav($id) {
	$fav = !empty($_SESSION['fav']) ? explode(';', $_SESSION['fav']) : [];

	return in_array($id, $fav);
}

function addToFav($id) {
	$fav = !empty($_SESSION['fav']) ? explode(';', $_SESSION['fav']) : [];
	$search = array_search($id, $fav);

	if($search === false) {
		$fav[] = $id;
	} else {
		unset($fav[$search]);
	}

	if(!empty($fav)) {
		write_session('fav', implode(';', $fav));
	} else {
		unset_session('fav');
	}
}

function axiosAddToFav() {
	$data = json_decode(file_get_contents('php://input'), true);

	addToFav($data['id']);

	die();
}
add_action('wp_ajax_axiosAddToFav', 'axiosAddToFav');
add_action('wp_ajax_nopriv_axiosAddToFav', 'axiosAddToFav');

/////

add_action ( 'init', function () {
    wp_register_sitemap_provider(
        'categories',
        new class extends \WP_Sitemaps_Provider {
            public function __construct() {
                $this->name = 'categories'; // public-facing name in URLs says parent class.
            }
            public function get_url_list( $page_num, $post_type = '' ) {
				$url_list = array();

				$urls = [];

				$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
				$data = file_get_contents($file);
				$data = json_decode($data);
				$data = $data->taxonomies;

				foreach($data as $item) {
					$line = ['catalog'];

					if($item->parent) {
						$line[] = $item->parent;
					}

					$line[] = $item->slug;

					$line = implode('/', $line);
					$urls[] = '/' . $line . '/';
				}

				foreach($urls as $url) {
					$url_list[] = [
						'loc' => home_url($url)
					];
				}

				return $url_list;
            }
            public function get_max_num_pages( $subtype = '' ) {
                return 1;
            }
        }
    );

	wp_register_sitemap_provider(
        'tags',
        new class extends \WP_Sitemaps_Provider {
            public function __construct() {
                $this->name = 'tags'; // public-facing name in URLs says parent class.
            }
            public function get_url_list( $page_num, $post_type = '' ) {
				$url_list = array();

				$urls = [];

				$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tags.json';
				$data = file_get_contents($file);
				$data = json_decode($data);
				$data = $data->tags;

				foreach($data as $item) {
					$line = ['tags'];

					if($item->parent) {
						$line[] = $item->parent;
					}

					$line[] = $item->slug;

					$line = implode('/', $line);
					$urls[] = '/' . $line . '/';
				}

				foreach($urls as $url) {
					$url_list[] = [
						'loc' => home_url($url)
					];
				}

				return $url_list;
            }
            public function get_max_num_pages( $subtype = '' ) {
                return 1;
            }
        }
    );

	wp_register_sitemap_provider(
        'flowers',
        new class extends \WP_Sitemaps_Provider {
            public function __construct() {
                $this->name = 'flowers'; // public-facing name in URLs says parent class.
            }
            public function get_url_list( $page_num, $post_type = '' ) {
				$url_list = array();

				$urls = [];

				$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/flowers.json';
				$data = file_get_contents($file);
				$data = json_decode($data);
				$data = $data->flowers;

				foreach($data as $item) {
					$line = ['flowers'];

					$line[] = $item->slug;

					$line = implode('/', $line);
					$urls[] = '/' . $line . '/';
				}

				foreach($urls as $url) {
					$url_list[] = [
						'loc' => home_url($url)
					];
				}

				return $url_list;
            }
            public function get_max_num_pages( $subtype = '' ) {
                return 1;
            }
        }
    );

	wp_register_sitemap_provider(
        'products',
        new class extends \WP_Sitemaps_Provider {
            public function __construct() {
                $this->name = 'products'; // public-facing name in URLs says parent class.
            }
            public function get_url_list( $page_num, $post_type = '' ) {
				$url_list = array();

				$urls = [];

				$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products.json';
				$data = file_get_contents($file);
				$data = json_decode($data);
				$data = $data->products;

				foreach($data as $item) {
					$line = ['product', $item];

					$line = implode('/', $line);
					$urls[] = '/' . $line . '/';
				}

				foreach($urls as $url) {
					$url_list[] = [
						'loc' => home_url($url)
					];
				}

				return $url_list;
            }
            public function get_max_num_pages( $subtype = '' ) {
                return 1;
            }
        }
    );

} );

add_filter( 'wp_sitemaps_add_provider', 'init_remove_sitemap_providers', 10, 2 );

function init_remove_sitemap_providers( $provider, $name ){

	$remove_providers = [ 'users' ];

	// отключаем архивы пользователей
	if( in_array( $name, $remove_providers ) ){
		return false;
	}

	return $provider;
}

add_filter( 'wp_sitemaps_posts_query_args', 'init_filter_sitemap_links', 10, 2 );
function init_filter_sitemap_links( $args, $post_type ){
	$exclude = [61, 16, 56, 58, 70, 3, 12, 14, 141];

	// учтем что этот параметр может быть уже установлен
	if( !isset( $args['post__not_in'] ) )
		$args['post__not_in'] = array();

	$dashboard_id = 63;

	$args['post__not_in'][] = $dashboard_id;
	$args['post_parent__not_in'] = [$dashboard_id];

	$args['post__not_in'] = array_merge($args['post__not_in'], $exclude);

	return $args;
}

/////

if ( ! function_exists( 'init_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function init_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on init, use a find and replace
		 * to change 'init' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'init', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'top' => __( 'Top Menu', 'init' ),
			'primary' => __( 'Primary Menu', 'init' ),
			'mobile' => __( 'Mobile Menu', 'init' ),
			'footer_1' => __( 'Footer Menu 1', 'init' ),
			'footer_2' => __( 'Footer Menu 2', 'init' ),
			'footer_3' => __( 'Footer Menu 3', 'init' ),
			'footer_4' => __( 'Footer Menu 4', 'init' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'init_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'init_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function init_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'init_content_width', 640 );
}
add_action( 'after_setup_theme', 'init_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function init_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'init' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'init' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

		register_sidebar( array(
		'name'          => esc_html__( 'Phone and Min Price', 'init' ),
		'id'            => 'sidebar-phonesize',
		'description'   => esc_html__( 'Change phome and min price.', 'init' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'init_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function init_scripts() {
	wp_enqueue_style( 'init-theme', get_template_directory_uri() . '/css/theme.css', false, filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/css/theme.css') );
	wp_enqueue_style( 'new-theme', get_template_directory_uri() . '/css/new.css', false, filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/css/new.css') );

	wp_enqueue_script( 'init-jquery', get_template_directory_uri() . '/js/jquery/jquery.min.js', false, NULL, true );
	wp_enqueue_script( 'init-slick', get_template_directory_uri() . '/js/scripts/plugins/slick.min.js', false, NULL, true );

	wp_enqueue_script( 'init-imask', get_template_directory_uri() . '/js/scripts/plugins/imask.js', false, NULL, true );
	wp_enqueue_script( 'init-datepicker', get_template_directory_uri() . '/js/scripts/plugins/datepicker-full.min.js', false, NULL, true );
	wp_enqueue_script( 'init-axios', get_template_directory_uri() . '/js/scripts/plugins/axios.min.js', false, NULL, true );
	wp_enqueue_script( 'init-swiper', get_template_directory_uri() . '/js/scripts/plugins/swiper.js', false, NULL, true );
	wp_enqueue_script( 'init-magnifier', get_template_directory_uri() . '/js/scripts/plugins/magnifier.js', false, NULL, true );

	if(is_page('product')) {
		wp_enqueue_script( 'init-fancybox', get_template_directory_uri() . '/js/scripts/plugins/fancybox.js', false, NULL, true );
	}

    wp_enqueue_script( 'init-filters', get_template_directory_uri() . '/js/filters.js', false, filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/js/filters.js'), true );

    $jsScripts = ["accord","ajax","add-product","archive","best-deals","cart","city","dropzone","edit-profile","fav","files","first-slide","flowers","header","images","input-masks","inputs","lazy","news","notification","one-click","orders","popup","quantity","price","promo","rating","recently","request","reviews","ring","single-product","single","tax-tabs","text","auth/auth","auth/login","auth/register","auth/restore"];
    foreach ($jsScripts as $jsScript) {
        wp_enqueue_script( 'init-'. $jsScript, get_template_directory_uri() . '/js/scripts/custom/' . $jsScript . '.js', false, filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/js/scripts/custom/' . $jsScript . '.js'), true );
    }

    /* end separated of scripts */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'init_scripts' );

add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if (!is_admin()) {
        return str_replace( ' src', ' defer src', $tag ); // defer the script
	}
	return $tag;
}, 10, 2 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/widgets/widget-phone.php';
require get_template_directory() . '/widgets/widgets.php';



/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Убераем слово Рубрика, Архивы, Категория
 */
add_filter( 'get_the_archive_title', 'wp_remove_name_cat' );
function wp_remove_name_cat( $title ){
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
}

function bgi($url){
	echo 'style="background-image: url(/wp-content/themes/init/img/' . $url . ')"';
}

function src($url){
	echo 'src="/wp-content/themes/init/img/' . $url . '"';
}

function the_logo(){
	echo '<div class="site-branding">';

	$logo = '<div class="site-name">Flow<span>Love</span></div>';

	if(get_custom_logo()){
		$logo = '<img src="' . wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] . '" alt="' . get_bloginfo('name') . ' в '.CITY_GENITIVE.'">';
	}

	echo '<a href="' . PRE_LINK . '/">' . $logo . '</a>';
	echo '</div>';
}

function developers(){
	echo '
	<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
	viewBox="0 0 5813.82 4168.45"
	 xmlns:xlink="http://www.w3.org/1999/xlink"
	 xmlns:xodm="http://www.corel.com/coreldraw/odm/2003">
	 <defs>
	 </defs>
	 <g id="Слой_x0020_1">
	  <metadata id="CorelCorpID_0Corel-Layer"/>
	  <path d="M156.71 0l5657.11 0 0 4168.45 -5813.82 0 0 -4168.45 156.71 0zm5343.7 313.41l-5186.99 0 0 3541.62 5186.99 0 0 -3541.62z"/>
	  <path d="M1524.51 1185.97l0 300.25 -355.29 0 0 -300.25 355.29 0zm0 490.41l0 1291.08 -355.29 0 0 -1291.08 355.29 0zm1496.25 1291.08l-360.3 0 0 -753.13c0,-91.74 -15.01,-161.38 -45.04,-208.92 -30.02,-47.54 -88.41,-71.31 -175.14,-71.31 -186.82,0 -280.24,113.43 -280.24,340.29l0 693.08 -352.79 0 0 -1291.08 337.78 0 0 180.14c106.75,-143.45 249.37,-215.17 427.85,-215.17 138.46,0 247.71,40.03 327.78,120.1 80.06,80.07 120.1,194.33 120.1,342.78l0 863.23zm633.03 -1781.49l0 300.25 -355.29 0 0 -300.25 355.29 0zm0 490.41l0 1291.08 -355.29 0 0 -1291.08 355.29 0zm990.83 0l0 240.2 -262.72 0 0 608c0,38.37 0.84,66.31 2.51,83.82 1.66,17.52 7.51,35.45 17.51,53.79 10.01,18.35 25.44,30.44 46.3,36.28 20.85,5.84 50.45,8.76 88.82,8.76 43.37,0 79.23,-1.67 107.59,-5.01l0 270.23c-86.74,6.67 -158.47,10.01 -215.18,10.01 -155.13,0 -260.62,-27.11 -316.51,-81.33 -55.88,-54.2 -83.81,-158.87 -83.81,-314.01l0 -670.56 -215.18 0 0 -240.2 215.18 0 0 -390.33 352.79 0 0 390.33 262.72 0z"/>
	 </g>
	</svg>
	';
}

function unmask_phone($phone) {

    // Масив из символов, которые нужно удалить
    $removable_symbols = array( '+', '(', ')', ' ', '-', '_');
    // Удаление лишних символов
    $phone = str_replace($removable_symbols, '', trim($phone));

    return $phone;

}

function get_roles($select = '', $plural = false){

	if($plural){
		$roles = [
			'administrator'     => 'Администраторы',
			'subscriber'        => 'Пользователи',
		];
	}else{
		$roles = [
			'administrator'     => 'Администратор',
			'subscriber'        => 'Пользователь',
		];
	}

	if($select){
		return $roles[$select];
	}else{
		return $roles;
	}
}

function user_info($user_id = 'cur'){
	global $wpdb;

	if($user_id == 'cur'){
		$user_id = get_current_user_id();
	}

	if($user_id != 0){
		$user = get_userdata($user_id);
		$phone = $user->user_login;
		$email = $user->user_email;
		$first_name = $user->first_name;
		$last_name = $user->last_name;
		$register = date("d.m.Y", strtotime( $user->user_registered ));
		$user_name = trim($first_name . ' ' . $last_name);
		$first_letter = mb_substr($user_name, 0, 1);

		$roles = get_roles();
		$role_slug = $user->roles[0];
		$role = $roles[$role_slug];

		if($user_name == ' '){
			$user_name = $role;
		}

		$avatar = [
			'large' 	=> '<div class="avatar large">' . $first_letter . '</div>',
			'big' 		=> '<div class="avatar">' . $first_letter . '</div>',
			'medium' 	=> '<div class="avatar medium">' . $first_letter. '</div>',
			'small' 	=> '<div class="avatar small">' . $first_letter. '</div>'
		];

		$results = array(
			'id' 				=> $user_id,
			'login' 			=> $user->user_login,
			'email' 			=> $email,
			'phone' 			=> $phone,
			'first_name' 		=> $first_name,
			'last_name' 		=> $last_name,
			'user_name' 		=> $user_name,
			'first_letter' 		=> $first_letter,
			'role' 				=> $role,
			'role_slug'			=> $role_slug,
			'register' 			=> date("d.m.Y", strtotime( $user->user_registered )),
			'avatar'			=> $avatar,
		);

	}else{

		$results = array(
			'id' 			=> 0,
			'userdata' 		=> '',
			'login' 		=> '',
			'email' 		=> '',
			'phone' 		=> '',
			'first_name' 	=> '',
			'last_name' 	=> '',
			'user_name' 	=> '',
			'address' 		=> '',
			'role' 			=> '',
			'role_slug'		=> '',
			'register' 		=> ''
		);

	}

	return $results;

}

function mask($phone){
    $input_mask = '+. (...) ...-..-..';
    $phone = str_split($phone);

    while ( count($phone) > 0 ):
        $input_mask = preg_replace('/\./m', $phone[0], $input_mask, 1);
        array_shift($phone);
    endwhile;

    return $input_mask;
}

function get_date($date, $formate = 'default'){
	$months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
	$date = strtotime($date);

	if($formate == 'default'){
		$date = date('d', $date) . ' ' . $months[date('n', $date)] . ' ' . date('Y', $date);
	}else if($formate == 'ym'){
		$date = $months[date('n', $date)] . ' ' . date('Y', $date);
	}else if($formate == 'dmyh'){
		$months = array( 1 => 'Января' , 'Февраля' , 'Марта' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );
		$date = date('d', $date)  . ' ' . $months[date('n', $date)] . ' ' . date('Y', $date) . ' в ' . date('H:i', $date);
	}

	return $date;
}

function get_past_date($date){
	$date = date_create($date);

	$diff = date_diff($date, date_create('now'));
	if($diff->y){
		$date = $diff->y;

		if($date == 1){
			$date .= ' год';
		}else if($date > 1 && $date < 5){
			$date .= ' года';
		}else{
			$date .= ' лет';
		}

	}elseif($diff->m){
		$date = $diff->m;

		if($date == 1){
			$date .= ' месяц';
		}else if($date > 1 && $date < 5){
			$date .= ' месяца';
		}else{
			$date .= ' месяцев';
		}
	}elseif($diff->d){
		$date = $diff->d;

		if($date == 1){
			$date .= ' день';
		}else if($date > 1 && $date < 5){
			$date .= ' дня';
		}else{
			$date .= ' дней';
		}
	}
	elseif($diff->h){
		$date = $diff->h;

		if($date == 1){
			$date .= ' час';
		}else if($date > 1 && $date < 5){
			$date .= ' часа';
		}else{
			$date .= ' часов';
		}
	}
	elseif($diff->i){
		$date = $diff->i;

		if($date == 1){
			$date .= ' минуту';
		}else if($date > 1 && $date < 5){
			$date .= ' минуты';
		}else{
			$date .= ' минут';
		}
	}
	elseif($diff->s){
		$date = $diff->s;

		if($date == 1){
			$date .= ' секунду';
		}else if($date > 1 && $date < 5){
			$date .= ' секунды';
		}else{
			$date .= ' секунд';
		}
	}else{
		$date = '0 с.';
	}

	return $date;
}

function page_header($args = []) {
	$title = get_the_title();
	$after = !empty($args['after']) ? $args['after'] : '';

	if(isset($args['title'])) {
		$title = $args['title'];
	}

	if(is_archive() || is_tax()) {
		$title = get_the_archive_title();
	}

	echo '
	<section class="page-header">
		<div class="container">
			<div class="wrapper">';

	echo '<div class="article-sm">';

	if($title) {
		echo '<h1>' . $title . '</h1>';
	}

	echo bread();

	echo '</div>';

	echo $after;

	echo '
			</div>
		</div>
	</section>
	';
}

//define('PHONES', [
//	[
//		'tel' => '+7 987 319-88-04',
//		'link'	=> unmask_phone('+7 987 319-88-04')
//	],
	 //[
	 //	'tel' => '+7 908 039-05-82',
	 //	'link'	=> unmask_phone('+7 908 039-05-82')
	 //]
//]);

define('EMAILS', [
	'info@flowlove.ru'
]);

//define('SOCIAL', [
//	'telegram' => 'https://telegram.me/Flowlove_ru',
//	'whatsapp' => 'https://api.whatsapp.com/send?phone=79080390582',
//	'viber' => 'viber://chat?number=79080390582',
//	'vk' => 'https://vk.com/flowlove_ru',
//]);

define('SOCIAL', [
	'telegram' => get_option('telegram', 'https://telegram.me/Flowlove_ru'),
	'whatsapp' => get_option('whatsapp', 'https://api.whatsapp.com/send?phone=79080390582'),
	'viber' => get_option('viber', 'viber://chat?number=79080390582'),
	'vk' => get_option('vk', 'https://vk.com/flowlove_ru'),
]);

function price_block($slug, $price = '', $type = 'card') {
	if($price == '') {
		$city = get_city_slug();
		$price = getPrice($slug, $city);
	}

	$result = '';

	if($type == 'card') {
		$old_price = $price['old_price'] ? '<div class="old-price">' . formate($price['old_price']) . ' ' . CUR . '</div>' : '';
		$cur_price = $price['price'] ? '<div class="current-price">' . formate($price['price']) . ' ' . CUR . '</div>' : '';

		if(!empty($price['variants'])) {
			$cur_price = $price['price'] ? '<div class="current-price">от ' . formate($price['price']) . ' ' . CUR . '</div>' : '';
		}

		$result = '<div class="price-block">' . $cur_price . $old_price . '</div>';
	} else if ($type == 'single' || $type == 'day') {
		$variants = $price['variants'];
		$old_price = $price['old_price'];
		$sizes = $price['sizes'];
		$selected = $price['selectedKey'];
		$price = $price['price'];
		$city = get_city_slug();
		$append_sizes = '';

		if(!empty($prices->{$city})) {
			$city_prices = $prices->{$city};
			$price = $city_prices->price;
			$old_price = $city_prices->old_price;
		}
        if ($slug == 'buketpofoto') {
            $ot = 'от ';
        } else {
            $ot = '';
        }
		$price = $price ? '<div class="current-price append-calced-price">' . $ot . formate($price) . ' ' . CUR . '</div>' : '';
		$old_price = $old_price ? '<div class="old-price">' . formate($old_price) . ' ' . CUR . '</div>' : '';

		if(!empty($variants)) {
			foreach($variants as $key => $variant) {
				$price = '<div class="current-price append-calced-price" data-key="' . $slug . '">' . formate($variant) . ' ' . CUR . '</div>';
				$old_price = '';

				break;
			}

			$variants_block = [];

			$index = 0;
			foreach($variants as $key => $variant) {
				$variant_price = formate($variant) . ' ' . CUR;
				$classes = ['btn', 'price-tab'];

				$classes[] = 'small';

				if($index) {
					$classes[] = 'outline';
				}

				$classes = implode(' ', $classes);

				if(!empty($sizes[$key])) {
					$width = $sizes[$key][0];
					$height = $sizes[$key][1];

					$variants_block[] = '<div class="' . $classes . '" data-raw-price="' . $variant . '" data-price="' . $variant_price . '" data-key="' . $index . '" data-width="' . $width . '" data-height="' . $height . '"><span class="text">' . $key . '</span></div>';
				} else {
					$variants_block[] = '<div class="' . $classes . '" data-raw-price="' . $variant . '" data-price="' . $variant_price . '" data-key="' . $index . '"><span class="text">' . $key . '</span></div>';
				}

				$index++;
			}

			$variants_block = implode('', $variants_block);
			$variants_block = '<div>Выберите размер букета:</div><div class="inline pricing-tabs small" data-slug="' . $slug . '"><div class="line">' . $variants_block . '</div></div>';
		} else {
			$variants_block = '';
		}

		if(!empty($sizes[$selected])) {
			$width = $sizes[$selected][0] . ' см.';
			$height = $sizes[$selected][1] . ' см.';

			$append_sizes = '<div class="sizes"> <div class="item icon-width">' . $width . '</div> <div class="item icon-height">' . $height . '</div> </div>';
		}

		$price_block = '<div class="price-block" data-slug="' . $slug . '">' . $price . $old_price . $append_sizes . '</div>';
		$result = $variants_block . $price_block;
	}

	return $result;
}

/////

function addToCart($slug, $quantity = 1, $florist_data = false) {
	$cart = !empty($_SESSION['cart']) ? explode(';', $_SESSION['cart']) : [];
	$found = false;
	$filtred = [];
	if(!empty($cart)) {
		foreach($cart as $item) {
			$item = explode(':', $item);
			$item_slug = $item[0];
			$item_quantity = (int)$item[1];
            if(isset($item[2])) $item_price = $item[2];
            if(isset($item[3])) $item_image = $item[3];


			if($item_slug == $slug) {
				$found = true;
				$item_quantity += $quantity;
			}

			if($item_slug == 'buketpofoto') {
                $filtred[] = $item_slug . ':' . $item_quantity .':'.$_SESSION['cart_florist_price'].':'.$_SESSION['cart_florist_file'];
            } else {
                $filtred[] = $item_slug . ':' . $item_quantity;
            }
		}
	}

	if(!$found) {
        if($slug == 'buketpofoto' && $florist_data) {
            if (!empty($florist_data['florist_file'])) {
                $filtred[] = $slug . ':' . $quantity .':'. $florist_data['florist_price'].':'.$florist_data['florist_file'];
            } else {
                $filtred[] = $slug . ':' . $quantity .':'. $florist_data['florist_price'];
            }
        } else {
            $filtred[] = $slug . ':' . $quantity;
        }

	}

    if($slug == 'buketpofoto') {
        write_session('cart_florist_price', $florist_data['florist_price']);
        if (!empty($florist_data['florist_comment'])) {
        write_session('cart_florist_comment', $florist_data['florist_comment']);
        }
        if (!empty($florist_data['florist_file'])) {
            write_session('cart_florist_file', $florist_data['florist_file']);
        }
    }

	write_session('cart', implode(';', $filtred));
}

function axiosAddToCart() {
	$data = json_decode(file_get_contents('php://input'), true);
	$slug = $data['slug'];
	$quantity = (int)$data['quantity'];
    $florist_data = $data['florist_data'];
	if(!$quantity) {
        $quantity = 1;
    }

	addToCart($slug, $quantity, $florist_data);
	die();
}
add_action('wp_ajax_axiosAddToCart', 'axiosAddToCart');
add_action('wp_ajax_nopriv_axiosAddToCart', 'axiosAddToCart');

function oneClickProduct() {
	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'];
	$product = product_data($id);
	if($product) {
		$item_id = $id;
		$item_data = $product;

		$item_title = $item_data->title;
		$item_link = '/product/' . $item_id . '/';
        if (is_array($item_data->images->medium)) {
            $item_image = !empty($item_data->images->medium[0]) ? '<img src="' . $item_data->images->medium[0] . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';
        } else {
            $item_image = !empty($item_data->images->medium) ? '<img src="' . $item_data->images->medium . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';
        }


		$item_price = getPrice($item_id);
		$item_unit_price = $item_price['price'];

		if($item_price['selectedKey']) {
			$item_title .= ' (' . $item_price['selectedKey'] . ')';
		}

		$item_structure = '
		<div class="large-product-item">
			<div class="item-content">
				<div class="info">
					<a href="' . $item_link . '" class="image">' . $item_image . '</a>
					<div class="content">
						<a href="' . $item_link . '" class="title">' . $item_title . '</a>
						<div class="product-meta">
						  ' . ($product->stars ?? '') . '	 
							<div class="label">' . formate($item_unit_price) . ' ' . CUR . ' / шт.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		';

		echo $item_structure;
	}

	die();
}
add_action('wp_ajax_oneClickProduct', 'oneClickProduct');
add_action('wp_ajax_nopriv_oneClickProduct', 'oneClickProduct');

function removeFromCart($slug) {
	$cart = !empty($_SESSION['cart']) ? explode(';', $_SESSION['cart']) : [];
	$filtred = [];

	if(!empty($cart)) {
		foreach($cart as $item) {
			$item = explode(':', $item);
			$item_id = $item[0];
			$item_quantity = (int)$item[1];

			if($item_id != $slug) {
				$filtred[] = $item_id . ':' . $item_quantity;
			}
		}
	}

	if(!empty($filtred)) {
		write_session('cart', implode(';', $filtred));
	} else {
		unset_session('cart');
		if($slug == 'buketpofoto') {
            unset_session('cart_florist_price');
            unset_session('cart_florist_comment');
            unset_session('cart_florist_file');
        }
	}
}

function axiosRemoveFromCart() {
	$slug = json_decode(file_get_contents('php://input'), true);
	$slug = $slug['id'];

	removeFromCart($slug);
	die();
}
add_action('wp_ajax_axiosRemoveFromCart', 'axiosRemoveFromCart');
add_action('wp_ajax_nopriv_axiosRemoveFromCart', 'axiosRemoveFromCart');

function changeQuantity($id, $quantity) {
	$cart = !empty($_SESSION['cart']) ? explode(';', $_SESSION['cart']) : [];
	$found = false;
	$filtred = [];

	if(!empty($cart)) {
		foreach($cart as $item) {
			$item = explode(':', $item);
			$item_id = $item[0];
			$item_quantity = (int)$item[1];

			if($item_id == $id) {
				$found = true;
				$item_quantity = $quantity;
			}

			$filtred[] = $item_id . ':' . $item_quantity;
		}
	}

	if(!$found) {
		$filtred[] = $id . ':' . $quantity;
	}

	write_session('cart', implode(';', $filtred));
}

function axiosChangeQuantity() {
	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'];
	$quantity = (int)$data['quantity'];
	$quantity = $quantity ? $quantity : 1;

	changeQuantity($id, $quantity);
	die();
}
add_action('wp_ajax_axiosChangeQuantity', 'axiosChangeQuantity');
add_action('wp_ajax_nopriv_axiosChangeQuantity', 'axiosChangeQuantity');

function clearCart() {

	unset_session('cart');
    unset_session('cart_florist_price');
    unset_session('cart_florist_comment');
    unset_session('cart_florist_file');
}

function axiosClearCart() {
	clearCart();
	die();
}
add_action('wp_ajax_axiosClearCart', 'axiosClearCart');
add_action('wp_ajax_nopriv_axiosClearCart', 'axiosClearCart');

function cartInfo($city = '') {
	$raw_cart = !empty($_SESSION['cart']) ? explode(';', $_SESSION['cart']) : [];
	$cart = [];
	$quantity = 0;
	$price = 0;
	$old_price = 0;

	if(!$city) {
		$city = CITY_SLUG;
	}

	if(!empty($raw_cart)) {
		foreach($raw_cart as $item) {
			$item = explode(':', $item);
			$item_slug = $item[0];
			$item_data = product_data($item_slug);
			$item_quantity = (int)$item[1];
			$item_explode_slug = explode('.', $item_slug);
			$item_pure_slug = $item_explode_slug[0];
			$item_price_index = !empty($item_explode_slug[1]) ? (int)$item_explode_slug[1] : 0;
			$item_price = getPrice($item_slug, $city);
			$total_price = $item_price['price'];
			if ($item_slug == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                $total_price = $_SESSION['cart_florist_price'];
                $item_price['price'] = $_SESSION['cart_florist_price'];
            }
			$total_old_price = $item_price['old_price'];
			$item_title = $item_data->title;

			if($item_price['selectedKey']) {
				$item_title .= ' (' . $item_price['selectedKey'] . ')';
			}

			$total_old_price *= $item_quantity;
			$total_price *= $item_quantity;

			$price += $total_price;
			$old_price += $total_old_price;
			$quantity += $item_quantity;

			$cart[] = [
				'title' => $item_title,
				'slug' => $item_slug,
				'quantity' => $item_quantity,
				'price' => $total_price,
				'pricePer' => $item_price['price'],
				'oldPricePer' => $item_price['old_price'],
			];
		}
	}

	$cartItems = cartItems();

	$promo = !empty($_SESSION['promo']) ? $_SESSION['promo'] : '';
	$discount = 0;

	if($promo) {
		$promo = getPromo($promo);

		if(!empty($promo)) {
			$old_price = $price;
			$type = $promo['type'];
			$discount_val = $promo['discount'];

			if($discount_val) {
				if($type == 'percent') {
					$discount_val = $discount_val * 0.01;
					$discount_val = round($price * $discount_val);
				}

				$price = $price - $discount_val;
			}

			if($price < 0) {
				$price = 0;
				$discount = 100;
			}

			if($price && $old_price) {
				$discount = round( 100 - (($price / $old_price) * 100) );
			}
		}

	}

	$data = [
		'session' => !empty($_SESSION['cart']) ? $_SESSION['cart'] : '',
		'cart' => $cart,
		'quantity' => $quantity,
		'price' => $price,
		'oldPrice' => $old_price,
		'cartItems' => $cartItems['structure'],
		'cartItemsData' => $cartItems['data'],
		'promoForm' => promoForm(),
		'promo' => $promo,
		'discount' => $discount,
		'discountVal' => $old_price - $price,
	];

	return $data;
}

function axiosCartInfo() {
	$city = json_decode(file_get_contents('php://input'), true);
	$data = cartInfo($city);

	echo json_encode($data, JSON_UNESCAPED_UNICODE);

	die();
}
add_action('wp_ajax_axiosCartInfo', 'axiosCartInfo');
add_action('wp_ajax_nopriv_axiosCartInfo', 'axiosCartInfo');

function cartItems() {
	$cartItems = [];
	$items_data = [];
	$cart = !empty($_SESSION['cart']) ? explode(';', $_SESSION['cart']) : [];

	if(!empty($cart)) {

		foreach($cart as $item) {
			$item = explode(':', $item);
			$item_id = $item[0];
			$cleared_id = explode('.', $item_id);
			$cleared_id = $cleared_id[0];
			$item_quantity = (int)$item[1];
			$item_data = product_data($item_id);

			$item_title = $item_data->title;
			$item_link = '/product/' . $cleared_id . '/';


			$image_s = [];

			if( !empty($item_data->images->small) ){

				$small_image = $item_data->images->small;

				if( is_array($small_image) ){
					foreach($small_image as $small){
						$new_image = '<img src="' . $small . '" alt="' . $item_title . '">';
						array_push($image_s, $new_image);
					}
				}else{
					$image_s = !empty($item_data->images->small) ? '<img src="' . $item_data->images->small . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';
				}
			}
			// $item_image = !empty($item_data->images->small) ? '<img src="' . $item_data->images->small . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';

			$item_price = getPrice($item_id);
			$item_unit_price = $item_price['price'];
            if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                $item_unit_price = $_SESSION['cart_florist_price'];
            }

            if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_file'])) {
                $img_server_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                $img_host_path =  '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                if(file_exists($img_server_path)) {
                    $image_s = '<img src="' . $img_host_path . '" alt="' . $item_title . '">';
                }
            }
			$item_unit_old_price = $item_price['old_price'];
			$discount = '';

			if($item_price['selectedKey']) {
				$item_title .= ' (' . $item_price['selectedKey'] . ')';
			}

			$item_total_price = $item_unit_price * $item_quantity;
            if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                $item_total_price = $_SESSION['cart_florist_price'] * $item_quantity;
            }

			if($item_unit_old_price) {
				$total_old_price = $item_unit_old_price * $item_quantity;
				$total_discount = $total_old_price - $item_total_price;

				$discount = '
				<div class="discount-block">
					<div class="old-price"><span class="product-old-price" data-id="' . $item_id . '">' . formate($total_old_price) . '</span> ' . CUR . '</div>
					<div class="discount-value-wrapper">-<span class="discount product-discount" data-id="' . $item_id . '">' . formate($total_discount) . '</span> ' . CUR . '</div>
				</div>
				';
			}

			if( is_array( $image_s ) ){
				$image_s = $image_s[0];
			}

            if($cleared_id == 'chereshnya' || $cleared_id == 'ezhevika' || $cleared_id == 'golubika' || $cleared_id == 'malina') {
                $item_data->stars = '';
                $product_image = '<div class="image">' . $image_s . '</div>';
                $product_title = '<div class="title">' . $item_title . '</div>';
            } else {
                $product_image = '<a href="' . $item_link . '" class="image">' . $image_s . '</a>';
                $product_title = '<a href="' . $item_link . '" class="title">' . $item_title . '</a>';
            }

			$item_structure = '
			<div class="large-product-item" data-id="' . $item_id . '">
				<div class="item-content">
					<div class="info">
						'.$product_image.'
						<div class="content">
							'.$product_title.'
							<div class="product-meta">
								' . $item_data->stars . '
								<div class="label">' . formate($item_unit_price) . ' ' . CUR . ' / шт.</div>
							</div>
						</div>
					</div>
					<div class="stat">
						<div class="title"><span class="current-price product-total-price" data-id="' . $item_id . '">' . formate($item_total_price) . '</span> ' . CUR . '</div>
						' . $discount . '
					</div>
					<div class="quantity">
						<button class="minus">-</button>
						<input type="text" class="quantity-input cart-item-quantity medium" value="' . $item_quantity . '" data-id="' . $item_id . '">
						<button class="plus">+</button>
					</div>
					<div class="btns inline">
						<div class="line">
							<button class="btn outline red-theme remove-cart-item medium" data-id="' . $item_id . '"><span class="icon icon-close small"></span></button>
						</div>
					</div>
				</div>
			</div>
			';

			$items_data[] = [
				'id' => $item_id,
				'title' => $item_title,
				'price' => $item_unit_price,
				'totalPrice' => $item_total_price,
				'quantity' => $item_quantity,
			];

			$cartItems[] = $item_structure;
		}

	}

	if(empty($cartItems)) {
		$cartItems[] = '
			<div class="empty-block">
				<div class="icon icon-error"></div>
				<h6>Корзина пуста</h6>
			</div>
		';
	}

	$cartItems = implode("\n", $cartItems);

	return [
		'structure' => $cartItems,
		'data' => $items_data
	];
}

function getProducts($products, $hide_mobile = false) {
	$items = [];
	$products = $products ? explode(';', $products) : [];

	if(!empty($products)) {

		foreach($products as $item) {
			$item = explode(':', $item);
			$item_id = $item[0];
			$cleared_id = explode('.', $item_id);
			$cleared_id = $cleared_id[0];
			$item_quantity = (int)$item[1];
			$item_data = product_data($item_id);

			$item_title = $item_data->title;
			$item_link = '/product/' . $cleared_id . '/';
            if(is_array($item_data->images->small)) {
                $item_image = !empty($item_data->images->small[0]) ? '<img src="' . $item_data->images->small[0] . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';
            } else {
                $item_image = !empty($item_data->images->small) ? '<img src="' . $item_data->images->small . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';
            }
//            $image_s = !empty($item_data->images->small) ? '<img src="' . $item_data->images->small . '" alt="' . $item_title . '">' : '<span class="icon icon-image"></span>';

			$item_price = getPrice($item_id);
			$item_unit_price = $item_price['price'];
			$item_unit_old_price = $item_price['old_price'];
			$discount = '';

			if($item_price['selectedKey']) {
				$item_title .= ' (' . $item_price['selectedKey'] . ')';
			}

			$item_total_price = $item_unit_price * $item_quantity;
            if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                $item_total_price = $_SESSION['cart_florist_price'] * $item_quantity;
            }

			if($item_unit_old_price) {
				$total_old_price = $item_unit_old_price * $item_quantity;
				$total_discount = $total_old_price - $item_total_price;

				$discount = '
				<div class="discount-block">
					<div class="old-price"><span class="product-old-price" data-id="' . $item_id . '">' . formate($total_old_price) . '</span> ' . CUR . '</div>
					<div class="discount-value-wrapper">-<span class="discount product-discount" data-id="' . $item_id . '">' . formate($total_discount) . '</span> ' . CUR . '</div>
				</div>
				';
			}

			$item_structure = '
				<div class="large-product-item">
					<div class="item-content">
						<div class="info">
							<a href="' . $item_link . '" class="image">' . $item_image . '</a>
							<div class="content">
								<a href="' . $item_link . '" class="title">' . $item_title . '</a>
								<div class="product-meta">
									' . $item_data->stars . '
									<div class="label">' . formate($item_unit_price) . ' ' . CUR . ' (' . $item_quantity . ' шт.)</div>
								</div>
							</div>
						</div>

						<div class="stat">
							<div class="title"><span class="current-price product-total-price">' . formate($item_total_price) . '</span> ' . CUR . '</div>
							
							' . $discount . '
						
						</div>
					</div>
				</div>
			';

			$items[] = $item_structure;
		}

	}

	$items = implode('', $items);
	return $items;
}

/////

function initMailTemplate($title, $content) {
	$structure = '
	<div class="content">

	<div style="background: #f1f1f1;padding: 42px 0;">

		<div style="margin: 0px auto;max-width: 640px;background: #fff;">

			<table style="width:100%;">
				<tbody>
					<tr>
						<td style="padding:28px;">
							<table style="width: 100%">
								<tbody style="color:#737F8D;font-size:16px;line-height:24px;">
									<tr>
										<td colspan="2">
											<h2 style="font-weight: bold;font-size: 24px;border-bottom: 1px solid rgba(0, 0, 0, 0.2);padding-bottom: 20px;text-align: center;color: #222;">' . $title . '</h2>
										</td>
									</tr>
									' . $content . '               
								</tbody>
								</table>
							</td>
						</tr>

						<tr>
							<td style="vertical-align:top;padding:20px 0px;">
								<div style="color:#99AAB5;font-size:12px;line-height:24px;text-align:center;">Магазин цветов <a href="https://FlowLove.ru/" style="text-decoration: none; color: #ff1515;" target="_blank">FlowLove.ru</a></div>
							</td>
						</tr>

					</tbody>
				</table>

			</div>

		</div>

	</div>
	';

	return $structure;
}

function sendTelegram($message) {
	$token = TELEGRAM_TOKEN_1;
	$chat_id = TELEGRAM_CHAT_ID_1;

	$message = urlencode(trim($message));

	$url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}";

	//Передаем данные боту
//    if (!DEV_MODE) {
        $sendToTelegram = fopen($url,"r");
//    }
}

function sendInitTelegram($message) {
	$token = TELEGRAM_TOKEN_2;
	$chat_id = TELEGRAM_TOKEN_1;

	$message = urlencode(trim($message));

	$url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}";
	//Передаем данные боту
//    if (!DEV_MODE) {
        $sendToTelegram = fopen($url, 'r');
//    }
}

function telegramBot($data, $type = 'normal', $email = ''){
	$title = $type == 'one_click' ? 'Новый заказ (в один клик)' : 'Новый заказ';
	$title = $type == 'request' ? 'Новый заказ (заказать звонок)' : 'Новый заказ';


	if(!empty($data['message'])){
		$data['message'] = "Примечания к заказу: <b>" . $data['message'] . "</b>";
	}else{
		$data['message'] = "";
	}

	if(!empty($data['postcard'])){
		$data['postcard'] = "Текст для открытки: <b>" . $data['postcard'] . "</b>";
	}else{
		$data['postcard'] = "";
	}

	$data['phone'] = !empty($data['phone']) ? '<a href="tel:+' . $data['phone'] . '">' . $data['phone'] . '</a>' : '';
	$data['recipient_phone'] = !empty($data['recipient_phone']) ? '<a href="tel:+' . $data['recipient_phone'] . '">' . $data['recipient_phone'] . '</a>' : '';
	$data['delivery'] = !empty($data['delivery']) ? $data['delivery'] : '';
	$data['email'] = !empty($data['email']) ? $data['email'] : '';
	$data['recipient_name'] = !empty($data['recipient_name']) ? $data['recipient_name'] : '';
	$data['address'] = !empty($data['address']) ? $data['address'] : '';
	$data['promo'] = !empty($data['promo']) ? $data['promo'] : '';
	$data['discount'] = !empty($data['discount']) ? $data['discount'] . '%' : '';

	if($type == 'one_click') {
		$data['delivery'] = '';
	}

	////

	$header = [
		"<b>FlowLove " . CITIES[$data['city']]['name'] . "</b>",
		"$title: #" . $data['id'],
	];

	$header = implode("\n", $header);
	$content = [$header];

	////

	$customer = [];

	if(!empty($data['name'])) {
		$customer[] = "Имя заказчика: <b>" . $data['name'] . "</b>";
	}

	if(!empty($data['phone'])) {
		$customer[] = "Телефон заказчика: <b>" . $data['phone'] . "</b>";
	}

	if(!empty($data['email'])) {
		$customer[] = "E-mail заказчика: <b>" . $data['email'] . "</b>";
	}

	if(!empty($customer)) {
		array_unshift($customer, '<b>ЗАКАЗЧИК</b>');
		$customer = implode("\n", $customer);
		$content[] = $customer;
	} else {
		$customer = '';
	}

	////

	$recipient = [];

	if($type != 'one_click' && $type != 'request') {
		if(!empty($data['recipient_name'])) {
			$recipient[] = "Имя получателя: <b>" . $data['recipient_name'] . " </b>";
		}

		if(!empty($data['recipient_phone'])) {
			$recipient[] = "Телефон получателя: <b>" . $data['recipient_phone'] . " </b>";
		}

		if(!empty($data['address'])) {
			$recipient[] = "Адрес доставки: <b>" . $data['address'] . "</b>";
		}

		if(!empty($data['delivery'])) {
			$recipient[] = "Дата доставки: <b>" . $data['delivery'] . "</b>";
		}
	}

	if(!empty($recipient)) {
		array_unshift($recipient, '<b>ПОЛУЧАТЕЛЬ</b> ');
		$recipient = implode("\n", $recipient);
		$content[] = $recipient;
	} else {
		$recipient = '';
	}

	////

	$details = [];

	if(!empty($data['promo'])) {
		$details[] = "Промокод: <b>" . $data['promo'] . "</b>";
	}

	if(!empty($data['discount'])) {
		$details[] = "Скидка: <b>" . $data['discount'] . "</b>";
	}

	if(!empty($data['products'])) {
		$details[] = $data['products'];
	}

	if(!empty($data['postcard'])) {
		$details[] = $data['postcard'];
	}

	if(!empty($data['message'])) {
		$details[] = $data['message'];
	}

	if(!empty($details)) {
		array_unshift($details, '<b>ДЕТАЛИ ЗАКАЗА</b>');
		$details = implode("\n", $details);
		$content[] = $details;
	} else {
		$details = '';
	}

	////

	$total = [];

	if(!empty($data['price'])) {
		$total[] = "<b>ИТОГО</b>: " . $data['price'] . ' ' . CUR;
	}

	if(!empty($total)) {
		array_unshift($total, '<b>ИТОГО</b>');
		$total = implode("\n", $total);
		$content[] = $total;
	} else {
		$total = '';
	}

	////

	if(!empty($content)) {
		$content = implode("\n\n", $content);
	} else {
		$content = '';
	}

	////

	$message = $content;

	$headers = array(
		'content-type: text/html'
	);

	// if($email) {
	// 	$content = str_replace("\n", '<br>', $content);
	// 	wp_mail($email, 'Новая заявка на сайте', $content, $headers);
	// }

	sendTelegram($message);
	sendInitTelegram($message);
}

function sendOrder($fields, $products, $type = 'normal', $city = '') {
	global $wpdb;
	$telegram_products = [];

	if(is_user_logged_in()) {
		$fields['user_id'] = get_current_user_id();
	}

	$blocks_list = array(
		'79317659900',
		'79253764360',
		'79616380184',
		'77777777777'
	);


	foreach($blocks_list as $block_number){

		if($fields['phone'] == $block_number){
			die();
		}

	}

	$card_products = [];

	if($products) {
		if(!empty($fields['products'])) {
			$products = explode(';', $fields['products']);
			$quantity = 0;
			$price = 0;

			foreach($products as $item) {
				$item = explode(':', $item);
				$item_id = $item[0];
				$item_quantity = (int)$item[1];
				$item_price_data = getPrice($item_id, $city);
				$item_price = $item_price_data['price'];
                if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                    $item_price = $_SESSION['cart_florist_price'];
                }
                if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_file'])) {
                    $img_server_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                    $img_host_path =  '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                    if(file_exists($img_server_path)) {
                        $item_image = $img_host_path;
                    }
                } else {
                    $item_image = '';
                }
				$item_data = product_data($item_id);
				$title = $item_data->title;

				if($item_price_data['selectedKey']) {
					$title .= ' (' . $item_price_data['selectedKey'] . ')';
				}

				$card_products[] = [
					'id' => $item_id,
					'quantity' => $item_quantity,
					'price' => $item_price * $item_quantity,
				];

				$quantity += $item_quantity;
				$price += $item_price * $item_quantity;

				$telegram_products[] = '<b>' . $title . ' x ' . $item_quantity . '</b>: ' . $item_price . ' ' . CUR;
			}

			$fields['products'] = $fields['products'];
			$fields['quantity'] = $quantity;
			$fields['price'] = $price;
            $fields['image'] = $item_image;
		} else {
			$cart = cartInfo();
			$fields['products'] = $cart['session'];
			$fields['quantity'] = $cart['quantity'];
			$fields['price'] = $cart['price'];

			if(!empty($cart['promo'])) {
				$fields['promo'] = $cart['promo']['code'];
				$fields['discount'] = $cart['discount'];
			}

			if(!empty($cart['session'])) {
				$products = explode(';', $cart['session']);

				foreach($products as $item) {
					$item = explode(':', $item);
					$item_id = $item[0];
					$item_quantity = (int)$item[1];
					$item_price_data = getPrice($item_id, $city);
					$item_price = $item_price_data['price'];
                    if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_price'])) {
                        $item_price = $_SESSION['cart_florist_price'];
                    }
                    if ($item_id  == 'buketpofoto' && isset($_SESSION['cart_florist_file'])) {
                        $img_server_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                        $img_host_path =  'https://' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/init/catalog/user-images/' . $_SESSION['cart_florist_file'];
                        if(file_exists($img_server_path)) {
                            $item_image = $img_host_path;
                        }
                    } else {
                        $item_image = '';
                    }
					$item_data = product_data($item_id);
					$title = $item_data->title;

					if($item_price_data['selectedKey']) {
						$title .= ' (' . $item_price_data['selectedKey'] . ')';
					}

					$card_products[] = [
						'id' => $item_id,
						'quantity' => $item_quantity,
						'price' => $item_price * $item_quantity,
					];

					if ($item_image) {
					    $code_image = '<a href="'.$item_image.'">Фото букета</a> ';
                    } else {
                        $code_image = '';
                    }
					$telegram_products[] = $code_image . '<b>' . $title . ' x ' . $item_quantity . '</b>: ' . $item_price . ' ' . CUR;
				}
			}

			unset_session('cart');
		}
	}

	$old_date = '';
	if(!empty($fields['delivery'])) {
		$old_date = $fields['delivery'];
		$fields['delivery'] = date('Y-m-d H:i', strtotime($fields['delivery']));
	}

	$token = bin2hex(random_bytes(20));

	$fields['token'] = $token;
    write_session('last_order_token', $token);

	$wpdb->insert('init_orders', $fields);
	$fields['id'] = $wpdb->insert_id;
	$user_fields = $fields;

	$to_email = [NOTIFICATION_EMAIL];
	if(!empty($to_email)) {
		$filtred = [];
		$labels = [
            'id' => 'Номер заказа',
			'name' => 'Имя',
			'phone' => 'Номер телефона',
			'email' => 'Email',
			'recipient_name' => 'Имя получателя',
			'recipient_phone' => 'Телефон получателя',
			'address' => 'Адрес',
			'delivery' => 'Дата доставки',
			'postcard' => 'Текст для открытки',
			'message' => 'Примечания к заказу',
			'price' => 'Стоимость',
			'quantity' => 'Количество',
			'discount' => 'Скидка',
			'promo' => 'Промокод',
			'city' => 'Город',
			'type' => 'Тип',
			'image' => 'Фото букета',
		];

		foreach($fields as $key => $value) {
			if(!empty($labels[$key]) && $value) {

				if($key == 'phone' || $key == 'recipient_phone') {
					$value = '<a href="tel:+' . $value . '">' . $value . '</a>';
				}else if($key == 'email'){
					$value = '<a href="mailto:' . $value . '">' . $value . '</a>';
				}else if($key == 'discount'){
					$value = $value . '%';
				}else if($key == 'price'){
					$value = $value . '₽';
				}else if($key == 'quantity'){
					$value = $value . ' шт.';
				}else if($key == 'type'){
					$types = [
						'order' => 'Заказ',
						'one_click' => 'Заказ в один клик',
						'request' => 'Заказать звонок',
					];
					$value = !empty($types[$value]) ? $types[$value] : $types['request'];
				}
//                else if($key == 'image'){
//                    $value = '<img src="' . $value . '">';
//                }

				$label = $labels[$key];
				$filtred[] = '
					<div class="item">
						<h5 style="margin: 0 0 6px 0;">' . $label . '</h5>
						<p style="margin: 0;color: #000;">' . $value . '</p>
					</div>
					<br>
				';
			}
		}

		$filtred = implode('', $filtred);

		$mail_title = 'Новая заявка на сайте';
		$mail = '<tr><td>' . $filtred . '</td></tr>';
		$mail = initMailTemplate($mail_title, $mail);

		$headers = array(
			'content-type: text/html'
		);

        if (!DEV_MODE) {
            wp_mail($to_email, $mail_title, $mail, $headers);
        }

		$fields['date'] = date('d.m.Y H:i');
		$fields['products'] = implode("\n", $telegram_products);
		$fields['delivery'] = $old_date;
        if (!DEV_MODE) {
		    telegramBot($fields, $type, $to_email);
        }
	}

	if(!empty($user_fields['email'])) {
		$to_email = $user_fields['email'];

		$user_labels = [
			'id' => 'Номер заказа',
			'products' => 'Заказ',
			'recipient_name' => 'Имя получателя',
			'recipient_phone' => 'Телефон получателя',
			'address' => 'Адрес',
			'delivery' => 'Дата доставки',
			'postcard' => 'Текст для открытки',
			'message' => 'Примечания к заказу',
			'price' => 'Стоимость',
			'quantity' => 'Количество',
			'discount' => 'Скидка',
			'promo' => 'Промокод',
			'city' => 'Город',
			'name' => 'Имя',
			'phone' => 'Номер телефона',
			'email' => 'Email',
		];

		$filtred = ['
			<div class="item">
				<h5 style="margin: 0 0 6px 0;">Здравствуйте, ' . $user_fields['name'] . '.</h5>
				<p style="margin: 0;color: #000;">Спасибо за заказ. Он будет зарезервирован, пока мы не подтвердим, что платёж получен. В то же время, напоминаем содержимое вашего заказа:</p>
			</div>
			<br>
		'];

		foreach($user_labels as $key => $label) {
			if(!empty($user_fields[$key])) {
				$value = $user_fields[$key];

				if($key == 'phone' || $key == 'recipient_phone') {
					$value = '<a href="tel:+' . $value . '">' . $value . '</a>';
				}else if($key == 'email'){
					$value = '<a href="mailto:' . $value . '">' . $value . '</a>';
				}else if($key == 'discount'){
					$value = $value . '%';
				}else if($key == 'price'){
					$value = $value . '₽';
				}else if($key == 'quantity'){
					$value = $value . ' шт.';
				}else if($key == 'type'){
					$types = [
						'order' => 'Заказ',
						'one_click' => 'Заказ в один клик',
						'request' => 'Заказать звонок',
					];
					$value = !empty($types[$value]) ? $types[$value] : $types['request'];
				}else if($key == 'products'){
					$rows = [];
					$rows[] = '<tr><td>Наименование</td><td>Количество</td><td>Цена</td></tr>';

					if(!empty($card_products)) {
						foreach($card_products as $product) {
                            $slug = array_key_exists('slug', $product) ? $product['slug'] : null;

                            if (!$slug) {
                                // Иногда вместо слага можно использовать id
                                $slug = array_key_exists('id', $product) ? $product['id'] : null;
                            }
                            if (!$slug) continue;

							$product_data = product_data($slug);
							$rows[] = '<tr><td>' . $product_data->title . '</td> <td>' . $product['quantity'] . '</td> <td>' . ($product['price'] / $product['quantity']) . ' ' . CUR . '</td></tr>';
						}
					}

					$rows = implode('', $rows);
					$value = '<table border="1" style="width: 100%;">' . $rows . '</table>';
				}

				$label = $user_labels[$key];
				$filtred[] = '
					<div class="item">
						<h5 style="margin: 0 0 6px 0;">' . $label . '</h5>
						<p style="margin: 0;color: #000;">' . $value . '</p>
					</div>
					<br>
				';
			}
		}

		$mail_title = 'Спасибо за ваш заказ';
		$filtred = implode('', $filtred);
		$filtred = '<tr><td>' . $filtred . '</tr></td>';
		$mail = initMailTemplate($mail_title, $filtred);
        if (!DEV_MODE) {
            wp_mail($to_email, $mail_title, $mail, $headers);
        }
        return compact('token');
	}
}

function axiosSendOrder() {
	$data = json_decode(file_get_contents('php://input'), true);
	$fields = $data['fields'];
	$products = (int)$data['products'];
	$type = !empty($data['type']) ? $data['type'] : 'normal';
	$city = !empty($fields['city']) ? $fields['city'] : '';
    if (checkCaptcha($data['fields']['recaptcha_response'])) {
        unset($fields['recaptcha_response']);
        $data = sendOrder($fields, $products, $type, $city);
        Header('Content-Type: application/json; charset=UTF8');
        echo json_encode($data);
    }

	die();
}
add_action('wp_ajax_axiosSendOrder', 'axiosSendOrder');
add_action('wp_ajax_nopriv_axiosSendOrder', 'axiosSendOrder');

function checkCaptcha($token) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6Le6nHUkAAAAADEQaH7ZjDmr-iJcnQ18EouQgu95';
    $recaptcha_response = $token;
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    if ($recaptcha->success && $recaptcha->score >= 0.8) {
        return true;
    } else {
        return false;
    }
}

function sendReview() {
	global $wpdb;
	$data = json_decode(file_get_contents('php://input'), true);
	$name = $data['name'];
	$date = !empty($data['date']) ? date('Y-m-d H:i:s', strtotime($data['date'])) : date('Y-m-d H:i:s');
	$phone = $data['phone'];
	$review = $data['review'];
	$rating = $data['rating'];
	$image = !empty($data['image'][0]) ? $data['image'][0] : '';
	$image = $image ? save_image( $image['base64'], $image['type'] ) : '';
	$content = [];
	$stars = [];
	$status = current_user_can('administrator') ? 1 : 0;

	for($i = 1; $i < 6; $i++) {
		if($rating >= $i) {
			$stars[] = '★';
		} else {
			$stars[] = '☆';
		}
	}

	$stars = implode('', $stars);

	$wpdb->insert(
		'init_reviews',
		[
			'name' => $name,
			'phone' => $phone,
			'review' => $review,
			'rating' => $rating,
			'image' => $image,
			'date' => $date,
			'status' => $status
		]
	);
	$id = $wpdb->insert_id;

	$content[] = "<b>Новый отзыв на сайте: #$id</b>";
	$content[] = '';
	$content[] = 'Имя: <b>' . $name . '</b>';
	$content[] = 'Рейтинг: ' . $stars;
	$content[] = 'Отзыв: <b>' . $review . '</b>';

	$content = implode("\n", $content);
    if (!DEV_MODE) {
        sendTelegram($content);
    }
	die();
}
add_action('wp_ajax_sendReview', 'sendReview');
add_action('wp_ajax_nopriv_sendReview', 'sendReview');

function sendProductReview() {
	global $wpdb;
	$data = json_decode(file_get_contents('php://input'), true);
	$user_id = get_current_user_id();
	$name = !empty($data['name']) ? $data['name'] : $wpdb->get_var("SELECT `display_name` FROM `init_users` WHERE `ID` = $user_id");
	$date = !empty($data['date']) ? date('Y-m-d H:i:s', strtotime($data['date'])) : date('Y-m-d H:i:s');
	$product = $data['product'];
	$rating = $data['rating'];
	$review = $data['review'];
	$product_data = product_data($product);
	$product_name = $product_data->title;
	$link = get_site_url() . '/product/' . $product . '/';
	//$status = current_user_can('administrator') ? 'approved' : 'static';
	$status = 'approved';
	$content = [];
	$stars = [];

	for($i = 1; $i < 6; $i++) {
		if($rating >= $i) {
			$stars[] = '★';
		} else {
			$stars[] = '☆';
		}
	}

	$stars = implode('', $stars);

	$wpdb->insert(
		'init_rating',
		[
			'user_id' => $user_id,
			'review' => $review,
			'rating' => $rating,
			'product' => $product,
			'name' => $name,
			'date' => $date,
			'status' => $status,
		]
	);
	$id = $wpdb->insert_id;

	$content[] = "Новый отзыв на товар - <b>$product_name</b>";
	$content[] = '';
	$content[] = 'Имя: <b>' . $name . '</b>';
	$content[] = 'Рейтинг: ' . $stars;
	$content[] = 'Отзыв: <b>' . $review . '</b>';
	$content[] = 'Ссылка: <b>' . $link . '</b>';

	$content = implode("\n", $content);
    if (!DEV_MODE) {
        sendTelegram($content);
    }
	die();
}
add_action('wp_ajax_sendProductReview', 'sendProductReview');
add_action('wp_ajax_nopriv_sendProductReview', 'sendProductReview');

function updateProductRating($id) {
	global $wpdb;
	$rating = 0;
	$count = 0;
	$reviews = $wpdb->get_col("SELECT `rating` FROM `init_rating` WHERE `product` = '$id' AND `status` = 'approved' ORDER BY `id` DESC");

	if(!empty($reviews)) {
		$count = count($reviews);
		$rating = array_sum($reviews);
		$rating = floor($rating / $count);
	}

	$wpdb->delete(
		'init_product_rating',
		[
			'product' => $id
		]
	);

	$wpdb->insert(
		'init_product_rating',
		[
			'product' => $id,
			'rating' => $rating,
			'count' => $count,
		]
	);
}

function changeProductReviewStatus() {
	global $wpdb;
	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'];
	$product_id = $wpdb->get_var("SELECT `product` FROM `init_rating` WHERE `id` = $id");
	$status = $data['status'];

	$wpdb->update(
		'init_rating',
		[
			'status' => $status
		],
		[
			'id' => $id
		]
	);

	updateProductRating($product_id);

	die();
}
add_action('wp_ajax_changeProductReviewStatus', 'changeProductReviewStatus');
add_action('wp_ajax_nopriv_changeProductReviewStatus', 'changeProductReviewStatus');

function save_image( $base64_img, $type ) {
	if(!function_exists('wp_generate_attachment_metadata')) {
		require ABSPATH . 'wp-admin/flowers/image.php';
	}

	$upload_dir  = wp_upload_dir();
	$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

	$img             = str_replace( 'data:image/jpeg;base64,', '', $base64_img );
	$img             = str_replace( 'data:image/png;base64,', '', $img );
	$img             = str_replace( 'data:image/webp;base64,', '', $img );
	$img             = str_replace( ' ', '+', $img );
	$decoded         = base64_decode( $img );
	$file_type       = $type;
    $extenstion      = explode('/', $type);
    $extenstion      = end($extenstion);
	$hashed_filename = md5( 'image_' . microtime() ) . '.' . $extenstion;

	$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );

	$attachment = array(
		'post_mime_type' => $file_type,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
		'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
	);

	$attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
    wp_generate_attachment_metadata($attach_id, $upload_dir['path'] . '/' . $hashed_filename);
    return $attach_id;
}

/////

define('PROMO', [
	'FlowLove' => [
		'discount' => 5,
		'type' => 'percent',
		'code' => 'FlowLove'
	]
]);

function getPromo($promo) {
	$res = '';

	if(!empty(PROMO[$promo])) {
		$res = PROMO[$promo];
	}

	return $res;
}

function applyPromo($promo) {
	$search = getPromo($promo);

	if( !empty($search) ) {
		write_session('promo', $promo);
		return $search;
	}
}

function axiosApplyPromo() {
	$data = json_decode(file_get_contents('php://input'), true);
	$promo = $data['code'];
	$apply = applyPromo($promo);

	if(!empty($apply)) {
		echo json_encode($apply);
	}
	die();
}
add_action('wp_ajax_axiosApplyPromo', 'axiosApplyPromo');
add_action('wp_ajax_nopriv_axiosApplyPromo', 'axiosApplyPromo');

function promoForm() {
	$promo = !empty($_SESSION['promo']) ? $_SESSION['promo'] : '';

	if($promo) {
		$promo = getPromo($promo);
	}

	if(!empty($promo)) {
		$text = $promo['code'];

		if($promo['type'] == 'percent') {
			$text .= ' (-' . $promo['discount'] . '%)';
		} else {
			$text .= ' (-' . $promo['discount'] . ' ' . CUR . ')';
		}

		return '
		<form class="inline full">
			<div class="line">
				<div class="input-wrapper grow">
					<input type="text" id="promo_input" readonly placeholder="Введите промокод" value="' . $text . '">
				</div>
				<button class="btn promo-remove red-theme"><span class="icon icon-close"></span></button>
			</div>
		</form>
		';
	} else {
		return '
		<form class="inline full">
			<div class="line">
				<div class="input-wrapper grow">
					<input type="text" id="promo_input" placeholder="Введите промокод">
				</div>
				<button class="btn promo-send"><span class="icon icon-right"></span></button>
			</div>
		</form>
		';
	}

}

function axiosPromoForm() {
	echo promoForm();
	die();
}
add_action('wp_ajax_axiosPromoForm', 'axiosPromoForm');
add_action('wp_ajax_nopriv_axiosPromoForm', 'axiosPromoForm');

function removePromo() {
	unset_session('promo');
}

function axiosRemovePromo() {
	removePromo();
	die();
}
add_action('wp_ajax_axiosRemovePromo', 'axiosRemovePromo');
add_action('wp_ajax_nopriv_axiosRemovePromo', 'axiosRemovePromo');

define('USER', user_info());

function review($id) {
	global $wpdb;
	$review = $wpdb->get_row("SELECT * FROM `init_reviews` WHERE `id` = $id");

	if(!empty($review)) {
		$name = $review->name;
		$text = $review->review;
        $text = str_replace('[city]', CITY_GENITIVE, $text );
		$rating = $review->rating;
		$image = $review->image;
		$date = strtotime($review->date);
		$date = date('d.m.Y', $date);
		$stars = [];

		if($image) {
			$image = wp_get_attachment_image_url( $image, 'large');
			$image = '<div class="image"><img src="' . $image . '" loading="lazy" alt="Отзыв от ' . $name . ' на сайте FlowLove"></div>';
		} else {
			$image = '';
		}

		for($i = 1; $i < 6; $i++) {
			if($rating >= $i) {
				$stars[] = '<li class="star active icon-star-solid"></li>';
			} else {
				$stars[] = '<li class="star icon-star-solid"></li>';
			}
		}

		$stars = implode('', $stars);

		return '
		<div class="review-card">
			' . $image . '
			<div class="card-content">
				<div class="review-card-header">
					<div class="text">
						<div class="date">' . $date . ' г.</div>
						<div class="name">' . $name . '</div>
					</div>
					<ul class="star-rating">' . $stars . '</ul>
				</div>

				<div class="review-card-text">' . $text . '</div>
			</div>
		</div>
		';
	}
}

function print_contacts() {
	$print = [
		[
			'title' => 'Адрес',
			'items' => [ADDRESS],
			'type' => 'text'
		],
		[
			'title' => 'Номер телефона',
			'items' => PHONES,
			'type' => 'phone',
		],
		[
			'title' => 'Email',
			'items' => EMAILS,
			'type' => 'email',
		],
		[
			'title' => 'Соц. сети',
			'items' => SOCIAL,
			'type' => 'social',
		],
	];

	foreach($print as $item) {
		if(!empty($item['items'])) {
			$title = $item['title'];
			$type = $item['type'];
			$items = [];

			foreach($item['items'] as $key => $item) {
				switch ($type) {
					case 'text':
						$items[] = '<div class="value">' . $item . '</div>';
						break;
					case 'phone':
						$items[] = '<a href="tel:' . $item['link'] . '" class="value">' . $item['tel'] . '</a>';
						break;
					case 'email':
						$items[] = '<a href="mailto:' . $item . '" class="value">' . $item . '</a>';
						break;
					case 'link':
						$items[] = '<a href="' . $item . '" class="value">' . $item . '</a>';
						break;
					case 'social':
						$items[] = '<a href="' . $item . '" target="_blank" class="btn medium ' . $key . '-theme"><span class="icon icon-' . $key . '"></span></a>';
						break;
				}
			}

			$items = implode('', $items);

			if($type == 'social') {
				$items = '<div class="inline"><div class="line">' . $items . '</div></div>';
			}

			echo '
				<div class="article-sm contacts-item">
					<div class="label">' . $title . '</div>
					<div class="items article-sm">' . $items . '</div>
				</div>
			';
		}
	}
}

define('FAQ', [
    [
        'title' => 'Где мы находимся?',
        'text' => ADDRESS ? 'Доставка со склада в [city_genitive]. <div><b>Адрес магазина</b>: ' . ADDRESS . '</div>' : 'Доставка со склада в [city_genitive].',
    ],
    [
        'title' => 'Как вы доставите мой заказ?',
        'text' => 'Все доставки осуществляются курьером точно в срок. После доставки мы предоставляем фотоотчёт с получателем.',
    ],
    [
        'title' => 'Сколько стоит доставка?',
        'text' => 'В пределах города доставки в любое время дня и ночи осуществляется бесплатно не зависимо от выбранного вами товара Доставка в отдалённые населенные пункты, рассчитывается менеджером при оформлении заказа.',
    ],
    [
        'title' => 'Как быстро доставят заказ?',
        'text' => 'При предварительном оформлении заказа не менее чем за 2 часа до доставки, мы доставим ваш заказ к точному времени и дате. Если нужно быстрее звонить нам.',
    ],
    [
        'title' => 'Есть круглосуточная доставка?',
        'text' => 'Мы работаем 24 часа в сутки.',
    ],
    [
        'title' => 'Могу ли я сделать доставку сюрпризом или анонимно?',
        'text' => 'Мы не сообщим получателю о вашем заказе, если это сюрприз.',
    ],
    [
        'title' => 'Как я узнаю, что мой заказ доставили получателю?',
        'text' => 'Наши менеджеры пришлют вам смс уведомления о доставке (и вышлют фото с получателем). В случае отсутствия адресата, мы организуем повторную доставку.',
    ],
    [
        'title' => 'Как я могу оплатить заказ?',
        'text' => 'Оплатить ваш заказ вы можете любым удобным для Вас способом: Банковской картой ( Visa, MasterCard, МИР ) , Альфа банк Электронной платежной системой: (Robokassa, Qiwi-кошелек, Билайн, МТС,) – не доступно',
    ],
]);

function faq() {
	$structure = [];

	if(!empty(FAQ)) {
		foreach( FAQ as $item ){
			$question = do_shortcode($item['title']);
			$answer = do_shortcode($item['text']);

			$structure[] = '
			<div class="accord-item">

				<div class="accord-header">
					<div class="title">' . $question . '</div>
					<span class="indicator icon-down"></span>
				</div>

				<div class="accord-content article-sm article-block">' . $answer . '</div>

			</div>
			';
		}
	}

	if(!empty($structure)) {
		$structure = implode('', $structure);
		return '<div class="accord">' . $structure . '</div>';
	} else {
		return '';
	}
}

add_shortcode( 'faq', 'faq' );

function bread() {

	$bread = [
		[
			'title' => 'Доставка цветов в ' . CITY_GENITIVE,
			'link' => '/'
		]
	];

	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = explode('/', $url);
	$url = array_filter($url);

	foreach($url as $item) {
		$taxonomy = taxonomy_data($item);
		$tag = tag_data($item);
		$product = product_data($item);
		$flower = flower_data($item);

		if($item == 'product') {
			$bread[] = [
				'title' => 'Каталог',
				'link' => PRE_LINK . '/product/',
			];
		} else if (is_search()) {
			$bread[] = [
				'title' => 'Поиск',
				'link' => PRE_LINK . '/',
			];
		} else if ($item == 'tags') {

		} else if ($item == 'flowers') {
			$bread[] = [
				'title' => 'О цветах',
				'link' => PRE_LINK . '/flowers/',
			];

		} else if ($item == 'news') {
			$bread[] = [
				'title' => 'Новости',
				'link' => PRE_LINK . '/news/',
			];
		} else if(is_tax()) {
			$taxonomy = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			$bread[] = [
				'title' => $taxonomy->name,
				'link' => PRE_LINK . '/news/' . $taxonomy->slug . '/',
			];
		} else if ($item == 'catalog') {

		} else if ($item == 'dashboard') {
			$bread[] = [
				'title' => 'Личный кабинет',
				'link' => PRE_LINK . '/dashboard/',
			];
		} else if(!empty($product)) {
			$last = '';
			$taxonomies = product_taxonomies($item);

			if(!empty($taxonomies)) {
				foreach($taxonomies as $taxonomy) {
					$taxonomy = taxonomy_data($taxonomy);

					if(!$last || $taxonomy->parent == $last) {
						$tax_title = $taxonomy->title;
						$tax_parent = $taxonomy->parent ? $taxonomy->parent . '/' : '';
						$tax_slug = $taxonomy->slug;
						$tax_link = '/catalog/' . $tax_parent . $tax_slug . '/';

						$bread[] = [
							'title' => $tax_title,
							'link' => $tax_link,
						];

						$last = $tax_slug;
					}
				}
			}

			$bread[] = [
				'title' => $product->title,
				'link' => PRE_LINK . '/product/' . $product->slug . '/',
			];
		} else if(!empty($tag)) {
			$bread[] = [
				'title' => $tag->title,
				'link' => PRE_LINK . '/tags/' . $tag->slug . '/',
			];
		} else if(!empty($taxonomy)) {
			$bread[] = [
				'title' => $taxonomy->title,
				'link' => PRE_LINK . '/catalog/' . $taxonomy->slug . '/',
			];
		} else if(!empty($flower)) {
			$bread[] = [
				'title' => $flower->title,
				'link' => PRE_LINK . '/flowers/' . $flower->slug . '/',
			];
		} else if($item == CITY_SLUG) {
			$bread[0]['link'] = '/' . CITY_SLUG . '/';
		} else {
			$link = get_the_permalink();
			$link = str_replace(site_url(), PRE_LINK, $link);

			$bread[] = [
				'title' => get_the_title(),
				'link' => $link,
			];
		}
	}

	if(is_search()) {
		$bread[] = [
			'title' => 'Поиск',
			'link' => PRE_LINK . '/',
		];
	}

	$links = [];
	$last = count($bread) - 1;

	foreach($bread as $key => $item) {
		$name = $item['title'];
		$link = $item['link'];

		$link = $last == $key ? '<span class="current">' . $name . '</span>' : '<a href="' . $link . '">' . $name . '</a>';
		$links[] = $link;
	}

	$links = implode('<span class="arrow">»</span>', $links);

	echo '<p id="bread">' . $links . '</p>';
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

function product_review($id) {
	global $wpdb;
	$data = $wpdb->get_row("SELECT * FROM `init_rating` WHERE `id` = $id");
	$user_id = $data->user_id;
	$name = $data->name ? $data->name : $wpdb->get_var("SELECT `display_name` FROM `init_users` WHERE `ID` = $user_id");
	$review = $data->review;
	$rating = $data->rating;
	$date = date('d.m.Y', strtotime($data->date));
	$status = $data->status;
	$stars = [];
	$bottom = [];

	for($i = 1; $i < 6; $i++) {
		if($rating >= $i) {
			$stars[] = '<li class="star active icon-star-solid"></li>';
		} else {
			$stars[] = '<li class="star icon-star-solid"></li>';
		}
	}

	$stars = implode('', $stars);

	if(current_user_can('administrator')) {
		$bottom[] = '<div class="action change-product-review-status red-theme" data-status="deleted" data-id="' . $id . '">Удалить</div>';

		if($status != 'approved') {
			$bottom[] = '<div class="action change-product-review-status" data-status="approved" data-id="' . $id . '">Одобрить</div>';
		}
	}

	if(!empty($bottom)) {
		$bottom = implode('', $bottom);
		$bottom = '<div class="comment-bottom">' . $bottom . '</div>';
	} else {
		$bottom = '';
	}

	return '
	<div class="comment ' . $status . '">
		<div class="comment-header">
			<div class="text">
				<div class="title">' . $name . '</div>
				<div class="date">' . $date . ' г.</div>
			</div>

			<ul class="star-rating">' . $stars . '</ul>
		</div>
		<div class="comment-content">' . $review . '</div>
		' . $bottom . '
	</div>
	';
}

function print_rating($post_id) {
	global $wpdb;
	$slug = get_post_field('post_name', $post_id);
	$sku = CITY_SLUG ? $slug . '-' . CITY_SLUG : $slug;
	$rating = 0;
	$count = 0;
	$best = 0;
	$data = [
		'@context' => 'http://schema.org',
		'@type' => 'Product',
		'name' => do_shortcode(TITLE),
		'url' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
		'image' => 'https://' . $_SERVER['SERVER_NAME']. '/wp-content/themes/init/img/about-1.webp',
		'description' => do_shortcode(DESCRIPTION),
		// 'offers' => do_shortcode(DESCRIPTION),
		'sku' => $sku,
		'gtin' => $sku,
		'brand' => [
			'@type' => 'Brand',
			'name' => 'INIT KZ'
		]
	];

	$get_rating = $wpdb->get_results("SELECT * FROM `init_reviews` WHERE `status` = 1 ORDER BY `id` DESC");

	if(!empty($get_rating)) {
		$reviews = [];
		$count = count($get_rating);

		foreach($get_rating as $item) {
			$date = date('Y-m-d', strtotime($item->date));
			$rating += $item->rating;

			if($item->rating > $best) {
				$best = $item->rating;
			}

			$reviews[] = [
				'@type' => 'Review',
				'datePublished' => $date,
				'reviewBody' => str_replace('"', '', $item->review),
				'author' => [
					'@type' => 'Person',
					'name' => $item->name
				],
				'reviewRating' => [
					'@type' => 'Rating',
					'ratingValue' => intval($item->rating)
				]
			];
		}

		$rating = round($rating / $count, 1);

		$data['aggregateRating'] = [
			'@type' => 'AggregateRating',
			'ratingValue' => floatval($rating),
			'bestRating' => intval($best),
			'reviewCount' => intval($count)
		];
		$data['review'] = $reviews;

		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		echo '<script type="application/ld+json">' . stripslashes($data) . '</script>';
	}
}

function print_product_rating($slug) {
	global $wpdb;
	$sku = $slug;
	$rating = 0;
	$count = 0;
	$best = 0;
	$data = [
		'@context' => 'http://schema.org',
		'@type' => 'Product',
		'name' => do_shortcode(TITLE),
		'url' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
		'image' => 'https://' . $_SERVER['SERVER_NAME']. '/wp-content/themes/init/img/about-1.webp',
		'description' => do_shortcode(DESCRIPTION),
		// 'offers' => do_shortcode(DESCRIPTION),
		'sku' => $sku,
		'gtin' => $sku,
		'brand' => [
			'@type' => 'Brand',
			'name' => 'FlowLove'
		]
	];

	$get_rating = $wpdb->get_results("SELECT * FROM `init_rating` WHERE `status` = 'approved' AND `product` = '$slug' ORDER BY `id` DESC");

	if(!empty($get_rating)) {
		$reviews = [];
		$count = count($get_rating);

		foreach($get_rating as $item) {
			$date = date('Y-m-d', strtotime($item->date));
			$rating += $item->rating;
			$user_id = $item->user_id;
			$name = $wpdb->get_var("SELECT `display_name` FROM `init_users` WHERE `ID` = $user_id");
            if(!$name) {
                $name = 'Покупатель';
            }
			if($item->rating > $best) {
				$best = $item->rating;
			}

			$reviews[] = [
				'@type' => 'Review',
				'datePublished' => $date,
				'reviewBody' => $item->review,
				'author' => [
					'@type' => 'Person',
					'name' => $name
				],
				'reviewRating' => [
					'@type' => 'Rating',
					'ratingValue' => intval($item->rating)
				]
			];
		}

		$rating = round($rating / $count, 1);

		$data['aggregateRating'] = [
			'@type' => 'AggregateRating',
			'ratingValue' => floatval($rating),
			'bestRating' => intval($best),
			'reviewCount' => intval($count)
		];
		$data['review'] = $reviews;

		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		echo '	<script type="application/ld+json">' . stripslashes($data) . '</script>';
	}
}

function print_category_rating($slug) {
    $args = [
        'posts_per_page' => '-1',
        'taxonomy' => $slug
    ];
    $products_array = get_products($args);
    global $wpdb;
    $sku = $slug;
    $rating = 0;
    $count = 0;
    $data = [
        '@context' => 'http://schema.org',
        '@type' => 'Product',
        'name' => do_shortcode(TITLE),
        'url' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
        'image' => 'https://' . $_SERVER['SERVER_NAME']. '/wp-content/themes/init/img/about-1.webp',
        'description' => do_shortcode(DESCRIPTION),
        // 'offers' => do_shortcode(DESCRIPTION),
        'sku' => $sku,
        'gtin' => $sku,
        'brand' => [
            '@type' => 'Brand',
            'name' => 'FlowLove'
        ]
    ];

    $get_rating = $wpdb->get_results("SELECT `rating` FROM `init_rating` WHERE `status` = 'approved' AND `product` IN ('" . implode("','",  $products_array['ids']) . "')");

    if(!empty($get_rating)) {
        $count = count($get_rating);

        foreach($get_rating as $item) {
            $rating += $item->rating;
        }

        $rating = round($rating / $count, 1);

        $data['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => floatval($rating),
            'reviewCount' => intval($count)
        ];

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo '	<script type="application/ld+json">' . stripslashes($data) . '</script>';
    }
}

function print_blocks($data) { ?>

	<section class="about section-padding bordered">
		<div class="container">
			<div class="wrapper article-lg">
				<?php
					$index = 0;
					foreach($data as $row) {
						echo '<div class="row">';

						foreach($row as $col) {
							$type = $col['type'];

							if($type == 'image') {
								$url = !empty($col['url']) ? $col['url'] : '';
								$alt = !empty($col['alt']) ? $col['alt'] : '';

								echo '
								<div class="image">
									<img src="' . $url . '" alt="' . $alt . '" loading="lazy">
								</div>
								';
							} else if ($type == 'text') {
								$subtitle = !empty($col['subtitle']) ? '<div class="subtitle grey">' . do_shortcode($col['subtitle']) . '</div>' : '';

								if($index) {
									$title = !empty($col['title']) ? '<h3 class="h1">' . do_shortcode($col['title']) . '</h3>' : '';
								} else {
									$title = !empty($col['title']) ? '<h2 class="h1 large">' . do_shortcode($col['title']) . '</h2>' : '';
								}

								$header = $title || $subtitle ? '<div class="article-sm">' . $subtitle . $title . '</div>' : '';
								$text = !empty($col['text']) ? do_shortcode($col['text']) : '';
								$btn = '';

								if(!empty($col['btn'])) {
									$btn_data = $col['btn'];
									$classes = ['btn'];
									$type = !empty($btn_data['type']) ? $btn_data['type'] : '';
									$btn_text = !empty($btn_data['text']) ? $btn_data['text'] : '';

									if($type) {
										$classes[] = $type;
									}

									$classes = implode(' ', $classes);

									if(!empty($btn_data['url'])) {
										$url = !empty($btn_data['url']) ? $btn_data['url'] : '';

										$btn = '<a href="' . $url . '" class="' . $classes . '"><span class="text">' . $btn_text . '</span></a>';
									} else {
										$btn = '<button class="' . $classes . '"><span class="text">' . $btn_text . '</span></button>';
									}
								}

								echo '
								<div class="content article article-block">
									' . $header . $text . $btn . '
								</div>
								';
							}

							$index++;
						}

						echo '</div>';
					}
				?>
			</div>
		</div>
	</section>

<?php }

//////


function updatePrices($city) {
	$file_slug = $city ? $city : 'moscow';
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/prices/' . $file_slug . '.csv';
	$keys = [
		'лента' => [
			'type' => 'product',
			'value' => 'atlasnaya-lenta'
		],
		'пленка' => [
			'type' => 'product',
			'value' => 'plenka'
		],
		'крафт' => [
			'type' => 'product',
			'value' => 'kraft'
		],
		'пленка матовая' => [
			'type' => 'product',
			'value' => 'plenka-matovaya'
		],
		'фетр' => [
			'type' => 'product',
			'value' => 'fetr'
		],
		'фоамиран' => [
			'type' => 'product',
			'value' => 'foamiran'
		],
		'роза россия' => [
			'type' => 'tax',
			'value' => 'roza-rossijskaya'
		],
		'роза голландия' => [
			'type' => 'tax',
			'value' => 'rozy-gollandskie'
		],
		'роза эквадор' => [
			'type' => 'tax',
			'value' => 'rozy-ekvadorskie'
		],
		'роза кения' => [
			'type' => 'tax',
			'value' => 'rozy-kenijskie'
		],
		'роза кустовая' => [
			'type' => 'tax',
			'value' => 'rozy-kustovye'
		],
		'роза редкие' => [
			'type' => 'tax',
			'value' => 'raduzhnye-rozy'
		],
		'роза пионна видная' => [
			'type' => 'tax',
			'value' => 'rozy-pionovidnye'
		],
		'тюльпаны' => [
			'type' => 'tax',
			'value' => 'tjulpany'
		],
		'хризантемы одноголовая' => [
			'type' => 'tax',
			'value' => 'hrizantemy-odnogolovye'
		],
		'хризантемы кустовые' => [
			'type' => 'tax',
			'value' => 'hrizantemy-kustovye'
		],
		'гиацинт' => [
			'type' => 'tax',
			'value' => 'giacinty'
		],
		'пион' => [
			'type' => 'tax',
			'value' => 'piony'
		],
		'альстромерия' => [
			'type' => 'tax',
			'value' => 'alstromerii'
		],
		'ирис' => [
			'type' => 'tax',
			'value' => 'irisy'
		],
		'гербера' => [
			'type' => 'tax',
			'value' => 'gerbery'
		],
		'лилия' => [
			'type' => 'tax',
			'value' => 'lilii'
		],
		'гортензия' => [
			'type' => 'tax',
			'value' => 'gortenzii'
		],
		'эустома' => [
			'type' => 'tax',
			'value' => 'eustomy'
		],
		'гипсофил' => [
			'type' => 'tax',
			'value' => 'gipsofily'
		],
		'ромашки' => [
			'type' => 'tax',
			'value' => 'romashki'
		],
		'гвоздика' => [
			'type' => 'tax',
			'value' => 'gvozdiki'
		],
		'букеты' => [
			'type' => 'tax',
			'value' => 'bukety'
		],
		'цветы в коробках' => [
			'type' => 'tax',
			'value' => 'cvety-v-korobke'
		],
		'корзины с цветами' => [
			'type' => 'tax',
			'value' => 'korziny-s-cvetami'
		],
		'нарцисс' => [
			'type' => 'tax',
			'value' => 'narczissy'
		],
	];

	if(file_exists($file)) {
		echo '<pre>';
		$content = file_get_contents($file);
		$content = explode("\n", $content);

		array_shift($content);
		foreach($content as $item) {
			if(trim($item)) {
				$item = explode(';', $item);
				$cleared = [];

				foreach($item as $col) {
					$col = trim($col);
					$cleared[] = $col;
				}

				$item = $cleared;
				$name = $item[0];
				$price = $item[1];
				$cm50 = $item[2];
				$cm60 = $item[3];
				$cm70 = $item[4];
				$cm80 = $item[5];
				$cm90 = $item[6];
				$cm100 = $item[7];
				$small = $item[8];
				$medium = $item[9];
				$big = $item[10];
				$excl = $item[11];

				$products = [];

				if(!empty($keys[$name])) {
					$data = $keys[$name];
					$type = $data['type'];
					$value = $data['value'];

					if($type == 'product') {
						$products[] = product_data($value, true, true);
					} else if($type == 'tax') {
						$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json';
						$items = file_get_contents($file);
						$items = json_decode($items);
						$items = $items->taxonomy_products;
						$slugs = $items->{$value};

						foreach($slugs as $slug) {
							$products[] = product_data($slug, true, true);
						}
					}
				}

				if($price) {
					$filtred = [];
					foreach($products as $product) {
						if(!empty($product['prices'][$city])) {
							$product['prices'][$city]['price'] = (int)$price;
						} else {
							$product['prices'][$city] = [
								'price' => (int)$price,
								'old_price' => 0,
							];
						}

						$filtred[] = $product;
					}

					$products = $filtred;
				}

				$variants = [
					'50' => $cm50,
					'60' => $cm60,
					'70' => $cm70,
					'80' => $cm80,
					'90' => $cm90,
					'100' => $cm100,
					'малый' => $small,
					'средний' => $medium,
					'большой' => $big,
					'эксклюзивный' => $excl,
				];

				foreach($variants as $label => $value) {
					if($value) {
						foreach($products as $key => $product) {
							if(empty($product['variants'][$label])) {
								$product['variants'][$label] = [
									'title' => $label,
									'price' => $value,
									'prices' => []
								];
							}

							$product['variants'][$label]['prices'][$city] = [
								'price' => $value,
								'old_price' => 0,
							];

							$products[$key] = $product;
						}
					}
				}

				foreach($products as $product) {
					$slug = $product['slug'];
					$product = json_encode($product, JSON_UNESCAPED_UNICODE);
					$path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products/' . $slug . '.json';
					$file = fopen($path, "w");
					fwrite($file, $product);
					fclose($file);
				}
			}
		}
		echo '</pre>';
	}
}


///// SEO TAGS

remove_action( 'wp_head', 'wp_generator');

add_filter('after_setup_theme', 'gomaya_remove_shortlink');
function gomaya_remove_shortlink() {
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action( 'template_redirect', 'wp_shortlink_header', 11);
}

remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wlwmanifest_link');

add_shortcode( 'message_block', 'message_block' );
function message_block( $atts, $content ){
	$icon = !empty($atts['icon']) ? $atts['icon'] : '';

	return '
	<div class="message-block">
		<div class="avatar icon-' . $icon . '"></div>
		<div class="message-block-content">
			<p class="text">' . $content . '</p>
		</div>
	</div>
	';
}

function get_flowers() {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/flowers.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->flowers;

	return $data;
}

function product_flowers($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-flowers.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->product_flowers;

	return !empty($products->{$slug}) ? $products->{$slug} : [];
}

function flower_products($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/flower-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->flower_products;

	return !empty($products->{$slug}) ? $products->{$slug} : [];
}

function flower_data($slug) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/flowers.json';
	$data = file_get_contents($file);
	$data = json_decode($data);
	$data = $data->flowers;
	$result = '';

	if(!empty($data->{$slug})) {
		$result = $data->{$slug};
	}

	return $result;
}

add_filter( 'wp_robots', function($robots) {
	return [];
});

function start_wp_head_buffer() {
	ob_start();
}
add_action('wp_head','start_wp_head_buffer',0);

function end_wp_head_buffer() {
	$in = ob_get_clean();
	$in = explode("\n", $in);
	$filtred = [];

	foreach($in as $row) {
		$first = mb_substr($row, 0, 1);

		if($first != '	') {
			$row = '	' . $row;
		}

		$filtred[] = $row;
	}

	$filtred = implode("\n", $filtred);

	echo $filtred;
}
add_action('wp_head','end_wp_head_buffer', PHP_INT_MAX);

function taxonomy_list_item($taxonomy) {
	$slug = $taxonomy->slug;
	$data = taxonomy_data($slug);
	$title = $taxonomy->title;
	$parent = $taxonomy->parent ? $taxonomy->parent . '/' : '';

	return '<a href="' . PRE_LINK . '/catalog/' . $parent . $slug . '/">' . $title . '</a>';
}

add_filter( 'robots_txt', function( $output, $public ) {

	$output = explode("\n", $output);
	$content = [];
	$site_url = parse_url( site_url() );

    if ( '0' == $public ) {

        $output = "User-agent: *\nDisallow: /\nDisallow: /*\nDisallow: /*?\n";

    } else {

		$content[] .= "Disallow: /cgi-bin";
		$content[] .= "Disallow: /wp/";

		$content[] .= "";
		$content[] .= "Disallow: /?";
		$content[] .= "Disallow: *?s=";
		$content[] .= "Disallow: *&s=";
		$content[] .= "Disallow: /search";
		$content[] .= "Disallow: /author/";
		$content[] .= "Disallow: */embed";
		$content[] .= "Disallow: */page/";
		$content[] .= "Disallow: */xmlrpc.php";
		$content[] .= "Disallow: *utm*=";
		$content[] .= "Disallow: *openstat=";
		$content[] .= "Disallow: /wp-";
		$content[] .= "Disallow: */trackback";

		$content[] .= "";
		$content[] .= "Disallow: *?C=";
		$content[] .= "Disallow: */vendor";
		$content[] .= "Disallow: */bootstrap";
		$content[] .= "Disallow: */tests";
		$content[] .= "Disallow: */storage";
		$content[] .= "Disallow: */resources";
		$content[] .= "Disallow: */app";
		$content[] .= "Disallow: */config";

		$content[] .= "";
		$content[] .= "Disallow: */feed";
		$content[] .= "Disallow: */rss";

		$content[] .= "";
		$content[] .= "Disallow: */init";
		$content[] .= "Disallow: */fav";
		$content[] .= "Disallow: */login";
		$content[] .= "Disallow: */register";
		$content[] .= "Disallow: */restore";
		$content[] .= "Disallow: */dashboard";
		$content[] .= "Disallow: */success";
		$content[] .= "Disallow: */checkout";
		$content[] .= "Disallow: */order";
		$content[] .= "Disallow: */privacy-policy";
		$content[] .= "Disallow: */cart";
		$content[] .= "Disallow: */auth";
		$content[] .= "Disallow: */warranty";
		$content[] .= "Disallow: */return";
		$content[] .= "Disallow: */how";

		$content[] .= "";
		$content[] .= "Disallow:";
		$content[] .= "Clean-param: add-to-cart /product/*";
		$content[] .= "Clean-param: add-to-cart /catalog/*";

		$content[] .= "";
		$content[] .= "Allow:    */wp-*/*ajax*.php";
		$content[] .= "Allow:    */wp-sitemap";
		$content[] .= "Allow:    */uploads";
		$content[] .= "Allow:    */wp-*/*.js";
		$content[] .= "Allow:    */wp-*/*.css";
		$content[] .= "Allow:    */wp-*/*.mp3";
		$content[] .= "Allow:    */wp-*/*.png";
		$content[] .= "Allow:    */wp-*/*.jpg";
		$content[] .= "Allow:    */wp-*/*.jpeg";
		$content[] .= "Allow:    */wp-*/*.gif";
		$content[] .= "Allow:    */wp-*/*.svg";
		$content[] .= "Allow:    */wp-*/*.webp";
		$content[] .= "Allow:    */wp-*/*.pdf";

		$content[] .= "
User-agent: Googlebot
Disallow: /wp-admin/
Disallow: /cgi-bin
Disallow: /wp/
Disallow: /search
Disallow: /author/
Disallow: */embed
Disallow: */page/
Disallow: */xmlrpc.php
Disallow: /wp-
Disallow: */trackback
Disallow: *?*
Disallow: */vendor
Disallow: */bootstrap
Disallow: */tests
Disallow: */storage
Disallow: */resources
Disallow: */app
Disallow: */config
Disallow: */init
Disallow: */fav
Disallow: */login
Disallow: */register
Disallow: */restore
Disallow: */dashboard
Disallow: */success
Disallow: */checkout
Disallow: */order
Disallow: */privacy-policy
Disallow: */cart
Disallow: */auth
Disallow: */warranty
Disallow: */return
Disallow: */how
Allow: */wp-*/*ajax*.php
Allow: */wp-sitemap
Allow: */uploads
Allow: */wp-*/*.js
Allow: */wp-*/*.css
Allow: */wp-*/*.mp3
Allow: */wp-*/*.png
Allow: */wp-*/*.jpg
Allow: */wp-*/*.jpeg
Allow: */wp-*/*.gif
Allow: */wp-*/*.svg
Allow: */wp-*/*.webp
Allow: */wp-*/*.pdf";

		$content[] .= "
User-agent: Yandex
Disallow: /wp-admin/
Disallow: /cgi-bin
Disallow: /wp/
Disallow: /search
Disallow: /author/
Disallow: */embed
Disallow: */page/
Disallow: */xmlrpc.php
Disallow: /wp-
Disallow: */trackback
Disallow: *?*
Disallow: */vendor
Disallow: */bootstrap
Disallow: */tests
Disallow: */storage
Disallow: */resources
Disallow: */app
Disallow: */config
Disallow: */init
Disallow: */fav
Disallow: */login
Disallow: */register
Disallow: */restore
Disallow: */dashboard
Disallow: */success
Disallow: */checkout
Disallow: */order
Disallow: */privacy-policy
Disallow: */cart
Disallow: */auth
Disallow: */warranty
Disallow: */return
Disallow: */how
Allow: */wp-*/*ajax*.php
Allow: */wp-sitemap
Allow: */uploads
Allow: */wp-*/*.js
Allow: */wp-*/*.css
Allow: */wp-*/*.mp3
Allow: */wp-*/*.png
Allow: */wp-*/*.jpg
Allow: */wp-*/*.jpeg
Allow: */wp-*/*.gif
Allow: */wp-*/*.svg
Allow: */wp-*/*.webp
Allow: */wp-*/*.pdf
Clean-param: add-to-cart /product/*
Clean-param: add-to-cart /catalog/*
		";
    }

	$content = implode("\n", $content);
	$output[3] = "" . $content . "\n";

	$output = implode("\n", $output);

	$output .= "\n" . "Host: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}";

	$robots = preg_replace( '/Allow: [^\0\s]*\/wp-admin\/admin-ajax\.php\n/', '', $output );

	if ( null !== $robots ) {
		$output = $robots;
	}

    return $output;

}, 99, 2 );

function copy_reviews($from, $to) {
	global $wpdb;
	$reviews = $wpdb->get_results("SELECT * FROM `init_rating` WHERE `product` = '$from'");

	if(!empty($reviews)) {
		foreach($reviews as $review) {
			unset($review->id);

			$review->product = $to;

			$wpdb->insert(
				'init_rating',
				(array)$review
			);
		}
	}

	updateProductRating($to);
}

function writeFile($file, $text) {
	$myfile = fopen($file, 'w') or die("Unable to open file!");
	fwrite($myfile, $text);
	fclose($myfile);
}

function changeProductTaxonomy($slug, $taxonomies) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-taxonomies.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$product_taxonomies = $products->product_taxonomies;

	$product_taxonomies->{$slug} = $taxonomies;

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$taxonomy_products = $products->taxonomy_products;

	$old_value = product_taxonomies($slug);

	if(!empty($old_value)) {
		foreach($old_value as $item) {
			if(!empty($taxonomy_products->{$item})) {
				$index = array_search($slug, $taxonomy_products->{$item});
				unset($taxonomy_products->{$item}[$index]);
				$taxonomy_products->{$item} = array_values($taxonomy_products->{$item});
			}
		}
	}

	if(!empty($taxonomies)) {
		foreach($taxonomies as $item) {
			if(empty($taxonomy_products->{$item})) {
				$taxonomy_products->{$item} = [];
			}

			$taxonomy_products->{$item}[] = $slug;
		}
	}

	$product_taxonomies = ['product_taxonomies' => $product_taxonomies];
	$product_taxonomies = json_encode($product_taxonomies);

	$taxonomy_products = ['taxonomy_products' => $taxonomy_products];
	$taxonomy_products = json_encode($taxonomy_products);

	writeFile($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-taxonomies.json', $product_taxonomies);
	writeFile($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomy-products.json', $taxonomy_products);
}

function changeProductTags($slug, $tags) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-tags.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$product_tags = $products->product_tags;

	$product_tags->{$slug} = $tags;

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tag-products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$tag_products = $products->tag_products;

	$old_value = product_tags($slug);

	if(!empty($old_value)) {
		foreach($old_value as $item) {
			if(!empty($tag_products->{$item})) {
				$index = array_search($slug, $tag_products->{$item});
				unset($tag_products->{$item}[$index]);
				$tag_products->{$item} = array_values($tag_products->{$item});
			}
		}
	}

	if(!empty($tags)) {
		foreach($tags as $item) {
			if(empty($tag_products->{$item})) {
				$tag_products->{$item} = [];
			}

			$tag_products->{$item}[] = $slug;
		}
	}

	$product_tags = ['product_tags' => $product_tags];
	$product_tags = json_encode($product_tags);

	$tag_products = ['tag_products' => $tag_products];
	$tag_products = json_encode($tag_products);

	writeFile($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-tags.json', $product_tags);
	writeFile($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/tag-products.json', $tag_products);
}

function transliterate($input) {
    $replace=array(
        " "=>"-",
        '"'=>'',
        "«"=>"",
        "»"=>"",
        "ый"=>"yj",
        "№"=>"",
        "'"=>"",
        "`"=>"",
        "а"=>"a","А"=>"a",
        "б"=>"b","Б"=>"b",
        "в"=>"v","В"=>"v",
        "г"=>"g","Г"=>"g",
        "д"=>"d","Д"=>"d",
        "е"=>"e","Е"=>"e",
        "ё"=>"e","Ё"=>"e",
        "ж"=>"zh","Ж"=>"zh",
        "з"=>"z","З"=>"z",
        "и"=>"i","И"=>"i",
        "й"=>"j","Й"=>"j",
        "к"=>"k","К"=>"k",
        "л"=>"l","Л"=>"l",
        "м"=>"m","М"=>"m",
        "н"=>"n","Н"=>"n",
        "о"=>"o","О"=>"o",
        "п"=>"p","П"=>"p",
        "р"=>"r","Р"=>"r",
        "с"=>"s","С"=>"s",
        "т"=>"t","Т"=>"t",
        "у"=>"u","У"=>"u",
        "ф"=>"f","Ф"=>"f",
        "х"=>"h","Х"=>"h",
        "ц"=>"cz","Ц"=>"cz",
        "ч"=>"ch","Ч"=>"ch",
        "ш"=>"sh","Ш"=>"sh",
        "щ"=>"sch","Щ"=>"sch",
        "ь"=>"","Ь"=>"",
        "ы"=>"y","Ы"=>"y",
        "ъ"=>"","Ъ"=>"",
        "э"=>"e","Э"=>"e",
        "ю"=>"yu","Ю"=>"yu",
        "я"=>"ya","Я"=>"ya",
        "і"=>"i","І"=>"i",
        "ї"=>"yi","Ї"=>"yi",
        "є"=>"e","Є"=>"e"
    );

    return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($input,$replace));
}

function unique_product_id ($slug) {
    $products_ids_file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products-ids.json';
    $products_ids = file_get_contents($products_ids_file);
    $products_ids = json_decode($products_ids, true);
    $rand_num = rand(2000, 9999999);
    if (in_array($rand_num, $products_ids)) {
        $new_id = unique_product_id($slug);
    } else {
        $new_id = $rand_num;
        $products_ids[$slug] = $new_id;
        $products_ids_json = json_encode($products_ids, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        file_put_contents($products_ids_file, $products_ids_json);
    }
    return $new_id;
}

function addProduct($data) {
	$dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/';

	// print_r( $data );

	// die();

	$images = $data['image'];


	$title = $data['title'];
	//$slug = $data['slug'];
	//$slug = $slug ? $slug : urldecode( sanitize_title(preg_replace('/[^0-1a-zA-Zа-яА-Я]/um', '', $title)) );

    $slug = transliterate($title);

    unique_product_id($slug);

	$sizes = [
		'full',
		'large',
		'medium',
		'thumbnail',
	];

	foreach($images as $key => $image) {
		$image = $image ? save_image( $image['base64'], $image['type'] ) : '';

		foreach($sizes as $size) {
			$url = wp_get_attachment_image_url($image, $size);
			$url = str_replace(get_site_url(), $_SERVER['DOCUMENT_ROOT'], $url);

			copy($url, $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/images/products/' . $slug . '-' . $key . '-' . $size . '.webp');
		}

		wp_delete_attachment($image, true);

	}

	$description = $data['description'];
	$price = $data['price'];
	$prices = $data['prices'];
	$variants = $data['variants'];
	$taxonomies = $data['taxonomies'];
	$tags = $data['tags'];
	$product_data = [
		'slug' => $slug,
		'title' => $title,
		'description' => $description,
		'price' => $price,
		'old_price' => 0,
		'prices' => $prices,
		'variants' => $variants,
	];

	$product_data = json_encode($product_data, JSON_UNESCAPED_UNICODE);

	writeFile($dir . 'products/' . $slug . '.json', $product_data);

	$file = $dir . 'products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->products;
	$index = array_search($slug, $products);

	if($index === false) {
		$products[] = $slug;
		$products = ['products' => $products];
		$products = json_encode($products);

		writeFile($dir . 'products.json', $products);
	}

	changeProductTaxonomy($slug, $taxonomies);
	changeProductTags($slug, $tags);

	return '/product/' . $slug . '/';
}

function axiosAddProduct() {
	$data = json_decode(file_get_contents('php://input'), true);

	echo addProduct($data);
	die();
}
add_action('wp_ajax_axiosAddProduct', 'axiosAddProduct');
add_action('wp_ajax_nopriv_axiosAddProduct', 'axiosAddProduct');

function axiosDeleteProductImage() {
    $image_name = json_decode(file_get_contents('php://input'), true);
    $image_array = explode('-', $image_name[0]);

    $exists_files = glob($_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/init/catalog/images/products/".$image_array[0]."-".$image_array[1]."*.webp");
    if($exists_files) {
        foreach ($exists_files as $exists_file) {
            unlink($exists_file);
        }
    }
    die();
}
add_action('wp_ajax_axiosDeleteProductImage', 'axiosDeleteProductImage');
add_action('wp_ajax_nopriv_axiosDeleteProductImage', 'axiosDeleteProductImage');

function removeProduct($slug) {
	changeProductTaxonomy($slug, []);
	changeProductTags($slug, []);

	$dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/';
	$remove = [
		$dir . 'images/products/' . $slug . '-full.webp',
		$dir . 'images/products/' . $slug . '-large.webp',
		$dir . 'images/products/' . $slug . '-medium.webp',
		$dir . 'images/products/' . $slug . '-thumbnail.webp',
		$dir . 'products/' . $slug . '.json',
	];

	foreach($remove as $link) {
		if(file_exists($link)) {
			unlink($link);
		}
	}

	$file = $dir . 'products.json';
	$products = file_get_contents($file);
	$products = json_decode($products);
	$products = $products->products;
	$index = array_search($slug, $products);
	array_splice($products, $index, 1);

	$products = ['products' => $products];
	$products = json_encode($products);

	writeFile($dir . 'products.json', $products);
}

function axiosRemoveProduct () {
	$data = json_decode(file_get_contents('php://input'), true);
	$slug = $data['slug'];

	removeProduct($slug);

	die();
}
add_action('wp_ajax_axiosRemoveProduct', 'axiosRemoveProduct');
add_action('wp_ajax_nopriv_axiosRemoveProduct', 'axiosRemoveProduct');

function productEditor($slug = '') {
	$product_taxonomies = product_taxonomies($slug);
	$product_tags = product_tags($slug);
	$product = product_data($slug);
	$title = '';
	$description = '';
	$price = '';
	$image = '';

	if(!empty($product)) {
		$title = $product->title;
		$description = $product->description;
		$price = $product->price;



		if(!empty($product->images->full)) {
			$image = $product->images->full;
		} else if(!empty($product->images->large)) {
			$image = $product->images->large;
		}

		if(is_array($image)){
			$image = implode(",", $image);
		}

	}


?>
	<div class="image-picker square">
		<input type="file" class="name" id="product_image" accept="image/webp" data-image="<?php echo $image ?>" multiple>
		<label for="product_image" class="image-picker-field">
			<div class="placeholder">
				<span class="icon icon-image"></span>
				<div class="title">Выберите или перетащите изображение</div>
			</div>
			<div class="files-list"></div>
		</label>
	</div>

	<hr>

	<div class="form-group article-sm">
		<label for="product_title" class="label">Наименование</label>
		<input type="text" id="product_title" class="title" placeholder="Наименование" value="<?php echo $title; ?>">
	</div>

	<div class="form-group article-sm">
		<label for="product_description" class="label">Описание</label>
		<textarea id="product_description" cols="30" rows="4" class="description" placeholder="Описание"><?php echo $description; ?></textarea>
	</div>

	<div class="form-group article-sm">
		<label for="product_price" class="label">Цена</label>
		<div class="input-wrapper">
			<div class="fixed-label">₽</div>
			<input type="text" id="product_price" class="price price-mask" placeholder="Цена" value="<?php echo $price; ?>">
		</div>
	</div>

	<hr>

	<div class="form-group article-sm">
		<div class="label">Региональные цены</div>
		<div class="product-prices article" id="regional_prices" data-slug="<?php echo $slug ?>">
			<div class="prices-list"></div>
			<button class="btn add"><span class="text">Добавить</span></button>
		</div>
	</div>

	<hr>

	<div class="h6">Несколько цен</div>

	<div class="many-prices article" id="many_prices" data-slug="<?php echo $slug ?>">
		<div class="groups-list"></div>
		<button class="btn add-group outline"><span class="text">Добавить</span></button>
	</div>

	<hr>

	<div class="h6">Категории</div>

	<div class="checkbox-groups" id="taxonomies">
		<?php
			$taxes = get_taxonomis();

			function tax_structure($tax, $selected) {
				$title = $tax->title;
				$slug = $tax->slug;
				$get_children = get_taxonomis(['parent' => $slug]);
				$children = [];
				$is_checked = in_array($slug, $selected) ? ' checked' : '';

				if(!empty($get_children)) {
					foreach($get_children as $item) {
						$children[] = tax_structure($item, $selected);
					}
				}

				if(!empty($children)) {
					$children = implode('', $children);
					$children = '<div class="children">' . $children . '</div>';
				} else {
					$children = '';
				}

				return '
					<div class="checkbox-groups-item">
						<label for="' . $slug . '" class="item-checkbox">
							<div class="checkbox">
								<input type="checkbox" id="' . $slug . '"' . $is_checked . '>
								<label class="icon-check" for="' . $slug . '"></label>
							</div>
							<div class="name">' . $title . '</div>
						</label>
						' . $children . '
					</div>
				';
			}

			foreach($taxes as $tax) {
				echo tax_structure($tax, $product_taxonomies);
			}
		?>

	</div>

	<hr>

	<div class="h6">Метки</div>

	<div class="checkbox-groups" id="tags">
		<?php
			$taxes = get_archive_tags();

			function tag_structure($tax, $selected) {
				$title = $tax->title;
				$slug = $tax->slug;
				$get_children = get_archive_tags(['parent' => $slug]);
				$children = [];
				$is_checked = in_array($slug, $selected) ? ' checked' : '';

				if(!empty($get_children)) {
					foreach($get_children as $item) {
						$children[] = tag_structure($item, $selected);
					}
				}

				if(!empty($children)) {
					$children = implode('', $children);
					$children = '<div class="children">' . $children . '</div>';
				} else {
					$children = '';
				}

				return '
					<div class="checkbox-groups-item">
						<label for="' . $slug . '" class="item-checkbox">
							<div class="checkbox">
								<input type="checkbox" id="' . $slug . '"' . $is_checked . '>
								<label class="icon-check" for="' . $slug . '"></label>
							</div>
							<div class="name">' . $title . '</div>
						</label>
						' . $children . '
					</div>
				';
			}

			foreach($taxes as $tax) {
				echo tag_structure($tax, $product_tags);
			}
		?>

	</div>

	<button class="btn large" id="save_product" data-slug="<?php echo $slug; ?>"><span class="text">Сохранить</span></button>
<?php
}

function admin_r($data) {
	if(current_user_can('administrator')) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

function getProductPrices() {
	$data = json_decode(file_get_contents('php://input'), true);
	$slug = $data['slug'];
	$res = [];
	$product = product_data($slug);

	if(!empty($product)) {
		if(!empty($product->prices)) {
			foreach($product->prices as $key => $item) {
				$res[] = [
					'slug' => $key,
					'price' => $item->price,
					'old_price' => 0,
				];
			}
		}
	}

	echo json_encode($res);

	die();
}
add_action('wp_ajax_getProductPrices', 'getProductPrices');
add_action('wp_ajax_nopriv_getProductPrices', 'getProductPrices');

function getProductVariants() {
	$data = json_decode(file_get_contents('php://input'), true);
	$slug = $data['slug'];
	$res = [];
	$product = product_data($slug);

	if(!empty($product)) {
		if(!empty($product->variants)) {

			foreach($product->variants as $item) {
				$name = $item->title;
				$item_prices = [];

				foreach($item->prices as $key => $price) {
					$item_prices[] = [
						'slug' => $key,
						'price' => $price->price,
						'old_price' => 0,
					];
				}

				$res[] = [
					'name' => $name,
					'value' => $item_prices,
				];
			}
		}
	}

	echo json_encode($res);

	die();
}
add_action('wp_ajax_getProductVariants', 'getProductVariants');
add_action('wp_ajax_nopriv_getProductVariants', 'getProductVariants');

function getImageData() {
	$data = json_decode(file_get_contents('php://input'), true);


	$url = $data['image'];
	$type = 'image/webp';
	$size = 0;
	$image = [];

	if( is_array($url) ){
		foreach($url as $url_one){
			$url = $url_one;

			$base64 = imageEncode($url, $type);
			$image[] = [
				'name' => wp_basename($url),
				'size' => $size,
				'type' => $type,
				'base64' => $base64,
			];

		}

	}else{

		$base64 = imageEncode($url, $type);
		$image[] = [
			'name' => wp_basename($url),
			'size' => $size,
			'type' => $type,
			'base64' => $base64,
		];
	}

	echo json_encode($image, JSON_UNESCAPED_UNICODE);
    die();
}
add_action('wp_ajax_getImageData', 'getImageData');
add_action('wp_ajax_nopriv_getImageData', 'getImageData');


function imageEncode($path, $type) {
    $path = explode('/wp-content/', $path);
    $path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/' . end($path);
	$image = file_get_contents($path);
	return "data:".$type.";base64,".base64_encode($image);
}

function getIspAddress() {
	echo 'https://' . gethostbyname($_SERVER['HTTP_HOST']) . ':1500';
    die();
}
add_action('wp_ajax_getIspAddress', 'getIspAddress');
add_action('wp_ajax_nopriv_getIspAddress', 'getIspAddress');


function plural_type($n) {
    return ($n%10==1 && $n%100!=11 ? 0 : ($n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2));
}


function get_metro() {
    $cities_file = fopen($_SERVER['DOCUMENT_ROOT'] .'/wp-content/themes/init/catalog/metro.csv', 'r');
    $cities_assoc = array();
    while (($data = fgetcsv($cities_file, 100,',')) !== FALSE) {
        $metro_slug = strtolower(str_replace(' ', '-',translit($data[1])));
        $cities_assoc[$metro_slug][0] = $data[1];
        $cities_assoc[$metro_slug][1] = $metro_slug;
    }
    return $cities_assoc;
}

function get_areas() {
    $areas_file = fopen($_SERVER['DOCUMENT_ROOT'] .'/wp-content/themes/init/catalog/areas.csv', 'r');
    $areas_assoc = array();
    while (($data = fgetcsv($areas_file, 100,',')) !== FALSE) {
        $area_slug = strtolower(str_replace(' ', '-',translit($data[1])));
        $areas_assoc[$area_slug][0] = $data[1];
        $areas_assoc[$area_slug][1] = $area_slug;
    }
    return $areas_assoc;
}

function translit($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    );

    $value = strtr($value, $converter);
    return $value;
}

function prefix_url_rewrite_templates() {
    if ( strpos($_SERVER['REQUEST_URI'], 'metro-') !== false ) {
        add_filter( 'template_include', function() {
            status_header(200);
            return get_template_directory() . '/page-metro.php';
        });
    } elseif (strpos($_SERVER['REQUEST_URI'], 'area-') !== false) {
        add_filter( 'template_include', function() {
            status_header(200);
            return get_template_directory() . '/page-area.php';
        });
    }
}
add_action( 'template_redirect', 'prefix_url_rewrite_templates' );
