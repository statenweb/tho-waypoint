<?php

namespace Victoria\Traits;

trait Placeholders_Replacement {
	public function replace_placeholders( string $content, ?\WP_User $recipient = null ): string {
		if ( ! empty( $this->placeholders ) ) {
			array_walk(
				$this->placeholders,
				function ( $replacement, $placeholder ) use ( &$content, $recipient ) {
					if ( $this->is_link_placeholder( $placeholder, $content ) ) {
						$content = $this->replace_link_placeholder( $content, $placeholder, $replacement );
					} else {
						if ( is_callable( $replacement ) ) {
							$replacement = $replacement( $recipient );
						}

						if ( $replacement ) {
							$content = str_replace( $placeholder, $replacement, $content );
						}
					}
				}
			);
		}

		return $content;
	}

	private function is_link_placeholder( string $placeholder, string $content ): bool {
		$pattern = $this->get_link_placeholder_pattern( $placeholder );

		return preg_match( $pattern, $content ) === 1;
	}

	private function replace_link_placeholder( $content, $placeholder, $replacement ): string {
		$pattern = $this->get_link_placeholder_pattern( $placeholder );

		return preg_replace_callback(
			$pattern,
			function ( $matches ) use ( $replacement ) {
				// Extract attributes from the placeholder (e.g., text, class)
				$attributes = isset( $matches[0] ) ? $this->parse_attributes( $matches[0] ) : [];
				$link_text = $attributes['text'] ?? 'Link';

				// Remove 'text' as it's used inside the tag
				unset( $attributes['text'] );

				// Build the attribute string for the <a> tag
				$attribute_string = '';
				foreach ( $attributes as $key => $value ) {
					$attribute_string .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
				}

				// Return the final <a> tag with the replacement URL and attributes
				return sprintf( '<a href="%s"%s>%s</a>', esc_url( $replacement ), $attribute_string, esc_html( $link_text ) );
			},
			$content
		);
	}

	private function parse_attributes( $attribute_string ): array {
		// Parse attributes from the placeholder string like `text='Pass reset' class="mt-1" disabled=disabled`
		preg_match_all( '/(\w+)=([\'"]?)(.*?)\2/', $attribute_string, $matches, PREG_SET_ORDER );

		$attributes = [];

		foreach ( $matches as $match ) {
			$attributes[ $match[1] ] = $match[3];
		}

		return $attributes;
	}

	private function get_link_placeholder_pattern( $placeholder ): string {
		// Pattern to match placeholders with attributes like {placeholder text="..." class="..."}
		$pattern = '/\{' . preg_quote( trim( $placeholder, '{}' ), '/' ) . '\s+[^}]+\}/';

		return $pattern;
	}
}
