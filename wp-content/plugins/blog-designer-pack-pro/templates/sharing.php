<?php
/**
 * Social Sharing Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/sharing.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$social_services 	= bdpp_get_option( 'sharing', array() );
$share_title		= bdpp_get_share_title( $post->ID );
$share_url			= bdpp_get_share_url( $post->ID );

if( $sharing && bdpp_sharing_enabled() ) { ?>
	<div class="bdpp-social-share bdpp-social-<?php echo $sharing; ?> bdpp-clearfix">

		<?php if( !empty( $sharing_label ) ) { ?>
		<div class="bdpp-social-share-lbl"><span><?php echo $sharing_label; ?></span></div>
		<?php }

		// Loop of social services
		foreach ($social_services as $social_key => $social_val) {
			switch ( $social_val ) {
				case 'facebook':
					$fb_url = 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode( $share_url ).'&t='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-facebook" href="<?php echo esc_url( $fb_url ); ?>" title="<?php esc_html_e('Facebook', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
					<?php
					break;

				case 'twitter':
					$twitter_url = 'https://twitter.com/intent/tweet?text='.rawurlencode( $share_title ).'&url='.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-twitter" href="<?php echo esc_url( $twitter_url ); ?>" title="<?php esc_html_e('Twitter', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
					<?php
					break;

				case 'linkedin':
					$linkedin_url = 'https://www.linkedin.com/shareArticle?url='.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-linkedin" href="<?php echo esc_url( $linkedin_url ); ?>" title="<?php esc_html_e('LinkedIn', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-linkedin"></i></a>
					<?php
					break;

				case 'pinterest':
					$pinterest_url = 'https://pinterest.com/pin/create/button/?url='. rawurlencode( $share_url ) .'&media='. rawurlencode( bdpp_get_post_feat_image( $post->ID, 'full' ) ) .'&description='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-pinterest" href="<?php echo esc_url( $pinterest_url ); ?>" title="<?php esc_html_e('Pinterest', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-pinterest"></i></a>
					<?php
					break;
					
				case 'tumblr':
					$tumblr_url = 'https://tumblr.com/widgets/share/tool?canonicalUrl='.rawurlencode( $share_url ).'&title='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-tumblr" href="<?php echo esc_url( $tumblr_url ); ?>" title="<?php esc_html_e('Tumblr', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-tumblr"></i></a>
					<?php
					break;

				case 'pocket':
					$pocket_url = 'https://getpocket.com/save?url='.rawurlencode( $share_url ).'&title='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-pocket" href="<?php echo esc_url( $pocket_url ); ?>" title="<?php esc_html_e('Pocket', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-get-pocket"></i></a>
					<?php
					break;

				case 'skype':
					$skype_url = 'https://web.skype.com/share?text='.rawurlencode( $share_title ).'&url='.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-skype" href="<?php echo esc_url( $skype_url ); ?>" title="<?php esc_html_e('Skype', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-skype"></i></a>
					<?php
					break;

				case 'telegram':
					$telegram_url = 'https://telegram.me/share/url?text='.rawurlencode( $share_title ).'&url='.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-telegram" href="<?php echo esc_url( $telegram_url ); ?>" title="<?php esc_html_e('Telegram', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-telegram"></i></a>
					<?php
					break;

				case 'whatsapp':
					$whatsapp_url = 'whatsapp://send?text='.rawurlencode( $share_title ). ' ' .rawurlencode( $share_url ) . '&url='.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-whatsapp" href="<?php echo $whatsapp_url; ?>" title="<?php esc_html_e('WhatsApp', 'blog-designer-pack'); ?>" target="_blank"><i class="fa fa-whatsapp"></i></a>
					<?php
					break;
				
				case 'reddit':
					$reddit_url = 'https://www.reddit.com/submit?url='.rawurlencode( $share_url ).'&title='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-reddit" href="<?php echo esc_url( $reddit_url ); ?>" title="<?php esc_html_e('Reddit', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-reddit"></i></a>
					<?php
					break;

				case 'digg':
					$digg_url = 'http://digg.com/submit?url='.rawurlencode( $share_url ).'&title='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-digg" href="<?php echo esc_url( $digg_url ); ?>" title="<?php esc_html_e('Digg', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-digg"></i></a>
					<?php
					break;

				case 'wordpress':
					$wordpress_url = 'https://wordpress.com/press-this.php?u='.rawurlencode( $share_url ).'&t='.rawurlencode( $share_title );
				?>
					<a class="bdpp-share-link bdpp-wordpress" href="<?php echo esc_url( $wordpress_url ); ?>" title="<?php esc_html_e('WordPress', 'blog-designer-pack'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-wordpress"></i></a>
					<?php
					break;

				case 'email':
					$email_url = 'mailto:?subject='.rawurlencode( $share_title ).'&body='.rawurlencode( $share_title ) .' '.rawurlencode( $share_url );
				?>
					<a class="bdpp-share-link bdpp-envelope" href="<?php echo esc_url( $email_url ); ?>" title="<?php esc_html_e('Email', 'blog-designer-pack'); ?>"><i class="fa fa-envelope"></i></a>
					<?php
					break;
			}
		} ?>

	</div>
<?php } ?>