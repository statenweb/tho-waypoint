<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Blog_Grid extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'blog-grid';
	const BLOCK_NAME = 'Blog Grid';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Blog post listing grid with thumbnail, title, and date.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'admin-post',
			'keywords'          => [ 'blog', 'posts', 'grid', 'listing' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'blog_grid' ) );

		$section
			->addText( 'heading', [ 'label' => 'Section Heading' ] )
			->addNumber( 'posts_per_page', [
				'label'         => 'Posts to Show',
				'default_value' => 6,
				'min'           => 1,
				'max'           => 24,
			] )
			->addSelect(
				'columns',
				[
					'label'         => 'Columns',
					'choices'       => [
						'2' => '2 Columns',
						'3' => '3 Columns',
					],
					'default_value' => '3',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
