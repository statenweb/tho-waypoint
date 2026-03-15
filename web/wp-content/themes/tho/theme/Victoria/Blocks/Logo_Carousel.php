<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Logo_Carousel extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'logo-carousel';
	const BLOCK_NAME = 'Logo Carousel';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Horizontal scrolling partner/press logos.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'slides',
			'keywords'          => [ 'logos', 'carousel', 'partners', 'press' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'logo_carousel' ) );

		$section
			->addText( 'heading', [ 'label' => 'Section Heading' ] )
			->addRepeater(
				'logos',
				[
					'label'         => 'Logos',
					'layout'        => 'block',
					'button_label'  => 'Add Logo',
					'min'           => 1,
				]
			)
				->addImage(
					'logo',
					[
						'label'         => 'Logo Image',
						'return_format' => 'id',
						'required'      => 1,
					]
				)
				->addText( 'name', [ 'label' => 'Name / Alt Text' ] )
				->addLink( 'link', [ 'label' => 'Link' ] )
			->endRepeater()
			->addSelect(
				'autoplay',
				[
					'label'         => 'Autoplay',
					'choices'       => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
					'default_value' => 'yes',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
