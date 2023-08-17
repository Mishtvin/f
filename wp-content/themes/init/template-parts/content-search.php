<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

?>

<a href="<?php the_permalink(); ?>" class="big-link">
	<div class="text">
		<h5 class="mb0"><?php the_title(); ?></h5>
		<p><?php the_permalink(); ?></p>
	</div>
	<span class="icon-arrow-right"></span>
</a>
