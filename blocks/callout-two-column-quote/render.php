<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
?>

<?php
$rows = get_field( 'callout_two_column_quote' );
if ( $rows ) :
	?>
	<section class="<?php echo get_classes( 'callout-two-column-quote', $block ); ?>" <?php echo get_anchor( $block ); ?>>
		<?php
		foreach ( $rows as $key => $row ) {

			$link        = $row['link'];
			$link_url    = ! empty( $link ) ? $link['url'] : '';
			$link_target = ( ! empty( $link ) && $link['target'] == '_blank' ) ? 'target="_blank"' : '';

			$accent_color = $row['kicker']['color_value'];

			if ( $accent_color == 'primary' ) {
				$accent_color = 'yellow';
			}
			if ( $accent_color == 'none' ) {
				$accent_color = 'gray';
			}

			?>
			<div class="callout-two-column-quote__item">
				<div class="container">
					<div class="grid-default callout-two-column-quote__wrapper">
						<div class="callout-two-column-quote__text <?php echo ( $row['quote_align'] == 'left' ) ? 'callout-two-column-quote__text--left' : 'callout-two-column-quote__text--right'; ?>">
							<?php
							$kicker = $row['kicker'];
							if ( $kicker ) :
								?>
								<p
									class="t-d3 callout-two-column-quote__kicker"
									style="color: var(--color-theme-<?php echo $accent_color; ?>)"
								>
									<?php echo $kicker['text']; ?>
								</p>
							<?php endif; ?>
							<?php
							$heading = $row['heading'];
							if ( $heading ) :
								?>
								<a href="<?php echo $link_url; ?>"
									class="t-h3 callout-two-column-quote__heading"
									style="--hover-color: var(--color-theme-<?php echo $accent_color; ?>)">
									<?php echo $heading; ?>
								</a>
							<?php endif ?>
							<div class="callout-two-column-quote__quote <?php echo ( $row['quote_align'] == 'left' ) ? 'callout-two-column-quote__quote--left' : ''; ?>">
								<?php
								$quote = $row['quote'];
								$attribution = $row['attribution'];
								if ( $quote ) {
									?>
									<blockquote class="callout-two-column-quote__quote-text t-p1">
										<?php echo $quote; ?>
									</blockquote>
									<?php if ( $attribution ) { ?>
										<p style="font-weight: 400; line-height: 1.1; font-size: 18px; color: white;">
											<?php echo $attribution; ?>
										</p>
									<?php } ?>
								<?php } ?>
								<?php

								$link_color = array(
									'color' => 'button-link-right--color-theme-white button-link-right--hover-color-theme-' . $accent_color,
								);
								if ( ! empty( $link ) ) {
									?>
									<div class="callout-two-column-quote__links">
										<?php require dirname( __DIR__, 2 ) . '/components/button-link-right/template.php'; ?>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php
						$image = $row['image'];
						if ( ! empty( $image ) ) :
							?>
							<div class="callout-two-column-quote__media <?php echo ( $row['quote_align'] == 'left' ) ? 'callout-two-column-quote__media--right' : 'callout-two-column-quote__media--left'; ?>">
								<img
									src="<?php echo esc_url( $image['url'] ); ?>"
									srcset="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( $image['alt'] ); ?>"
									class="callout-two-column-quote__media-image"
								>
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		<?php } ?>
	</section>
<?php endif; ?>
