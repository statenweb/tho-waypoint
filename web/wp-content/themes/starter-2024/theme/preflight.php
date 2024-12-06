<?php

if ( ! file_exists( __DIR__ . '/../vendor/autoload.php' ) ) :
	wp_die( 'You forgot to run composer install' );
endif;
