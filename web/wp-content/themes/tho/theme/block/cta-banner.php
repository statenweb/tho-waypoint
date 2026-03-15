<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$body_text     = get_field( 'body_text' );
$button_link   = get_field( 'button_link' );
$button_style  = get_field( 'button_style' ) ?: 'primary';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-4xl mx-auto px-6 py-16 text-center">
		<?php if ( $heading ) : ?>
		<h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $body_text ) : ?>
		<div class="text-lg mb-8 max-w-2xl mx-auto"><?php echo wp_kses_post( $body_text ); ?></div>
		<?php endif; ?>
		<?php
		if ( $button_link ) :
			$btn_class = match ( $button_style ) {
				'primary'   => 'bg-[#007129] text-white hover:bg-[#005a21]',
				'secondary' => 'bg-black text-white hover:bg-gray-800',
				'outline'   => 'border-2 border-current hover:bg-black hover:text-white',
				default     => 'bg-[#007129] text-white hover:bg-[#005a21]',
			};
			?>
		<a href="<?php echo esc_url( $button_link['url'] ); ?>" class="inline-block font-bold py-3 px-8 transition-colors duration-300 <?php echo esc_attr( $btn_class ); ?>" target="<?php echo esc_attr( $button_link['target'] ?: '_self' ); ?>">
			<?php echo esc_html( $button_link['title'] ); ?>
		</a>
		<?php endif; ?>
	</div>
</section>
