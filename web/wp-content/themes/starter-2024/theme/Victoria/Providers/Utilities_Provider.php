<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Utilities\Tailwind_Navwalker;
use Victoria\Utilities\Utils;

class Utilities_Provider extends Provider {
	protected array $items = [
		Tailwind_Navwalker::class,
		Utils::class,
	];
}
