<?php

namespace Victoria\Background_Processing\Sw_Email_Background_Processing_Classes;

use Victoria\Utilities\SW_Mailer;
use WP_Background_Process;

class Sw_Email_Background_Job extends WP_Background_Process {
	protected $prefix = 'sw';

	protected $action = 'email_background_job';

	protected function task( $email_data ) {
		( new SW_Mailer() )->execute( $email_data );

		return false;
	}
}
