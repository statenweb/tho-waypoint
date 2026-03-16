<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$posts_count   = get_field( 'posts_per_page' ) ?: 6;
$columns       = get_field( 'columns' ) ?: '3';

$recent_posts = get_posts(
	[
		'posts_per_page' => $posts_count,
		'post_status'    => 'publish',
	]
);
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-6xl mx-auto px-6">
		<?php if ( $heading ) : ?>
		<h2 class="text-3xl md:text-4xl font-bold mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $recent_posts ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr( $columns ); ?> gap-8">
			<?php foreach ( $recent_posts as $post ) : ?>
			<article class="flex flex-col">
				<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="mb-4">
					<?php echo get_the_post_thumbnail( $post->ID, 'medium_large', [ 'class' => 'w-full h-auto object-cover' ] ); ?>
				</a>
				<?php endif; ?>
				<h3 class="text-lg font-bold mb-2">
					<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="hover:underline">
						<?php echo esc_html( get_the_title( $post->ID ) ); ?>
					</a>
				</h3>
				<time class="text-sm opacity-60"><?php echo esc_html( get_the_date( '', $post->ID ) ); ?></time>
			</article>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php endif; ?>
	</div>
</section>
