<?php

/**
 * Custom functions for this theme
 */

class Functions_Theme {

	public static function init(): void {
		add_filter( 'body_class', fn( $classes ) => array( ...$classes, 'tailwind-wp-wrapper' ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'tailwind_wp_theme_enqueue_frontend_styles' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'tailwind_wp_theme_enqueue_editor_styles' ) );

		add_action( 'wp_head', function () {
			echo "<script>var ajaxurl = '" . esc_url( admin_url( 'admin-ajax.php' ) ) . "';</script>";
		});


		require_once dirname( __DIR__ ) . '/parts/dynamic-partials/class-dynamic-partials.php';
		require_once dirname( __DIR__ ) . '/inc/stocks-apis/class-internal-stock-api.php';
		require_once dirname( __DIR__ ) . '/inc/class-stock-cpt.php';
		require_once dirname( __DIR__ ) . '/inc/class-stock-frontend.php';
		require_once dirname( __DIR__ ) . '/inc/class-stock-backend.php';
	}

	/**
	 * Enqueue styles for the frontend.
	 *
	 * @since portfolio-theme 1.0
	 *
	 * @return void
	 */
	public static function tailwind_wp_theme_enqueue_frontend_styles(): void {
		wp_register_style(
			'portfolio-theme-style',
			get_template_directory_uri() . '/build/tailwind-style.css',
			array(),
			wp_get_theme()->get( 'Version' ),
			false
		);

		wp_enqueue_style( 'portfolio-theme-style' );
	}

	/**
	 * We want tailwind styles also in the editor
	 *
	 * @since portfolio-theme 1.0
	 *
	 * @return void
	 */
	public static function tailwind_wp_theme_enqueue_editor_styles(): void {
		add_editor_style( get_template_directory_uri() . '/build/tailwind-style.css' );
	}
}
Functions_Theme::init();
