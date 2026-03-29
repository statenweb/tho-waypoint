<?php

namespace Victoria\Abstracts;

use Victoria\Interfaces\Mailable;
use Victoria\Traits\Placeholders_Replacement;

abstract class Mail_Template implements Mailable {
	use Placeholders_Replacement;

	public function __construct(
		protected string $subject,
		protected string $body,
		protected ?array $attachments = null,
		protected ?array $placeholders = null
	) {}

	public function get_subject( ?\WP_User $recipient = null ): string {
		return $this->placeholders ? $this->replace_placeholders( $this->subject, $recipient ) : $this->subject;
	}

	public function get_body( ?\WP_User $recipient = null ): string {
		return $this->placeholders ? $this->replace_placeholders( $this->body, $recipient ) : $this->body;
	}

	public function get_attachments(): ?array {
		return $this->attachments;
	}

	public function get_placeholders(): ?array {
		return $this->placeholders;
	}
}
