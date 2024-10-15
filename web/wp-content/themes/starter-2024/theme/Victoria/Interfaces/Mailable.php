<?php

namespace Victoria\Interfaces;

interface Mailable {
	public function get_subject( ?\WP_User $recipient = null ): string;

	public function get_body( ?\WP_User $recipient = null ): string;

	public function get_attachments(): ?array;
}
