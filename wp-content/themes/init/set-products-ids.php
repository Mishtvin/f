<?php
/*
 создать файл для привязки продуктов к id
*/

$products_ids_file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products-ids.json';
$json_input = array();

$products_dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/products/';
$files = scandir($products_dir);

$inc = 1;
if ($files) {
    foreach($files as $file) {
        // название файла без .jsom
        $product_slug = str_replace('.json', '', $file);
        // путь к файлу
        $file_path = $products_dir . $file;
        // пропустить ненужное
        if($file == '.' || $file == '..' || $file == '.json') {
            continue;
        }
        // если файл существует
        if(file_exists($file_path)) {
            $product_content = file_get_contents($file_path);
            $product_content = json_decode($product_content, true);
            $json_input[$product_slug] = $inc;
        }
        $inc++;
//        if($inc > 5) break;
    }
    $json_input = json_encode($json_input, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
//    echo $json_input;
    file_put_contents($products_ids_file, $json_input);
}