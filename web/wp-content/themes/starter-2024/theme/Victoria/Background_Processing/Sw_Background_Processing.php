<?php

namespace Victoria\Background_Processing;

use Victoria\Interfaces\Hookable;

class Sw_Background_Processing implements Hookable {
	protected $process_single;

	protected $process_all;

	public function attach_hooks(): void {
		add_action( 'init', [ $this, 'init' ] );
	}

	public function init() {
		$this->process_single = new Sw_Async_Request();
		$this->process_all = new Sw_Background_Job();
	}
}
