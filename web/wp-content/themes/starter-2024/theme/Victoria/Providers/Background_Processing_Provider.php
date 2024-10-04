<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Background_Processing\Sw_Background_Processing;

class Background_Processing_Provider extends Provider {
	protected array $items = [
		Sw_Background_Processing::class,
	];
}
