<?php
/**
 * Template part for displaying Search Results
 */

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

// $init_index = htmlentities( json_encode( get_field( 'indices' )[ 0 ],JSON_HEX_QUOT ), ENT_QUOTES );
// $all_indices = htmlentities( json_encode( get_field( 'indices' ),JSON_HEX_QUOT ), ENT_QUOTES );
$init_index = get_field( 'indices' )[0];
$all_indices = get_field( 'indices' );

?>

<section class="<?php echo get_classes( 'search-results', $block ); ?>">
	<div class="container">
		<?php require dirname( __DIR__, 2 ) . '/components/search/template.php'; ?>
	</div>
</section>