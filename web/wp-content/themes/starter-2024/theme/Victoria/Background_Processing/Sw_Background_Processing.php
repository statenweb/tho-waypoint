<?php

namespace Victoria\Background_Processing;

use Victoria\Abstracts\Background_Processing;
use Victoria\Background_Processing\Sw_Background_Processing_Classes\Sw_Async_Request;
use Victoria\Background_Processing\Sw_Background_Processing_Classes\Sw_Background_Job;

class Sw_Background_Processing extends Background_Processing {
	protected ?string $async_request_class_name = Sw_Async_Request::class;
	protected ?string $background_job_class_name = Sw_Background_Job::class;
}
