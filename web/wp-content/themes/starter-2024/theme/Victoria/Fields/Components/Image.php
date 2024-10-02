<?php

namespace Victoria\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Field;

class Image extends Field {
	public static function fields(): FieldsBuilder {
		$image = new FieldsBuilder( static::$field_name );

		$image
			->addImage(
				static::$field_name,
				[
					'label'         => static::$title,
					'return_format' => 'id'
				]
			);

		return $image;
	}
}