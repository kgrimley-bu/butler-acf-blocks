<?php
require_once realpath( __DIR__ ) . '/../utils/functions/has_page_menu.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$has_wysiwyg_block_class = has_page_menu( $post_id, $block['name'] ) ? 'hero-alternate__socialMedia--hasWysiwyg' : '';
$loop_video = ( true == get_field( 'loop_video' ) ) ? 'loop' : '';
$background_type = get_field( 'background_type' );
$layout = get_field( 'layout' );

$classes = array( "hero-alternate", "hero-alternate--$background_type", "hero-alternate--$layout", "color-overlay", "color-overlay--blue-bright" );
?>

<section class="<?php echo get_classes( $classes, $block ); ?>" <?php echo get_anchor( $block ); ?> >
	<div class="container">
		<h1 class="hero-alternate__headline"><?php the_field( 'headline' ); ?></h1>
		<?php
			$has_social_media = get_field( 'social_media' );
			$social_media = get_field( 'social_media_link_overrides' ) ? get_field( 'social_media_link_overrides' ) : get_field( 'social_media_links', 'acf_site_options' );
		if ( $has_social_media ) {
			if ( $social_media ) {
				?>
				<nav class="hero-alternate__socialMedia <?php echo $has_wysiwyg_block_class; ?>" aria-label="Social Media Links">
				<?php
					$social_media_options = array(
						'links' => $social_media,
						'option_new_tab' => get_field( 'social_media_new_tab' ),
					);
					require dirname( __DIR__, 2 ) . '/components/social-media/template.php';
					?>
				</nav>
				<?php
			}
		}
		?>
	</div>
	<?php
	if ( get_field( 'background_type' ) == 'video' ) {
		$video = get_field( 'hero_video' );
		if ( $video ) {
			?>
			<video src="<?php echo $video['url']; ?>" class="hero-alternate__video" playsinline muted <?php echo $loop_video; ?> controls="false" ></video>
			<?php
		}
	} else if ( get_field( 'background_type' ) == 'image' ) {
		if ( get_field( 'hero_image' ) ) {
			echo wp_get_attachment_image(
				get_field( 'hero_image' ),
				'large',
				false,
				array(
					'class' => 'hero-alternate__image color-overlay__media',
				)
			);
		}
	}
	?>
</section>