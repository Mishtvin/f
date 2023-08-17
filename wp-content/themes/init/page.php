<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package init
 */

get_header();
page_header();

$recommendation = 'akcii';
$recommendation = tag_data($recommendation);
?>

<section class="news section-padding pb">
    <div class="container">
        <div class="wrapper article-md">
            <div class="news-archive-body article-md">
                <div class="article-block article bordered">
                    <?php
                        the_post_thumbnail();
                        the_content();
                    ?>
                </div>
                <div class="single-meta bordered">
					<script src="https://yastatic.net/share2/share.js"></script>
					<div class="ya-share2" data-curtain data-size="l" data-shape="round" data-services="vkontakte,odnoklassniki,telegram,viber,whatsapp"></div>
                </div>
				<?php
					if(!empty($recommendation)) {
						$link = [];

						if(CITY_SLUG) {
							$link[] = CITY_SLUG;
						}

						$link[] = 'tags';

						if($recommendation->parent) {
							$link[] = $recommendation->parent;
						}

						$link[] = $recommendation->slug;

						$link = implode('/', $link);
						$link = '/' . $link . '/';

						$products = get_products([
							'tag' => $recommendation->slug
						]);

						$products = array_slice($products['ids'], 0, 8);
						$structure = [];

						foreach($products as $id) {
							$structure[] = product($id);
						}

						$structure = implode('', $structure);
				?>
					<div class="inline full">
						<div class="line">
						
							<div class="h2 hide-md hide-lg">Так же рекомендуем</div>
							<div class="grow"></div>
							
						</div>
					</div>
					
				<?php } ?>
            </div>
            <?php get_sidebar('news'); ?>
        </div>
    </div>
</section>

<?php
get_footer();
