<?php

namespace Victoria\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Block;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Email_Signup extends Block {
	use Has_Acf_Fields_Builder;

	const BLOCK_SLUG = 'email-signup';
	const BLOCK_NAME = 'Email Signup';

	public function get_block_definition(): array {
		return [
			'name'              => $this->get_acf_unique_name(),
			'title'             => self::BLOCK_NAME,
			'description'       => 'Email signup form with heading and submit button.',
			'render_template'   => sprintf( 'block/%s.php', self::BLOCK_SLUG ),
			'category'          => 'common',
			'icon'              => 'email',
			'keywords'          => [ 'email', 'signup', 'form', 'newsletter' ],
			'align'             => false,
			'mode'              => 'preview',
			'supports'          => [
				'color' => [
					'background' => true,
					'text'       => true,
					'gradients'  => true,
				],
				'jsx' => true,
			],
			'enqueue_assets' => function () {},
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$section = new FieldsBuilder( $this->get_acf_field_unique_name( 'email_signup' ) );

		$section
			->addText( 'heading', [ 'label' => 'Heading' ] )
			->addText( 'placeholder', [
				'label'         => 'Placeholder Text',
				'default_value' => 'Enter your email',
			] )
			->addText( 'button_text', [
				'label'         => 'Button Text',
				'default_value' => 'Sign Up',
			] )
			->addText( 'form_action', [
				'label'       => 'Form Action URL',
				'instructions' => 'External form endpoint (Mailchimp, etc.) or leave blank for default.',
			] )
			->setLocation( 'block', '==', 'acf/' . $this->get_acf_unique_name() );

		return $section;
	}
}
