<?php

namespace Victoria\Traits;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Abstracts\Cpt;
use Victoria\Attributes\Handler_Method;

trait Has_Acf_Fields_Builder {
	abstract public function get_acf_fields(): ?FieldsBuilder;

	#[Handler_Method]
	public function register_acf_fields(): self {
		if (
			function_exists( 'acf_add_local_field_group' )
			&& $acf_fields = $this->get_acf_fields()
		) {
			add_action( 'acf/init', fn () => acf_add_local_field_group( $acf_fields->build() ) );
		}

		return $this;
	}

	protected function get_acf_field_unique_name( ?string $name = null ): string {
		$prefix = 'sw-';

		return match ( true ) {
			$this instanceof Block => $prefix . self::BLOCK_SLUG,
			$this instanceof Cpt => $prefix . self::POST_TYPE,
			default => 'sw-' . ( $name ?: sanitize_title( str_replace( '\\', '-', get_called_class() ) ) )
		};
	}
}
