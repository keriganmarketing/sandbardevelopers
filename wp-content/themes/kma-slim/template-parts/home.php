<?php

use Includes\Modules\Slider\BulmaSlider;
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
<div id="mid" class="home">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="section-wrapper">
            <div class="container has-text-centered">
                <?php if ( get_theme_mod( 'kmaslim_logo' ) ) : ?>
                    <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                        <img class="logo" src='<?php echo esc_url( get_theme_mod( 'kmaslim_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
                    </a>
                <?php else : ?>
                    <p class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></p>
                    <p class='site-description'><?php bloginfo( 'description' ); ?></p>
                <?php endif; ?>

                <div class="home-page-copy">
                    <section class="home-title">
                        <h1 class="title is-3 is-primary"><?php echo $headline; ?></h1>
                        <?= ($subhead != '' ? '<h2 class="subtitle is-secondary">'.$subhead.'</h2>' : ''); ?>
                    </section>

                    <?php the_content(); ?>
                </div>
                <a id="bid-button" href="/subscribe-to-our-bidders-list/" class="button is-primary is-caps is-round">Sign up for our bidder’s list</a>
                <p class="contact-details"><a href="tel:850-528-1781" >850-528-1781</a> <span class="is-hidden-mobile">|</span> <a href="mailto:info@sandbardevelopers.com">info@sandbardevelopers.com</a></p>
            </div>
        </div>

    </article>
</div>
<?php include(locate_template('template-parts/sections/bot.php')); ?>
