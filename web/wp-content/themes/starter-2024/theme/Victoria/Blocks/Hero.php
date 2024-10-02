<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Fields\Background_Image;
use Victoria\Fields\Submit_Button;
use Victoria\Fields\Subtitle;
use Victoria\Fields\Title;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Hero extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'hero';
	const BLOCK_NAME = 'SW Hero';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => self::BLOCK_NAME,
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'admin-site',
			'keywords'          => [ self::BLOCK_NAME ],
			'align'             => false,
			'mode'              => 'preview',
			'supports'          => [
				'color'             => [
					'background'    => true,
					'text'          => true,
					'gradients'     => true,
				],
				'jsx'           => true,
			],
			'enqueue_assets'  => function () {
			},
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'section' ) );

		$section
			->addFields( Title::fields() )
			->addFields( Subtitle::fields() )
			->addFields( Background_Image::fields() )
			->addFields( Submit_Button::fields() )

			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
