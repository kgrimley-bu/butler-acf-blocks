<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<div class="<?php echo get_classes( 'gallery-modal__container', $block ); ?>">
	<section class="gallery-modal" <?php echo get_anchor( $block ); ?>>
		<div class="gallery-modal__collage" id="<?php echo uniqid( 'collage-' ); ?>">
			<?php
			if ( get_field( 'images' ) ) {
				// Number of image slots to skip. This makes the collage on modals with a smaller number of images look cohesive.
				$image_list_spacing = floor( 12 / count( get_field( 'images' ) ) ) >= 2 ? 2 : 1;
				foreach ( get_field( 'images' ) as $key => $item ) {
					// only use the first 12 images
					if ( $key < 12 ) {
						$image_id = ( $key + 1 ) * $image_list_spacing;
						$image_url = $item['image']['sizes']['large'];
						$image_width = $item['image']['sizes']['large-width'];
						$image_height = $item['image']['sizes']['large-height'];
						$image_alt = $item['image']['alt'];

						$css_class = 'gallery-modal__collageImgWrap gallery-modal__collageImgWrap--' . $image_id;

						$strength = rand( 40, 100 );
						?>
						<button class="<?php echo $css_class; ?>" data-slideid="<?php echo $image_id; ?>" data-slidenum="<?php echo $key; ?>" tabindex="0">
							<?php
							echo wp_get_attachment_image(
								$item['image']['ID'],
								'medium',
								false,
								array(
									'class' => 'gallery-modal__collageImage',
								)
							);
							?>
						</button>
						<?php
					}
				}
			}
			?>
		</div>
		<div class="container gallery-modal__wrapper">
			<div class="gallery-modal__app">
				<div class="grid-default gallery-modal__app-wrapper">
					<?php if ( get_field( 'description' ) ) : ?>
						<p class="gallery-modal__headline t-h2">
							<?php the_field( 'description' ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php if ( get_field( 'link' ) ) : ?>
					<button
						type="button"
						class="gallery-modal__button--open" 
					>
						<?php the_field( 'link' ); ?>
					</button>
				<?php endif; ?>
				<div class="gallery-modal__dialog" id="galleryModal" aria-label="Gallery of Butler Images">
					<div class="gallery-modal__modal-wrapper">
						<div class="gallery-modal__overlay">
							<div class="gallery-modal__modal-content">
								<div class="swiper gallery-modal__swipper">
									<div class="swiper-wrapper">
										<?php if ( have_rows( 'images' ) ) : ?>
											<?php
											while ( have_rows( 'images' ) ) :
												the_row();
												?>
												<?php $image = get_sub_field( 'image' ); ?>
												<div class="swiper-slide">
													<div class="gallery-modal__slider-wrapper">
														<figure class="gallery-modal__slider-figure" aria-live="polite" aria-relevant="all">
															<img
																src="<?php echo esc_url( $image['url'] ); ?>"
																srcset="<?php echo esc_url( $image['url'] ); ?>"
																alt="<?php echo esc_attr( $image['alt'] ); ?>"
																class="gallery-modal__slider-img"
															>
															<figcaption class="gallery-modal__slider-caption">
																<span class="gallery-modal__slider-caption-text">
																	<?php if ( get_sub_field( 'caption' ) ) : ?>
																		<?php the_sub_field( 'caption' ); ?>
																	<?php endif; ?>
																</span>
															</figcaption>
														</figure>
													</div>
												</div>
											<?php endwhile; ?>
										<?php endif; ?>
									</div>
									<div class="swiper-pagination gallery-modal__pagination"></div>
									<button class="swiper-button-next gallery-modal__buttonFocus"><span class="sr-only">Next</span></button>
									<button class="swiper-button-prev gallery-modal__buttonFocus"><span class="sr-only">Previous</span></button>
								</div>
								<button class="gallery-modal__button--close gallery-modal__buttonFocus">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>