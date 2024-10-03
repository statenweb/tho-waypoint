<?php

namespace Victoria\Traits;

use Victoria\Attributes\Handler_Method;

trait Save {
	#[Handler_Method]
	public function save_hooks() {
		add_action( 'save_post', [ $this, 'trait_save_post' ], PHP_INT_MAX, 2 );
	}

	public function trait_save_post( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! defined( 'OVERRIDE_AJAX' ) ) {
			return;
		}

		if ( false !== wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( static::POST_TYPE !== $post->post_type ) {
			return;
		}

		do_action( 'real_save_post', $post_id, $post );
	}
}
