<?php
require_once realpath( __DIR__ ) . '/../utils/functions/has_page_menu.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$image_option = get_field( 'hero_image' ) ? 'hero-standard--hasImage' : 'hero-standard--noImage';
$headline = get_field( 'headline' ) ? get_field( 'headline' ) : $args['headline'];
$color = get_field( 'headline_highlight' ) ? get_field( 'headline_highlight' )['value'] : '';
?>

<section class="<?php echo get_classes( 'hero-standard ' . $image_option, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="container hero-standard__container">
		<?php
		  $headline = array(
			  'text' => $headline,
			  'color_value' => $color,
			  'size' => 'h1',
		  );
		  require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
			?>
		<?php if ( get_field( 'sub_headline' ) || get_field( 'sub_headline_description' ) ) { ?>
			<div class="hero-standard__subHeadlineDescription">
				<p class="hero-standard__subHeadline">
					<?php the_field( 'sub_headline' ); ?>
				</p>
				<div class="hero-standard__subHeadlineDescriptionText">
					<?php the_field( 'sub_headline_description' ); ?>
				</div>
			</div>
		<?php } ?>
		<?php if ( get_field( 'hero_buttons' ) ) { ?>
			<ul class="hero-standard__buttonList">
				<?php
				foreach ( get_field( 'hero_buttons' ) as $item ) {

					$link_title = empty( $item['button_title'] ) ? $item['link']['title'] : $item['button_title'];
					$link_url = empty( $item['button_url'] ) ? $item['link']['url'] : $item['button_url'];
					$link_target = ! empty( $item['link']['target'] ) ? 'target="' . $item['link']['target'] . '"' : '';

					?>
					<li class="hero-standard__buttonListItem">
						<a href="<?php echo $link_url; ?>" class="button-solid hero-standard__buttonListButton" <?php echo $link_target; ?>>
							<span class="button-solid__label">
								<?php echo $link_title; ?>
							</span>
						</a>      
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
	<div class="hero-standard__extraContent">
		<?php
			$has_wysiwyg_block_class = has_page_menu( $post_id, $block['name'] ) ? 'hero-standard__socialMedia--hasWysiwyg' : '';
			$has_social_links = get_field( 'social_media_links' );

		if ( $has_social_links ) {
			$social_media = get_field( 'social_media_link_overrides' ) ? get_field( 'social_media_link_overrides' ) : get_field( 'social_media_links', 'acf_site_options' );

			if ( $social_media ) {
				?>
					<nav class="container" aria-label="Social media links" aria-label="Social Media Links">
						<div class="hero-standard__socialMedia <?php echo $has_wysiwyg_block_class; ?>">
							<?php
							$social_media_options = array(
								'links' => $social_media,
								'option_new_tab' => get_field( 'social_media_new_tab' ),
							);
							require dirname( __DIR__, 2 ) . '/components/social-media/template.php';
							?>
						</div>
					</nav>
				<?php
			}
		}
		?>
		<?php
		if ( get_field( 'hero_image' ) ) {
			echo wp_get_attachment_image(
				get_field( 'hero_image' ),
				array( '1600' ),
				false,
				array(
					'class' => 'hero-standard__image',
				)
			);
		}
		?>
	</div>
</section>
