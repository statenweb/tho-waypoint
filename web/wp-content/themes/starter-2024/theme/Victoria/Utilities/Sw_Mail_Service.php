<?php

namespace Victoria\Utilities;

use Victoria\Background_Processing\Sw_Email_Background_Processing_Classes\Sw_Email_Background_Job;

class Sw_Mail_Service {
	private array $recipients_emails;
	private ?array $from;
	private ?array $reply_to;
	private ?array $cc_emails;
	private ?array $bcc_emails;
	private string $subject;
	private string $body;
	private ?array $attachments;
	private ?array $headers;

	public function send_mail( bool $sync = false ): bool {
		$email_data = [
			$this->get_recipients(),
			$this->get_subject(),
			$this->get_body(),
			$this->get_headers(),
			$this->get_attachments(),
		];

		if ( $sync ) {
			return $this->execute( $email_data );
		} else {
			$background_job = new Sw_Email_Background_Job();

			$background_job->push_to_queue( $email_data );
			$background_job->save()->dispatch();

			return true;
		}
	}

	public function execute( array $email_data ): bool {
		$result = wp_mail( ...$email_data );

		return $result;
	}

	public function add_recipient( string $recipient_email ): self {
		$this->recipients_emails[] = $recipient_email;

		return $this;
	}

	public function get_recipients(): array {
		return $this->recipients_emails;
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

	public function get_from(): array {
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

	public function get_reply_to(): array {
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

	public function get_cc_emails(): array {
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

	public function get_bcc_emails(): array {
		return $this->bcc_emails;
	}

	public function set_subject( string $email_subject ): self {
		$this->subject = $email_subject;

		return $this;
	}

	public function get_subject(): string {
		return $this->subject;
	}

	public function set_body( string $email_body ): self {
		$this->body = $email_body;

		return $this;
	}

	public function get_body(): string {
		return $this->body;
	}

	public function add_attachment( string $attachment_file_path ): self {
		$this->attachments[] = $attachment_file_path;

		return $this;
	}

	public function get_attachments(): array {
		return $this->attachments ?? [];
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
