<?php

namespace Victoria\Hooks;

use Victoria\Abstracts\Hook;

class Actions extends Hook {
	public function attach_hooks(): void {
		add_action( 'after_setup_theme', [$this, 'image_sizes'] );
	}

	public function image_sizes(){
		add_image_size( 'provider-crop-small', 313, 400, true );
		add_image_size( 'provider-crop', 500, 638, true );
		add_image_size( 'provider', 500, 638, false );
		add_image_size( '1200x500', 1200, 500, false );
		add_image_size( '1200x500-crop', 1200, 500, true );
		add_image_size( '1200x480', 1200, 480, false );
		add_image_size( '1200x480-crop', 1200, 480, true );
		add_image_size( 'hero-smallish-crop', 1920, 400, true );
	}
}