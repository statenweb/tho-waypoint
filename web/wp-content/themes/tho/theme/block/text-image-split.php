<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$body_text     = get_field( 'body_text' );
$cta_link      = get_field( 'cta_link' );
$image_id      = get_field( 'image' );
$image_pos     = get_field( 'image_position' ) ?: 'right';
$ratio         = get_field( 'ratio' ) ?: '50/50';

$text_col  = match ( $ratio ) {
	'60/40' => 'lg:col-span-7',
	'40/60' => 'lg:col-span-5',
	default  => 'lg:col-span-6',
};
$img_col   = match ( $ratio ) {
	'60/40' => 'lg:col-span-5',
	'40/60' => 'lg:col-span-7',
	default  => 'lg:col-span-6',
};
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-6xl mx-auto px-6">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
			<?php
			$text_order = $image_pos === 'left' ? 'lg:order-2' : 'lg:order-1';
			$img_order  = $image_pos === 'left' ? 'lg:order-1' : 'lg:order-2';
			?>
			<div class="<?php echo esc_attr( $text_col . ' ' . $text_order ); ?>">
				<?php if ( $heading ) : ?>
				<h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $body_text ) : ?>
				<div class="text-lg leading-relaxed mb-6"><?php echo wp_kses_post( $body_text ); ?></div>
				<?php endif; ?>
				<?php if ( $cta_link ) : ?>
				<a href="<?php echo esc_url( $cta_link['url'] ); ?>" class="inline-block bg-[#007129] text-white font-bold py-3 px-8 hover:bg-[#005a21] transition-colors duration-300" target="<?php echo esc_attr( $cta_link['target'] ?: '_self' ); ?>">
					<?php echo esc_html( $cta_link['title'] ); ?>
				</a>
				<?php endif; ?>
			</div>
			<div class="<?php echo esc_attr( $img_col . ' ' . $img_order ); ?>">
				<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'large', false, [ 'class' => 'w-full h-auto object-cover' ] ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
