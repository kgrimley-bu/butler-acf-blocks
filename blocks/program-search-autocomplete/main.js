window.addEventListener('load', function () {

	if (typeof algolia === "undefined") { return; }
	if (typeof algoliasearch === "undefined") { return; }

	let val = document.getElementById("program-search");
	if (val) {
		val.onkeypress = function (key) {
			var btn = 0 || key.keyCode || key.charCode;
			if (btn == 13) {

				key.preventDefault();
			}
		}
	}

	/* Initialize Algolia client */
	var client = algoliasearch(algolia.application_id, algolia.search_api_key);

	/**
	 * Algolia hits source method.
	 *
	 * This method defines a custom source to use with autocomplete.js.
	 *
	 * @param object $index Algolia index object.
	 * @param object $params Options object to use in search.
	 */
	var algoliaHitsSource = function (index, params) {
		return function (query, callback) {
			index
				.search(query, params)
				.then(function (response) {
					callback(response.hits, response);
				})
				.catch(function (error) {
					callback([]);
				});
		}
	}

	/* Setup autocomplete.js sources */
	var sources = [];
	algolia.autocomplete.sources.forEach(function (config, i) {
		var suggestion_template = wp.template(config['tmpl_suggestion']);
		sources.push({
			source: algoliaHitsSource(client.initIndex('majors_posts_programs_asc'), {
				hitsPerPage: config['max_suggestions'],
				attributesToSnippet: [
					'content:10'
				],
				highlightPreTag: '__ais-highlight__',
				highlightPostTag: '__/ais-highlight__'
			}),
			templates: {
				suggestion: function (hit) {
					if (hit.escaped === true) {
						return suggestion_template(hit);
					}
					hit.escaped = true;

					for (var key in hit._highlightResult) {
						/* We do not deal with arrays. */
						if (typeof hit._highlightResult[key].value !== 'string') {
							continue;
						}
						hit._highlightResult[key].value = _.escape(hit._highlightResult[key].value);
						hit._highlightResult[key].value = hit._highlightResult[key].value.replace(/__ais-highlight__/g, '<em>').replace(/__\/ais-highlight__/g, '</em>');
					}

					for (var key in hit._snippetResult) {
						/* We do not deal with arrays. */
						if (typeof hit._snippetResult[key].value !== 'string') {
							continue;
						}

						hit._snippetResult[key].value = _.escape(hit._snippetResult[key].value);
						hit._snippetResult[key].value = hit._snippetResult[key].value.replace(/__ais-highlight__/g, '<em>').replace(/__\/ais-highlight__/g, '</em>');
					}

					return suggestion_template(hit);
				}
			}
		});

	});

	/* Setup dropdown menus */
	document.querySelectorAll(algolia.autocomplete.input_selector).forEach(function (element) {

		var config = {
			debug: true,
			hint: false,
			openOnFocus: true,
			appendTo: 'body',
			templates: {
				empty: wp.template('autocomplete-empty')
			}
		};

		/* Instantiate autocomplete.js */
		var autocomplete = algoliaAutocomplete(element, config, sources)
			.on('autocomplete:selected', function (e, suggestion) {
				/* Redirect the user when we detect a suggestion selection. */
				window.location.href = suggestion.permalink ?? suggestion.posts_url; // Users use the `posts_url` property instead of `permalink`.
			});

		/* Force the dropdown to be re-drawn on scroll to handle fixed containers. */
		window.addEventListener('scroll', function () {
			if (autocomplete.autocomplete.getWrapper().style.display === "block") {
				autocomplete.autocomplete.close();
				autocomplete.autocomplete.open();
			}
		});
	});
});
