<?php
/**
 * Loop End - Slider Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/slider/loop-end.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

	</div>
	<?php
		// For Thumbnail
		if( $show_thumbnail ) {
			bdpp_get_template( 'slider/thumb-nav.php', $template_args );
		}
	?>
</div>