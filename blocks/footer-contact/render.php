<?php

require_once realpath( __DIR__ ) . '/../utils/functions/hrc-calendar-api.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<section class="<?php echo get_classes( 'footer-contact', $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="container">
		<div class="footer-contact__wrapper grid-default">

			<?php echo get_field( 'headline' ) ? '<header class="footer-contact__headline t-d3">' . get_field( 'headline' ) . '</header>' : ''; ?>

			<?php if ( get_field( 'column_1' ) ) { ?>
				<div class="footer-contact__column">
					<?php echo get_field( 'column_1_header' ) ? '<div class="footer-contact__columnHeader">' . get_field( 'column_1_header' ) . '</div>' : ''; ?>
					<?php echo get_field( 'column_1_content' ) ? '<div class="footer-contact__columnContent wysiwyg__content">' . get_field( 'column_1_content' ) . '</div>' : ''; ?>
				</div>
			<?php } ?>

			<?php if ( get_field( 'column_2' ) ) { ?>
				<div class="footer-contact__column">
					<?php echo get_field( 'column_2_header' ) ? '<div class="footer-contact__columnHeader">' . get_field( 'column_2_header' ) . '</div>' : ''; ?>
					<?php echo get_field( 'column_2_content' ) ? '<div class="footer-contact__columnContent wysiwyg__content">' . get_field( 'column_2_content' ) . '</div>' : ''; ?>
				</div>
			<?php } ?>

			<?php if ( get_field( 'column_3' ) ) { ?>
				<div class="footer-contact__column">
					<?php echo get_field( 'column_3_header' ) ? '<div class="footer-contact__columnHeader">' . get_field( 'column_3_header' ) . '</div>' : ''; ?>
					<?php echo get_field( 'column_3_content' ) ? '<div class="footer-contact__columnContent wysiwyg__content">' . get_field( 'column_3_content' ) . '</div>' : ''; ?>
				</div>
			<?php } ?>

			<?php if ( get_field( 'social_media_show_social_media' ) ) { ?>
				<div class="footer-contact__column">
					
					<?php
						$has_social_media = get_field( 'social_media_show_social_media' );
						$social_media = get_field( 'social_media_social_media_link_overrides' ) ? get_field( 'social_media_social_media_link_overrides' ) : get_field( 'social_media_links', 'acf_site_options' );
						$social_media_options = array(
							'links' => $social_media,
							'option_new_tab' => get_field( 'social_media_new_tab' ),
						);
						if ( $has_social_media ) {
							?>
							<nav class="footer-contact__socialMedia" aria-label="Social Media Links">
								<?php
								require dirname( __DIR__, 2 ) . '/components/social-media/template.php';
								?>
							</nav>
							<?php
						}
						?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>