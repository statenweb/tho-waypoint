<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$logo          = get_field( 'logo' );
$columns       = get_field( 'columns' );
$copyright     = get_field( 'copyright' );
?>

<footer id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="container">
		<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-12 py-10">

			<?php if ( $logo ) : ?>
			<div>
				<?php echo wp_get_attachment_image( $logo, 'full', false, [ 'class' => 'h-auto max-w-[180px]' ] ); ?>
			</div>
			<?php endif; ?>

			<?php if ( $columns ) : ?>
			<?php foreach ( $columns as $column ) : ?>
			<div>
				<?php if ( ! empty( $column['heading'] ) ) : ?>
				<h3 class="font-bold mb-4"><?php echo esc_html( $column['heading'] ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $column['links'] ) ) : ?>
				<ul class="space-y-2">
					<?php foreach ( $column['links'] as $item ) : ?>
					<li>
						<a href="<?php echo esc_url( $item['link']['url'] ); ?>" target="<?php echo esc_attr( $item['link']['target'] ?? '_self' ); ?>" class="hover:underline transition-colors duration-200">
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>

		</div>

		<div class="border-t border-gray-200 my-6"></div>

		<?php if ( $copyright ) : ?>
		<div class="pb-8 text-sm text-center">
			<?php echo esc_html( $copyright ); ?>
		</div>
		<?php endif; ?>

	</div>
</footer>
