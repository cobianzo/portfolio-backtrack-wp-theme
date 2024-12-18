<?php
/**
 * Title: Dividends results
 * Slug: stock-templates/sub-templates/partial-dividends-table.php
 * Categories: partials
 * Description: Use the slug to include it as get_template_part.
 *  We send the data of the dividend from the frontend. Actually we could have do it
 * directly here by passing just the ticker. My bad.
 * Arguments: $data, $options
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      portfolio-theme 1.0.1
 */



if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	$POST_args = Dynamic_Partials::get_postdata_as_args_in_template( [ 'symbol', 'data', 'options' ] );
	extract( $POST_args );
	// this gives us access to $data and $options and $symbol
} elseif ( isset( $args ) ) {
		extract( $args );
}
	$data    = isset( $data ) ? $data : [];
	$options = isset( $options ) ? $options : [];
	$options = array_merge( array(
		'titles_map' => array(
			'Title'          => 'year',
			'price_start'    => '$ start',
			'divs_increment' => 'inc %',
			'last_div_date'  => '',
			'yield'          => 'yield %',
		),
		'append'     => array(
			'divs_increment' => ' %',
			'yield'          => ' %',
		),
	), $options );

	?>

	<div class="add-remove-button-wrapper pb-5"
		data-template-container="add-remove-button-wrapper-<?php echo esc_attr( $symbol ); ?>"
	>
	<?php
		get_template_part(
			'stock-templates/sub-templates/partial-add-to-portfolio-button',
			'',
		[ 'symbol' => $symbol ] );
		?>
	</div>

	<?php
	// Print the table
	echo Stock_Frontend::generate_table_html( $data, $options );
