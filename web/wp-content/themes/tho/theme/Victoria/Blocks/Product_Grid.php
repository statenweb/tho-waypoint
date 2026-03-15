<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Product_Grid extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'product-grid';
	const BLOCK_NAME = 'Product Grid';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Shop product listing grid with image, title, and price.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'store',
			'keywords'          => [ 'products', 'shop', 'grid', 'woocommerce' ],
			'align'             => false,
			'mode'              => 'preview',
			'supports'          => [
				'color' => [
					'background' => true,
					'text'       => true,
					'gradients'  => true,
				],
				'jsx' => true,
			],
			'enqueue_assets' => function () {},
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'product_grid' ) );

		$section
			->addText( 'heading', [ 'label' => 'Section Heading' ] )
			->addNumber(
				'products_per_page',
				[
					'label'         => 'Products to Show',
					'default_value' => 8,
					'min'           => 1,
					'max'           => 48,
				]
			)
			->addSelect(
				'columns',
				[
					'label'         => 'Columns',
					'choices'       => [
						'2' => '2 Columns',
						'3' => '3 Columns',
						'4' => '4 Columns',
					],
					'default_value' => '4',
				]
			)
			->addSelect(
				'category',
				[
					'label'         => 'Product Category',
					'choices'       => [
						''             => 'All Products',
						'apparel'      => 'Apparel',
						'promotional'  => 'Promotional Items',
						'accessories'  => 'Accessories',
					],
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
