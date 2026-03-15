<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Social_Links extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'social-links';
	const BLOCK_NAME = 'Social Links';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Row of social media icon links.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'share',
			'keywords'          => [ 'social', 'icons', 'links' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'social_links' ) );

		$section
			->addRepeater(
				'links',
				[
					'label'         => 'Social Links',
					'layout'        => 'table',
					'button_label'  => 'Add Social Link',
				]
			)
				->addSelect(
					'platform',
					[
						'label'   => 'Platform',
						'choices' => [
							'instagram' => 'Instagram',
							'facebook'  => 'Facebook',
							'linkedin'  => 'LinkedIn',
							'youtube'   => 'YouTube',
							'twitter'   => 'Twitter / X',
							'tiktok'    => 'TikTok',
						],
						'required' => 1,
					]
				)
				->addUrl( 'url', [ 'label' => 'URL', 'required' => 1 ] )
			->endRepeater()
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
