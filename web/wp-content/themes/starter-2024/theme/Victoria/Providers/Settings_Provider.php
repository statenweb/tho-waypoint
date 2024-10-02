<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Settings\Site;

class Settings_Provider extends Provider {
	protected array $items = [
		Site::class
	];
}