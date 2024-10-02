<?php

namespace Victoria\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Field;

class Button extends Field {
	public static function fields(): FieldsBuilder {
		$button = new FieldsBuilder( static::$field_name );

		$button
			->addLink(
				static::$field_name,
				[
					'label' => static::$title,
				]
			)
	       ->addField('color', 'editor_palette', ['label' => 'Color'])
	       ->addField('text_color', 'editor_palette', ['label' => 'Text Color'])
	       ->addField('hover_text_color', 'editor_palette')
	       ->addTrueFalse('outline')
	       ->addTrueFalse('bold', [
		       'label' => 'Bold',
	       ]);

		return $button;
	}
}