<?php
/**
 * Create a table of "events" happening at the HRC.
 */

// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- Variable name set externally

/**
 * Construct the markup for the HRC calendar.
 *
 * @param string $block_key The name for checking if this is the HRC calendar block. Not sure if we need this.
 *
 * @return array Contains the table markup for the display of the HRC calendar.
 */
function butler_hrc_block_view( $block_key ) {
	$block = array();
	if ( 'butlerHRC' == $block_key ) { // We only want to define the content of OUR block.
		$today = gmdate( 'Y-m-d' ) . 'T00:00:00'; // We Need Data For the three days.
		$tomorrow = gmdate( 'Y-m-d', strtotime( 'tomorrow' ) ) . 'T00:00:00';
		$two_tomorrow = gmdate( 'Y-m-d', strtotime( '+2 days' ) ) . 'T00:00:00';
		$rooms = get_hrc_rooms(); // We need an array of Rooms that are Standard and Not Combo.
		$output = '<table><thead><tr>' .
		'<th>Start Time</th>' .
				  '<th>End Time</th>' . // Egad this HTML is Ugly, but it's needed to make a table.
				  '<th>Event Name</th>' .
				  '<th>Location</th>' .
				  '</tr></thead><tbody>';
		$output .= '<tr><th colspan="4">' . gmdate( 'l, F d, Y', strtotime( $today ) ) . '</th></tr>' . format_data( get_hrc_bookings( $today ), $rooms ); // it's easier to request thrice than sort it all out once.
		$output .= '<tr><th colspan="4">' . gmdate( 'l, F d, Y', strtotime( $tomorrow ) ) . '</th></tr>' . format_data( get_hrc_bookings( $tomorrow ), $rooms );
		$output .= '<tr><th colspan="4">' . gmdate( 'l, F d, Y', strtotime( $two_tomorrow ) ) . '</th></tr>' . format_data( get_hrc_bookings( $two_tomorrow ), $rooms );
		$output .= '</tbody></table>';

		// Define the block content.
		$block['content'] = $output;
	}

	return $block;
}

/**
 * Get the upcoming bookings based on date
 *
 * @param string $date The date to get bookings.
 *
 * @return object Contains the booking data for the given day.
 */
function get_hrc_bookings( $date ) {
	$api_user = 'butlerapi';
	$api_password = 'D@nkoBlue2021';
	$url = 'https://butleru.emscloudservice.com/ems-api/service.asmx';

	try {
		$client = new SoapClient(
			$url . '?WSDL',
			array(
				'encoding' => 'utf-8',
				'SOAPAction' => 'http://DEA.EMS.API.Web.Service/GetBookings',
			)
		);
		$result = $client->GetBookings(
			array(
				'UserName' => $api_user,
				'Password' => $api_password,
				'StartDate' => $date,
				'EndDate' => $date,
				'ViewComboRoomComponents' => true,
				'Buildings' => array( 'int' => '26' ),
			)
		);
	} catch ( Exception $e ) {
		return $e->getMessage();// This error will appear in the Table so it'll help figure out what day went wrong.
	}

	$simple_result = simplexml_load_string( $result->GetBookingsResult );
	return $simple_result;
}

/**
 * Get rooms in the HRC.
 *
 * @return array Contains the room data from the HRC.
 */
function get_hrc_rooms() {
	$api_user = 'butlerapi';
	$api_password = 'D@nkoBlue2021';
	$url = 'https://butleru.emscloudservice.com/ems-api/service.asmx';

	try {
		$client = new SoapClient(
			$url . '?WSDL',
			array(
				'encoding' => 'utf-8',
				'SOAPAction' => 'http://DEA.EMS.API.Web.Service/GetRooms',
			)
		);
		$result = $client->GetRooms(
			array(
				'UserName' => $api_user,
				'Password' => $api_password,
				'Buildings' => array( 'int' => '26' ),
			)
		);
	} catch ( Exception $e ) {
		return $e->getMessage();
	}

	$simple_result = simplexml_load_string( $result->GetRoomsResult );
	$rooms = json_decode( json_encode( $simple_result ), true );
	$room_array = array();
	$rooms = $rooms['Data'];
	foreach ( $rooms as $room ) {
		if ( ! strcmp( 'Standard', $room['Classification'] ) ) {
			$room_array[ $room['Description'] ] = $room['ID'];
		}
	}
	return $room_array;
}

/**
 * Get the upcoming bookings based on date
 *
 * @param object $data The booking data for the given day.
 * @param array  $rooms The rooms in the HRC.
 *
 * @return string Contains the booking data for the given day.
 */
function format_data( $data, $rooms ) {
	$output = '';// Good Form.
	if ( is_object( $data ) ) {
		$data = (array) $data->children();
		$data = $data['Data'];
		usort( $data, 'sort_time' );
		$data = array_unique( $data, SORT_REGULAR );
		foreach ( $data as $booking ) {
			if ( -14 == $booking->StatusTypeID && in_array( $booking->RoomID, $rooms ) ) {
				$output .= '<tr>';
				$output .= '<td>' . gmdate( 'g:i A', strtotime( $booking->TimeEventStart ) ) . '</td>';
				$output .= '<td>' . gmdate( 'g:i A', strtotime( $booking->TimeEventEnd ) ) . '</td>';
				$output .= "<td>{$booking->EventName}</td>";
				$output .= "<td>{$booking->RoomDescription}</td>";
				$output .= '</tr>';
			}
		}
	} else {
		$output .= "<tr><td>$data</td></tr>";
	}
	return $output;
}

/**
 * Callback function for compairing two times.
 *
 * @param object $a Object of data containing the time to be compared.
 * @param object $b Object of data containing the time to be compared.
 *
 * @return int Comparison result for usort function.
 */
function sort_time( $a, $b ) {
	$time1 = strtotime( $a->TimeEventStart );
	$time2 = strtotime( $b->TimeEventStart );

	if ( $time1 == $time2 ) {
		return 0;
	}

	return ( $time1 > $time2 ? 1 : -1 );
}

// phpcs:enable