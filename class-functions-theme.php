<?php

/**
 * Custom functions for this theme
 */

class Functions_Theme {
	public static function init(): void {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'tailwind_wp_theme_enqueue_frontend_styles' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'tailwind_wp_theme_enqueue_editor_styles' ) );
	}

	/**
	 * Enqueue styles for the frontend.
	 *
	 * @since portfolio-theme 1.0
	 *
	 * @return void
	 */
	public static function tailwind_wp_theme_enqueue_frontend_styles(): void {
		wp_enqueue_style(
			'portfolio-theme-style',
			get_template_directory_uri() . '/dist/tailwind-style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}

	/**
	 * We want tailwind styles also in the editor
	 *
	 * @since portfolio-theme 1.0
	 *
	 * @return void
	 */
	public static function tailwind_wp_theme_enqueue_editor_styles(): void {
		add_editor_style( get_template_directory_uri() . '/dist/tailwind-style.css' );
	}
}
Functions_Theme::init();
