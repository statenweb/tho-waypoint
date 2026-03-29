<?php

namespace Victoria\Background_Processing;

use Victoria\Abstracts\Background_Processing;
use Victoria\Background_Processing\Sw_Email_Background_Processing_Classes\Sw_Email_Background_Job;

class Sw_Email_Background_Processing extends Background_Processing {
	protected ?string $background_job_class_name = Sw_Email_Background_Job::class;
}
