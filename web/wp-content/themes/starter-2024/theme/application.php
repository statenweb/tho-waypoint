<?php

use Victoria\App;
use Victoria\Providers\Background_Processing_Provider;
use Victoria\Providers\Blocks_Provider;
use Victoria\Providers\Cpts_Provider;
use Victoria\Providers\Enqueues_Provider;
use Victoria\Providers\Hooks_Provider;
use Victoria\Providers\Settings_Provider;
use Victoria\Providers\Shortcodes_Provider;
use Victoria\Providers\Sidebars_Provider;
use Victoria\Providers\Utilities_Provider;

( new App() )
	->add_providers(
		[
			Background_Processing_Provider::class,
			Blocks_Provider::class,
			Cpts_Provider::class,
			Shortcodes_Provider::class,
			Sidebars_Provider::class,
			Enqueues_Provider::class,
			Hooks_Provider::class,
			Utilities_Provider::class,
			Settings_Provider::class,
		]
	)
	->init();

//if ( isset( $_GET['test'] ) && 'test' === $_GET['test'] ) {
//  $mailer = new \Victoria\Utilities\Sw_Mail_Service();
//
//  $mailer->add_recipient_email( 'recipient.1@statenweb.com' )
//         ->add_recipient_email( 'recipient.2@statenweb.com' )
//         ->add_recipient_email( 'recipient.2-1@statenweb.com', 'recipient.2-2@statenweb.com' )
//         ->add_group_recipients_emails( [ 'recipient.3@statenweb.com', 'recipient.4@statenweb.com' ] )
//         ->set_subject( 'Hello from StatenWeb' )
//         ->set_body( 'Welcome to StatenWeb. This text can be HTML.' )
//      ->set_from(
//          [
//              'name' => 'StetenWeb',
//              'email' => 'hello@statenweb.com',
//          ]
//      )
//      ->set_reply_to(
//          [
//              'name' => 'StetenWeb',
//              'email' => 'hello@statenweb.com',
//          ]
//      )
//      ->add_cc_email(
//          [
//              'name' => 'Operations',
//              'email' => 'operations@statenweb.com',
//          ]
//      )
//      ->add_cc_email(
//          [
//              'name' => 'Marketing',
//              'email' => 'marketing@statenweb.com',
//          ]
//      )
//      ->add_bcc_email(
//          [
//              'name' => 'developers',
//              'email' => 'developers@statenweb.com',
//          ]
//      )
//         ->add_attachment( wp_get_upload_dir()['basedir'] . '/example_file_1.csv' )
//         ->add_attachment( wp_get_upload_dir()['basedir'] . '/example_file_2.csv' )
//         ->send_mail();
//
//  $mailer2 = new \Victoria\Utilities\Sw_Mail_Service();
//
//  $mail_template = new \Victoria\Mails\Sw_Mail_Template(
//      subject: 'Hello {first_name}',
//      body: 'Welcome to StatenWeb! Mr. {function_callback} you can login here {login text="Click here to login"}. You can pass additional attributes to link {pass_reset text=\'Click here to reset password\' class=\'some-class\'}',
//      attachments: [ wp_get_upload_dir()['basedir'] . '/example_file_1.csv' ],
//      placeholders: [
//          '{first_name}' => 'Marko 1',
//          '{function_callback}' => fn ( $user ) => $user?->display_name,
//          '{login}' => get_home_url(),
//          '{pass_reset}' => get_home_url(),
//      ]
//  );
//
//  $mailer2->add_user( get_user_by( 'id', 1 ), get_user_by( 'id', 2 ), get_user_by( 'id', 3 ) )
//         ->add_user( get_user_by( 'id', 2 ) )
//         ->add_group_users( [ get_user_by( 'id', 2 ), get_user_by( 'id', 3 ) ] )
//         ->set_mail_template( $mail_template )
//      ->set_from(
//          [
//              'name' => 'StetenWeb',
//              'email' => 'hello@statenweb.com',
//          ]
//      )
//      ->set_reply_to(
//          [
//              'name' => 'StetenWeb',
//              'email' => 'hello@statenweb.com',
//          ]
//      )
//      ->add_cc_email(
//          [
//              'name' => 'Operations',
//              'email' => 'operations@statenweb.com',
//          ]
//      )
//      ->add_cc_email(
//          [
//              'name' => 'Marketing',
//              'email' => 'marketing@statenweb.com',
//          ]
//      )
//      ->add_bcc_email(
//          [
//              'name' => 'developers',
//              'email' => 'developers@statenweb.com',
//          ]
//      )
//         ->send_mail();
//}
