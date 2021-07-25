<?php
/**
 * Taxonomy Pagination Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/taxonomy/pagination.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( $pagination && $term_total > 1 && $term_total > $limit ) { ?>
	<div class="bdpp-paging bdpp-clearfix">
		<?php if( $pagination_type == 'prev-next-ajax' ) { ?>

			<div class="bdpp-prev-next-ajax bdpp-prev-next-term-ajax" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>">
				<span class="bdpp-ajax-pagi-btn bdpp-ajax-prev-page bdpp-ajax-disabled"><?php echo $prev_text; ?></span>
				<span class="bdpp-ajax-pagi-btn bdpp-ajax-next-page"><?php echo $next_text; ?></span>
				<div class="bdpp-text-center"><span class="bdpp-loader"></span></div>
			</div>

		<?php } elseif( $pagination_type == 'load-more' ) { ?>

			<div class="bdpp-load-more bdpp-term-load-more" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>"><?php esc_html_e( 'Load More', 'blog-designer-pack' ); ?> <i class="fa fa-chevron-down bdpp-load-more-icon"></i> <span class="bdpp-loader"></span></div>

		<?php } elseif( $pagination_type == 'infinite' ) { ?>

			<div class="bdpp-infinite-pagi bdpp-term-infinite-pagi" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>"><span class="bdpp-loader"></span></div>

		<?php } else {
			echo bdpp_pagination( array(
									'paged'		=> $paged,
									'total'		=> ceil( $term_total / $limit ),
									'prev_text'	=> $prev_text,
									'next_text'	=> $next_text,
									'base'    	=> esc_url_raw( add_query_arg( 'bdpp-term-page', '%#%', false ) ),
									'format'  	=> '?bdpp-term-page=%#%',
								) );
		} ?>
	</div>
<?php } ?>