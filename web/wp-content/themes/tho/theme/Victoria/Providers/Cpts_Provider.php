<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Post_Types\Student;
use Victoria\PostTypes\TeamMember;

class Cpts_Provider extends Provider {
	protected array $items = [
		Student::class,
		TeamMember::class,
	];
}
