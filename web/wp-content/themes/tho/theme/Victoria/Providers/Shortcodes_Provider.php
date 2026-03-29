<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Shortcodes\Year;

class Shortcodes_Provider extends Provider {
	protected array $items = [
		Year::class,
	];
}
