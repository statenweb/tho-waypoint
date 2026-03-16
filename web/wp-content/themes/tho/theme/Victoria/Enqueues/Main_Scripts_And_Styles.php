<?php

namespace Victoria\Enqueues;

use Victoria\Abstracts\Enqueue;

class Main_Scripts_And_Styles extends Enqueue {
	public function attach_hooks(): void {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ], 100 );
	}

	public function enqueue(): void {
		wp_dequeue_script( '_tw-script' );
		wp_dequeue_style( '_tw-style' );
		wp_enqueue_style( 'statenweb-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );
		wp_enqueue_script( 'statenweb-script', get_template_directory_uri() . '/js/script.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/js/script.min.js' ), true );

		wp_localize_script(
			'statenweb-script',
			'sw',
			apply_filters(
				'sw_localize_script',
				[
					'menu_style' => get_field( 'menu_style', 'option' ),
				]
			)
		);
	}
}
