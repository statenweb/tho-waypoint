<?php

namespace Victoria\Hooks;

use Victoria\Abstracts\Hook;
use Victoria\Settings\Site;

class Actions extends Hook {
	public function attach_hooks(): void {
		add_action( 'after_setup_theme', [ $this, 'image_sizes' ] );
		add_action( 'wp_head', [ $this, 'gtm_container_head' ] );
		add_action( 'wp_body_open', [ $this, 'gtm_container_body_open' ] );
	}

	public function image_sizes() {
		add_image_size( 'provider-crop-small', 313, 400, true );
		add_image_size( 'provider-crop', 500, 638, true );
		add_image_size( 'provider', 500, 638, false );
		add_image_size( '1200x500', 1200, 500, false );
		add_image_size( '1200x500-crop', 1200, 500, true );
		add_image_size( '1200x480', 1200, 480, false );
		add_image_size( '1200x480-crop', 1200, 480, true );
		add_image_size( 'hero-smallish-crop', 1920, 400, true );
	}

	public function gtm_container_head() {
		$gtm_container = Site::get( 'gtm_container' );
		if ( ! $gtm_container ) {
			return;
		}

		?><!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','<?php echo esc_js( $gtm_container ); ?>');</script>
		<!-- End Google Tag Manager -->
		<?php
	}

	public function gtm_container_body_open() {
		$gtm_container = Site::get( 'gtm_container' );
		if ( ! $gtm_container ) {
			return;
		}
		if ( $gtm_container ) {
			?>
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_js( $gtm_container ); ?>"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
			<?php
		}
	}
}
