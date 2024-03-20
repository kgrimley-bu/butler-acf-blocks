<?php
/**
 * Template part for displaying Callout - Two columns w/ video/image
 */
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$classes = array( 'callout-two-column-full-width-image-video' );

// Should the video player have a card?
// We only show a card if any of the card's fields are filled.
$has_card = false;

if ( get_field( 'kicker' )!= "" || get_field( 'headline' )[ "text" ] != "" || get_field( 'description' ) != "" || gettype( get_field( 'items' ) ) == "array" ) {
	$has_card = true;
	$classes[] = 'callout-two-column-full-width-image-video__has_card';
}

$media = get_field( 'media' );
?>
<section class="<?php echo get_classes( $classes, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="callout-two-column-full-width-image-video__wrapper <?php echo $media[ 'show' ] == 'image' ? 'callout-two-column-full-width-image__wrapper' : ''; ?>">
		<?php
		if ( $media ) :
			?>
			<?php if ( $media['show'] == 'image' ) : ?>
				<div class="callout-two-column-full-width-image-video-bg__media-container">
					<div class="callout-two-column-full-width-image-video-bg--overlay"></div>
					<img 
						class="callout-two-column-full-width-image-video__bg-image"
						src="<?php echo esc_url( $media[ 'image' ][ 'url' ] ); ?>" 
						srcset="<?php echo esc_url( $media[ 'image' ][ 'url' ] ); ?>" 
						alt="<?php echo esc_attr( $media[ 'image' ][ 'alt' ] ); ?>"
					>
				</div>
			<?php else : ?>
				<div class="callout-two-column-full-width-image-video__image_overlay_wrapper">
					<video playsinline autoplay muted loop class="callout-two-column-full-width-image-video-plyr-mp4">
						<source id="" src="<?php echo $media[ 'video' ]; ?>" type="video/mp4">
					</video>
					<img 
						class="callout-two-column-full-width-image-video__image_overlay_image" src="<?php echo $media[ 'overlay' ][ 'url' ] ? $media[ 'overlay' ][ 'url' ] : '' ?>"
						style="transform: scale(<?php echo get_field( 'media' )[ 'image_overlay_scale' ] / 100; ?> ); opacity: <?php echo get_field( 'media' )[ 'image_overlay_opacity' ] / 100; ?>;"
						alt=""
					></img>
					<script>
						Plyr.setup( document.querySelectorAll( '.callout-two-column-full-width-image-video-plyr-mp4' ), {
							autoplay: true,
							muted: true,
							controls: [ 'play' ],
							poster: "<?php echo $media[ 'poster' ][ 'url' ] ? $media[ 'poster' ][ 'url' ] : ''; ?>"
						} );
					</script>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
			$video_content_container = ( $media['show'] == 'video' ) ? 'callout-two-column-full-width-image-video__video-container' : '';
		?>

		<div class="container callout-two-column-full-width-image-video__container <?php echo $video_content_container; ?>">
			<div class="callout-two-column-full-width-image-video__content grid-default">
				<?php $card_accent = ( get_field( 'headline' ) ) ? get_field( 'headline' )['color_value'] : ''; ?>
				<?php if ( $has_card ) { ?>
					<div class="callout-two-column-full-width-image-video__card" style="--color-accent: var(--color-theme-<?php echo $card_accent; ?>)">
						<?php if ( get_field( 'kicker' ) ) { ?>
							<p class="callout-two-column-full-width-image-video__kicker">
								<?php the_field( 'kicker' ); ?>
							</p>
						<?php } ?>
						<?php
							$headline = get_field( 'headline' );
							$headline['size'] = 'h2';

						if ( $headline ) {
							?>
							<div class="callout-two-column-full-width-image-video__headline">
							<?php
							$highlight_style = ( $headline['color_value'] == 'blue-butler' ) ? '--highlight-color: background-color: var(--color-theme-' . $headline['color_value'] . '); color: var(--color-theme-white);' : '--highlight-color: var(--color-theme-' . $headline['color_value'] . ');';

							?>
								<?php
								require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
								?>
							</div>
						<?php } ?>
						<?php if ( get_field( 'description' ) ) { ?>
							<p class="callout-two-column-full-width-image-video__description">
								<?php the_field( 'description' ); ?>
							</p>
						<?php } ?>
						<?php
							$items = get_field( 'items' );
							$link_color = array( 'color' => 'button-link-right--color-theme-blue-bright' );
						if ( $items ) {
							?>
							<div class="callout-two-column-full-width-image-video__links">
							<?php
							foreach ( $items as $link ) {
								if ( $link['link'] != "" ) {
									$link['url'] = $link['link']['url'];
									$link['title'] = $link['link']['title'];
									require dirname( __DIR__, 2 ) . '/components/button-link-right/template.php';
								}
							}
							?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
