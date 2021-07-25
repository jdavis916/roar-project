<?php
/**
 * Ticker Template 1
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/ticker/design-1.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li class="bdpp-ticker-ele <?php echo $wrp_cls; ?>"><a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a></li>