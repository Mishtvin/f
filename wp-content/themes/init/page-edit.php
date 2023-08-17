<?php
/**
 * Template Name: Edit Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];
$url = explode('/', $url);
$url = array_diff($url, array(''));
$length = count($url);
$slug = $url[$length];
$product = product_data($slug);

if(empty($product) || !current_user_can('administrator')) {
    wp_redirect('/');
}

get_header();
page_header();
?>
    <section class="section-padding pb">
        <div class="container">
            <div class="wrapper article-bg">
                <?php productEditor($slug); ?>
            </div>
        </div>
    </section>
<?php
get_footer();
