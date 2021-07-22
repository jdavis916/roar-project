<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="col-sm-6">
	<div class="wc-account-order-card">
		<h2 class="wc-account-order-card_h"><?php esc_html_e( 'Customer Details', 'avenue' ); ?></h2>

		<table class="wc-account-order-customer-details">
			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Note:', 'avenue' ); ?></th>
					<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
				</tr>
			<?php endif; ?>

			<?php if ( $order->get_billing_email() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Email:', 'avenue' ); ?></th>
					<td><?php echo esc_html( $order->get_billing_email() ); ?></td>
				</tr>
			<?php endif; ?>

			<?php if ( $order->get_billing_phone() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Telephone:', 'avenue' ); ?></th>
					<td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
				</tr>
			<?php endif; ?>

			<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
		</table>


		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>
			<div class="row">
				<div class="col-md-6">
		<?php endif; ?>

					<h3 class="wc-account-order-card_h"><?php esc_html_e( 'Billing Address', 'avenue' ); ?></h3>
					<address><?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : esc_html__( 'N/A', 'avenue' ); ?></address>

		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>
				</div>
				<div class="col-md-6">
					<h3 class="wc-account-order-card_h"><?php esc_html_e( 'Shipping Address', 'avenue' ); ?></h3>
					<address><?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : esc_html__( 'N/A', 'avenue' ); ?></address>
				</div>
			</div>
		<?php endif; ?>


	</div>
</div>