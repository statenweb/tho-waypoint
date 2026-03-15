<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$heading_el    = get_field( 'heading_element' ) ?: 'h2';
$body_text     = get_field( 'body_text' );
$alignment     = get_field( 'alignment' ) ?: 'text-center';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-3xl mx-auto px-6 <?php echo esc_attr( $alignment ); ?>">
		<?php if ( $heading ) : ?>
		<<?php echo Utils::validate_heading_element( $heading_el ); ?> class="text-3xl md:text-4xl font-bold mb-4">
			<?php echo esc_html( $heading ); ?>
		</<?php echo Utils::validate_heading_element( $heading_el ); ?>>
		<?php endif; ?>
		<?php if ( $body_text ) : ?>
		<div class="text-lg leading-relaxed"><?php echo wp_kses_post( $body_text ); ?></div>
		<?php endif; ?>
	</div>
</section>
