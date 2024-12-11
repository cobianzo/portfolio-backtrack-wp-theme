<?php
/**
 * Title: Button to add the selected stock to portfolio
 * Slug: parts/dynamic-partials/programmatic-partials/partial-add-to-portfolio-button.php
 * Categories: partials
 * Description: Use the slug to include it as get_template_part.
 * Arguments: $ticker
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      portfolio-theme 1.0.1
 */

if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	$POST_args = Dynamic_Partials::get_postdata_as_args_in_template( [ 'symbol' ] );
	extract( $POST_args );
	// this gives us access to $symbol
} elseif ( isset( $args ) ) {
		extract( $args );
}

$already_in_portfolio = Stock_Backend::is_in_current_user_portfolio( $symbol );

if ( ! $already_in_portfolio ) :
	?>
	<div id="add-to-portfolio-button" class="wp-block-button has-custom-width wp-block-button__width-100 flex items-center justify-center">
			<button class="wp-block-button__link wp-element-button"
				data-ticker="<?php echo esc_attr( $symbol ); ?>">
				Add <b><?php echo esc_html( $symbol ); ?></b> to portfolio
			</button>
	</div>
	<?php
else :
	?>

	<div id="remove-from-portfolio-button" class="wp-block-button has-custom-width wp-block-button__width-100 flex items-center justify-center">
			<button class="wp-block-button__link wp-element-button"
				data-ticker="<?php echo esc_attr( $symbol ); ?>">
				Remove <b><?php echo esc_html( $symbol ); ?></b> from portfolio
			</button>
	</div>
	<?php
endif;
