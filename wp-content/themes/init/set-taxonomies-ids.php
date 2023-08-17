<?php
/*
 * расставить id в файле с категориями
*/
$taxonomies_file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/init/catalog/taxonomies.json';
$get_taxonomies_content = file_get_contents($taxonomies_file);
$all_taxonomies = json_decode($get_taxonomies_content, true);
$all_taxonomies = $all_taxonomies['taxonomies'];

if ($all_taxonomies) {
    $new_taxonomies = array();
    $inc = 1;

    foreach ($all_taxonomies as $taxonomy_name => $taxonomy_values) {

        $new_taxonomies['taxonomies'][$taxonomy_name] = $taxonomy_values;
        $new_taxonomies['taxonomies'][$taxonomy_name]['id'] = $inc;

        $inc++;
    }
    $new_taxonomies = json_encode($new_taxonomies, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    file_put_contents($taxonomies_file, $new_taxonomies);
}