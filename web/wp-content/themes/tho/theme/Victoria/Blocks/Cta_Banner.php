<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Cta_Banner extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'cta-banner';
	const BLOCK_NAME = 'CTA Banner';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Full-width call-to-action with heading, text, and button.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'megaphone',
			'keywords'          => [ 'cta', 'banner', 'call to action' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'cta_banner' ) );

		$section
			->addText(
				'heading',
				[
					'label' => 'Heading',
					'required' => 1,
				]
			)
			->addWysiwyg(
				'body_text',
				[
					'label' => 'Body Text',
					'tabs' => 'basic',
				]
			)
			->addLink(
				'button_link',
				[
					'label' => 'Button Link',
					'required' => 1,
				]
			)
			->addSelect(
				'button_style',
				[
					'label'         => 'Button Style',
					'choices'       => [
						'primary'   => 'Primary (Green)',
						'secondary' => 'Secondary (Black)',
						'outline'   => 'Outline',
					],
					'default_value' => 'primary',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
