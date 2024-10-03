<?php

namespace Victoria\Interfaces;

use Victoria\Attributes\Handler_Method;

interface Bootable {
	#[Handler_Method]
	public function boot();
}
