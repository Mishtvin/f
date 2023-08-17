<?php
$products_dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/yml/';
$files = scandir($products_dir);
if ($files) {
    $inc = 1;
    foreach($files as $file) {
        if($file == '.' || $file == '..' || $file == '.json') {
            continue;
        }
        echo $inc. ' <a href="https://flowlove.ru/wp-content/themes/init/catalog/yml/' . $file . '">https://flowlove.ru/wp-content/themes/init/catalog/yml/' . $file . '</a>';
        echo "</br>";
        $inc++;
    }
}