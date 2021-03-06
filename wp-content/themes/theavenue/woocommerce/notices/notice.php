<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

?>

<div class="wc-message-w __notice">
	<div class="wc-message_ic"><i class="fa fa-info"></i></div>
	<div class="wc-message_cnt">
		<?php foreach ( $messages as $message ) : ?>
			<div class="woocommerce-info"><?php echo wp_kses_post( $message ); ?></div>
		<?php endforeach; ?>
	</div>
</div>
