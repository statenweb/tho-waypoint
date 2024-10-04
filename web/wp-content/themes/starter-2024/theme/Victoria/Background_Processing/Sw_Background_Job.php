<?php

namespace Victoria\Background_Processing;

use WP_Background_Process;

class Sw_Background_Job extends WP_Background_Process {
	protected $prefix = 'sw';

	protected $action = 'background_job';

	protected function task( $item ) {
		// implement logic to handle background job data

		return false;
	}
}
