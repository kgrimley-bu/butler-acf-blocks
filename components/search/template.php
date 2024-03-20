<?php
/**
 * WP Search With Algolia instantsearch template file.
 *
 * @author  WebDevStudios <contact@webdevstudios.com>
 * @since   1.0.0
 *
 * @version 2.0.0
 * @package WebDevStudios\WPSWA
 */

?>
<div id="ais-wrapper">
	<main id="ais-main" class="page-content">
		<div class="algolia-search-box-wrapper">
			<div id="algolia-search-box"></div>
		</div>
		<div class="federated-hits tabs">
			<div role="tablist" aria-labelledby="tablist-1" class="automatic search-tablist">
				<?php
				foreach ( $all_indices as $key => $index ) {
					?>
					<button id="tab-<?php echo $key; ?>" class="search-results-tabButton" type="button" role="tab" aria-selected="<?php echo ( 0 == $key ) ? 'true' : 'false'; ?>" aria-controls="tabpanel-<?php echo $key; ?>">
						<span class="focus"><h2 class="ais-results-section-title"><?php echo $index['index_label']; ?></h2></span>
					</button>
				<?php } ?>
				
			</div>
			<?php
			foreach ( $all_indices as $key => $index ) {
				?>
				<div id="tabpanel-<?php echo $key; ?>" role="tabpanel" tabindex="0" aria-labelledby="tab-<?php echo $key; ?>">
					<div class="index-container my-container">
						<div id="<?php echo $index['index_id']; ?>-hits"></div>
						<div id="<?php echo $index['index_id']; ?>-pagination"></div>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
</div>

<script type="text/html" id="tmpl-directory-hits">
	<article itemtype="http://schema.org/Article">
		<div class="ais-hits--content">
			
			<div class="ais-directory-info-container">
				<# if ( data.photo_url.length !== 0 ) { #>
					<div class="ais-directory-image-container">
						<img class="ais-directory-image" src="{{ data.photo_url }}" alt="{{ data.firstname_preferred }} {{ data.lastname_preferred }}">
					</div>
				<# } #>
				<div>
					<div itemprop="name headline" class="ais-directory-title">{{{ data.firstname_preferred }}} {{{ data.lastname_preferred }}}</div>
					<# if ( data.groups[0] != undefined ) { #>
						<span class="ais-directory-info ais-directory-groups"><strong>{{{ data.groups[0] }}}</strong></span>
					<# } #>
					<# if ( data.groups[0] != undefined ) { #>
						<span class="ais-directory-info ais-directory-spacer"> - </span>
					<# } #>
					<# if ( data.titles[0] != undefined ) { #>
						<span class="ais-directory-info ais-directory-titles">{{{ data.titles[0] }}}</span>
					<# } #>
					<# if ( data.email ) { #>
						<span class="ais-directory-info ais-directory-email"><a href="mailto:{{data.email}}">{{{ data.email }}}</a></span>
					<# } #>
					<# if ( data.phone ) { #>
						<span class="ais-directory-info ais-directory-phone"><a href="tel:{{data.phone}}">{{{ data.phone }}}</a></span>
					<# } #>
					<# if ( data.location ) { #>
						<span class="ais-directory-info ais-directory-location">{{{ data.location }}}</span>
					<# } #>
					<div>
						<a href="https://directory.butler.edu/#/{{ data.username }}" title="{{ data.title }}" class="button-link-right" itemprop="url">View Profile</a>
					</div>
				</div>
			</div>
		</div>
		<hr class="muted" />
		<div class="ais-clearfix"></div>
	</article>
</script>

<script type="text/html" id="tmpl-events-hits">
	<article itemtype="http://schema.org/Article">
		<div class="ais-hits--content">
			
			<a class="ais-hits--link" href="https://events.butler.edu/event/{{ data.slug }}" title="{{ data._highlightResult.title.value }}" class="ais-hits--title-link" itemprop="url">
				<div itemprop="name headline" class="ais-hits--link-title">{{{ data._highlightResult.title.value }}}</div>
				<div class="ais-hits--link-url">https://events.butler.edu/event/{{ data.slug }}</div>
			</a>
			<div class="search-results__itemDateTime">{{ data.event_date }}</div>
			<div class="excerpt">
				<# if ( data.summary ) { #>
					<p class="ais-hits-kb-summary">{{{ data.summary }}}</p>
				<# } #>
			</div>
		</div>
		<hr class="muted" />
		<div class="ais-clearfix"></div>
	</article>
</script>

<script type="text/html" id="tmpl-wp_documents-hits">
	<article itemtype="http://schema.org/Article">
		<div class="ais-hits--content">
			<a href="{{ data.full_attachment_url }}" title="{{ data.post_title }}" class="ais-hits--link" itemprop="url">
				<div itemprop="name headline" class="ais-hits--link-title">{{{ data._highlightResult.post_title.value }}}</div>
				<div class="ais-hits--link-url">{{ data.full_attachment_url }}</div>
			</a>
		</div>
		<hr class="muted" />
		<div class="ais-clearfix"></div>
	</article>
</script>

<script type="text/html" id="tmpl-wordpress-hits">
	<article itemtype="http://schema.org/Article">
		<div class="ais-hits--content">
			<a class="ais-hits--link" href="{{ data.permalink }}" title="{{ data.post_title }}" class="ais-hits--title-link" itemprop="url">
				<div itemprop="name headline" class="ais-hits--link-title">{{{ data._highlightResult.post_title.value }}}</div>
				<div class="ais-hits--link-url">{{ data.permalink }}</div>
			</a>
			<div class="excerpt">
				<# if ( data.meta_description ) { #>
					<p class="ais-hits-my-summary">{{{ data.meta_description }}}</p>
				<# } else if ( data.post_excerpt ) { #>
					<p class="ais-hits-my-summary">{{{ data.post_excerpt }}}</p>
				<# } else if ( data.content ) { #>
					<p class="ais-hits-my-summary">{{{ data._snippetResult.content.value }}}</p>
				<# } #>

			</div>
		</div>
		<hr class="muted" />
		<div class="ais-clearfix"></div>
	</article>
</script>


<script type="text/javascript">
	jQuery( function() {
		if ( jQuery('#algolia-search-box' ).length > 0 ) {

			if ( algolia.indices.searchable_posts === undefined && jQuery( '.admin-bar' ).length > 0 ) {
				alert('It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.');
			}

			/* Instantiate instantsearch.js */
			var search = instantsearch({
				indexName: '<?php echo $init_index['index_id']; ?>',
				searchClient: algoliasearch( algolia.application_id, algolia.search_api_key ),
				routing: {
					router: instantsearch.routers.history({ writeDelay: 1000 }),
					stateMapping: {
						stateToRoute( uiState ) {
							const indexUiState = uiState[ '<?php echo $init_index['index_id']; ?>'];
							return {
								search: indexUiState.query,
								page: indexUiState.page,
							}
						},
						routeToState( routeState ) {
							return {
								[ '<?php echo $init_index['index_id']; ?>' ]: {
									query: routeState.search,
									page: routeState.page,
								},
							};
						},
					},
				},
			});

			const initPagination = instantsearch.widgets.panel( {
				hidden: ( { results } ) => results.nbPages <= 1,
			} )( instantsearch.widgets.pagination);

			<?php
			foreach ( $all_indices as $key => $index ) {
				if ( $key > 0 ) {
					?>
						const <?php echo $index['index_id']; ?>pagination = instantsearch.widgets.panel( {
							hidden: ( { results } ) => results.nbPages <= 1,
						} )( instantsearch.widgets.pagination );
					<?php
				}
			}
			?>

			search.addWidgets([

				/* Search box widget */
				instantsearch.widgets.searchBox( {
					container: '#algolia-search-box',
					placeholder: 'Search for...',
					showReset: false,
					showSubmit: false,
					showLoadingIndicator: false,
				} ),

				instantsearch.widgets.index( {
					indexName: '<?php echo $init_index['index_id']; ?>'
				} ).addWidgets( [
					instantsearch.widgets.configure( {
						hitsPerPage: 10,
					} ),
					instantsearch.widgets.hits( {
						container: '#<?php echo $init_index['index_id']; ?>-hits',
						templates: {
							empty: 'No Directory results were found for "<strong>{{query}}</strong>"',
							item: wp.template('<?php echo $init_index['results_template']; ?>-hits')
						},
						transformItems: ( items ) => {
							return items.map( ( item ) => {
								/*function replace_highlights_recursive ( item ) {
									if ( item instanceof Object && item.hasOwnProperty( 'value' ) ) {
										item.value = _.escape( item.value );
										item.value = item.value.replace( /__ais-highlight__/g, '<em>' ).replace( /__\/ais-highlight__/g, '</em>' );
									} else {
										for ( var key in item ) {
											item[ key ] = replace_highlights_recursive( item[ key ] );
										}
									}
									return item;
								}*/
								//item._highlightResult = replace_highlights_recursive( item._highlightResult );
								//item._snippetResult = replace_highlights_recursive( item._snippetResult );

								return item;
							} );
						},
					}),
					initPagination({
						container: '#<?php echo $init_index['index_id']; ?>-pagination',
					})
				]),

				<?php
				foreach ( $all_indices as $key => $index ) {
					if ( $key > 0 ) {
						?>
						instantsearch.widgets.index( {
							indexName: '<?php echo $index['index_id']; ?>'
						} ).addWidgets( [
							instantsearch.widgets.configure( {
								distinct: true,
								hitsPerPage: 10,
								attributesToSnippet: [ 'content', 'content_main', 'post_title', 'meta_description', 'post_excerpt' ],
							} ),
							instantsearch.widgets.hits( {
								container: '#<?php echo $index['index_id']; ?>-hits',
								templates: {
									empty: 'No My Butler results were found for "<strong>{{query}}</strong>"',
									item: wp.template('<?php echo $index['results_template']; ?>-hits')
								},
								transformItems: ( items ) => {
									return items.map( ( item ) => {
										if ( undefined === item.event_start ) {
											return item;
										}
										let d = new Date( item.event_start );

										const newDate = d.toLocaleDateString( 'en-US', {
											month: 'short',
											day: 'numeric',
											year: 'numeric',
										} );

										const newTime = d.toLocaleString( 'en-US', {
											timeStyle: 'short'
										} );
										
										item.event_date = newDate + ' at ' + newTime

										return item;
									} );
								},
							} ),
							<?php echo $index['index_id']; ?>pagination({
								container: '#<?php echo $index['index_id']; ?>-pagination',
							})
						]),
						<?php
					}
				}
				?>

				/* Configure widget */
				instantsearch.widgets.configure({
					hitsPerPage: 10,
					attributesToSnippet: [ 'post_title', 'meta_description', 'content_main', 'content' ],
				}),
			]);

			/* Start */
			search.start();

			jQuery( '#algolia-search-box input' ).attr( 'type', 'search' ).trigger( 'select' );
		}
	});
</script>
<?php
