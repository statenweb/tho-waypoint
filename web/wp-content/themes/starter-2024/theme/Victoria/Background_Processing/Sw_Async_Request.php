<?php

namespace Victoria\Background_Processing;

use WP_Async_Request;

class Sw_Async_Request extends WP_Async_Request {
	protected $prefix = 'sw';

	protected $action = 'async_request';

	protected function handle() {
		// implement logic to handle async request data
	}
}
