<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Handleable;

abstract class Handler_Manager {
	protected array $handlers = [];

	public function process_handlers( $class_instance ): void {
		if ( empty( $this->handlers ) || ! is_array( $this->handlers ) ) {
			return;
		}

		array_walk(
			$this->handlers,
			fn ( $handler_class ) => ( $handler = new $handler_class() ) instanceof Handleable && $handler->handle( $class_instance )
		);
	}
}
