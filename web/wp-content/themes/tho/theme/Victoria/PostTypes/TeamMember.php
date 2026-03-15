<?php

namespace Victoria\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Cpt;
use Victoria\Traits\Has_Acf_Fields_Builder;

class TeamMember extends Cpt {
	use Has_Acf_Fields_Builder;

	const POST_TYPE = 'team_member';

	public function get_cpt_definition(): array {
		return [
			'labels'             => [
				'name'                  => 'Team Members',
				'singular_name'         => 'Team Member',
				'menu_name'             => 'Team Members',
				'all_items'             => 'All Team Members',
				'edit_item'             => 'Edit Team Member',
				'view_item'             => 'View Team Member',
				'view_items'            => 'View Team Members',
				'add_new_item'          => 'Add New Team Member',
				'add_new'               => 'Add New',
				'new_item'              => 'New Team Member',
				'parent_item_colon'     => 'Parent Team Member:',
				'search_items'          => 'Search Team Members',
				'not_found'             => 'No team members found',
				'not_found_in_trash'    => 'No team members found in Trash',
				'archives'              => 'Team Member Archives',
				'attributes'            => 'Team Member Attributes',
				'insert_into_item'      => 'Insert into team member',
				'uploaded_to_this_item' => 'Uploaded to this team member',
				'filter_items_list'     => 'Filter team members list',
				'filter_by_date'        => 'Filter team members by date',
				'items_list_navigation' => 'Team Members list navigation',
				'items_list'            => 'Team Members list',
				'item_published'        => 'Team Member published.',
				'item_published_privately' => 'Team Member published privately.',
				'item_reverted_to_draft' => 'Team Member reverted to draft.',
				'item_scheduled'        => 'Team Member scheduled.',
				'item_updated'          => 'Team Member updated.',
				'item_link'             => 'Team Member Link',
				'item_link_description' => 'A link to a team member.',
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
			'menu_icon'          => 'dashicons-groups',
			'supports'           => [
				'title',
				'thumbnail',
				'page-attributes',
			],
			'delete_with_user'   => false,
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'team_member' ) );

		$settings
			->addText(
				'title',
				[
					'label'        => 'Title',
					'instructions' => 'The team member\'s role or title.',
				]
			)
			->addTextarea(
				'bio',
				[
					'label'        => 'Bio',
					'instructions' => 'A short biography for the team member.',
				]
			)
			->addImage(
				'headshot',
				[
					'label'         => 'Headshot',
					'instructions'  => 'The team member\'s headshot photo.',
					'return_format' => 'id',
				]
			)
			->addUrl(
				'linkedin_url',
				[
					'label'        => 'LinkedIn URL',
					'instructions' => 'The team member\'s LinkedIn profile URL.',
				]
			)
			->setLocation( 'post_type', '==', self::POST_TYPE );

		return $settings;
	}
}
