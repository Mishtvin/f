<?php
/**
 * Template Name: Contacts Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */

get_header();
page_header();
?>
    <section class="contacts section-padding pb">
        <div class="container">
            <div class="wrapper">
                <div class="content article-md">
                    <?php print_contacts(); ?>
                </div>
                <div class="faq article-md">
                    <div class="h4">Часто задаваемые вопросы</div>
                    <?php echo faq()  ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
