<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package init
 */

get_header();
?>
	
	<section class="error-404 not-found">

		<div class="container">
			<div class="wrapper">
				<span>404</span>
				<h1>Страница не найдена.</h1>
				<p>Неправильно набран адрес, или такой страницы сайте не существует</p>
				<?php get_search_form(); ?>
			</div>
		</div>

	</section>

<?php
get_footer();
