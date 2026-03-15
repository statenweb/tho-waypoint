<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Section_Heading extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'section-heading';
	const BLOCK_NAME = 'Section Heading';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Reusable heading and body text block.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'heading',
			'keywords'          => [ 'heading', 'title', 'section' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'section_heading' ) );

		$section
			->addSelect(
				'heading_element',
				[
					'label'         => 'Heading Element',
					'choices'       => [
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
					],
					'default_value' => 'h2',
				]
			)
			->addText( 'heading', [ 'label' => 'Heading', 'required' => 1 ] )
			->addWysiwyg( 'body_text', [ 'label' => 'Body Text', 'tabs' => 'basic' ] )
			->addSelect(
				'alignment',
				[
					'label'         => 'Alignment',
					'choices'       => [
						'text-left'   => 'Left',
						'text-center' => 'Center',
					],
					'default_value' => 'text-center',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
