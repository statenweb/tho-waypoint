<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Sidebars\Footer_Left;
use Victoria\Sidebars\Footer_Right;

class Sidebars_Provider extends Provider {
	protected array $items = [
		Footer_Right::class,
		Footer_Left::class
	];
}