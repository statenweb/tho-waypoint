<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Post_Types\Student;

class Cpts_Provider extends Provider {
	protected array $items = [
		Student::class,
	];
}
