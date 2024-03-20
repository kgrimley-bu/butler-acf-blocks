<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<div class="<?php echo get_classes( 'ticker__container', $block ); ?>">
	<?php if ( get_field( 'ticker_text' ) ) { ?>
		<div class="ticker__ticker-wrap" data-paused="false">
			<div class="ticker__tickerStrip"  >
				<div class="ticker__ticker-icon-wrapper">    
					<svg class="ticker__ticker-icon--pause" aria-hidden="true" focusable="false">
						<use xlink:href="<?php echo plugin_dir_url( __DIR__ ) . '../assets/images/plyr.svg#plyr-play'; ?>" />
					</svg>
					<svg class="ticker__ticker-icon--play" aria-hidden="true" focusable="false">
						<use xlink:href="<?php echo plugin_dir_url( __DIR__ ) . '../assets/images/plyr.svg#plyr-pause'; ?>" />
					</svg>
					<span class="plyr__sr-only">Pause/Play Ticker Title</span>
				</div>
				<div class="ticker__ticker" >
					<?php
					if ( get_field( 'ticker_text' ) ) :
							// To ensure the ticker repeats properly and doesn't have a bunch of white space,
							// we check the length of the entered ticker string and increase the number of
							// ticker items accordingly.
							$tickerText = get_field( 'ticker_text' );
							$itemCount = 10;
						if ( strlen( $tickerText ) > 0 && strlen( $tickerText ) <= 2 ) {
							$itemCount = 80;
						} elseif ( strlen( $tickerText ) > 2 && strlen( $tickerText ) <= 3 ) {
							$itemCount = 60;
						} elseif ( strlen( $tickerText ) > 3 && strlen( $tickerText ) <= 6 ) {
							$itemCount = 40;
						} elseif ( strlen( $tickerText ) > 6 && strlen( $tickerText ) <= 8 ) {
							$itemCount = 30;
						}
						?>
						<?php for ( $i = 0; $i < $itemCount; $i++ ) : ?>
							<p class="ticker__ticker-item t-h3">
								<?php the_field( 'ticker_text' ); ?>
							</p>
						<?php endfor; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>