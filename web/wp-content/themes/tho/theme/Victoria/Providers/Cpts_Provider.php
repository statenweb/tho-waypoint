<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\PostTypes\Partner;
use Victoria\PostTypes\Program;

class Cpts_Provider extends Provider {
	protected array $items = [
		Partner::class,
		Program::class,
	];
}
