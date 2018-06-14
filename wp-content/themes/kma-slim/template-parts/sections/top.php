<?php

use Includes\Modules\Navwalker\BulmaNavwalker;

/**
 * @package KMA
 * @subpackage kmaslim
 * @since 1.0
 * @version 1.2
 */
?>
<div id="MobileNavMenu" :class="[{ 'is-active': isOpen }, 'navbar']">
    <?php 
        // wp_nav_menu(array(
        //     'theme_location' => 'main-menu',
        //     'container'      => false,
        //     'menu_class'     => 'navbar-start',
        //     'fallback_cb'    => '',
        //     'menu_id'        => 'mobile-menu',
        //     'link_before'    => '',
        //     'link_after'     => '',
        //     'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
        //     'walker'         => new BulmaNavwalker()
        // )); 
    ?>
</div>
<div :class="['site-wrapper', { 'menu-open': isOpen }, {'full-height': footerStuck }, {'scrolling': isScrolling }]">
<div class="site-mobile-overlay"></div>
<header id="top-none" :class="['header', {'modal-open': modalOpen}]">
    <!--<div class="container">
        <nav class="navbar">

            <div class="navbar-brand">
                logo here

                <div class="navbar-burger burger" id="MobileNavBurger" data-target="MobileNavMenu" @click="toggleMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <?php 
                // wp_nav_menu(array(
                //     'theme_location' => 'main-menu',
                //     'container'      => false,
                //     'menu_class'     => 'navbar-end is-hidden-touch',
                //     'fallback_cb'    => '',
                //     'menu_id'        => 'main-menu',
                //     'link_before'    => '',
                //     'link_after'     => '',
                //     'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
                //     'walker'         => new BulmaNavwalker()
                // )); 
            ?>

        </nav>
    </div>-->
</header>