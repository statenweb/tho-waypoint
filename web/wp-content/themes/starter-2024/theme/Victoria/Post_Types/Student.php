<?php

namespace Victoria\Post_Types;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Victoria\Abstracts\Cpt;
use Victoria\Traits\Has_Acf_Fields_Builder;

class Student extends Cpt {
	use Has_Acf_Fields_Builder;

	const POST_TYPE = 'student';

	public function get_cpt_definition(): array {
		return [
			'labels' => array(
				'name' => 'Students',
				'singular_name' => 'Student',
				'menu_name' => 'Students',
				'all_items' => 'All Students',
				'edit_item' => 'Edit Student',
				'view_item' => 'View Student',
				'view_items' => 'View Students',
				'add_new_item' => 'Add New Student',
				'add_new' => 'Add New Student',
				'new_item' => 'New Student',
				'parent_item_colon' => 'Parent Student:',
				'search_items' => 'Search Students',
				'not_found' => 'No students found',
				'not_found_in_trash' => 'No students found in Trash',
				'archives' => 'Students Archives',
				'attributes' => 'Students Attributes',
				'insert_into_item' => 'Insert into student',
				'uploaded_to_this_item' => 'Uploaded to this student',
				'filter_items_list' => 'Filter students list',
				'filter_by_date' => 'Filter students by date',
				'items_list_navigation' => 'Students list navigation',
				'items_list' => 'Students list',
				'item_published' => 'Student published.',
				'item_published_privately' => 'Student published privately.',
				'item_reverted_to_draft' => 'Student reverted to draft.',
				'item_scheduled' => 'Student scheduled.',
				'item_updated' => 'Student updated.',
				'item_link' => 'Student Link',
				'item_link_description' => 'A link to a student.',
			),
			'public' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-admin-post',
			'supports' => array(
				0 => 'title',
				1 => 'editor',
				2 => 'thumbnail',
				3 => 'custom-fields',
			),
			'taxonomies' => array(
				0 => 'category',
				1 => 'post_tag',
			),
			'delete_with_user' => false,
		];
	}

	public function get_acf_fields(): FieldsBuilder {
		$settings = new FieldsBuilder( $this->get_acf_field_unique_name( 'locations' ) );

		$settings
			->addPostObject(
				'locations',
				[
					'label' => 'Locations',
					'post_type' => [ self::POST_TYPE ],
					'multiple' => 1,
					'return_format' => 'id',
				]
			)
			->addText( 'street', [ 'label' => 'Street' ] )
			->addText( 'street2', [ 'label' => 'Street 2/Suite' ] )
			->addText( 'city', [ 'label' => 'City' ] )
			->addText( 'state', [ 'label' => 'State' ] )
			->addText( 'zip', [ 'label' => 'Zip' ] )
			->addText( 'phone', [ 'label' => 'Phone' ] )
			->addText( 'fax', [ 'label' => 'Fax' ] )
			->addEmail( 'email', [ 'label' => 'Email' ] )
			->addMessage( 'Hours', '' )

			->addField(
				'text_2',
				'medium_editor',
				[
					'label' => 'Hours Text Top Line 1',
				]
			)

			->addText( 'monday', [ 'label' => 'Monday' ] )
			->addText( 'tuesday', [ 'label' => 'Tuesday' ] )
			->addText( 'wednesday', [ 'label' => 'Wednesday' ] )
			->addText( 'thursday', [ 'label' => 'Thursday' ] )
			->addText( 'friday', [ 'label' => 'Friday' ] )
			->addText( 'saturday', [ 'label' => 'Saturday' ] )
			->addText( 'sunday', [ 'label' => 'Sunday' ] )
			->addTextarea( 'bottom_text', [ 'label' => 'Bottom Text' ] )
			->addText(
				'latitude',
				[
					'label' => 'Latitude',
					'instructions' => 'Only touch this if you know what you are doing',
				]
			)
			->addText(
				'longitude',
				[
					'label' => 'Longitude',
					'instructions' => 'Only touch this if you know what you are doing',
				]
			)

			->setLocation( 'post_type', '==', self::POST_TYPE );

		return $settings;
	}
}
