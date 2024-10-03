<?php

namespace Victoria\Interfaces;

use Victoria\Attributes\Handler_Method;

interface Hookable {
	#[Handler_Method]
	public function attach_hooks(): void;
}
