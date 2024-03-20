<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$headline                        = get_field( 'headline' ) ? get_field( 'headline' ) : $args['headline'];
$body_copy                       = get_field( 'body_copy' ) ? get_field( 'body_copy' ) : $args['body_copy'];
$color                           = get_field( 'headline_highlight' ) ? get_field( 'headline_highlight' )['value'] : '';
$detail_page_associated_taxonomy = get_term( get_field( 'detail_page_associated_taxonomy', $post_id ) );

if ( $detail_page_associated_taxonomy->name === 'persona' ) {
	$tax_term = get_term( get_field( 'persona_taxonomy_term', $post_id ) );
} else {
	$tax_term = get_term( get_field( 'career_paths_taxonomy_term', $post_id ) );
}

if ( $detail_page_associated_taxonomy && $tax_term ) {
	$filter_string = 'taxonomies.' . $detail_page_associated_taxonomy->name . ':"' . $tax_term->name . '"';
} else {
	exit();
}
?>
<section class="<?php echo get_classes( 'program-finder', $block ); ?>">
	<div class="content-row">
		<?php
		$headline = array(
			'text'        => $headline,
			'color_value' => $color,
			'size'        => 'h2',
		);
		require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
		?>
		<p><?php echo $body_copy; ?></p>
	</div>
	<div id="algolia-hits"></div>
</section>
<script type="text/html" id="tmpl-instantsearch-hit">
	<a class="title-card"
	   href="{{ data.permalink }}"
	   title="{{ data.post_title }}"
	   aria-label="learn more about the {{data.post_title}} program"
	   data-guid="{{ data.butler_slate_guid }}">
					<span class="ais-hits--content">
						<span itemprop="name headline" class="program-title">{{{ data.post_title }}}</span>
						<span class="program-degree-container">
							<# if(typeof data.taxonomies.program_type == 'object'){
								for (const [key, value] of Object.entries(data.taxonomies.program_type)) { #>
									<span class="program-type">{{value}}</span>
							<# }} #>
						</span>
						<span class="major-program-excerpt">
							<# if ( data.post_excerpt ) { #>
								{{{ data.post_excerpt }}}
							<# } #>
						</span>
					</span>
		<span class="action-container">
						<span class="button-link-right">Learn More</span>
					</span>
	</a>
</script>
<script type="text/javascript">
	jQuery(function () {
		if (jQuery('.program-finder').length > 0) {

			if (algolia.indices.searchable_posts === undefined && jQuery('.admin-bar').length > 0) {
				alert('It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.');
			}

			const indexName = 'majors_posts_programs_asc';
			let currentPage = 1;
			const hitsPerPage = 6;

			var search = instantsearch({
				indexName: indexName,
				searchClient: algoliasearch(algolia.application_id, algolia.search_api_key),
				routing: true
			});
			search.addWidgets([
				/* Hits widget */
				// instantsearch.widgets.hits({
				// 	container: '#algolia-hits',
				// 	cssClasses: {
				// 		list: ['program-box-container'],
				// 		item: ['program-box', 'butler-blue-branded-top'],
				// 	},
				// 	templates: {
				// 		empty: 'No results were found for "<strong>{{query}}</strong>".',
				// 		item: wp.template('instantsearch-hit')
				// 	},
				// 	transformItems(items) {
				// 		function replaceProgramTypeName(item) {
				// 			if (typeof item.taxonomies.program_type == 'object') {
				// 				for (const [key, value] of Object.entries(item.taxonomies.program_type)) {
				// 					if ('3-Year Degree' === value) {
				// 						item.taxonomies.program_type[key] = '3YR';
				// 					}
				// 					if ('Education Licensure' === value) {
				// 						item.taxonomies.program_type[key] = 'Licensure';
				// 					}
				// 				}
				// 			}
				// 		}
				//
				// 		function replaceDegreeTypeName(item) {
				// 			if (typeof item.taxonomies.degree_type == 'object') {
				// 				for (const [key, value] of Object.entries(item.taxonomies.degree_type)) {
				// 					switch (value) {
				// 						case 'Bachelor of Arts':
				// 						case 'BA':
				// 							item.taxonomies.degree_type[key] = 'BA';
				// 							break;
				// 						case 'Bachelor of Arts or Bachelor of Science':
				// 						case 'BA or BS':
				// 							item.taxonomies.degree_type[key] = 'BA or BS';
				// 							break;
				// 						case 'Bachelor of Fine Arts':
				// 						case 'BFA':
				// 							item.taxonomies.degree_type[key] = 'BFA';
				// 							break;
				// 						case 'Bachelor of Music':
				// 						case 'BM':
				// 							item.taxonomies.degree_type[key] = 'BM';
				// 							break;
				// 						case 'Bachelor of Music Arts':
				// 						case 'BMA':
				// 							item.taxonomies.degree_type[key] = 'BMA';
				// 							break;
				// 						case 'Bachelor of Science':
				// 						case 'BS':
				// 							item.taxonomies.degree_type[key] = 'BS';
				// 							break;
				// 						case 'Bachelor of Science Economics':
				// 						case 'BS Economics':
				// 							item.taxonomies.degree_type[key] = 'BS Economics';
				// 							break;
				// 						case 'Bachelor of Science Health Science':
				// 						case 'BSHS':
				// 							item.taxonomies.degree_type[key] = 'BSHS';
				// 							break;
				// 						case 'PharmD':
				// 							item.taxonomies.degree_type[key] = 'PharmD';
				// 							break;
				// 						default:
				// 							item.taxonomies.degree_type[key] = 'N/A';
				// 							break;
				// 					}
				//
				// 				}
				// 			}
				// 		}
				//
				// 		return items.map(item => ({
				// 			...item,
				// 			program_type: replaceProgramTypeName(item),
				// 			degree_type: replaceDegreeTypeName(item),
				// 		}));
				// 	},
				// }),
				/* Configure widget */
				instantsearch.widgets.configure({
					hitsPerPage: hitsPerPage,
					filters: '<?php echo $filter_string; ?>'
				}),
				instantsearch.widgets.infiniteHits({
					showPrevious: false,
					container: '#algolia-hits',
					cssClasses: {
						list: ['program-box-container'],
						item: ['program-box'],
					},
					templates: {
						empty: 'No results were found.',
						item: wp.template('instantsearch-hit')
					},
					transformItems(items) {
						function replaceProgramTypeName(item) {
							if (typeof item.taxonomies.program_type == 'object') {
								for (const [key, value] of Object.entries(item.taxonomies.program_type)) {
									if ('3-Year Degree' === value) {
										item.taxonomies.program_type[key] = '3YR';
									}
									if ('Education Licensure' === value) {
										item.taxonomies.program_type[key] = 'Licensure';
									}
								}
							}
						}

						function replaceDegreeTypeName(item) {
							if (typeof item.taxonomies.degree_type == 'object') {
								for (const [key, value] of Object.entries(item.taxonomies.degree_type)) {
									switch (value) {
										case 'Bachelor of Arts':
										case 'BA':
											item.taxonomies.degree_type[key] = 'BA';
											break;
										case 'Bachelor of Arts or Bachelor of Science':
										case 'BA or BS':
											item.taxonomies.degree_type[key] = 'BA or BS';
											break;
										case 'Bachelor of Fine Arts':
										case 'BFA':
											item.taxonomies.degree_type[key] = 'BFA';
											break;
										case 'Bachelor of Music':
										case 'BM':
											item.taxonomies.degree_type[key] = 'BM';
											break;
										case 'Bachelor of Music Arts':
										case 'BMA':
											item.taxonomies.degree_type[key] = 'BMA';
											break;
										case 'Bachelor of Science':
										case 'BS':
											item.taxonomies.degree_type[key] = 'BS';
											break;
										case 'Bachelor of Science Economics':
										case 'BS Economics':
											item.taxonomies.degree_type[key] = 'BS Economics';
											break;
										case 'Bachelor of Science Health Science':
										case 'BSHS':
											item.taxonomies.degree_type[key] = 'BSHS';
											break;
										case 'PharmD':
											item.taxonomies.degree_type[key] = 'PharmD';
											break;
										default:
											item.taxonomies.degree_type[key] = 'N/A';
											break;
									}

								}
							}
						}

						return items.map(item => ({
							...item,
							program_type: replaceProgramTypeName(item),
							degree_type: replaceDegreeTypeName(item),
						}));
					},
				})
			]);

			/* Start */
			search.start();

			// const client = algoliasearch(algolia.application_id, algolia.search_api_key);
			// const index = client.initIndex(indexName);
			//
			// index.search("", {filters: 'taxonomies.persona:Globetrotter'}).then(({ hits }) => {
			// 	console.log(hits);
			// });


			search.on('render', () => {
				// Do something on render
				setTimeout(() => {
					const event = new Event("algolia-hits-results");
					window.dispatchEvent(event);
				}, 200);

			});

		}
	});
</script>
