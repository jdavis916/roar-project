<?php
/**
 * Single Product Rating
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<?php echo wc_get_rating_html( $average, $rating_count ); ?>
		<?php if (comments_open()) { ?><span class="js--scroll-nav"><a href="#product-tabs" class="product_review-lk" rel="nofollow"><?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'avenue' ), '<span itemprop="reviewCount">' . esc_html( $review_count ) . '</span>' ); ?></a></span><?php } ?>
	</div>

<?php endif; ?>
