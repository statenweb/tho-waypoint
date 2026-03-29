<?php

namespace Victoria\Utilities;

class Utils {


	const MIN_HEIGHT_DESKTOP_MODE = 'sw_min_height_desktop_mode';
	const MIN_HEIGHT_DESKTOP_SLUG = 'sw_min_height_desktop';
	const MIN_HEIGHT_SLUG = 'sw_min_height';

	const HEIGHT_DESKTOP_MODE = 'sw_height_desktop_mode';
	const HEIGHT_DESKTOP_SLUG = 'sw_height_desktop';
	const HEIGHT_SLUG = 'sw_height';





	public static function get_all_block_classes( array $args ) {

		// normalize $args['fields']
		if ( isset( $args['fields'] ) && ! is_array( $args['fields'] ) ) {
			$args['fields'] = [];
		}

		$default = [
			'fields' => [],
			'block' => [],
		];
		$args = array_merge( $default, $args );
		[ 'block' => $block, 'fields' => $fields ] = $args;

		$wrapper_classes = Utils::get_wrapper_classes_from_block( $block );
		$spacing_classes = Utils::get_spacing_classes( $fields );

		$merged_outer_classes = array_merge( $wrapper_classes['outer_classes'], $spacing_classes['outer_classes'] );
		$merged_inner_classes = array_merge( $wrapper_classes['inner_classes'], $spacing_classes['inner_classes'] );

		return [
			'outer_classes' => implode( ' ', $merged_outer_classes ),
			'inner_classes' => implode( ' ', $merged_inner_classes ),
			'combined_classes' => implode( ' ', array_merge( $merged_outer_classes, $merged_inner_classes ) ),
		];
	}

	public static function get_spacing_classes( $fields ) {
		if ( ! $fields || ! is_array( $fields ) ) {
			$fields = [];
		}
		$inner_classes = [];
		$outer_classes = [];

		if ( ! empty( $fields['max-width'] ) ) {
			$inner_classes[] = $fields['max-width'];
			if ( ! empty( $fields['max-width-desktop'] ) ) {
				$inner_classes[] = $fields['max-width-desktop'];
			}
		}

		if ( ! empty( $fields[ self::MIN_HEIGHT_SLUG ] ) ) {
			$outer_classes[] = $fields[ self::MIN_HEIGHT_SLUG ];
			if ( $fields[ self::MIN_HEIGHT_DESKTOP_MODE ] ) {
				$outer_classes[] = $fields[ self::MIN_HEIGHT_DESKTOP_SLUG ];
			}
		}

		if ( ! empty( $fields[ self::HEIGHT_SLUG ] ) ) {
			$outer_classes[] = $fields[ self::HEIGHT_SLUG ];
			if ( $fields[ self::HEIGHT_DESKTOP_MODE ] ) {
				$outer_classes[] = $fields[ self::HEIGHT_DESKTOP_SLUG ];
			}
		}

		if ( array_key_exists( 'flex', $fields ) && ! empty( $fields['flex'] ) ) {
			$inner_classes[] = $fields['flex'] . ' ';
		}
		if ( array_key_exists( 'flex_direction', $fields ) && ! empty( $fields['flex_direction'] ) ) {
			$inner_classes[] = $fields['flex_direction'] . ' ';
		}
		if ( array_key_exists( 'flex_direction_desktop', $fields ) && ! empty( $fields['flex_direction_desktop'] ) ) {
			$inner_classes[] = $fields['flex_direction_desktop'] . ' ';
		}
		if ( array_key_exists( 'flex_wrap', $fields ) && ! empty( $fields['flex_wrap'] ) ) {
			$inner_classes[] = $fields['flex_wrap'] . ' ';
		}
		if ( array_key_exists( 'flex_wrap_desktop', $fields ) && ! empty( $fields['flex_wrap_desktop'] ) ) {
			$inner_classes[] = $fields['flex_wrap_desktop'] . ' ';
		}
		if ( array_key_exists( 'justify_content', $fields ) && ! empty( $fields['justify_content'] ) ) {
			$inner_classes[] = $fields['justify_content'] . ' ';
		}
		if ( array_key_exists( 'justify_content_desktop', $fields ) && ! empty( $fields['justify_content_desktop'] ) ) {
			$inner_classes[] = $fields['justify_content_desktop'] . ' ';
		}
		if ( array_key_exists( 'align_items', $fields ) && ! empty( $fields['align_items'] ) ) {
			$inner_classes[] = $fields['align_items'] . ' ';
		}
		if ( array_key_exists( 'align_items_desktop', $fields ) && ! empty( $fields['align_items_desktop'] ) ) {
			$inner_classes[] = $fields['align_items_desktop'] . ' ';
		}

		return [
			'inner_classes' => $inner_classes,
			'outer_classes' => $outer_classes,
		];
	}


	public static function convert_alignment_to_flex( $alignment ) {
		switch ( $alignment ) {
			case 'left':
				return 'start';
			case 'right':
				return 'end';
			case 'center':
			default:
				return 'center';
		}
	}

	public static function get_link( $field ) {
		if ( ! isset( $field['url'] ) || ! $field['url'] ) {
			return false;
		}
		$link['url']    = $field['url'];
		$link['title']  = $field['title'];
		$link['target'] = $field['target'] ?: '_self';

		return $link;
	}

	public static function get_link_attributes( $field ) {
		$link_data = self::get_link( $field );

		return sprintf( 'href="%s" target="%s" rel="%s" title="%s"', esc_attr( $link_data['url'] ), esc_attr( $link_data['target'] ), strtolower( $link_data['target'] ) === '_blank' ? 'noopener noreferrer' : '', esc_attr( wp_strip_all_tags( strip_shortcodes( $link_data['title'] ) ) ) );
	}

	/**
	 * Get the classes for the block wrapper, return inner and outer to handle cases where there is an outer wrapper and inner wrapper
	 * @param $block
	 *
	 * @return array
	 */
	public static function get_wrapper_classes_from_block( $block ) {

		$inner_classes = [];
		$outer_classes = [];

		if ( ! empty( $block['className'] ) ) {
			$outer_classes[] = ' ' . $block['className'];
		}
		if ( ! empty( $block['align'] ) ) {
			$outer_classes[] = ' align' . $block['align'];
		}

		if ( ! empty( $block['className'] ) ) {
			$outer_classes[] = ' ' . $block['className'];
		}

		if ( ! empty( $block['gradient'] ) ) {
			$outer_classes[] = ' bg-' . $block['gradient'];
		} elseif ( ! empty( $block['backgroundColor'] ) ) {
			$outer_classes[] = ' bg-' . $block['backgroundColor'];
		}

		if ( ! empty( $block['textColor'] ) ) {
			$outer_classes[] = ' text-' . $block['textColor'];
		}

		return [
			'inner_classes' => $inner_classes,
			'outer_classes' => $outer_classes,
		];
	}

	public static function convert_px_to_rem( $px, $integer = true ) {
		$conversion = $px / 16;
		if ( $integer ) {
			$conversion = round( $conversion );
		}
		return $conversion;
	}

	public static function basic_allowed_blocks() {
		return [ 'core/paragraph', 'core/heading', 'core/list', 'acf/sw-buttons', 'acf/sw-group', 'core/image', 'core/group' ];
	}

	public static function get_current_filename( $file ) {
		return pathinfo( $file, PATHINFO_FILENAME );
	}

	public static function format_phone_link( $phone_number ) {
		// Remove all non-numeric characters
		$digits = preg_replace( '/\D/', '', $phone_number );

		// Ensure the number has 10 or 11 digits (US number with or without country code)
		if ( 10 == strlen( $digits ) ) {
			$digits = '1' . $digits; // Add country code if not present
		}

		// Format as +1-###-###-####
		if ( 11 == strlen( $digits ) ) {
			return '+1-' . substr( $digits, 1, 3 ) . '-' . substr( $digits, 4, 3 ) . '-' . substr( $digits, 7, 4 );
		} else {
			return 'Invalid phone number';
		}
	}

	public static function format_phone_pretty( $phone_number ) {
		// Remove all non-numeric characters
		$digits = preg_replace( '/\D/', '', $phone_number );

		// Ensure the number has 10 digits
		if ( 11 == strlen( $digits ) && '1' == $digits[0] ) {
			$digits = substr( $digits, 1 ); // Remove country code if present
		}

		// Format as (###) ###-####
		if ( strlen( $digits ) == 10 ) {
			return '(' . substr( $digits, 0, 3 ) . ') ' . substr( $digits, 3, 3 ) . '-' . substr( $digits, 6, 4 );
		} else {
			return 'Invalid phone number';
		}
	}

	public static function handle_killswitch( $fields, $block ) {
		if ( isset( $fields['killswitch'] ) && $fields['killswitch'] ) {
			if ( is_admin() ) :

				return '<div style="width:100%;height:200px;background:#CCC; text-align:center; color:black;display:flex;align-items: center;justify-content: center;font-weight:bold;">This <u style="display:inline-block;color:red;margin:0 15px;font-weight:900">' . $block['title'] . '</u> block is disabled</div>';
			endif;
			return true;
		}
		return false;
	}


	public static function get_conditional_logic( $raw_conditional_logic ) {

		$conditional_logic = [];
		foreach ( (array) $raw_conditional_logic as $logum ) {
			$conditional_logic[] = [
				'field'    => $logum[0],
				'operator' => $logum[1],
				'value'    => $logum[2],
			];
		}

		return [
			'conditional_logic' => $conditional_logic,
		];
	}


	public static function get_value_unit( $value, $unit ) {
		$unit = match ( $unit ) {
			'vh' => 'vh',
			'%' => '%',
			default => 'px',
		};
		if ( 'px' === $unit ) {
			return Utils::convert_px_to_rem( $value ) . 'rem';
		}
		return $value . $unit;
	}


	public static function get_spacing_options( $prefix = '', $suffix = '' ) {
		return [
			$prefix . '0.5' . $suffix => '0.5',
			$prefix . '1' . $suffix => '1',
			$prefix . '1.5' . $suffix => '1.5',
			$prefix . '2' . $suffix => '2',
			$prefix . '2.5' . $suffix => '2.5',
			$prefix . '3' . $suffix => '3',
			$prefix . '3.5' . $suffix => '3.5',
			$prefix . '4' . $suffix => '4',
			$prefix . '5' . $suffix => '5',
			$prefix . '6' . $suffix => '6',
			$prefix . '7' . $suffix => '7',
			$prefix . '8' . $suffix => '8',
			$prefix . '9' . $suffix => '9',
			$prefix . '10' . $suffix => '10',
			$prefix . '11' . $suffix => '11',
			$prefix . '12' . $suffix => '12',
			$prefix . '14' . $suffix => '14',
			$prefix . '16' . $suffix => '16',
			$prefix . '20' . $suffix => '20',
			$prefix . '24' . $suffix => '24',
			$prefix . '28' . $suffix => '28',
			$prefix . '32' . $suffix => '32',
			$prefix . '36' . $suffix => '36',
		];
	}

	public static function get_spacing_choices() {
		return [
			'none' => 'None',
			'default' => 'Default',
			'basic' => 'Basic',
			'advanced' => 'Advanced',
		];
	}

	public static function get_height_choices( $suffix, $prefix = '' ) {
		return [
			'' => 'none',
			$prefix . '10vh' . $suffix => '10vh',
			$prefix . '20vh' . $suffix => '20vh',
			$prefix . '30vh' . $suffix => '30vh',
			$prefix . '40vh' . $suffix => '40vh',
			$prefix . '50vh' . $suffix => '50vh',
			$prefix . '60vh' . $suffix => '60vh',
			$prefix . '70vh' . $suffix => '70vh',
			$prefix . '80vh' . $suffix => '80vh',
			$prefix . '90vh' . $suffix => '90vh',
			$prefix . '100vh' . $suffix => '100vh',

		];
	}

	public static function get_percentage_choices( $prefix = '', $suffix = '' ) {
		return [
			'' => 'none/inherit',
			$prefix . '10%' . $suffix => '10%',
			$prefix . '20%' . $suffix => '20%',
			$prefix . '30%' . $suffix => '30%',
			$prefix . '40%' . $suffix => '40%',
			$prefix . '50%' . $suffix => '50%',
			$prefix . '60%' . $suffix => '60%',
			$prefix . '70%' . $suffix => '70%',
			$prefix . '80%' . $suffix => '80%',
			$prefix . '90%' . $suffix => '90%',
			$prefix . '100%' . $suffix => '100%',
		];
	}
}
