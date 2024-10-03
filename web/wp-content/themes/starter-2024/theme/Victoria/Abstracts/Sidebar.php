<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Initiable;

abstract class Sidebar implements Initiable {
	abstract public function get_sidebar_definition(): array;

	public function init(): void {
		$this->register_sidebar();
	}

	protected function register_sidebar(): self {
		if ( $sidebar_definition = $this->get_sidebar_definition() ) {
			add_action( 'widgets_init', fn () => register_sidebar( $sidebar_definition ) );
		}

		return $this;
	}
}
