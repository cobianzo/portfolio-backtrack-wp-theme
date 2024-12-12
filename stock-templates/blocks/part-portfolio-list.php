<div
	data-template-container="portfolio-wrapper"
	class="container mx-auto bg-gray-200">
<?php

	$tickers_list = User_Controller::get_current_user_portfolio();

	if ( is_user_logged_in() && $tickers_list ) :
?>



	<ul class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-5 gap-4 p-4">
		<?php
		foreach ( $tickers_list as $ticker ) :
			$ticker_post_id = Stock_Model::get_stock_post_by_symbol( $ticker );
			?>
			<div class="relative bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'stock/' . $ticker ) ) ); ?>"
					class="block">
					<h2 class="text-lg font-bold"><?php echo esc_html( $ticker ); ?></h2>
				</a>
				<div class="absolute top-0 right-0">
					<button class="remove-button bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center"
					data-ticker="<?php echo esc_attr( $ticker ); ?>";
					data-template-container="add-remove-button-wrapper-<?php echo esc_attr( $ticker ); ?>"
					data-action="remove"
					onclick="handleAddRemoveFromPortfolio(event)">
						X
					</button>
				</div>

				<?php if ( $ticker_post_id ) : ?>
					<a href="<?php echo esc_url( get_permalink( $ticker_post_id ) ); ?>"
						class="wp-block-button__link has-white-color has-blue-500-background-color has-text-color has-background wp-element-button">
						Go to <?php echo esc_html( $ticker ); ?> page
					</a>
				<?php else: ?>
					<small>ticker <?php echo esc_html( $ticker ); ?> not found in DB</small>
				<?php endif; ?>


			</div>
			<?php
		endforeach;
		?>
	</ul>

<?php
	endif;
?>
</div>
