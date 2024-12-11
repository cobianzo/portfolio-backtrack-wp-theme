<?php

	$tickers_list = User_Controller::get_current_user_portfolio();

?>


<div class="container mx-auto bg-gray-200">
	<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4">
		<?php
		foreach ( $tickers_list as $ticker ) :
			?>
			<div class="bg-white rounded-lg shadow-md p-4">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'stock/' . $ticker ) ) ); ?>"
					class="block">
					<h2 class="text-lg font-bold"><?php echo esc_html( $ticker ); ?></h2>
				</a>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>
