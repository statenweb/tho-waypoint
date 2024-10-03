<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler;
use Victoria\Interfaces\Hookable;
use Victoria\Interfaces\Initiable;

class Interface_Handler extends Handler {
	public static function handle( $class_instance ): void {
		if ( $class_instance instanceof Initiable ) {
			$class_instance->init();
		}

		if ( $class_instance instanceof Hookable ) {
			$class_instance->attach_hooks();
		}
	}
}
