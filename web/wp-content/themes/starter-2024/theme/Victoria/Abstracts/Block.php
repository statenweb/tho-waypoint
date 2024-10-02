<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Initializable;

abstract class Block implements Initializable {
	const BLOCK_SLUG = '';
	const BLOCK_NAME = '';

	abstract public function get_block_definition(): array;

	public function init(): void {
		$this->register_block();
	}

	protected function register_block(): self {
		if (
			function_exists( 'acf_register_block_type' )
			&& $block_definition = $this->get_block_definition()
		) {
			add_action( 'acf/init', fn () => acf_register_block_type( $block_definition ) );
		}

		return $this;
	}

	public function get_acf_unique_name(): string {
		return sprintf( 'sw-%s', static::BLOCK_SLUG );
	}
}
