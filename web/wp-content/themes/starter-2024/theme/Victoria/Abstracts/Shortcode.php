<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Initializable;

abstract class Shortcode implements Initializable {
	abstract public function output( array $atts, ?string $content = null ): mixed;

	public function init(): void {
		add_shortcode( static::SLUG, [$this, 'output'] );
	}
}