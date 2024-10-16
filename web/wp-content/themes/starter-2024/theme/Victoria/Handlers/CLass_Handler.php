<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler;
use Victoria\Attributes\Handler_Method;

class CLass_Handler extends Handler {
	public function handle( $class_instance ): void {
		$reflection_class = new \ReflectionClass( $class_instance );

		$class_methods = $reflection_class->getMethods();

		foreach ( $class_methods as $method ) {
			$method_name = $method->getName();

			$attributes = $method->getAttributes( Handler_Method::class );

			if ( ! empty( $attributes ) ) {
				$class_instance->{$method_name}();
			}
		}
	}
}
