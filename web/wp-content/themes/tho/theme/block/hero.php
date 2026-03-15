<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$background_image = get_field( 'background_image' );
$min_height    = get_field( 'min_height' ) ?: 'min-h-[80vh]';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes . ' ' . $min_height ); ?>"<?php if ( $background_image ) : ?> style="background-image: url('<?php echo esc_url( wp_get_attachment_image_url( $background_image, 'full' ) ); ?>');"<?php endif; ?>>
	<?php
	if ( ! empty( $block['innerBlocks'] ) ) {
		echo '<InnerBlocks />';
	}
	?>
</section>
