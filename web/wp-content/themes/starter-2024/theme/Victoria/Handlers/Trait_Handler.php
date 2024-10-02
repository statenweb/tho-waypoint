<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Trait_Handler extends Handler {
	public static function handle( $class_instance ): void {
		$class_traits = self::get_class_traits( $class_instance );

		if ( ! $class_traits ) {
			return;
		}

		if ( in_array( Has_Acf_Fields_Builder::class, $class_traits ) ) {
			$class_instance->register_acf_fields();
		}
	}

	private static function get_class_traits( $class_instance ): array {
		return array_merge(
			class_uses( $class_instance ),
			array_values( array_map( 'class_uses', class_parents( $class_instance ) ) )
		);
	}
}
