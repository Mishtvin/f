<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
?>

<?php if ( !is_front_page() && function_exists('yoast_breadcrumb') ) { ?>
	<nav class="breadcrumbs">

		<div class="container">
			<?php yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); ?>
		</div>

	</nav>
<?php } ?>

	<section>

		<div class="container">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<?php

				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
		</div>

	</section>

<?php
get_footer();
