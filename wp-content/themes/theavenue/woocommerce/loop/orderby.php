<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
	<div class="col-sm-6">
		<form class="cat-lst-sort woocommerce-ordering" method="get">
			<select name="orderby" class="orderby __slim">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit' ) ); ?>
		</form>
	</div>
</div>
