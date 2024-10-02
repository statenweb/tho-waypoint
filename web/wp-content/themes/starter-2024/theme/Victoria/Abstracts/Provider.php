<?php

namespace Victoria\Abstracts;

use Victoria\Handlers\Interface_Handler;
use Victoria\Handlers\Trait_Handler;
use Victoria\Interfaces\Bootable;

abstract class Provider implements Bootable {
	protected array $items = [];

	public function boot(): void {
		if ( empty( $this->items ) || ! is_array( $this->items ) ) return;

		array_walk(
			$this->items,
			function ( $item_class ) {
				$item_instance = new $item_class();

				Interface_Handler::handle( $item_instance );

				Trait_Handler::handle( $item_instance );
			}
		);
	}
}