<?php
/**
 * Loop End - Ticker Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/ticker/loop-end.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
		</ul>
	</div>
	<?php  if( $arrows || $pause_button ) { ?>
	 <div class="inf-controls bdpp-controls">
		<?php if( $arrows ) { ?><span class="bdpp-ctrl-btn inf-ctrl-btn"><span class="inf-arrow inf-prev"></span></span><?php } ?>
		<?php if( $pause_button ) { ?><span class="bdpp-ctrl-btn inf-ctrl-btn"><span class="inf-action"></span></span> <?php } ?>
		<?php if( $arrows ) { ?><span class="bdpp-ctrl-btn inf-ctrl-btn"><span class="inf-arrow inf-next"></span></span><?php } ?>
	</div>
	<?php } ?>
</div>