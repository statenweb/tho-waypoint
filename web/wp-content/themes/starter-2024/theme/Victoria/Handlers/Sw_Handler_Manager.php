<?php

namespace Victoria\Handlers;

use Victoria\Abstracts\Handler_Manager;

class Sw_Handler_Manager extends Handler_Manager {
	protected array $handlers = [
		Interface_Handler::class,
		Trait_Handler::class,
	];
}
