<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Text_Image_Split extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'text-image-split';
	const BLOCK_NAME = 'Text + Image Split';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Two-column layout with content on one side and image on the other.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'align-pull-left',
			'keywords'          => [ 'text', 'image', 'split', 'two column' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'text_image_split' ) );

		$section
			->addText( 'heading', [ 'label' => 'Heading' ] )
			->addWysiwyg(
				'body_text',
				[
					'label' => 'Body Text',
					'tabs' => 'basic',
				]
			)
			->addLink( 'cta_link', [ 'label' => 'CTA Link' ] )
			->addImage(
				'image',
				[
					'label'         => 'Image',
					'return_format' => 'id',
					'required'      => 1,
				]
			)
			->addSelect(
				'image_position',
				[
					'label'         => 'Image Position',
					'choices'       => [
						'right' => 'Image Right',
						'left'  => 'Image Left',
					],
					'default_value' => 'right',
				]
			)
			->addSelect(
				'ratio',
				[
					'label'         => 'Column Ratio',
					'choices'       => [
						'50/50' => '50/50',
						'60/40' => '60/40 (Text/Img)',
						'40/60' => '40/60 (Text/Img)',
					],
					'default_value' => '50/50',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
