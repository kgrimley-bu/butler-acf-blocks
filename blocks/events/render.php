<?php
require_once realpath( __DIR__ ) . '/../utils/classes/APIRequest.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

// Load values and assign defaults.
$event_title = get_field( 'section_title' ) ?: '';
$event_cat   = get_field_object( 'events_categories' ) ? get_field_object( 'events_categories' ) : '';
$event_tag   = get_field_object( 'events_tags' ) ? get_field_object( 'events_tags' ) : '';

$new_query = array();
$value     = $event_cat != '' ? $event_cat['value'] : '';

if ( $value === '' || $event_cat['choices'][ $value ] === 'All Categories' ) {
	$new_query['category'] = '';
} else {
	$new_query['category'] = $event_cat['choices'][ $value ];
}

$value = $event_tag != '' ? $event_tag['value'] : '';

if ( is_array( $event_tag ) ) {
	// If the `Events Tags` ACF field isn't blank/invalid and not set to `All Tags`
	if ( array_key_exists( $value, $event_tag['choices'] ) && $event_tag['choices'][ $value ] != 'All Tags' ) {
		$new_query['tags'] = $event_tag['choices'][ $value ];
	} else {
		$new_query['tags'] = '';
	}
}

$new_query_url = '&' . http_build_query( $new_query );

// GET EVENT API DATA.
$events       = new APIRequest();
$event_return = $events->get_event_data( 'events?pageSize=4' . $new_query_url );

if ( $event_return !== false && sizeof( $event_return ) > 0 ) {
	$event_data = array_slice( $event_return, 0, 4 );

	?>
	<section class="<?php echo get_classes( 'events', $block ); ?>" <?php echo get_anchor( $block ); ?>>
		<div class="container events__container">
			<div class="events__heading">
				<?php
				$label   = '';
				$url_cat = '';
				$field   = get_field_object( 'events_categories' );
				$value   = get_field( 'events_categories' );
				if ( 'All Categories' !== $field['choices'][ $value ] ) {
					$label   = $field['choices'][ $value ];
					$url_cat = '?refinementList%5Bcategory%5D%5B0%5D=' . urlencode( $label );
				}
				?>
				<a href="https://events.butler.edu/events/search<?php echo $url_cat; ?>"
				   target="_blank"
				   class="events__moreButton events__moreLink">Browse All <?php echo $label; ?> Events</a>
				<?php if ( $event_title !== '' ) { ?>
					<header class="t-h3 events__headline"><?php echo $event_title; ?></header>
				<?php } ?>
			</div>

			<div class="events__wrapper grid-default">
				<?php
				foreach ( $event_data as $key => $event ) {
					if ( '7' !== get_field( 'events_categories' ) ) {
						$title = $event->attributes->title;

						date_default_timezone_set( 'America/Indiana/Indianapolis' );

						$date       = date( 'D F j, Y \a\t g:ia', strtotime( $event->attributes->event_start ) );
						$short_date = date( 'n/j/y', strtotime( $event->attributes->event_start ) );

						$location = $event->attributes->region;

						$url = 'https://events.butler.edu/event/' . $event->attributes->slug;

						$link_prefix = ( $is_preview == true ) ? '<span class="events__cardLink grid-default">' : '<a href="' . $url . '"target="_blank" class="events__cardLink grid-default">';
						$link_suffix = ( $is_preview == true ) ? '</span>' : '</a>';

						?>

						<article class="events__card">
							<?php echo $link_prefix; ?>
							<header class="t-h5 events__cardTitle"><?php echo $title; ?></header>
							<time class="t-h5 events__date"><?php echo $short_date; ?></time>
							<p class="events__meta"><?php echo $location; ?> / <?php echo $date; ?></p>
							<?php echo $link_suffix; ?>
						</article>

						<?php
					} else {
						$title      = $event->attributes->title;
						$image_url  = $event->attributes->image;
						$sponsor    = $event->attributes->sponsor_organization;
						$game_title = $event->attributes->summary;

						date_default_timezone_set( 'America/Indiana/Indianapolis' );

						$date_time  = date( 'F j \| g:i A', strtotime( $event->attributes->event_start ) );
						$watch_date = date( 'F j', strtotime( $event->attributes->event_start ) );

						$location = $event->attributes->region;

						$url = 'https://events.butler.edu/event/' . $event->attributes->slug;

						$link_prefix = ( $is_preview == true ) ? '<span class="events__cardLink grid-default">' : '<a href="' . $url . '" class="events__cardLink grid-default" style="padding-left: 0; padding-right: 0;" >';
						$link_suffix = ( $is_preview == true ) ? '</span>' : '</a>';

						?>
						<article class="events__card esports-events__card"
								style="background: #f5f7f6 url(/wp-content/themes/butler/src/assets/img/esports-event-background.png) no-repeat; color: var(--color-blue-butler); text-align: center; background-position: center top;">
							<?php echo $link_prefix; ?>
							<header class="t-h5 events__meta events__cardTitle"
									style="padding-top: 1rem; color: var(--color-blue-butler);"><?php echo $date_time; ?></header>
							<p class="events__meta"
								style="color: var(--color-blue-butler);"><?php echo $sponsor; ?></p>
							<img class="events__meta" src="<?php echo $image_url; ?>"
								style="max-width: 80%; margin-left: auto; margin-right: auto;"/>
							<div class="t-h5 events__meta"
								style="color: var(--color-blue-butler); text-transform: uppercase; display: grid; grid-template-columns: auto 1fr auto; column-gap: 1rem;">
								<div class="bottom-circut-container">
									<img src="/wp-content/themes/butler/src/assets/img/esports-event-bottom-circut.png"
										style="transform: scaleX(-1.0); height: 100%; object-fit: cover; object-position: left;">
								</div>
								<p style="width: max-content; max-width: 25vw;"><?php echo $game_title; ?></p>
								<div class="bottom-circut-container">
									<img src="/wp-content/themes/butler/src/assets/img/esports-event-bottom-circut.png"
										style=" height: 100%; object-fit: cover; object-position: left;">
								</div>
							</div>
							<p class="t-d6 events__meta"
								style="color: var(--color-blue-butler); text-transform: capitalize; font-family: var(--font-family-base); font-weight: 400; border-bottom: 2px solid var(--color-blue-bright); padding-bottom: 2px; width: fit-content; margin-right: auto; margin-left: auto;">
								Watch <?php echo $watch_date; ?></p>
							<?php echo $link_suffix; ?>
						</article>
						<?php
					}
				}
				?>
			</div>
			<div class="visible-mobile">
				<a href="https://events.butler.edu/events/search<?php echo $url_cat; ?>"
					class="events__moreButton events__moreLink">Browse All <?php echo $label; ?> Events</a>
			</div>
		</div>
	</section>
	<?php
} else {
	// fallback for preview.
	if ( $is_preview == true ) {
		?>
		<div class="message">
			<p>No events are found in this category.</p>
		</div>
	<?php }
} ?>
