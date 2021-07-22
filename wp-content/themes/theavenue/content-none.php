<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package avenue
 */
?>

<div class="no-results not-found">
	<div class="page-content">
		<div class="no-results-page">
			<?php if (is_home() && current_user_can('publish_posts')) { ?>

				<h2 class="no-results-page_h"><?php esc_html_e( 'Ready to publish your first post?', 'avenue' ); ?></h2>
				<p class="no-results-page_desk"><?php printf( wp_kses(__( '<a href="%1$s">Get started here</a>.', 'avenue' ), 'post'), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php } elseif (is_search()) { ?>

				<p class="no-results-page_lbl"><?php esc_html_e( 'No Result', 'avenue' ); ?></p>
				<h2 class="no-results-page_h"><?php esc_html_e( 'Sorry, but nothing matched your search terms.', 'avenue' ); ?></h2>
				<p class="no-results-page_desk"><?php esc_html_e( 'Please try again with some different keywords.', 'avenue' ); ?></p>
				<?php get_search_form(); ?>

			<?php } else { ?>

				<p class="no-results-page_lbl"><?php esc_html_e( 'No Result', 'avenue' ); ?></p>
				<h2 class="no-results-page_h"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'avenue' ); ?></h2>
				<p class="no-results-page_desk"><?php esc_html_e( 'Perhaps searching can help.', 'avenue' ); ?></p>
				<?php get_search_form(); ?>

			<?php } ?>
		</div>
	</div><!-- .page-content -->
</div><!-- .no-results -->
