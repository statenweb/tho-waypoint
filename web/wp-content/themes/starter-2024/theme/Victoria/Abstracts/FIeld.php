<?php

namespace Victoria\Abstracts;

use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class Field {
	abstract public static function fields(): FieldsBuilder;
}