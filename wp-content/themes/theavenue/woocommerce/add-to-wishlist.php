<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

global $product;
?>

<div class="add-to-wishlist yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id); ?>">
	<?php if (!($disable_wishlist && !is_user_logged_in())) { ?>
		<div class="yith-wcwl-add-button <?php echo ( $exists && ! $available_multi_wishlist ) ? 'hide': 'show' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'none': 'block' ?>">

			<?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>

		</div>

		<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
			<a href="<?php echo esc_url($wishlist_url); ?>" >
				<span class="add-to-wishlist_ic icon-heart __add"></span>
				<span class="add-to-wishlist_tx feedback"><?php echo esc_attr($product_added_text); ?></span>
				<span class="add-to-wishlist_tx"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?></span>
			</a>
		</div>

		<div class="yith-wcwl-wishlistexistsbrowse <?php echo ( $exists && ! $available_multi_wishlist ) ? 'show' : 'hide' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'block' : 'none' ?>">
			<a href="<?php echo esc_url($wishlist_url); ?>">
				<span class="add-to-wishlist_ic icon-heart __add"></span>
				<span class="add-to-wishlist_tx feedback"><?php echo esc_attr($already_in_wishslist_text); ?></span>
				<span class="add-to-wishlist_tx"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?></span>
			</a>
		</div>

		<div style="clear:both"></div>
		<div class="yith-wcwl-wishlistaddresponse"></div>
	<?php } else { ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="<?php echo esc_attr(str_replace('add_to_wishlist', '', $link_classes)); ?>">
			<?php
				if ($icon) {
					echo wp_kses($icon, 'post');
				} else {
					echo '<span class="add-to-wishlist_ic icon-heart"></span>';
				}
			?>
			<span class="add-to-wishlist_tx"><?php echo esc_attr($label); ?></span>
		</a>
	<?php } ?>
</div>