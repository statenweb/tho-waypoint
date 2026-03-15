<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$slides        = get_field( 'slides' );
$autoplay      = get_field( 'autoplay' ) ?? 'yes';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<?php if ( $slides ) : ?>
	<div class="relative overflow-hidden">
		<div class="flex transition-transform duration-500">
			<?php foreach ( $slides as $index => $slide ) :
				$image_url = $slide['image'] ? wp_get_attachment_image_url( $slide['image'], 'full' ) : '';
				?>
			<div class="min-w-full relative" data-slide="<?php echo esc_attr( $index ); ?>">
				<?php if ( $image_url ) : ?>
				<div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
				<?php endif; ?>
				<div class="absolute inset-0 bg-black/50"></div>
				<div class="relative z-10 flex flex-col justify-center items-center min-h-[80vh] px-6 text-white text-center">
					<?php if ( $slide['heading'] ) : ?>
					<h2 class="text-4xl md:text-6xl font-bold uppercase mb-4"><?php echo esc_html( $slide['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( $slide['body_text'] ) : ?>
					<div class="max-w-2xl text-lg mb-6"><?php echo wp_kses_post( $slide['body_text'] ); ?></div>
					<?php endif; ?>
					<?php if ( $slide['cta_link'] ) :
						$cta = $slide['cta_link'];
						?>
					<a href="<?php echo esc_url( $cta['url'] ); ?>" class="inline-block bg-[#007129] text-white font-bold py-3 px-8 hover:bg-[#005a21] transition-colors duration-300" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
						<?php echo esc_html( $cta['title'] ); ?>
					</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php if ( count( $slides ) > 1 ) : ?>
		<div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
			<?php foreach ( $slides as $index => $slide ) : ?>
			<button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-dot="<?php echo esc_attr( $index ); ?>"></button>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>
