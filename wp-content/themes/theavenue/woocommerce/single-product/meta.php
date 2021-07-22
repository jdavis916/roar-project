<?php
/**
 * Single Product Meta
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$cat_count = count( $product->get_category_ids() );
$tag_count = count( $product->get_tag_ids() );

?>
<div class="product-meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="product-meta-el sku_wrapper"><span class="product-meta-el_h"><?php esc_html_e( 'SKU:', 'avenue' ); ?></span> <span class="product-meta-el_cnt sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'avenue' ); ?></span></span>

	<?php endif; ?>

	<?php echo wp_kses( wc_get_product_category_list( $product->get_id(), ', ', '<span class="product-meta-el posted_in"><span class="product-meta-el_h">' . _n( 'Category:', 'Categories:', $cat_count, 'avenue' ) . '</span> <span class="product-meta-el_cnt">', '</span></span>' ), 'post'); ?>

	<?php echo wp_kses( wc_get_product_tag_list( $product->get_id(), ', ', '<span class="product-meta-el tagged_as"><span class="product-meta-el_h">' . _n( 'Tag:', 'Tags:', $tag_count, 'avenue' ) . '</span> <span class="product-meta-el_cnt">', '</span></span>' ), 'post'); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
