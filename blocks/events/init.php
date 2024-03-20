<?php
require_once realpath( __DIR__ ) . '/../utils/classes/APIRequest.php';

/**
 * Gets all event **tags** from the **Events API** and refactors them into
 * an **ACF-compatable** array.
 *
 * @return Array An **ACF-compatable** array filled with **tags**
 * to be used when dynamically populating the fields in the *block editor*.
 */
function get_events_tags() {
	$events = new APIRequest();
	$events_tags = $events->get_event_data( 'tags' );
	$return_data = array();
	$return_data['all'] = 'All Tags';

	if ( $events_tags !== false ) {
		foreach ( $events_tags as $key => $item ) {
			$return_data[ $item->id ] = $item->attributes->name;
		}
	}

	return $return_data;
}

/**
 * Gets all event **categories** from the **Events API** and refactors them into
 * an **ACF-compatable** array.
 *
 * @return Array An **ACF-compatable** array filled with **categories**
 * to be used when dynamically populating the fields in the *block editor*.
 */
function get_events_cats() {
	$events = new APIRequest();
	$event_data = $events->get_event_data( 'categories' );
	$return_data = array();
	$return_data['all'] = 'All Categories';

	if ( $event_data !== false ) {
		foreach ( $event_data as $key => $item ) {
			$return_data[ $item->id ] = $item->attributes->name;
		}
	}

	return $return_data;
}

/**
 * Sets the passed-in **ACF Field** to ***Category*** data from the **Events API**.
 *
 * @param Array $field A valid **ACF Field** (typically, a *chooser* will be passed here) to set its choices.
 *
 * @return Array The **ACF Field** with its choices set to all **Categories** recieved from the **API**.
 */
function acf_events_categories( $field ) {
	$cat_data = get_events_cats();
	$field['choices'] = $cat_data;
	return $field;
}

/**
 * Sets the passed-in **ACF Field** to ***Tag*** data from the **Events API**.
 *
 * @param Array $field A valid **ACF Field** (typically, a *chooser* will be passed here) to set its choices.
 *
 * @return Array The **ACF Field** with its choices set to all **Tags** recieved from the **API**.
 */
function acf_events_tags( $field ) {
	$tag_data = get_events_tags();
	$field['choices'] = $tag_data;
	return $field;
}

add_filter( 'acf/load_field/name=events_categories', 'acf_events_categories' );

add_filter( 'acf/load_field/name=events_tags', 'acf_events_tags' );
