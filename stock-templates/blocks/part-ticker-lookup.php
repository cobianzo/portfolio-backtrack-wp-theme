<?php
/**
 * Title: Ticker Lookup
 * Slug: portfolio-theme/part-ticker-lookup
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      portfolio-theme 1.0.1
 */

?>
<div class="ticker-lookup-form-wrapper">
	<h1> Todo esto deberia ir </h1>

	<?php
	// See js for the submit
	?>
	<form id="ticker-lookup-form">
	<!-- wp:group {"metadata":{"name":"Group wrapper"},"className":"is-style-default","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"backgroundColor":"accent-5","layout":{"type":"constrained"}} -->
	<div class="wp-block-group is-style-default has-accent-5-background-color has-background"
	style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:columns -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"100%"} -->
		<div class="wp-block-column" style="flex-basis:100%">
		<!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group grid grid-cols-[1fr,minmax(100px,0.5fr)] gap-4">
			<!-- wp:group {"metadata":{"name":"ticker field Group"},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group col-span-1">
				<!-- wp:heading -->
				<h2 class="wp-block-heading">Ticker</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->


					<input type="text" name="ticker-lookup" id="ticker-lookup" aria-label="Stock Ticker Lookup"
					placeholder="Enter stock ticker" aria-required="true" autocomplete="off"
					value="TROW"
					class="ticker-lookup-input rounded-lg border border-gray-300 p-2 pl-10 text-sm text-gray-700"
					list="ticker-options" />
					<!-- We'll fill the datalist with the response from Yahoo finance, once the user types the input -->
					<datalist id="ticker-options">
					</datalist>


				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group -->
			<div class="wp-block-group col-span-1 flex flex-col justify-end">
				<button class="wp-block-button__link wp-element-button text-sm"
					type="submit"
					style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
					Show results
				</button>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"100%"} -->
		<?php
		 	$partial_subtemplate = 'stock-templates/sub-templates/partial-show-ticker-info';
		?>
		<div class="wp-block-column" style="flex-basis:100%"
				data-dynamic-partial="<?php echo esc_attr( $partial_subtemplate ); ?>">
			<?php
			get_template_part( $partial_subtemplate, '', [ 'symbol' => null ] );
			?>
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:group {"metadata":{"name":"Row submit button"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group"
		style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40)">
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
		<!-- wp:button {"width":100} -->
		<div id="show-results-button" class="wp-block-button has-custom-width wp-block-button__width-100">
			<button type="submit" class="wp-block-button__link wp-element-button">Show results</button>
		</div>
		<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
	<!-- /wp:group -->

	</form>
	<!-- wp:group {"metadata":{"name":"Group results"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<div id="ticker-search-results" class="wp-block-group"
		style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:paragraph {"className":"is-style-text-annotation"} -->
		<p class="is-style-text-annotation">results here</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>


<button id="my-test"> TEST HERE </button>
<div id="container-test">put content here</div>
