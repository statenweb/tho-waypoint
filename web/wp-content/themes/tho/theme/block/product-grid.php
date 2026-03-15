<?php

use Victoria\Utilities\Utils;

$id              = basename( __FILE__ ) . $block['id'];
$block_classes   = Utils::get_block_classes( $block );
$heading         = get_field( 'heading' );
$products_count  = get_field( 'products_per_page' ) ?: 8;
$columns         = get_field( 'columns' ) ?: '4';
$category        = get_field( 'category' );
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="max-w-6xl mx-auto px-6">
		<?php if ( $heading ) : ?>
		<h2 class="text-3xl md:text-4xl font-bold mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( class_exists( 'WooCommerce' ) ) :
			$meta_query = [];
			$tax_query  = [];
			if ( $category ) {
				$tax_query[] = [
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $category,
				];
			}
			$products = wc_get_products( [
				'limit'     => $products_count,
				'status'    => 'publish',
				'tax_query' => $tax_query ?: null,
			] );
			?>
		<?php if ( $products ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr( $columns ); ?> gap-8">
			<?php foreach ( $products as $product ) : ?>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="group flex flex-col">
				<div class="mb-4 overflow-hidden">
					<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300' ] ); ?>
				</div>
				<h3 class="text-base font-bold mb-1"><?php echo esc_html( $product->get_name() ); ?></h3>
				<span class="text-sm font-bold"><?php echo $product->get_price_html(); ?></span>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php else : ?>
		<p class="text-center opacity-60">Product grid requires WooCommerce.</p>
		<?php endif; ?>
	</div>
</section>
