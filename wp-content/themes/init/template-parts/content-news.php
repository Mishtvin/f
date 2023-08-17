<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

$id = get_the_ID();
$title = get_the_title();
$link = get_the_permalink();
$link = str_replace(get_site_url(), PRE_LINK, $link);
$date = get_the_date('d.m.Y');
$image = get_the_post_thumbnail_url($id, 'large');
$image = $image ? '<img src="' . $image . '" alt="' . $title . '">' : '';
?>

<a href="<?php echo $link; ?>" class="news-card dark">
    <div class="image"><?php echo $image ?></div>
    <div class="content">
        <div class="date"><?php echo $date ?> г.</div>
        <div class="h6"><?php echo $title ?></div>
    </div>
</a>