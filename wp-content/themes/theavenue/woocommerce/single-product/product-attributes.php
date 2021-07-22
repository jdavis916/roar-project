<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="product-additional-info">

		<?php if ( $display_dimensions && $product->has_weight() ) : ?>
			<div class="product-additional-info-el">
				<div class="row">
					<div class="col-sm-3"><div class="product-additional-info-el_h"><?php _e( 'Weight', 'avenue' ) ?></div></div>
					<div class="col-sm-9"><div class="product-additional-info-el_desc product_weight"><?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></div></div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $display_dimensions && $product->has_dimensions() ) : ?>
			<div class="product-additional-info-el">
				<div class="row">
					<div class="col-sm-3"><div class="product-additional-info-el_h"><?php _e( 'Dimensions', 'avenue' ) ?></div></div>
					<div class="col-sm-9"><div class="product-additional-info-el_desc product_dimensions"><?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?></div></div>
				</div>
			</div>
		<?php endif; ?>

	<?php foreach ( $attributes as $attribute ) :
		
		?>
			<div class="product-additional-info-el">
				<div class="row">
					<div class="col-sm-3"><div class="product-additional-info-el_h"><?php echo wc_attribute_label( $attribute->get_name() ); ?></div></div>
					<div class="col-sm-9"><div class="product-additional-info-el_desc"><?php
							$values = array();

							if ( $attribute->is_taxonomy() ) {
								$attribute_taxonomy = $attribute->get_taxonomy_object();
								$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

								foreach ( $attribute_values as $attribute_value ) {
									$value_name = esc_html( $attribute_value->name );

									if ( $attribute_taxonomy->attribute_public ) {
										$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
									} else {
										$values[] = $value_name;
									}
								}
							} else {
								$values = $attribute->get_options();

								foreach ( $values as &$value ) {
									$value = make_clickable( esc_html( $value ) );
								}
							}

							echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
						?></div></div>
				</div>
			</div>
	<?php endforeach; ?>

</div>
