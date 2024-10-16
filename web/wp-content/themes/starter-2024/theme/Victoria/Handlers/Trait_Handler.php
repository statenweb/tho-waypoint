<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler;
use Victoria\Attributes\Handler_Method;

class Trait_Handler extends Handler {
	public function handle( $class_instance ): void {
		$class_traits = self::get_class_traits( $class_instance );

		if ( ! $class_traits ) {
			return;
		}

		foreach ( $class_traits as $trait_name ) {
			$reflection_trait = new \ReflectionClass( $trait_name );

			foreach ( $reflection_trait->getMethods() as $trait_method ) {
				$method_name = $trait_method->getName();

				$attributes = $trait_method->getAttributes( Handler_Method::class );

				if ( ! empty( $attributes ) ) {
					$class_instance->{$method_name}();
				}
			}
		}
	}

	private static function get_class_traits( $class_instance ): array {
		$class_parents = class_parents( $class_instance ) ?: [];
		$class_traits = class_uses( $class_instance ) ?: [];

		foreach ( $class_parents as $parent ) {
			$class_traits = array_merge( $class_traits, class_uses( $parent ) );
		}

		foreach ( $class_traits as $trait ) {
			$class_traits = array_merge( $class_traits, class_uses( $trait ) );
		}

		return $class_traits;
	}
}
