<?php

namespace Victoria\Sidebars;

use Victoria\Abstracts\Sidebar;

class Footer_Left extends Sidebar {
	public function get_sidebar_definition(): array {
		return [
			'name'          => __( 'Footer Left', '_tw' ),
			'id'            => 'footer-sidebar-left',
			'description'   => __( 'Add widgets here to appear in the center section of the footer', '_tw' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		];
	}
}
