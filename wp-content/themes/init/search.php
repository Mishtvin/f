<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package init
 */

get_header();
$search_query = get_search_query();
$title = 'Поиск по запросу: <span class="colored">' . $search_query . '</span>';
page_header([
	'title' => $title
]);

$products = get_products([
	'search' => $search_query
]);

$ids = $products['ids'];
$pages = $products['pages'];
$page = $products['page'];
?>

	<section class="search section-padding pb">
		<div class="container">
			<div class="wrapper article-md">
				<?php get_search_form() ?>
				<div class="catalog">
					<?php
						if(!empty($ids)) {
							print_products($ids);

							if($pages != $page) {
								echo '<div class="load-more-wrapper"><button class="btn load-more outline-border large" id="load_more" data-page="' . $page . '" data-max="' . $pages . '"><span class="text icon-refresh">Показать больше</span></button></div>';
							}
						} else {
							echo '
								<div class="empty-block">
									<span class="icon icon-error"></span>
									<div class="h5">Ничего не найдено</div>
								</div>
							';
						}
					?>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
