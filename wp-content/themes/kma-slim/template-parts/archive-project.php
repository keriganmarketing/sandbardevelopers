<?php
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
                    <section class="support-title">
                        <h1 class="title is-1">Projects</h1>
                    </section>
                    <?= get_post(14)->post_content; ?>
                    <p>&nbsp;</p>
                    <div class="projects">
                        <div class="container">
                            <div class="columns is-multiline has-text-centered">
                                <?php
                                    foreach(getProjects() as $project){
                                        $client = get_the_terms($project['id'], 'client')[0];
                                        include(locate_template('template-parts/partials/mini-project.php'));
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div><!-- .entry-content -->
            </div>
        </section>
    </article><!-- #post-## -->
</div>
<?php include(locate_template('template-parts/sections/bot.php')); ?>