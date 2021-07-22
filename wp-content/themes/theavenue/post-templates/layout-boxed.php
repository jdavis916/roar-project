<?php
global $avenue_post_loop;

$post_format = get_post_format();
$classes = 'post-boxed _' . ($post_format ? $post_format : 'standard');
$content_width = get_theme_option('layout--content_width');
$sidebar_location = get_sidebar_location();

if (is_sticky()) {
	$classes .= ' _sticky';
}
$col_classes = 'col-xs-12 col-md-12 col-xl-12 col-xxxl-12';
?>

<div class="<?php echo esc_attr($col_classes); ?> animate-on-screen js--animate-on-screen">
	<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
		<?php get_template_part('post-templates/boxed/content', $post_format); ?>
	</article>
</div>
