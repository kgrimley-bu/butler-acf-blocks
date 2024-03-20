<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
?>

<section class="<?php echo get_classes( 'full-width-video-image', $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<?php
	$outlined = get_field( 'outlined_text' );
	if ( ! empty( $outlined['line_1'] ) || ! empty( $outlined['line_2'] ) ) {
		?>
		<div class="full-width-video-image__outlined-wrapper">
			<h2 class="full-width-video-image__outlined" aria-hidden="true">
				<span class="full-width-video-image__outlined-line-1"><?php echo $outlined['line_1']; ?></span>
				<span class="full-width-video-image__outlined-line-2"><?php echo $outlined['line_2']; ?></span>
			</h2>
		</div>
	<?php } ?>
	<?php
	$media = get_field( 'media' );
	if ( $media ) {
		?>
		<div class="container full-width-video-image__wrapper" id="media-wrapper">
			<?php
			$headline_array = get_field( 'headline' );
			$headline = $headline_array[ 'text' ] ? $headline_array[ 'text' ] : $args['headline'];
			$color = $headline_array[ 'color_value' ] ? $headline_array[ 'color_value' ] : '';

			if ( $headline !== '' ) {
				?>
				<div class="full-width-video-image__headline <?php echo $media['type'] == 'image' ? '' : 'full-width-video-image__headline--video'; ?>">
					<?php
					$headline = array(
						'text' => $headline,
						'color_value' => $color,
						'size' => 'h2'
					);
					require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
					?>
				</div>
			<?php } ?>
			<?php
			if ( $media['type'] == 'image' ) {
				?>
				<div class="full-width-video-image__media">
					<img
							src="<?php echo esc_url( $media['image']['url'] ); ?>"
							srcset="<?php echo esc_url( $media['image']['url'] ); ?>"
							alt="<?php echo esc_attr( $media['image']['alt'] ); ?>"
							class="full-width-video-image__media-img"
					>
				</div>
				<?php
			} elseif ( $media['video']['url'] ) {
				$url = $media['video']['url'];
				?>
				<div class="full-width-video-image-plyr__wrapper">
					<div class="full-width-video-image-plyr plyr__video-embed">
						<video playsinline muted poster loop
							   class="full-width-video-image-plyr-mp4"
							   data-poster="<?php echo $media['poster']['image'] ? $media['poster']['image']['url'] : ''; ?>"
							   width="<?php echo $media['video']['width']; ?>"
							   height="<?php echo $media['video']['height']; ?>"
						>
							<source id="" src="<?php echo $url; ?>" type="video/mp4">
						</video>
					</div>
				</div>
				<?php

			}
			?>
		</div>
	<?php } ?>
	<?php
	$image = get_field( 'image_decoration' );
	if ( ! empty( $image ) ) {
		?>
		<img
				class="full-width-video-image__media-decoration"
				src="<?php echo esc_url( $image['url'] ); ?>"
				srcset="<?php echo esc_url( $image['url'] ); ?>"
				alt="<?php echo esc_attr( $image['alt'] ); ?>"
		>
	<?php } ?>
</section>
