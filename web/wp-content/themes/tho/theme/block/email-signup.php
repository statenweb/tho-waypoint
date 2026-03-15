<?php

use Victoria\Utilities\Utils;

$id            = basename( __FILE__ ) . $block['id'];
$block_classes = Utils::get_block_classes( $block );
$heading       = get_field( 'heading' );
$placeholder   = get_field( 'placeholder' ) ?: 'Enter your email';
$button_text   = get_field( 'button_text' ) ?: 'Sign Up';
$form_action   = get_field( 'form_action' );
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-xl mx-auto px-6 py-12 text-center">
		<?php if ( $heading ) : ?>
		<h3 class="text-2xl font-bold mb-6"><?php echo esc_html( $heading ); ?></h3>
		<?php endif; ?>
		<form class="flex flex-col sm:flex-row gap-3" method="post" action="<?php echo esc_url( $form_action ); ?>">
			<input
				type="email"
				name="email"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				required
				class="flex-1 px-4 py-3 border border-gray-300 bg-white focus:outline-none focus:border-black transition-colors"
			/>
			<button type="submit" class="bg-[#007129] text-white font-bold py-3 px-8 hover:bg-[#005a21] transition-colors duration-300 whitespace-nowrap">
				<?php echo esc_html( $button_text ); ?>
			</button>
		</form>
	</div>
</section>
