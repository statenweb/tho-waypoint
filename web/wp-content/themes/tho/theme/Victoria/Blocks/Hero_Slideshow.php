<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Hero_Slideshow extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'hero-slideshow';
	const BLOCK_NAME = 'Hero Slideshow';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Full-width image carousel with overlay text and dot navigation.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'slides',
			'keywords'          => [ 'hero', 'slideshow', 'carousel', 'slider' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'hero_slideshow' ) );

		$section
			->addRepeater(
				'slides',
				[
					'label'         => 'Slides',
					'layout'        => 'block',
					'button_label'  => 'Add Slide',
					'min'           => 1,
				]
			)
				->addImage(
					'image',
					[
						'label'         => 'Background Image',
						'return_format' => 'id',
						'required'      => 1,
					]
				)
				->addText( 'heading', [ 'label' => 'Heading' ] )
				->addWysiwyg( 'body_text', [ 'label' => 'Body Text', 'tabs' => 'basic' ] )
				->addLink( 'cta_link', [ 'label' => 'CTA Link' ] )
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
			->addNumber(
				'autoplay_speed',
				[
					'label'         => 'Autoplay Speed (ms)',
					'default_value' => 5000,
					'min'           => 1000,
					'step'          => 500,
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
