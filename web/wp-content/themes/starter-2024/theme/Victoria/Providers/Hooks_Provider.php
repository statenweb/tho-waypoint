<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Hooks\Actions;
use Victoria\Hooks\Filters;

class Hooks_Provider extends Provider {
	protected array $items = [
		Actions::class,
		Filters::class
	];
}