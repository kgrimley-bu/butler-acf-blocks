<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$slides = get_field( 'slides' );

$color_overlay = ( get_field( 'color_overlay' ) || is_null( get_field( 'color_overlay' ) ) ) ? 'color-overlay-blue-bright' : 'color-overlay--gradient-fade-down';
// turn off below because the new design has no shadow overlay.... maybe this can be a property in ACF?
$color_overlay_media = ( get_field( 'color_overlay' ) || is_null( get_field( 'color_overlay' ) ) ) ? 'color-overlay__media' : '';

// check if has kickers, add extra space
$has_card = false;
foreach ( $slides as $key => $item ) {
	if ( $item['headline']['text'] != "" || $item['kicker'] != "" || $item['description'] != "" || $item['link'] != "" ) {
		$has_card = true;
	}
}
$has_card_class = $has_card == true ? 'gallery-carousel--hasCard' : '';
?>

<section class="<?php echo get_classes( 'gallery-carousel ' . $has_card_class, $block ); ?>"
		 style="--slide-count: <?php echo count( $slides ); ?>" <?php echo get_anchor( $block ); ?>>
	<?php if ( count( $slides ) > 1 ) { ?>
		<div class="gallery-carousel__icon-wrapper">
			<button class="gallery-carousel__pauseButton gallery-carousel__button">
				<div class="gallery-carousel__pauseButton-icon-wrapper">
					<svg class="gallery-carousel__pauseButton-icon gallery-carousel__pauseButton-icon--pause"
						 aria-hidden="true" focusable="false">
						<use xlink:href="<?php echo plugin_dir_url( __DIR__ ) . '../assets/images/plyr.svg#plyr-play'; ?>"/>
					</svg>
					<svg class="gallery-carousel__pauseButton-icon gallery-carousel__pauseButton-icon--play"
						 aria-hidden="true" focusable="false">
						<use xlink:href="<?php echo plugin_dir_url( __DIR__ ) . '../assets/images/plyr.svg#plyr-pause'; ?>"/>
					</svg>
					<span class="plyr__sr-only">Pause/Play</span>
				</div>
			</button>
		</div>
	<?php } ?>
	<?php
	if ( $slides ) {
		?>
		<div class="swiper gallery-carousel__slider-swipper">
			<div class="swiper-wrapper">
				<?php
				foreach ( $slides as $slide ) {
					$has_cutout_bg = ( ! empty( $slide['background']['cutout_image'] ) ) ? '' : 'gallery-carousel__wrapper--no-cutout';
					?>
					<!-- Swiper -->
					<div class="swiper-slide">
						<div class="gallery-carousel__wrapper <?php echo $has_cutout_bg; ?> ">
							<?php
							$background = $slide['background'];
							if ( $background ) {
								?>
								<div class="color-overlay <?php echo $color_overlay; ?>">
									<img
											src="<?php echo esc_url( $background['poster']['url'] ); ?>"
											srcset="<?php echo esc_url( $background['poster']['url'] ); ?>"
											alt="<?php echo esc_attr( $background['poster']['alt'] ); ?>"
											class="gallery-carousel__bg-poster <?php echo $color_overlay_media; ?>"
											width="<?php echo $background['poster']['width']; ?>"
											height="<?php echo $background['poster']['height']; ?>"
									>
								</div>
								<?php if ( ! empty( $background['cutout_image'] ) ) { ?>
									<img
											src="<?php echo esc_url( $background['cutout_image']['url'] ); ?>"
											srcset="<?php echo esc_url( $background['cutout_image']['url'] ); ?>"
											alt="<?php echo esc_attr( $background['cutout_image']['alt'] ); ?>"
											class="gallery-carousel__bg-cutout"
											width="<?php echo $background['cutout_image']['width']; ?>"
											height="<?php echo $background['cutout_image']['height']; ?>"
									>
								<?php } ?>
							<?php } ?>
							<div class="container gallery-carousel__container">
								<div class="gallery-carousel__content grid-default">
									<?php
									$color_accent = ( $slide['headline'] ) ? $slide['headline']['color_value'] : '';
									?>
									<?php if ( $slide['headline']['text'] != "" || $slide['kicker'] != "" || $slide['description'] != "" || $slide['link'] != "" ) { ?>
									<div class="gallery-carousel__card"
										 style="--color-accent: var(--color-theme-<?php echo $color_accent; ?>)">
										<?php
										$kicker = $slide['kicker'];
										if ( $kicker ) {
											?>
											<p class="gallery-carousel__card_kicker t-p1">
												<?php echo $kicker; ?>
											</p>
										<?php } ?>
										<?php
										$headline = $slide['headline'];
										if ( $headline ) {
											$headline = array(
												'text' => $headline[ 'text' ],
												'color_value' => $headline[ 'color_value' ],
												'size' => 'h2'
											);
											?>
											<div class="gallery-carousel__card_headline-wrapper">
												<?php require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php'; 
												?>
											</div>
										<?php } ?>
										<?php
										$description = $slide['description'];
										if ( $description ) {
											?>
											<p class="gallery-carousel__card_description t-p1">
												<?php echo $description; ?>
											</p>
										<?php } ?>
										<?php
										$link       = $slide['link'];
										$link_color = array( 'color' => 'button-link-right--color-theme-blue-bright' );
										if ( $link ) {
											?>

											<div class="gallery-carousel__card_link-wrapper">
												<?php require dirname( __DIR__, 2 ) . '/components/button-link-right/template.php'; ?>
											</div>
										<?php } ?>
									</div><?php } ?>
								</div>
							</div>
						</div>
					</div> 
				<?php } ?>
			</div>
			<?php
			$slide_tags        = get_field( 'slides' );
			$slide_labels_list = array();
			if ( $slide_tags ) {
				foreach ( $slide_tags as $key => $item ) {
					$slide_labels_list[] = $item['tag_title'];
				}
			}

			$slide_labels_json = htmlspecialchars( json_encode( $slide_labels_list ), ENT_QUOTES, 'UTF-8' );

			if ( count( $slide_tags ) > 1 ) {
				?>
				<div class="swiper-pagination container" data-labels="<?php echo $slide_labels_json; ?>"></div>
			<?php } ?>
		</div>
	<?php } ?>
</section>
