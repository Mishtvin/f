<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package init
 */
?>

<aside class="news-archive-sidebar article-bg">

    <?php
        $taxonomies = get_taxonomis();

        if(!empty($taxonomies)) {

            echo '
            <div class="nav-item article">
                <div class="h6">Категории</div>
                <ul>
            ';

            foreach($taxonomies as $taxonomy) {
                echo '<li>';
                echo taxonomy_list_item($taxonomy);
                echo '</li>';
            }

            echo '
                </ul>
            </div>
            ';
        }
    ?>
</aside>