<?php

namespace Victoria\Background_Processing\Sw_Email_Background_Processing_Classes;

use Victoria\Utilities\Sw_Mail_Service;
use WP_Background_Process;

class Sw_Email_Background_Job extends WP_Background_Process {
	protected $prefix = 'sw';

	protected $action = 'email_background_job';

	protected function task( $email_data ) {
		( new Sw_Mail_Service() )->execute( $email_data );

		return false;
	}
}
