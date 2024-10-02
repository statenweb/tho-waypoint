<?php

namespace Victoria\Shortcodes;

use Victoria\Abstracts\Shortcode;

class Year extends Shortcode {
	const SLUG = 'year';

	public function output( $atts, $content = null ): string {
		return gmdate( 'Y' );
	}
}