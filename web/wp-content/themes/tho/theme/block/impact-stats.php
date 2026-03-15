<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$stats         = get_field( 'stats' );
$columns       = get_field( 'columns' ) ?: '2';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<?php if ( $stats ) : ?>
	<div class="grid grid-cols-<?php echo esc_attr( $columns ); ?> gap-8 max-w-4xl mx-auto text-center">
		<?php foreach ( $stats as $stat ) : ?>
		<div class="flex flex-col items-center">
			<span class="text-4xl md:text-5xl font-bold" data-counter><?php echo esc_html( $stat['number'] ); ?></span>
			<span class="text-lg mt-2 opacity-80"><?php echo esc_html( $stat['label'] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</section>
