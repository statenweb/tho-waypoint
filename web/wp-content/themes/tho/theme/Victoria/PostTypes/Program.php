<?php

namespace Victoria\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Cpt;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Program extends Cpt {
	use Has_Acf_Fields_Builder;

	const POST_TYPE = 'program';

	public function get_cpt_definition(): array {
		return [
			'labels' => [
				'name'                  => 'Programs',
				'singular_name'         => 'Program',
				'menu_name'             => 'Programs',
				'all_items'             => 'All Programs',
				'edit_item'             => 'Edit Program',
				'view_item'             => 'View Program',
				'view_items'            => 'View Programs',
				'add_new_item'          => 'Add New Program',
				'add_new'               => 'Add New',
				'new_item'              => 'New Program',
				'parent_item_colon'     => 'Parent Program:',
				'search_items'          => 'Search Programs',
				'not_found'             => 'No programs found',
				'not_found_in_trash'    => 'No programs found in Trash',
				'archives'              => 'Program Archives',
				'attributes'            => 'Program Attributes',
				'insert_into_item'      => 'Insert into program',
				'uploaded_to_this_item' => 'Uploaded to this program',
				'filter_items_list'     => 'Filter programs list',
				'filter_by_date'        => 'Filter programs by date',
				'items_list_navigation' => 'Programs list navigation',
				'items_list'            => 'Programs list',
				'item_published'        => 'Program published.',
				'item_published_privately' => 'Program published privately.',
				'item_reverted_to_draft' => 'Program reverted to draft.',
				'item_scheduled'        => 'Program scheduled.',
				'item_updated'          => 'Program updated.',
				'item_link'             => 'Program Link',
				'item_link_description' => 'A link to a program.',
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
			'menu_icon'          => 'dashicons-clipboard',
			'supports'           => [
				'title',
				'thumbnail',
				'page-attributes',
			],
			'delete_with_user'   => false,
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'program' ) );

		$settings
			->addTextarea(
				'description',
				[
					'label'        => 'Description',
					'instructions' => 'A detailed description of the program.',
				]
			)
			->addImage(
				'hero_image',
				[
					'label'        => 'Hero Image',
					'instructions' => 'The hero image for the program.',
					'return_format' => 'id',
				]
			)
			->addText(
				'cta_label',
				[
					'label'        => 'CTA Label',
					'instructions' => 'The label for the call-to-action button.',
				]
			)
			->addUrl(
				'cta_url',
				[
					'label'        => 'CTA URL',
					'instructions' => 'The URL for the call-to-action button.',
				]
			)
			->setLocation( 'post_type', '==', self::POST_TYPE );

		return $settings;
	}
}
