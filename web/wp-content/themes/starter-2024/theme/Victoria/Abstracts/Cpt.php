<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Initiable;

abstract class Cpt implements Initiable {
	const POST_TYPE = '';

	abstract public function get_cpt_definition(): array;

	public function init(): void {
		$this->register_cpt();
	}

	protected function register_cpt(): self {
		if ( $cpt_definition = $this->get_cpt_definition() ) {
			add_action( 'init', fn () => register_post_type( static::POST_TYPE, $cpt_definition ) );
		}

		return $this;
	}
}
