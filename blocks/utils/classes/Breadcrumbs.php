<?php

// Check if the constant is not defined to avoid redeclaration
if ( ! defined( 'CUSTOM_BREADCRUMBS_LOADED' ) ) {
	define( 'CUSTOM_BREADCRUMBS_LOADED', true );

	// Check if the class does not exist to avoid redeclaring it
	if ( ! class_exists( 'Custom_Breadcrumbs' ) ) {
		class Custom_Breadcrumbs {



			private $delimiter = ' <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.66895 11.1187L8.7244 8.05431L5.66895 4.98993L6.6096 4.04858L10.6124 8.05431L6.6096 12.06L5.66895 11.1187Z" fill="white"></path></svg> ';
			private $before    = '<span class="current">';
			private $after     = '</span>';

			private function get_breadcrumb() {
				if ( ! is_home() && ! is_front_page() || is_paged() ) {
					$output = '<div id="breadcrumb">';
					global $post;

					if ( is_category() ) {
						$output .= $this->get_category_breadcrumb();
					} elseif ( is_day() ) {
						$output .= $this->get_date_breadcrumb( 'Y', 'F', 'd' );
					} elseif ( is_month() ) {
						$output .= $this->get_date_breadcrumb( 'Y', 'F' );
					} elseif ( is_year() ) {
						$output .= $this->get_date_breadcrumb( 'Y' );
					} elseif ( is_single() && ! is_attachment() ) {
						$output .= $this->get_single_breadcrumb();
					} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
						$output .= $this->get_custom_post_type_breadcrumb();
					} elseif ( is_attachment() ) {
						$output .= $this->get_attachment_breadcrumb();
					} elseif ( is_page() && ! $post->post_parent ) {
						$output .= $this->before . get_the_title() . $this->after;
					} elseif ( is_page() && $post->post_parent ) {
						$output .= $this->get_page_breadcrumb();
					} elseif ( is_search() ) {
						$output .= $this->before . 'Search results for "' . get_search_query() . '"' . $this->after;
					} elseif ( is_tag() ) {
						$output .= $this->before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $this->after;
					} elseif ( is_author() ) {
						$output .= $this->before . 'Articles posted by ' . get_the_author() . $this->after;
					} elseif ( is_404() ) {
						$output .= $this->before . 'Error 404' . $this->after;
					}

					if ( get_query_var( 'paged' ) ) {
						$output .= ' (' . __( 'Page' ) . ' ' . get_query_var( 'paged' ) . ')';
					}

					$output .= '</div>';

					return $output;
				}
			}

			private function get_category_breadcrumb() {
				global $wp_query;
				$cat_obj   = $wp_query->get_queried_object();
				$thisCat   = $cat_obj->term_id;
				$thisCat   = get_category( $thisCat );
				$parentCat = get_category( $thisCat->parent );

				$output = '';
				if ( $thisCat->parent != 0 ) {
					$output .= get_category_parents( $parentCat, true, ' ' . $this->delimiter . ' ' );
				}
				$output .= $this->before . single_cat_title( '', false ) . $this->after;

				return $output;
			}

			private function get_date_breadcrumb( $year_format, $month_format = '', $day_format = '' ) {
				$output = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( $year_format ) . '</a>' . $this->delimiter;

				if ( $month_format !== '' ) {
					$output .= '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( $month_format ) . '</a>' . $this->delimiter;
				}

				if ( $day_format !== '' ) {
					$output .= $this->before . get_the_time( $day_format ) . $this->after;
				}

				return $output;
			}

			private function get_single_breadcrumb() {
				$output = '';

				if ( get_post_type() !== 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					$output   .= '<a href="' . home_url( '/' ) . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . $this->delimiter;
					$output   .= $this->before . get_the_title() . $this->after;
				} else {
					$cat     = get_the_category();
					$cat     = $cat[0];
					$output .= get_category_parents( $cat, true, ' ' . $this->delimiter . ' ' );
					$output .= $this->before . get_the_title() . $this->after;
				}

				return $output;
			}

			private function get_custom_post_type_breadcrumb() {
				$post_type = get_post_type_object( get_post_type() );
				$output    = $this->before . $post_type->labels->singular_name . $this->after;
				return $output;
			}

			private function get_attachment_breadcrumb() {
				global $post;
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );
				$cat    = $cat[0];

				$output  = get_category_parents( $cat, true, ' ' . $this->delimiter . ' ' );
				$output .= '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $this->delimiter;
				$output .= $this->before . get_the_title() . $this->after;

				return $output;
			}

			private function get_page_breadcrumb() {
				global $post;
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_page( $parent_id );
					$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				$output      = '';
				foreach ( $breadcrumbs as $crumb ) {
					$output .= $crumb . ' ' . $this->delimiter . ' ';
				}
				$output .= $this->before . get_the_title() . $this->after;

				return $output;
			}


			public function display_breadcrumbs() {
				echo $this->get_breadcrumb();
			}
		}
	}

	// Usage:
	// $breadcrumbs = new Custom_Breadcrumbs();
	// $breadcrumbs->display_breadcrumbs();
}
