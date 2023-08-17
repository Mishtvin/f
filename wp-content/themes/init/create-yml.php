<?php
// города
$get_cities = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/cities.json';
$get_cities = file_get_contents($get_cities);
$all_cities = json_decode($get_cities, true);
// категории
$get_taxonomies = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
$get_taxonomies = file_get_contents($get_taxonomies);
$all_taxonomies = json_decode($get_taxonomies, true);
$all_taxonomies = $all_taxonomies['taxonomies'];
// отнешение продукт -> категория
$get_product_taxonomies = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/product-taxonomies.json';
$get_product_taxonomies = file_get_contents($get_product_taxonomies);
$all_product_taxonomies = json_decode($get_product_taxonomies, true);

// продукты
$products_dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products/';
$products_files = scandir($products_dir);
// id продуктов
$products_ids = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products-ids.json';
$products_ids = file_get_contents($products_ids);
$products_ids = json_decode($products_ids, true);


// обходим все города, создаём yml для каждого города
if($all_cities) {
    foreach ($all_cities as $city) {
        // проверка поддомена
        if($city['slug']) {
            $subdomain = $city['slug'] . '.';
            $file_name = $city['slug'];
        } else {
            $subdomain = '';
            $file_name = 'moscow';
        }
        // хост с доменом
        $full_domain = $subdomain . $_SERVER['HTTP_HOST'];
        // название yml файла
        $file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/yml/' . $file_name . '-yml.xml';

        $yml_code = '<?xml version="1.0" encoding="UTF-8"?>
            <yml_catalog date="2020-11-22T14:37:38+03:00">
                <shop>
                    <name>FlowLove '.$city['name'].'</name>
                    <company>FlowLove в '.$city['genitive'].'</company>
                    <url>https://'.$full_domain.'/</url>
        ';
        // categories
        if($all_taxonomies) {
            $yml_code .= '<categories>';
            foreach ($all_taxonomies as $taxonomy) {
                $yml_code .= "<category id='".$taxonomy['id']."'>".$taxonomy['title']."</category>\n";
            }
            $yml_code .= '</categories>';
        }
        // offers
        if ($products_files) {
            $yml_code .= '<offers>';
            foreach($products_files as $products_file) {
                $product_file_path = $products_dir . $products_file;
                if($products_file == '.' || $products_file == '..' || $products_file == '.json') {
                    continue;
                }
                $product = file_get_contents($product_file_path);
                $product = json_decode($product, true);
                // цены
                if($product['price']) { $product_price = '<price>'.$product['price'].'</price>'; } else { $product_price = ''; }
                if($product['old_price']) { $product_old_price = '<oldprice>'.$product['old_price'].'</oldprice>'; } else { $product_old_price = ''; }
                // получить данные о категории товара
                $product_taxonomy = $all_product_taxonomies["product_taxonomies"][$product['slug']][0];
                if ($product_taxonomy) {
                    $product_category_id = $all_taxonomies[$product_taxonomy]['id'];
                }
                // записать в yml id категории товара
                if ($product_category_id) {
                    $product_category_id = '<categoryId>'.$product_category_id.'</categoryId>';
                } else {
                    $product_category_id = '';
                }

                $yml_code .= '
                <offer id="'.$products_ids[$product['slug']].'">
                    <name>'.$product['title'].'</name>
                    <vendor>Flowlove</vendor>
                    <url>https://'.$full_domain.'/product/'.$product['slug'].'</url>
                    '.$product_category_id.'
                    '.$product_price.'
                    '.$product_old_price.'
                    <currencyId>RUR</currencyId>
                    <picture>https://'.$full_domain.'/wp-content/themes/init/catalog/images/products/'.$product['slug'].'-0-large.webp</picture>
                    <description>'.html_entity_decode($product['description']).'</description>                
                </offer>
                ';
            }
            $yml_code .= '</offers>';
        }
        $yml_code .= '</shop></yml_catalog>';

        file_put_contents($file, $yml_code);
    }
}