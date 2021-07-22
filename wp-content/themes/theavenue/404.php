<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package avenue
 */

get_header(); ?>

	<div class="error-404 not-found">
		<div class="page-content">
			<div class="no-results-page">
				<p class="no-results-page_lbl __404">404</p>
				<h2 class="no-results-page_h"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'avenue' ); ?></h2>
				<p class="no-results-page_desk"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'avenue' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
