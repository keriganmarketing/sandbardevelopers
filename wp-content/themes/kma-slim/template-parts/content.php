<?php
/**
 * @package KMA
 * @subpackage kmaslim
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');

include(locate_template('template-parts/sections/top.php'));
?>
<!-- <div class="top-pad"></div> -->
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section id="content" class="section-wrapper">
            <div class="container has-text-centered">
                <?php if ( get_theme_mod( 'kmaslim_logo' ) ) : ?>
                    <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                        <img class="logo" src='<?php echo esc_url( get_theme_mod( 'kmaslim_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
                    </a>
                <?php else : ?>
                    <p class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></p>
                    <p class='site-description'><?php bloginfo( 'description' ); ?></p>
                <?php endif; ?>
            </div>
            <div class="section-wrapper support-content">
                <div class="container has-text-centered">    
                    <div class="content support">
                        <?php include(locate_template('template-parts/sections/support-heading.php')); ?>
                        <?php the_content();?>
                    </div><!-- .entry-content -->
                </div>
            </div>
        </section>
    </article><!-- #post-## -->
</div>
<?php include(locate_template('template-parts/sections/bot.php')); ?>