<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Hookable;
use WP_Async_Request;
use WP_Background_Process;

abstract class Background_Processing implements Hookable {
	/*
	 * When extending this class, override below properties
	 */
	protected ?string $async_request_class_name;
	protected ?string $background_job_class_name;

	/*
	 * Below properties will hold instances of background job and async request classes, don't override them
	 */
	protected ?WP_Async_Request $async_request;
	protected ?WP_Background_Process $background_job;

	public function attach_hooks(): void {
		add_action( 'init', [ $this, 'init' ] );
	}

	public function init(): void {
		if (
			$this->async_request_class_name
			&& class_exists( $this->async_request_class_name )
		) {
			$this->async_request = new $this->async_request_class_name();
		}

		if (
			$this->background_job_class_name
			&& class_exists( $this->background_job_class_name )
		) {
			$this->background_job = new $this->background_job_class_name();
		}
	}
}
