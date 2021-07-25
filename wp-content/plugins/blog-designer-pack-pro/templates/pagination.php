<?php
/**
 * Pagination Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/pagination.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( $pagination && $max_num_pages > 1 ) { ?>
	<div class="bdpp-paging bdpp-pagi-<?php echo $pagination_type; ?> bdpp-clearfix">
		<?php if( $pagination_type == 'numeric' || ($multi_page && $pagination_type == "prev-next") ) {

			echo bdpp_pagination( array( 'paged' => $paged, 'total' => $max_num_pages, 'prev_text' => $prev_text, 'next_text' => $next_text, 'multi_page' => $multi_page, 'pagination_type' => $pagination_type ) );

		} elseif( $pagination_type == 'numeric-ajax' ) { ?>

			<div class="bdpp-numeric-ajax bdpp-numeric-post-ajax" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>">
				<?php echo bdpp_pagination( array( 'paged' => $paged, 'total' => $max_num_pages, 'prev_text' => $prev_text, 'next_text' => $next_text, 'multi_page' => 1, 'pagination_type' => $pagination_type ) ); ?>
			</div>
			<div class="bdpp-text-center"><span class="bdpp-loader"></span></div>

		<?php } elseif( $pagination_type == 'prev-next-ajax' ) { ?>

			<div class="bdpp-prev-next-ajax bdpp-prev-next-post-ajax" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>">
				<span class="bdpp-ajax-pagi-btn bdpp-ajax-prev-page bdpp-ajax-disabled bdpp-ajax-btn-style"><?php echo $prev_text; ?></span>
				<span class="bdpp-ajax-pagi-btn bdpp-ajax-next-page bdpp-ajax-btn-style"><?php echo $next_text; ?></span>
				<div class="bdpp-text-center"><span class="bdpp-loader"></span></div>
			</div>

		<?php } elseif( $pagination_type == 'load-more' ) { ?>

			<div class="bdpp-load-more bdpp-post-load-more bdpp-ajax-btn-style" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>"><?php esc_html_e( 'Load More', 'blog-designer-pack' ); ?> <i class="fa fa-chevron-down bdpp-load-more-icon"></i> <span class="bdpp-loader"></span></div>

		<?php } elseif( $pagination_type == 'infinite' ) { ?>

			<div class="bdpp-infinite-pagi bdpp-post-infinite-pagi" data-conf="<?php echo htmlspecialchars(json_encode( $template_args )); ?>"><span class="bdpp-loader"></span></div>

		<?php } else { ?>

			<div class="bdpp-pagi-btn bdpp-next-btn"><?php next_posts_link( $next_text, $max_num_pages ); ?></div>
			<div class="bdpp-pagi-btn bdpp-prev-btn"><?php previous_posts_link( $prev_text ); ?></div>

		<?php } ?>
	</div>
<?php } ?>