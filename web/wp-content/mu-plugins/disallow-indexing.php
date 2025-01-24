<?php

class SW_Staging_Check {

    public static function init() {
        add_action( 'init', array( __CLASS__, 'check_environment' ) );
        add_action( 'admin_init', array( __CLASS__, 'check_environment' ) );

    }

    public static function check_environment() {

        $env = !empty($_ENV['WP_ENV']) ? $_ENV['WP_ENV'] : null;

        if ( 'production' === $env ) {
            return true;
		}

        self::disable_wordfence();
        self::handle_meta_robots();

    }

    public static function disable_wordfence() {
        $wordfence = [ 'wordfence-login-security/wordfence-login-security.php', 'wordfence/wordfence.php' ];

        foreach ( $wordfence as $single_wordfence ) {
            if ( function_exists( 'is_plugin_active' ) && function_exists( 'deactivate_plugins' ) && is_plugin_active( $single_wordfence ) ) {
                deactivate_plugins( $single_wordfence );
            }
        }

    }

    public static function handle_meta_robots() {
        add_filter( 'pre_option_blog_public', function () {
            return '0';
        } );

        add_filter( 'rank_math/frontend/robots', function ( $robots ) {
            $robots['index']  = 'noindex';
            $robots['follow'] = 'nofollow';

            return $robots;
        } );
        add_filter( 'wpseo_robots', function ( $robots ) {

            return 'noindex, nofollow';


        } );

    }


}

SW_Staging_Check::init();


