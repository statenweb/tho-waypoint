<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Blocks\Hero;

class Blocks_Provider extends Provider {
	protected array $items = [
		Hero::class,
	];
}
