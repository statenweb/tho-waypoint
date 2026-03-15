<?php

namespace Victoria\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Cpt;
use Victoria\Traits\Has_Acf_Fields_Builder;

class BoardMember extends Cpt {
	use Has_Acf_Fields_Builder;

	const POST_TYPE = 'board_member';

	public function get_cpt_definition(): array {
		return [
			'labels'             => [
				'name'                  => 'Board Members',
				'singular_name'         => 'Board Member',
				'menu_name'             => 'Board Members',
				'all_items'             => 'All Board Members',
				'edit_item'             => 'Edit Board Member',
				'view_item'             => 'View Board Member',
				'view_items'            => 'View Board Members',
				'add_new_item'          => 'Add New Board Member',
				'add_new'               => 'Add New',
				'new_item'              => 'New Board Member',
				'parent_item_colon'     => 'Parent Board Member:',
				'search_items'          => 'Search Board Members',
				'not_found'             => 'No board members found',
				'not_found_in_trash'    => 'No board members found in Trash',
				'archives'              => 'Board Member Archives',
				'attributes'            => 'Board Member Attributes',
				'insert_into_item'      => 'Insert into board member',
				'uploaded_to_this_item' => 'Uploaded to this board member',
				'filter_items_list'     => 'Filter board members list',
				'filter_by_date'        => 'Filter board members by date',
				'items_list_navigation' => 'Board Members list navigation',
				'items_list'            => 'Board Members list',
				'item_published'        => 'Board Member published.',
				'item_published_privately' => 'Board Member published privately.',
				'item_reverted_to_draft' => 'Board Member reverted to draft.',
				'item_scheduled'        => 'Board Member scheduled.',
				'item_updated'          => 'Board Member updated.',
				'item_link'             => 'Board Member Link',
				'item_link_description' => 'A link to a board member.',
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
			'menu_icon'          => 'dashicons-businessperson',
			'supports'           => [
				'title',
				'thumbnail',
				'page-attributes',
			],
			'delete_with_user'   => false,
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'board_member' ) );

		$settings
			->addText(
				'title',
				[
					'label'        => 'Title',
					'instructions' => 'The board member\'s role or title.',
				]
			)
			->addTextarea(
				'bio',
				[
					'label'        => 'Bio',
					'instructions' => 'A short biography for the board member.',
				]
			)
			->addImage(
				'headshot',
				[
					'label'         => 'Headshot',
					'instructions'  => 'The board member\'s headshot photo.',
					'return_format' => 'id',
				]
			)
			->addUrl(
				'linkedin_url',
				[
					'label'        => 'LinkedIn URL',
					'instructions' => 'The board member\'s LinkedIn profile URL.',
				]
			)
			->setLocation( 'post_type', '==', self::POST_TYPE );

		return $settings;
	}
}
