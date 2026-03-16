<?php

namespace Victoria\Utilities;

use Victoria\Background_Processing\Sw_Email_Background_Processing_Classes\Sw_Email_Background_Job;
use Victoria\Interfaces\Mailable;

class Sw_Mail_Service {
	private ?array $users = null;
	private ?array $group_users = null;
	private ?array $recipients_emails = null;
	private ?array $group_recipients_emails = null;
	private ?array $from = null;
	private ?array $reply_to = null;
	private ?array $cc_emails = null;
	private ?array $bcc_emails = null;
	private string $subject;
	private string $body;
	private ?array $attachments = null;
	private ?Mailable $mail_template = null;
	private ?array $headers = null;

	public function send_mail( bool $sync = false ): void {
		$this->handle_single_recipients( $sync );
		$this->handle_group_recipients( $sync );
	}

	private function handle_single_recipients( bool $sync ): void {
		$recipients = $this->get_recipients_emails() ?? [];

		$users = $this->get_users() ?? [];

		$recipients = array_merge(
			array_map(
				fn ( $user ) => [
					'email' => $user->user_email,
					'wp_user' => $user,
				],
				$users
			),
			array_map(
				fn ( $recipient ) => [
					'email' => $recipient,
					'wp_user' => null,
				],
				$recipients
			)
		);

		$background_job = new Sw_Email_Background_Job();

		array_walk(
			$recipients,
			function ( $recipient ) use ( $sync, $background_job ) {
				$recipient_email_data = [
					$recipient['email'],
					$this->get_subject( $recipient['wp_user'] ?? null ),
					$this->get_body( $recipient['wp_user'] ?? null ),
					$this->get_headers(),
					$this->get_attachments(),
				];

				if ( $sync ) {
					$this->execute( $recipient_email_data );
				} else {
					$background_job->push_to_queue( $recipient_email_data );

					$background_job->save()->dispatch();
				}
			}
		);
	}

	private function handle_group_recipients( bool $sync ): void {
		$group_recipients = $this->get_group_recipients_emails() ?? [];

		$group_users = $this->get_group_users() ?? [];

		$recipients = array_merge(
			array_map(
				fn ( $user ) => $user->user_email,
				$group_users
			),
			$group_recipients
		);

		$email_data = [
			$this->get_subject(),
			$this->get_body(),
			$this->get_headers(),
			$this->get_attachments(),
		];

		array_unshift( $email_data, $recipients );

		if ( $sync ) {
			$this->execute( $email_data );
		} else {
			$background_job = new Sw_Email_Background_Job();

			$background_job->push_to_queue( $email_data );

			$background_job->save()->dispatch();
		}
	}

	public function execute( array $email_data ): bool {
		return wp_mail( ...$email_data );
	}

	public function add_user( int|\WP_User ...$users ): self {
		$this->users = array_filter(
			array_merge(
				array_map(
					fn ( $user ) => $this->get_wp_user( $user ),
					$users
				),
				$this->users ?? []
			)
		);

		return $this;
	}

	public function get_users(): ?array {
		return $this->users;
	}

	public function add_group_users( array $users ): self {
		$users = array_map(
			fn ( $user ) => $this->get_wp_user( $user ),
			$users
		);

		$this->group_users = array_merge( $this->group_users ?? [], $users );

		return $this;
	}

	public function get_group_users(): ?array {
		return $this->group_users;
	}

	private function get_wp_user( int|\WP_User $user ): \WP_User {
		if ( is_int( $user ) ) {
			$user = get_userdata( $user );
		}

		if ( ! $user instanceof \WP_User ) {
			throw new \InvalidArgumentException( 'Unable to add user as recipient: WP User does not exist.' );
		}

		return $user;
	}

	public function add_recipient_email( string ...$recipient_emails ): self {
		$this->recipients_emails = array_filter(
			array_merge(
				array_map(
					function ( $recipient_email ) {
						if ( ! is_email( $recipient_email ) ) {
							throw new \InvalidArgumentException( 'Unable to add recipient: invalid email address.' );
						}

						$this->recipients_emails[] = sanitize_email( $recipient_email );
					},
					$recipient_emails
				),
				$this->recipients_emails ?? []
			)
		);

		return $this;
	}

	public function get_recipients_emails(): ?array {
		return $this->recipients_emails;
	}

	public function add_group_recipients_emails( array $recipients_emails ): self {
		$recipients_emails = array_map(
			function ( $recipients_email ) {
				if ( ! is_email( $recipients_email ) ) {
					throw new \InvalidArgumentException( 'Cannot add recipient. Not valid email address.' );
				}

				return sanitize_email( $recipients_email );
			},
			$recipients_emails
		);

		$this->group_recipients_emails = array_merge( $this->group_recipients_emails ?? [], $recipients_emails );

		return $this;
	}

	public function get_group_recipients_emails(): ?array {
		return $this->group_recipients_emails;
	}

	public function set_from( array $from ): self {
		if (
			! isset( $from['name'] )
			|| ! isset( $from['email'] )
		) {
			throw new \InvalidArgumentException( "The 'from' array must contain both 'name' and 'email' keys." );
		}

		$this->from = $from;

		return $this;
	}

	public function get_from(): ?array {
		return $this->from;
	}

	public function set_reply_to( array $reply_to ): self {
		if (
			! isset( $reply_to['name'] )
			|| ! isset( $reply_to['email'] )
		) {
			throw new \InvalidArgumentException( "The 'reply_to' array must contain both 'name' and 'email' keys." );
		}

		$this->reply_to = $reply_to;

		return $this;
	}

	public function get_reply_to(): ?array {
		return $this->reply_to;
	}

	public function add_cc_email( array $cc_email ): self {
		if (
			! isset( $cc_email['name'] )
			|| ! isset( $cc_email['email'] )
		) {
			throw new \InvalidArgumentException( "The 'cc' array must contain both 'name' and 'email' keys." );
		}

		$this->cc_emails[] = $cc_email;

		return $this;
	}

	public function get_cc_emails(): ?array {
		return $this->cc_emails;
	}

	public function add_bcc_email( array $bcc_email ): self {
		if (
			! isset( $bcc_email['name'] )
			|| ! isset( $bcc_email['email'] )
		) {
			throw new \InvalidArgumentException( "The 'bcc' array must contain both 'name' and 'email' keys." );
		}

		$this->bcc_emails[] = $bcc_email;

		return $this;
	}

	public function get_bcc_emails(): ?array {
		return $this->bcc_emails;
	}

	public function set_subject( string $email_subject ): self {
		$this->subject = $email_subject;

		return $this;
	}

	public function get_subject( ?\WP_User $recipient = null ): string {
		return $this->mail_template
			? wp_kses_post( $this->mail_template->get_subject( $recipient ) )
			: ( wp_kses_post( $this->subject ) ?? '' );
	}

	public function set_body( string $email_body ): self {
		$this->body = $email_body;

		return $this;
	}

	public function get_body( ?\WP_User $recipient = null ): string {
		return $this->mail_template
			? wp_kses_post( $this->mail_template->get_body( $recipient ) )
			: ( wp_kses_post( $this->body ) ?? '' );
	}

	public function add_attachment( string $attachment_file_path ): self {
		$this->attachments[] = $attachment_file_path;

		return $this;
	}

	public function get_attachments(): array {
		return $this->attachments ?? [];
	}

	public function set_mail_template( Mailable $mail_template ): self {
		$this->mail_template = $mail_template;

		return $this;
	}

	public function add_header( string $header ): self {
		$this->headers[] = $header;

		return $this;
	}

	protected function get_headers(): array {
		$this->headers ??= [
			'Content-Type: text/html; charset=UTF-8',
		];

		if ( $from = $this->get_from() ) {
			$this->add_header( "From: {$from['name']} <{$from['email']}>" );
		}

		if ( $reply_to = $this->get_reply_to() ) {
			$this->add_header( "Reply-To: {$reply_to['name']} <{$reply_to['email']}>" );
		}

		if ( $cc_emails = $this->get_cc_emails() ) {
			array_walk(
				$cc_emails,
				fn ( $cc_email ) => $this->add_header( "Cc: {$cc_email['name']} <{$cc_email['email']}>" . "\r\n" )
			);
		}

		if ( $bcc_emails = $this->get_bcc_emails() ) {
			array_walk(
				$bcc_emails,
				fn ( $bcc_email ) => $this->add_header( "Bcc: {$bcc_email['name']} <{$bcc_email['email']}>" . "\r\n" )
			);
		}

		return $this->headers;
	}
}
