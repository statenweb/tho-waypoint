<?php

namespace Victoria\Abstracts;

use Victoria\Handlers\Sw_Handler_Manager;
use Victoria\Interfaces\Bootable;

abstract class Provider implements Bootable {
	protected array $items = [];

	public function boot(): void {
		if ( empty( $this->items ) || ! is_array( $this->items ) ) {
			return;
		}

		array_walk(
			$this->items,
			function ( $item_class ) {
				$item_instance = new $item_class();

				( new Sw_Handler_Manager() )->process_handlers( $item_instance );
			}
		);
	}
}
