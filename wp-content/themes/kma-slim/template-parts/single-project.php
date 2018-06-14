<?php
/**
 * @package KMA
 * @subpackage kmaslim
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');

$youtubeId     = $post->project_details_youtube_video_id;
$featuredImage = $post->project_details_featured_image;
$city          = $post->project_details_city;
$state         = $post->project_details_state;
$cost          = $post->project_details_cost;
$photoGallery  = $post->project_details_photo_gallery;

include(locate_template('template-parts/sections/top.php'));
?>
<div class="top-pad"></div>
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section id="content" class="section-wrapper">
            <div class="container">
                <div class="content">
                    <?php include(locate_template('template-parts/sections/support-heading.php')); ?>
                    <div class="columns is-multiline" >
                        <div class="column is-5">
                            <h2 class="title is-3"><?= $city; ?>, <?= $state; ?></h2>
                            <h3 class="subtitle"><?= $cost; ?></h3>
                            <?php the_content();?>
                        </div>
                        <div class="column is-7">
                            <?php if(isset($youtubeId)){ ?>
                                <div class="responsive-embed">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?= $youtubeId; ?>?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            <?php }else{ ?>
                                <img src="<?= $featuredImage; ?>" alt="<?= $headline; ?>" >
                            <?php } ?>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <?php if(isset($photoGallery)){
                        $photoGallery = explode('|',$photoGallery);
                        $photos = [];
                        foreach($photoGallery as $key => $photo){  
                            $photoArray = wp_get_attachment_metadata($photo);
                            $photos[] = [
                                'id'  => $key,
                                'name' => $photoArray['image_meta']['title'],
                                'url'  => '/wp-content/uploads/'.$photoArray['file']
                            ];
                        } 
                    } ?>
                    <photo-gallery :data-photos='<?= json_encode($photos); ?>' ></photo-gallery>
                </div><!-- .entry-content -->
            </div>
        </section>
    </article><!-- #post-## -->
</div>
<?php include(locate_template('template-parts/sections/bot.php')); ?>