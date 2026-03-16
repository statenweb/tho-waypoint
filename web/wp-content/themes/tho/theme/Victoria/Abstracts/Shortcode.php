<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Initiable;

abstract class Shortcode implements Initiable {
	abstract public function output( array $atts, ?string $content = null ): mixed;

	public function init(): void {
		add_shortcode( static::SLUG, [ $this, 'output' ] );
	}
}
