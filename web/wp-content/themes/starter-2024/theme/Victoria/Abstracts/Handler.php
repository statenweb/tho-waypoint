<?php

namespace Victoria\Abstracts;

abstract class Handler {
	abstract public static function handle( $class_instance ): void;
}