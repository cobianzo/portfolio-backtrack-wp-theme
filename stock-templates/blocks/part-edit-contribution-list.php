<?php


// @TODO: prepare for ajax

// Assignments and validations. We need to have the value of $ticker and $contributions.
$ticker = null;
if ( is_singular( 'stock' ) ) {
	$ticker = strtoupper( get_post()->post_name );
} elseif ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	$args = Dynamic_Partials::get_postdata_as_args_in_template( [ 'ticker' ] );
}
if ( isset( $args['ticker'] ) ) {
	$ticker = $args['ticker'];
}

if ( ! $ticker ) {
	echo '<p class="text-red-600">Error: ticker symbol not provided</p>';
}

if ( ! User_Controller::is_in_current_user_portfolio( $ticker ) ) {
	echo '<p class="text-red-600">This ticker is not in oyur portfolio</p>';
	return;
}

$contributions = User_Controller::get_all_contributions_ticker( $ticker );
$contributions = get_user_meta( get_current_user_id(), 'contributions_JNJ', true );

if ( ! is_array( $contributions ) ) {
	echo '<p class="text-red-600">Erroe retrieving contributions for ' . $ticker . '</p>';
	return;
}
if ( ! count( $contributions ) ) {
	echo '<p class="text-red-600">No contributions</p>';
}
?>
	<ul class="divide-y divide-gray-200">
		<?php foreach ( $contributions as $c_year => $contribution ) : ?>
			<li class="flex items-center justify-between py-4">
				<div class="flex items-center">
					<span class="text-lg font-bold"><?php echo esc_html( $c_year ); ?></span>
					<span class="ml-4 text-sm">Contribution: <?php echo esc_html( '$' . number_format( $contribution, 2 ) ); ?></span>
				</div>
				<div class="flex items-center">
					<button class="remove-button bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2"
					data-year="<?php echo esc_attr( $c_year ); ?>"
					data-ticker="<?php echo esc_attr( $ticker ); ?>"
					data-action="remove"
					onclick="handleRemoveContribution(event)">
						X
					</button>
					<button class="edit-button bg-orange-500 text-white rounded-full w-6 h-6 flex items-center justify-center"
					data-year="<?php echo esc_attr( $c_year ); ?>"
					data-ticker="<?php echo esc_attr( $ticker ); ?>"
					data-action="edit"
					onclick="handleEditContribution(event)">
						<i class="fas fa-edit"></i>
					</button>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
