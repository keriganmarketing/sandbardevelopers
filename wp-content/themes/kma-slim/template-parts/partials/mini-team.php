<?php
$member = (isset($member) ? $member : null);
?>
<div class="column is-6 is-4-widescreen">
    <div class="member is-full-height has-text-centered">
        <div class="image is-square">
            <img src="<?= $member['images']['thumbnail'][0]; ?>" >
        </div>
        <h3 class="title is-3 is-secondary"><?= $member['name']; ?></h3>
        <p class="subtitle is-6"><?= $member['title']; ?></p>
        <?php if($member['email']!='' || $member['phone']!=''){ ?>
        <p class="contact-info">
            <?php if($member['email']!=''){ ?><a href="mailto:<?= $member['email']; ?>"><?= $member['email']; ?></a><br><?php } ?>
            <?php if($member['phone']!=''){ ?><a href="tel:<?= $member['phone']; ?>"><?= $member['phone']; ?></a><?php } ?>
        </p>
        <?php } ?>
        <p><a class="button is-primary is-rounded is-outlined" href="<?= $member['link']; ?>">Read Bio</a></p>
<!--        <pre>--><?//= print_r($member); ?><!--</pre>-->
    </div>
</div>
