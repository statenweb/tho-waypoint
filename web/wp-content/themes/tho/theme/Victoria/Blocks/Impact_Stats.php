<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Impact_Stats extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'impact-stats';
	const BLOCK_NAME = 'Impact Stats';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Number counter with labels in a multi-column grid.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'chart-bar',
			'keywords'          => [ 'stats', 'counter', 'impact', 'numbers' ],
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
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'impact_stats' ) );

		$section
			->addRepeater(
				'stats',
				[
					'label'         => 'Stats',
					'layout'        => 'block',
					'button_label'  => 'Add Stat',
					'min'           => 1,
				]
			)
				->addText(
					'number',
					[
						'label' => 'Number / Value',
						'required' => 1,
					]
				)
				->addText(
					'label',
					[
						'label' => 'Label',
						'required' => 1,
					]
				)
			->endRepeater()
			->addSelect(
				'columns',
				[
					'label'         => 'Columns',
					'choices'       => [
						'2' => '2 Columns',
						'3' => '3 Columns',
						'4' => '4 Columns',
					],
					'default_value' => '2',
				]
			)
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
