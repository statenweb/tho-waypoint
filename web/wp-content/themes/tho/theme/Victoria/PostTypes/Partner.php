<?php

namespace Victoria\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Cpt;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Partner extends Cpt {
	use Has_Acf_Fields_Builder;

	const POST_TYPE   = 'partner';
	const TAXONOMY    = 'partner_type';

	public function __construct() {
		parent::__construct();
		add_action( 'init', [ $this, 'register_taxonomy' ] );
	}

	public function register_taxonomy(): void {
		register_taxonomy(
			self::TAXONOMY,
			self::POST_TYPE,
			[
				'labels'            => [
					'name'              => 'Partner Types',
					'singular_name'     => 'Partner Type',
					'menu_name'         => 'Partner Types',
					'all_items'         => 'All Partner Types',
					'edit_item'         => 'Edit Partner Type',
					'view_item'         => 'View Partner Type',
					'update_item'       => 'Update Partner Type',
					'add_new_item'      => 'Add New Partner Type',
					'new_item_name'     => 'New Partner Type Name',
					'parent_item'       => 'Parent Partner Type',
					'parent_item_colon' => 'Parent Partner Type:',
					'search_items'      => 'Search Partner Types',
					'not_found'         => 'No partner types found',
				],
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_in_rest'      => false,
				'show_admin_column' => true,
				'rewrite'           => false,
			]
		);
	}

	public function get_cpt_definition(): array {
		return [
			'labels'             => [
				'name'                  => 'Partners',
				'singular_name'         => 'Partner',
				'menu_name'             => 'Partners',
				'all_items'             => 'All Partners',
				'edit_item'             => 'Edit Partner',
				'view_item'             => 'View Partner',
				'view_items'            => 'View Partners',
				'add_new_item'          => 'Add New Partner',
				'add_new'               => 'Add New',
				'new_item'              => 'New Partner',
				'parent_item_colon'     => 'Parent Partner:',
				'search_items'          => 'Search Partners',
				'not_found'             => 'No partners found',
				'not_found_in_trash'    => 'No partners found in Trash',
				'archives'              => 'Partner Archives',
				'attributes'            => 'Partner Attributes',
				'insert_into_item'      => 'Insert into partner',
				'uploaded_to_this_item' => 'Uploaded to this partner',
				'filter_items_list'     => 'Filter partners list',
				'filter_by_date'        => 'Filter partners by date',
				'items_list_navigation' => 'Partners list navigation',
				'items_list'            => 'Partners list',
				'item_published'        => 'Partner published.',
				'item_published_privately' => 'Partner published privately.',
				'item_reverted_to_draft' => 'Partner reverted to draft.',
				'item_scheduled'        => 'Partner scheduled.',
				'item_updated'          => 'Partner updated.',
				'item_link'             => 'Partner Link',
				'item_link_description' => 'A link to a partner.',
			],
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'show_in_rest'       => false,
			'exclude_from_search' => true,
			'has_archive'        => false,
			'rewrite'            => false,
			'query_var'          => false,
			'menu_icon'          => 'dashicons-businessman',
			'supports'           => [
				'title',
				'thumbnail',
				'page-attributes',
			],
			'delete_with_user'   => false,
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'partner' ) );

		$settings
			->addImage(
				'logo',
				[
					'label'         => 'Logo',
					'instructions'  => 'The partner logo image.',
					'return_format' => 'id',
				]
			)
			->addUrl(
				'url',
				[
					'label'        => 'URL',
					'instructions' => 'The partner website URL.',
				]
			)
			->setLocation( 'post_type', '==', self::POST_TYPE );

		return $settings;
	}
}
