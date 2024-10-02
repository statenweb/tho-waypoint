<?php

namespace Victoria\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Field;

class Text extends Field {
	public static function fields(): FieldsBuilder {
		$text = new FieldsBuilder( static::$field_name );

		$text
			->addText(
				static::$field_name,
				[
					'label' => static::$title,
				]
			);

		return $text;
	}
}