<?php

use Victoria\Settings\Site;
use Victoria\Utilities\Tailwind_Navwalker;

$menu_id  = 'primary_menu';
?>

<header id="masthead" class="header-shadow z-[2000] relative sticky top-0">
	<div class="largest-breakpoint:container w-full mx-auto flex justify-center w-full py-5 largest-bBreakpoint:px-0 px-5 container">
		<div class="largest-breakpoint:basis-1/4">
			<a aria-label="<?php esc_attr( bloginfo( 'name' ) ); ?>" href="<?php echo home_url( '/' ); ?>">
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, [ 'class' => 'logo' ] ); ?>
			</a>
		</div>
		<nav id="site-navigation" class="justify-end non-hamburger:mr-auto flex items-center grow-[5] non-hamburger:basis-3/4">
			<button aria-label="Expand Menu"  data-menu-id="<?php echo $menu_id; ?>" class="group hidden hamburger:!block menu-toggler  mr-5 z-[501]" aria-controls="primary-menu" aria-expanded="false">
				<div class="space-y-[8px] transform duration-300 hamburger-levels">
					<?php
					$hamburger_string = '<div class="w-8 h-0.5 bg-body-text hover:opacity-70 duration-300 transition-all"></div>';
					echo wp_kses_post( implode( "\n", array_fill( 0, 3, $hamburger_string ) ) );

					?>
				</div>
			</button>


			<div id="<?php echo esc_attr( $menu_id ); ?>-outer" class=" relative responsive-menu">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-1',
						'menu_id' => $menu_id,
						'container' => false,
						'menu_class' => 'menu-list header-navigation',
						'walker'          => new Tailwind_Navwalker(),
						'depth'           => 3,
					)
				);
				?>
			</div>
		</nav>

	</div>
</header>
