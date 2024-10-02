<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package $straus
 */

?>

<footer id="colophon" class="bg-white text-body-text pad-for-mobile py-10 mobile-only:text-center">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-1 lg:gap-20 container py-5">
        <div>
            <?php dynamic_sidebar('footer-sidebar-right'); ?>
        </div>
    </div>

    <div class="my-10  border-t border-gray-200"></div>
    <div class="container">
        <div>
		    <?php dynamic_sidebar('footer-sidebar-bottom'); ?>
        </div>

    </div>

</footer><!-- #colophon -->