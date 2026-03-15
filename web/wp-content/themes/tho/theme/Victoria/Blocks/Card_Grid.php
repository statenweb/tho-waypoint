<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Card_Grid extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'card-grid';
	const BLOCK_NAME = 'Card Grid';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Multi-column card layout with image, title, and description.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'grid-view',
			'keywords'          => [ 'cards', 'grid', 'pillars' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'card_grid' ) );

		$section
			->addText( 'heading', [ 'label' => 'Section Heading' ] )
			->addSelect(
				'columns',
				[
					'label'         => 'Columns',
					'choices'       => [
						'2' => '2 Columns',
						'3' => '3 Columns',
						'4' => '4 Columns',
					],
					'default_value' => '3',
				]
			)
			->addRepeater(
				'cards',
				[
					'label'         => 'Cards',
					'layout'        => 'block',
					'button_label'  => 'Add Card',
					'min'           => 1,
				]
			)
				->addImage(
					'image',
					[
						'label'         => 'Image',
						'return_format' => 'id',
					]
				)
				->addText( 'title', [ 'label' => 'Title', 'required' => 1 ] )
				->addWysiwyg( 'description', [ 'label' => 'Description', 'tabs' => 'basic' ] )
				->addLink( 'link', [ 'label' => 'Link' ] )
			->endRepeater()
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
