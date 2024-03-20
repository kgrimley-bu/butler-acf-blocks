<?php
require_once realpath( __DIR__ ) . '/../utils/classes/APIRequest.php';

/**
 * Retrieve News Categories
 *
 * Query the API located at https://stories.butler.edu and return the data to be used in the News Block under `Categories`.
 *
 * @return array Returns an array filled with the categories retrieved from the API response.
 */
function get_news_cats() {
	$news = new APIRequest();
	$news_cats = $news->get_news_data( 'per_page=100', 'categories' );

	$return_data = array();
	$return_data[''] = 'All Categories';

	if ( $news_cats !== false ) {
		foreach ( $news_cats->body as $key => $item ) {
			$return_data[ $item->id ] = $item->name;
		}
	}
	return $return_data;
}

/**
 * Set supplied ACF field's choices populated by `Category` data.
 *
 * Populates the Categories field in the ACF menu (when clicking on the News block), allowing the user to specify a category.
 *
 * @param array $field ACF field with choices to populate.
 * @return array ACF field with choices populated by category data.
 */
function acf_news_categories( $field ) {
	$cat_data = get_news_cats();
	$field['choices'] = $cat_data;
	return $field;
}
add_filter( 'acf/load_field/name=news_category', 'acf_news_categories' );

/**
 * Retrieve News Tags
 *
 * Query the API located at https://stories.butler.edu and return the data to be used in the News Block under `Tags`.
 *
 * @return array Returns an array filled with the tags retrieved from the API response.
 */
function get_news_tags() {

	$news = new APIRequest();
	$news_tag_data = $news->get_news_data( 'per_page=100', 'tags' );

	$return_data = array();
	$return_data[''] = 'All Tags';

	$pages = $news_tag_data->headers->{ 'X-WP-TotalPages' };

	for ( $i = 1; $i <= $pages; $i++ ) {
		$news_tag_data = $news->get_news_data( 'per_page=100&page=' . $i, 'tags' );
		if ( $news_tag_data !== false ) {
			foreach ( $news_tag_data->body as $key => $item ) {
				$return_data[ $item->id ] = $item->name;
			}
		}
	}
	return $return_data;
}

/**
 * Set supplied ACF field's choices populated by `Tag` data.
 *
 * Populates the Categories field in the ACF menu (when clicking on the News block), allowing the user to specify a tag.
 *
 * @param array $field ACF field with choices to populate.
 * @return array ACF field with choices populated by tag data.
 */
function acf_news_tags( $field ) {
	$tag_data = get_news_tags();
	$field['choices'] = $tag_data;
	return $field;
}
add_filter( 'acf/load_field/name=news_tags', 'acf_news_tags' );
