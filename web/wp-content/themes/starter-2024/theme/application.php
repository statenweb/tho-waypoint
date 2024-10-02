<?php

use Victoria\App;
use Victoria\Providers\Blocks_Provider;
use Victoria\Providers\Cpts_Provider;
use Victoria\Providers\Enqueues_Provider;
use Victoria\Providers\Hooks_Provider;
use Victoria\Providers\Settings_Provider;
use Victoria\Providers\Shortcodes_Provider;
use Victoria\Providers\Sidebars_Provider;
use Victoria\Providers\Utilities_Provider;

( new App() )
	->add_providers(
		[
			Blocks_Provider::class,
			Cpts_Provider::class,
			Shortcodes_Provider::class,
			Sidebars_Provider::class,
			Enqueues_Provider::class,
			Hooks_Provider::class,
			Utilities_Provider::class,
			Settings_Provider::class,
		]
	)
	->init();
