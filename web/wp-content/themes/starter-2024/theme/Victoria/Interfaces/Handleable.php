<?php

namespace Victoria\Interfaces;


use Victoria\Attributes\Handler_Method;

interface Handleable {
	#[Handler_Method]
	public function handle( $class_instance ): void;
}