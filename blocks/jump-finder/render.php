<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<section class="<?php echo get_classes( 'finder', $block ); ?>" <?php echo get_anchor( $block ); ?> <?php echo $data_attr; ?>>
	<div class="finder__grid container">
		<div class="finder__video-wrapper">
			<?php 
				if ( get_field( 'video') ) { 
				$video = get_field( 'video' );
				$poster = get_field( 'video_poster' );
			?>
				<div class="finder__video plyr__video-embed">
					<video playsinline muted poster loop class="finder__video-plyr-mp4 jump-finder-video-plyr-mp4" data-poster="<?php echo ! empty($poster) ? $poster['url'] : '' ?>">
						<source src="<?php echo $video ?>" type="video/mp4">
					</video>
				</div>
			<?php } ?>
		</div>
		<div class="finder__image-wrapper">
			<?php
				$image = get_field('image');
				if ( ! empty( $image ) ) {
			?>
				<img 
					src="<?php echo esc_url( $image['url'] ); ?>" 
					srcset="<?php echo esc_url( $image['url'] ); ?>"
					alt="<?php echo esc_attr( $image['alt'] ); ?>"
					class="finder__image"
				>

			<?php } ?>
		</div>
		<div class="finder__headline-wrapper">
			<?php 
				$headline = get_field( 'headline' );
				if ( $headline['title'] !== '' ) { 
					$headline = array(
						'text' => $headline['title'],
						'color_value' => $headline['color_value'],
						'size' => 'h2',
					);
					require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
				?>
			<?php } ?>
		</div>
		<div class="finder__links-wrapper">
			<?php 
				$field = get_field( 'field' ); 
				if ( $field ) {
			?>
				<?php 
					$image = $field['image'];
					if ( ! empty( $image ) ) {
				?>
					<div class="finder__links-bg-image--overlay color-overlay color-overlay--blue-bright">
					
						<img 
							src="<?php echo esc_url( $image['url'] ); ?>" 
							srcset="<?php echo esc_url( $image['url'] ); ?>"
							alt="<?php echo esc_attr( $image['alt'] ); ?>"
							class="finder__links-bg-image color-overlay__media"
						>

					</div>
				<?php } ?>
					<div class="finder__dropdown">
						<?php 
						if ( $field['headline'] ) { 

							?>
							<h2 class="finder__dropdown-headline t-h5">
								<?php echo $field['headline']; ?>
							</h2>
						<?php } ?>
						<?php $items = $field['items']; ?>
						<div id="accordionGroup" class="accordion">
							<h3>
								<button type="button"
								aria-expanded="false"
								class="accordion-trigger finder__dropdown-button"
								aria-controls="sect1"
								id="accordion1id">
									<span class="accordion-title">
										Explore Your Options and Browse Resources
										<span class="accordion-icon"></span>
									</span>
								</button>
							</h3>
							<div id="sect1"
							role="region"
							aria-labelledby="accordion1id"
							class="accordion-panel" hidden>
							<div>
								<ul class="finder__dropdown-ul">
									<?php foreach ( $items as $item ) { ?>
										<li class="finder__dropdown-li">
											<a href="<?php echo $item['link']['url']; ?>" class="finder__dropdown-a">
												<?php echo $item['link']['title']; ?>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
							</div>  
						</div>
					</div>
				<?php } ?>
		</div>
		<?php if ( get_field( 'kicker' ) ) { ?>
		<aside class="finder__accentText col-span-12">
			<span class="finder__accentText--left"><?php echo get_field( 'kicker' ); ?></span>
			<span class="finder__accentText--right"><?php echo get_field( 'kicker' ); ?></span>
		</aside>
		<?php } ?>
	</div>
</section>
