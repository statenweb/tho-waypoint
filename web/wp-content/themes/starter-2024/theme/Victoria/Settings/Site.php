<?php

namespace Victoria\Settings;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Setting;
use Victoria\Traits\Has_Acf_Fields_Builder;
use WP_Admin_Bar;

class Site extends Setting {
	use Has_Acf_Fields_Builder;

	const SLUG = 'site_settings';

	public function attach_hooks(): void {
		add_action( 'admin_bar_menu', [$this, 'admin_bar'], 100 );
		add_action( 'init', [$this, 'add_settings_page'] );
	}

	public function admin_bar( WP_Admin_Bar $wp_admin_bar ): void {
		if ( ! current_user_can( 'manage_options' ) ) return;

		$args = [
			'id'    => 'site-settings',
			'title' => 'Site Settings',
			'href'  => admin_url( 'options-general.php?page=' . self::SLUG ),
			'meta'  => [
				'class' => 'site-settings',
				'title' => 'Manage Site Settings'
			]
		];

		$wp_admin_bar->add_node( $args );
	}

	public function add_settings_page(): void {
		if ( function_exists( 'acf_add_options_sub_page' ) ) {
			acf_add_options_sub_page(
				[
					'page_title'  => 'Site Settings',
					'menu_title'  => 'Site Settings',
					'menu_slug'   => self::SLUG,
					'capability'  => 'edit_users',
					'parent_slug' => 'options-general.php',
				]
			);
		}
	}

	public function get_acf_fields(): ?FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'sw' ) );

		$settings
			->addImage('logo', ['return_format' => 'id', 'label' => 'Logo'])
			->addImage('footer_logo', ['return_format' => 'id', 'label' => 'Footer Logo', 'instructions' => 'If blank, it will use the main logo'])

			->setLocation('options_page', '==', self::SLUG);

		return $settings;
	}
}
