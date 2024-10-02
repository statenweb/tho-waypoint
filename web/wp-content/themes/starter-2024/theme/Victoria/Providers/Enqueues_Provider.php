<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Enqueues\Main_Scripts_And_Styles;

class Enqueues_Provider extends Provider {
	protected array $items = [
		Main_Scripts_And_Styles::class,
	];
}
