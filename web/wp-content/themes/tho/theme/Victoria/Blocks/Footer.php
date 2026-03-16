<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Footer extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'footer';
	const BLOCK_NAME = 'Footer';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Site footer with logo, navigation columns, social links, and copyright.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'admin-footer',
			'keywords'          => [ 'footer', 'colophon', 'navigation' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'footer' ) );

		$section
			->addImage(
				'logo',
				[
					'label'         => 'Logo',
					'return_format' => 'id',
				]
			)
			->addRepeater(
				'columns',
				[
					'label'         => 'Footer Columns',
					'layout'        => 'block',
					'button_label'  => 'Add Column',
					'max'           => 4,
				]
			)
				->addText(
					'heading',
					[
						'label'    => 'Column Heading',
						'required' => 1,
					]
				)
				->addRepeater(
					'links',
					[
						'label'        => 'Links',
						'layout'       => 'table',
						'button_label' => 'Add Link',
					]
				)
					->addText(
						'label',
						[
							'label'    => 'Label',
							'required' => 1,
						]
					)
					->addLink(
						'link',
						[
							'label'    => 'Link',
							'required' => 1,
						]
					)
				->endRepeater()
			->endRepeater()
			->addText(
				'copyright',
				[
					'label' => 'Copyright Text',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
