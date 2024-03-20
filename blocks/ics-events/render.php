<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

if ( ! function_exists( 'create_ics_download_button' ) ) {
	/**
	 * Creates the download button and `.ics` file for the calendar.
	 * If there are specified events, just download those.
	 * Otherwise, download the whole calendar.
	 *
	 * @param array  $aie_event_list The list of *all* events.
	 * @param string $aie_block_id The unique ID of the block.
	 */
	function create_ics_download_button( $aie_event_list, $aie_block_id ) {
		return "
            <button aria-label='download all checked events' id='{$aie_block_id}_aie_download_button' class='aie-row-item aie-download-button'>Download Calendar <span class='dashicons-before dashicons-download'></span></button>
                <script type=\"text/javascript\">
                    ( function ($) {
                        $( '#{$aie_block_id}_aie_download_button' ).click( function() {
                            let icsMSG = 'BEGIN:VCALENDAR\\nVERSION:2.0\\nPRODID:-//Butler University//NONSGML v1.0//EN\\nX-WR-CALNAME:" . get_field( 'aie_calendar_name' ) . "';
                            let index = 0;
                            // Check to see if the user specified any events to download. If they did not, download the whole calendar.
                            let any_events_checked = false;
                            " . json_encode( $aie_event_list ) . ".forEach( ( aie_event ) => {
                                if( document.getElementById( '{$aie_block_id}_aie_event_checkbox_' + index ).checked ) {
                                    any_events_checked = true;
                                }
                                index += 1;
                            }); // End forEach loop
                            index = 0;
                            " . json_encode( $aie_event_list ) . ".forEach( ( aie_event ) => {
                                if( document.getElementById( '{$aie_block_id}_aie_event_checkbox_' + index ).checked || ! any_events_checked ) {
                                    icsMSG += '\\nBEGIN:VEVENT\\nUID:" . rand() . "\\nDTSTAMP:' + aie_event[ 'aie_event_start' ] + '\\nDTSTART:' + aie_event[ 'aie_event_start' ] + 'Z\\nDTEND:' + 
                                    aie_event[ 'aie_event_end' ] + 'Z\\nLOCATION:' + aie_event[ 'aie_event_location' ] + '\\nSUMMARY:' + aie_event[ 'aie_event_name' ] + '\\nEND:VEVENT';
                                }
                                index += 1;
                            });
                            icsMSG += '\\nEND:VCALENDAR';
                            /* Create a blank anchor tag, set the href to the ics file data, and simulate a click to trigger download. */
                            let hidden_download_button = document.createElement( 'a' );
                            hidden_download_button.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent( icsMSG ) );
                            hidden_download_button.setAttribute( 'download', 'calendar.ics' );
                            hidden_download_button.click();
                        }); //End .click
                    })(jQuery);
                </script>
            ";
	}
}

if ( ! function_exists( 'create_add_to_download_checkmark' ) ) {
	/**
	 * Creates the checkbox for each event to add to the download.
	 *
	 * @param string $aie_event_id The unique ID of the event.
	 * @param string $aie_block_id The unique ID of the block.
	 */
	function create_add_to_download_checkmark( $aie_event_id, $aie_block_id ) {
		return "<form class='aie-row-item'>
                        <label> 
                            <input class='aie-checkbox' type='checkbox' aria-label='add this event to calendar download' id='{$aie_block_id}_aie_event_checkbox_{$aie_event_id}'/> 
                        </label>
                    </form>";
	}
}

if ( ! function_exists( 'create_aie_event_row' ) ) {
	/**
	 * Creates the row for each event.
	 *
	 * @param array  $aie_event The event data.
	 * @param string $aie_event_id The unique ID of the event.
	 * @param string $aie_block_id The unique ID of the block.
	 */
	function create_aie_event_row( $aie_event, $aie_event_id, $aie_block_id ) {
		// Checking to see if it's an empty row...
		if ( ! $aie_event['aie_event_start'] || ! $aie_event['aie_event_name'] ) {
			return '';
		}

		$start_date_formatted = date_format( new DateTime( $aie_event['aie_event_start'] ), 'M jS, g:i A' );
		$end_date_formatted = ( $aie_event['aie_event_end'] ? date_format( new DateTime( $aie_event['aie_event_end'] ), 'g:i A' ) : '' );

		return "<div class='aie-flex-container aie-flex-row " . ( /* Check if we need to apply the different colored background */ $aie_event_id % 2 == 0 ? 'aie-row-background' : '' ) . "'>
                        <p class='aie-row-item aie-date'>"
						. $start_date_formatted . ( $aie_event['aie_event_end'] && $start_date_formatted != $end_date_formatted ? ' to ' . $end_date_formatted : '' ) .
					"</p>
						<p class='aie-row-item aie-row-title aie-title'>" . $aie_event['aie_event_name'] . "</p>
						<p class='aie-row-item aie-row-title aie-title'>" . $aie_event['aie_event_location'] . "</p>
                        <p class='aie-row-item aie-row-description aie-description'>"
						. ( $aie_event['aie_event_description'] ? $aie_event['aie_event_description'] : $aie_event['aie_event_name'] ) .
					'</p>'
					. create_add_to_download_checkmark( $aie_event_id, $aie_block_id ) .
				'</div>';
	}
}

	$aie_block_id = rand();
	// See ACF Fields for field options... Name = aie_event_repeater

	// Get the field from ACF
	$aie_event_list = get_field( 'aie_event_list' );
	$aie_event_row_holder = '';

	// $aie_event_id also corresponds to the spot in the array the event resides.
	$aie_event_id = 0;

	// Create each row for each entry in ACF
if ( $aie_event_list ) {
	foreach ( $aie_event_list as $aie_event ) {

		$aie_event_row_holder .= create_aie_event_row( $aie_event, $aie_event_id, $aie_block_id );
		$aie_event_id += 1;
	}
}
?>

<div class="<?php echo get_classes( 'aie-flex-container aie-flex-column', $block ); ?>">
	<p>For a single .ics file with all the below listed events click the Download Calendar button. For only some of the events just tick the checkbox for the ones you want and then click the Download Calendar button.</p>
	<?php echo $aie_event_row_holder . create_ics_download_button( $aie_event_list, $aie_block_id ); ?>
</div>

