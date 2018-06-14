<?php

use Includes\Modules\Helpers\PageField;

/**
 * @package KMA
 * @subpackage kmaslim
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead  = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');

include(locate_template('template-parts/sections/top.php'));

?>
<div class="top-pad"></div>
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section id="content" class="section-wrapper">
            <div class="container">
                <div class="content">
                    <?php include(locate_template('template-parts/sections/support-heading.php')); ?>
                    <div class="columns is-multiline">
                        <div class="column is-12 is-4-desktop">
                            <p><em>phone:</em> <a href="tel:<?= PageField::getField('contact_info_phone_number', 20); ?>" ><?= PageField::getField('contact_info_phone_number', 20); ?></a><br>
                            <em>fax:</em> <?= PageField::getField('contact_info_fax_number', 20); ?></p>
                            <h4 class="title is-5 is-bold">Office Location:</h3>
                            <p><?= nl2br(PageField::getField('contact_info_office_location', 20)); ?></p>
                            <h4 class="title is-5 is-bold">Mailing Address:</h3>
                            <p><?= nl2br(PageField::getField('contact_info_mailing_address', 20)); ?></p>
                        </div>
                        <div class="column is-12 is-8-desktop">
                            <?php the_content(); ?>
                            <?php echo do_shortcode('[contact_form]'); ?>
                        </div>
                    </div>
                </div><!-- .entry-content -->
            </div>
        </section>
    </article><!-- #post-## -->
</div>
<?php include(locate_template('template-parts/sections/bot.php')); ?>