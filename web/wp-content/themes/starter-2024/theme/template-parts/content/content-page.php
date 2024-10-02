<?php
/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

$width = get_field( 'full_width' ) ? '' : 'container';
$entry_content_class = get_field( 'remove_margin_on_entry_content' ) ? '' : 'mt-10';
$margin = get_field( 'remove_margin_on_entry_content' ) ? 'py-0' : 'py-10';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( sprintf( '%s %s', $margin, $width ) ); ?>>

	<?php if ( ! get_field( 'kill_title' ) ) : ?>
		<header class="entry-header z-[-1] relative">
			<?php
				the_title( '<h1 class=" entry-title text-[48px] leading-[64px] mb-5 text-center lg:text-left">', '</h1>' );
			?>
		</header><!-- .entry-header -->
	<?php endif; ?>



	<div <?php _tw_content_class( sprintf( 'entry-content text-[18px] [&_figure]:mobile-only:w-full [&_figure]:mobile-only:float-none [&_figure]:mobile-only:!flex [&_figure]:mobile-only:mb-10 [&_figure]:mobile-only:justify-center leading-[28px] [&_ul]:pl-16 [&_li]:mb-3 [&>ul]:list-disc [&>h1]:my-4 [&>h2]:my-8 [&>h3]:my-6 [&>h4]:my-4 [&>h5]:my-4 [&>h6]:my-4 [&>p]:my-4 [&>ul]:my-10 %s', $entry_content_class ) ); ?>>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div>' . __( 'Pages:', '_tw' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers. */
						__( 'Edit <span class="sr-only">%s</span>', '_tw' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
