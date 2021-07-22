<?php
/**
 * Order tracking
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<p class="wc-lead"><?php
	echo wp_kses_post( apply_filters( 'woocommerce_order_tracking_status', sprintf(
		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'avenue' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	) ) );
?></p>

<?php if ( $notes = $order->get_customer_order_notes() ) { ?>
	<h2><?php esc_attr_e( 'Order Updates', 'avenue' ); ?></h2>
	<ol class="commentlist notes">
		<?php foreach ( $notes as $note ) { ?>
		<li class="comment note">
			<div class="comment_container">
				<div class="comment-text">
					<p class="meta"><?php echo date_i18n( esc_attr__( 'l jS \o\f F Y, h:ia', 'avenue' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php } ?>
	</ol>
<?php } ?>

<?php do_action( 'woocommerce_view_order', $order->id ); ?>
