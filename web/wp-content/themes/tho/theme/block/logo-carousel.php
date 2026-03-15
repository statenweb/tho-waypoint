<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$logos         = get_field( 'logos' );
$autoplay      = get_field( 'autoplay' ) ?? 'yes';
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-6xl mx-auto px-6">
		<?php if ( $heading ) : ?>
		<h2 class="text-2xl md:text-3xl font-bold mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $logos ) : ?>
		<div class="flex flex-wrap items-center justify-center gap-8" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
			<?php foreach ( $logos as $logo ) :
				$logo_html = $logo['logo'] ? wp_get_attachment_image( $logo['logo'], 'medium', false, [ 'class' => 'max-h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300' ] ) : '';
				?>
			<?php if ( $logo['link'] ) :
				$link = $logo['link'];
				?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>" class="flex items-center justify-center" title="<?php echo esc_attr( $logo['name'] ); ?>">
				<?php echo $logo_html; ?>
			</a>
			<?php else : ?>
			<div class="flex items-center justify-center">
				<?php echo $logo_html; ?>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
