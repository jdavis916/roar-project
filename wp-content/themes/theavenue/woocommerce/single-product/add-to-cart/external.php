<?php
/**
 * External product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<div class="product_add-to-cart-w">
	<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
</div>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
