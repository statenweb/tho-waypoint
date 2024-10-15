<?php

namespace Victoria\Interfaces;

use Victoria\Attributes\Handler_Method;

interface Initiable {
	#[Handler_Method]
	public function init(): void;
}
