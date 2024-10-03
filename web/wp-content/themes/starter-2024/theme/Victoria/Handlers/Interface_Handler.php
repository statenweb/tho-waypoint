<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler;
use Victoria\Attributes\Handler_Method;

class Interface_Handler extends Handler {
	public static function handle( $class_instance ): void {
		$reflection_class = new \ReflectionClass( $class_instance );

		$reflection_class_interfaces = $reflection_class->getInterfaces();

		if ( ! $reflection_class_interfaces ) return;

		foreach ( $reflection_class_interfaces as $interface ) {
			$interface_methods = $interface->getMethods();

			foreach ( $interface_methods as $method ) {
				$method_name = $method->getName();

				$attributes = $method->getAttributes( Handler_Method::class );

				if ( ! empty( $attributes ) ) {
					$class_instance->{$method_name}();
				}
			}
		}
	}
}
