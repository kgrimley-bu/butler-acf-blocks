<?php
/**
 * The functions referenced below live in the init.php file next to this one
 */

$hero_image_id  = $block['data']['hero_image'];
$hero_image_url = '';

if ( $hero_image_id ) {
	$hero_image_url = wp_get_attachment_image( $hero_image_id, 'full' );
}
$hero_headline           = nl2br( $block['data']['hero_headline'] ) ?: '';
$homepage_url            = get_home_url();
$program_type_terms      = wp_get_post_terms( $post_id, 'program_type' );
$degree_type_terms_array = wp_get_post_terms( $post_id, 'degree_type' );

$degree_type_term = get_term_info( $degree_type_terms_array, '' );

$major_term          = get_term_info( $program_type_terms, 'Major' );
$minor_term          = get_term_info( $program_type_terms, 'Minor' );
$three_year          = get_term_info( $program_type_terms, '3-Year Degree' );
$pre_professional    = get_term_info( $program_type_terms, 'Pre-Professional' );
$dual_degree         = get_term_info( $program_type_terms, 'Dual Degree' );
$education_licensure = get_term_info( $program_type_terms, 'Education Licensure' );

$classes = array( 'program-hero', 'alignfull' );

if ( empty( $callout_card_group_background_image ) ) {
	$classes[] = empty( $hero_image_url ) ? 'no-image' : '';
}
?>
<section class="<?php echo esc_attr( join( ' ', $classes ) ); ?>">
	<div class="container">
		<div class="back-row">
			<a class="back-row-link" href="<?php echo esc_url( $homepage_url ); ?>">Explore All Programs</a>
		</div>
		<div class="inner">
			<div class="content">
				<h1><?php echo $hero_headline; ?></h1>
				<div class="program-degree-container">
					<?php
					writeTermIfExists( $major_term );
					writeTermIfExists( $minor_term );
					writeTermIfExists( $three_year );

					writeEachTermInArray( $degree_type_terms_array );

					writeTermIfExists( $pre_professional );
					writeTermIfExists( $dual_degree );
					writeTermIfExists( $education_licensure );
					?>
				</div>
			</div>
			<div class="image-container">
				<?php echo $hero_image_url; ?>
			</div>
		</div>
	</div>
</section>

<?php
// exit();
?>
