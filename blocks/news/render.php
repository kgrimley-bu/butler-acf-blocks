<?php
/**
 * Template part for displaying News
 */

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
require_once realpath( __DIR__ ) . '/../utils/classes/APIRequest.php';
require_once realpath( __DIR__ ) . '/../utils/functions/image_set.php';

// Load values and assign defaults.
$filter = is_null( get_field( 'filter_stories' ) ) ? 'categories' : get_field( 'filter_stories' );

$title = get_field( 'section_title' ) ?: '';

// Get which pieces of info to show on articles
$show_photo   = get_field( 'show_photo' );
$show_title   = get_field( 'show_title' );
$show_date    = get_field( 'show_date' );
$show_excerpt = get_field( 'show_excerpt' );

// build query string for cats and tags
$new_query = array();

$new_query['categories'] = get_field( 'news_category' ) ? get_field( 'news_category' ) : null;
$new_query['tags']       = get_field( 'news_tags' ) ? get_field( 'news_tags' ) : null;

$new_query_url = '&' . http_build_query( $new_query );


// NEWS API
$news_request = new APIRequest();
$news_data    = $news_request->get_news_data( 'per_page=3' . $new_query_url );

if ( $news_data->headers->{'X-WP-Total'} > 0 && count( $news_data->body ) > 0 ) {

	?>

	<section class="<?php echo get_classes( 'news', $block ); ?>" <?php echo get_anchor( $block ); ?>>
		<div <?php echo "class='container news__wrapper'"; ?> >
			<header class="news__heading col-span-12 flex justify-between items-end">
				<?php if ( $title !== '' ) { ?>
					<h2 class="wysiwyg-content"><?php echo $title; ?></h2>
				<?php } ?>

				<?php if ( ! $is_preview ) { ?>
					<a href="https://stories.butler.edu" class="events__moreButton events__moreLink">View All</a>
				<?php } ?>
			</header>

			<div class="news__cards swiper-wrapper">
				<?php
				foreach ( $news_data->body as $key => $story ) {

					$link    = $story->link;
					$title   = $story->title->rendered;
					$excerpt = $story->excerpt->rendered;
					$date    = date( 'F j, Y', strtotime( $story->date ) );

					$has_image = $story->{'_embedded'}->{'wp:featuredmedia'}[0];

					if ( ! isset( $has_image->code ) ) {
						$img_tag = '<div class="news_cardImgWrapper">' . image_set( $story->{'_embedded'}->{'wp:featuredmedia'}[0], 'news__cardImg' ) . '</div>';
					} else {
						$img_tag = '<div class="news_cardImgWrapper"></div>';
					}

					$link_tag = $is_preview ? 'span' : 'a';

					?>
				<article class="news__card 
					<?php
					if ( ! $show_excerpt ) {
						echo 'news__card_no_excerpt';
					}
					?>
				 swiper-slide" id="card-<?php echo $key; ?>">
					<<?php echo $link_tag; ?> href="<?php echo $link; ?>">
					<?php
					if ( $show_photo ) {
						echo $img_tag;
					}
					?>
					<div class="news__cardMeta">
						<?php if ( $show_date ) { ?>
							<time class="t-d6 news__cardDate"><?php echo $date; ?></time>
						<?php } ?>
						<?php if ( $show_title ) { ?>
							<header class="t-h5 news__cardLink"><?php echo $title; ?></header>
						<?php } ?>
						<?php if ( $show_excerpt ) { ?>
							<div class="news__cardExcerpt"><?php echo $excerpt; ?></div>
						<?php } ?>
					</div>
					</<?php echo $link_tag; ?>>
					</article>
					<?php
				}
				?>

			</div>
			<div class="news__buttonHolder">
				<button class="news-swiper-button-prev gallery-modal__buttonFocus"><span class="sr-only">Previous</span>
				</button>
				<button class="news-swiper-button-next gallery-modal__buttonFocus"><span class="sr-only">Next</span>
				</button>
			</div>
			<?php if ( ! $is_preview ) { ?>
				<!-- <a href="https://stories.butler.edu" class="button-link-right news__moreButton">Browse All News</a> -->
			<?php } ?>

		</div>


	</section>


	<?php
} else {

	// fallback for preview

	if ( $is_preview == true ) {
		?>

		<div class="message">
			<p>No news stories are found in this category.</p>
		</div>

	<?php }
} ?>
