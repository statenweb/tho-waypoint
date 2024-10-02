<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _tw
 */

get_header();
?>

	<section id="primary">
		<main id="main" class="py-10">

			<div>
				<header class="page-header">
					<h1 class=" entry-title text-[48px] leading-[64px] mb-5 text-center"><?php esc_html_e( 'Page Not Found', '_tw' ); ?></h1>
				</header><!-- .page-header -->

                <div <?php _tw_content_class( sprintf('entry-content text-[18px] [&_figure]:mobile-only:w-full [&_figure]:mobile-only:float-none [&_figure]:mobile-only:!flex [&_figure]:mobile-only:mb-10 [&_figure]:mobile-only:justify-center leading-[28px] [&_ul]:pl-16 [&_li]:mb-3 [&>ul]:list-disc [&>h1]:my-4 [&>h2]:my-8 [&>h3]:my-6 [&>h4]:my-4 [&>h5]:my-4 [&>h6]:my-4 [&>p]:my-4 [&>ul]:my-10 %s', $entry_content_class) ); ?>>
					<p class="text-center"><?php esc_html_e( 'This page could not be found. It might have been removed or renamed, or it may never have existed.', '_tw' ); ?></p>
                    <p class="mt-10 text-center"><a href="<?php echo home_url(); ?>">&larr; Return Home</a></p>
				</div><!-- .page-content -->
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
