<?php

if ( ! file_exists( __DIR__ . '/../vendor/autoload.php' ) ) :
	wp_die( 'You forgot to run composer install' );
endif;

if ( ! function_exists( 'get_field' ) ) :
	wp_die( 'You need to install and activate Advanced Custom Fields Pro' );
endif;
