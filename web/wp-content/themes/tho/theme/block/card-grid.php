<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$columns       = get_field( 'columns' ) ?: '3';
$cards         = get_field( 'cards' );
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-6xl mx-auto px-6">
		<?php if ( $heading ) : ?>
		<h2 class="text-3xl md:text-4xl font-bold mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $cards ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr( $columns ); ?> gap-8">
			<?php
			foreach ( $cards as $card ) :
				$image_url = $card['image'] ? wp_get_attachment_image_url( $card['image'], 'medium' ) : '';
				?>
			<div class="flex flex-col">
				<?php if ( $image_url ) : ?>
				<div class="mb-4">
					<?php echo wp_get_attachment_image( $card['image'], 'medium', false, [ 'class' => 'w-full h-auto object-cover' ] ); ?>
				</div>
				<?php endif; ?>
				<?php if ( $card['title'] ) : ?>
				<h3 class="text-xl font-bold mb-2"><?php echo esc_html( $card['title'] ); ?></h3>
				<?php endif; ?>
				<?php if ( $card['description'] ) : ?>
				<div class="text-base leading-relaxed"><?php echo wp_kses_post( $card['description'] ); ?></div>
				<?php endif; ?>
				<?php
				if ( $card['link'] ) :
					$link = $card['link'];
					?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="mt-auto pt-4 font-bold underline hover:no-underline" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>">
					<?php echo esc_html( $link['title'] ?: 'Learn More' ); ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
