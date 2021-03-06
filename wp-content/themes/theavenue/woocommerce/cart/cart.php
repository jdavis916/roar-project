<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="cart-page">
	<div class="row">
		<div class="col-md-7 col-xl-8">
			<form id="cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

				<?php do_action( 'woocommerce_before_cart_table' ); ?>
				<div class="cart-lst-w">
					<table class="cart-lst" cellspacing="0">
						<thead>
							<tr>
								<th class="cart-lst-el_h">&nbsp;</th>
								<th class="cart-lst-el_h text-left"><?php _e( 'Product', 'avenue' ); ?></th>
								<th class="cart-lst-el_h"><?php _e( 'Price', 'avenue' ); ?></th>
								<th class="cart-lst-el_h"><?php _e( 'Quantity', 'avenue' ); ?></th>
								<th class="cart-lst-el_h"><?php _e( 'Total', 'avenue' ); ?></th>
								<th class="cart-lst-el_h">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php do_action( 'woocommerce_before_cart_contents' ); ?>

							<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

									?>
									<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> cart-lst-el">

										<td class="cart-lst-el_cnt __thumbnail">
											<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
											if ( ! $product_permalink ) {
												echo $thumbnail;
											} else {
												printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
											}
											?>
										</td>

										<td class="cart-lst-el_cnt __product" data-title="<?php esc_attr_e( 'Product', 'avenue' ); ?>">
											<?php
											if ( ! $product_permalink ) {
												echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
											} else {
												echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
											}

											// Meta data
											echo WC()->cart->get_item_data( $cart_item );

											// Backorder notification
											if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
												echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'avenue' ) . '</p>';
											}
											?>
										</td>

										<td class="cart-lst-el_cnt __price" data-title="<?php esc_attr_e( 'Price', 'avenue' ); ?>">
											<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
											?>
										</td>

										<td class="cart-lst-el_cnt __quantity" data-title="<?php esc_attr_e( 'Quantity', 'avenue' ); ?>">
											<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" class="__bold_round" value="1">', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input( array(
													'class' => '__bold_round',
													'input_name'  => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value'   => $_product->get_max_purchase_quantity(),
													'min_value'   => '0'
												), $_product, false );
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
											?>
										</td>

										<td class="cart-lst-el_cnt __subtotal" data-title="<?php esc_attr_e( 'Total', 'avenue' ); ?>">
											<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
											?>
										</td>

										<td class="cart-lst-el_cnt __remove text-right">
											<?php
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
												'<a href="%s" title="%s" data-product_id="%s" data-product_sku="%s"><span class="icon-cross"></span></a>',
												esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
												__( 'Remove this item', 'avenue' ),
												esc_attr( $product_id ),
												esc_attr( $_product->get_sku() )
											), $cart_item_key );
											?>
										</td>
									</tr>
									<?php
								}
							}

							do_action( 'woocommerce_cart_contents' );
							?>

							<?php do_action( 'woocommerce_after_cart_contents' ); ?>
						</tbody>
					</table>
				</div>

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="cart-coupon">

						<input type="text" name="coupon_code" class="cart-coupon_it __round" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'avenue' ); ?>" size="25"><button type="submit" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'avenue' ); ?>" class="cart-coupon_btn"><?php esc_attr_e( 'Apply Coupon', 'avenue' ); ?></button>

						<?php do_action( 'woocommerce_cart_coupon' ); ?>

					</div>
				<?php } ?>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>

			</form>
		</div>

		<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
