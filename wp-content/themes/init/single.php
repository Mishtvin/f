<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation();

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</div>

	</section>

<?php
get_footer();
