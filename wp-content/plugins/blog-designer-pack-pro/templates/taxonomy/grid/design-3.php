<?php
/**
 * Taxonomy Template 3
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/taxonomy/grid/design-3.php
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="<?php echo $wrp_cls; ?>">
	<div class="bdpp-term-inner bdpp-clearfix">
		<div class="bdpp-term-img-wrapper" <?php echo $image_style; ?>>
			<?php if( $link ) { ?><a class="bdpp-term-link-overlay" href="<?php echo esc_url( $term_link ); ?>"></a><?php } ?>
			<?php if( $bg_color ) { ?>
			<div class="bdpp-custom-color" style="<?php echo esc_attr($bg_color); ?>"></div>
			<?php } ?>
		</div>

		<?php if( $show_count || $show_title ) { ?>
		<div class="term-heading-main">
			<?php if( $show_count ) { ?>
			<div class="bdpp-term-count"><?php echo $term_data->count; ?></div>
			<?php }
			
			if( $show_title ) { ?>
			<div class="bdpp-term-title">
				<?php if( $link ) { ?>
					<a href="<?php echo esc_url( $term_link ); ?>" target="<?php echo $link_target; ?>"><?php if(!empty($term_icon)) { echo '<i class="bdpp-fa-custom '.$term_icon.'"></i>';  } ?> <?php echo $term_data->name; ?></a>
				<?php } else { ?>
					<span><?php if( ! empty($term_icon) ) { echo '<i class="bdpp-fa-custom '.$term_icon.'"></i>';  } ?> <?php echo $term_data->name; ?></span>
				<?php } ?>	
			</div>
			<?php } ?>
		</div>
		<?php }

		if( $show_desc && $term_data->description ) { ?>
		<div class="bdpp-term-bottom-wrapper">			
			<div class="bdpp-term-description"><?php echo $term_data->description; ?></div>		
		</div>
		<?php } ?>
	</div>
</div>