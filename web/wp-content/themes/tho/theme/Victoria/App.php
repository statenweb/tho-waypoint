<?php

namespace Victoria;

use Victoria\Interfaces\Bootable;

class App {
	protected array $providers = [];

	public function init(): void {
		if ( empty( $this->providers ) || ! is_array( $this->providers ) ) {
			return;
		}

		array_walk(
			$this->providers,
			fn ( $provider_class ) => ( $provider = new $provider_class() ) instanceof Bootable && $provider->boot()
		);
	}

	public function add_providers( array $providers ): self {
		array_walk(
			$providers,
			fn ( $provider ) => $this->providers[] = $provider
		);

		return $this;
	}
}
