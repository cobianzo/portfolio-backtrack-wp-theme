<?php
/**
 * Title: Ticker Lookup
 * Slug: portfolio-theme/part-ticker-lookup
 * Inserter: no
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      portfolio-theme 1.0
 */

?>
<div class="coco-dynamic-block-wrapper">
	<h1> Todo esto deberia ir </h1>
	<!-- wp:group {"metadata":{"name":"Group wrapper"},"className":"is-style-default","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"backgroundColor":"accent-5","layout":{"type":"constrained"}} -->
	<div class="wp-block-group is-style-default has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--30)"><!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column {"width":"100%"} -->
	<div class="wp-block-column" style="flex-basis:100%"><!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"ticker field Group"},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:heading -->
	<h2 class="wp-block-heading">Ticker</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p>

		<input type="text" name="ticker-lookup" id="ticker-lookup" aria-label="Stock Ticker Lookup" placeholder="Enter stock ticker" aria-required="true"
		class="ticker-lookup-input rounded-lg border border-gray-300 p-2 pl-10 text-sm text-gray-700" list="ticker-options" />
		<datalist id="ticker-options">
		</datalist>

	</p>
	<!-- /wp:paragraph --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"100%"} -->
	<div class="wp-block-column" style="flex-basis:100%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"ticker field Group"},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:heading {"level":3} -->
	<h3 class="wp-block-heading">Years</h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p>/input years</p>
	<!-- /wp:paragraph --></div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"ticker field Group"},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:heading {"level":3} -->
	<h3 class="wp-block-heading">Last year</h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p>/input years</p>
	<!-- /wp:paragraph --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns -->
	<!-- wp:group {"metadata":{"name":"Row submit button"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:buttons -->
	<div class="wp-block-buttons"><!-- wp:button {"width":100} -->
	<div id="show-results-button"
		class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button">Show results</a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons --></div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Group results"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<div id="ticker-search-results" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"className":"is-style-text-annotation"} -->
	<p class="is-style-text-annotation">results here</p>
	<!-- /wp:paragraph --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->
</div>
