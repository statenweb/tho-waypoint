<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\PostTypes\BoardMember;
use Victoria\PostTypes\Partner;
use Victoria\PostTypes\Program;
use Victoria\PostTypes\TeamMember;

class Cpts_Provider extends Provider {
	protected array $items = [
		BoardMember::class,
		Partner::class,
		Program::class,
		TeamMember::class,
	];
}
