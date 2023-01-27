<?php
function ci_theme_admin_notice_sample_content() {

	$dismissed = get_theme_mod( 'dismissed_sample_content', false );

	if ( ! current_user_can( 'manage_options' ) || $dismissed ) {
		return;
	}

	$sample_content_url = apply_filters( 'ci_theme_sample_content_url',
		sprintf( 'https://www.cssigniter.com/sample_content/%s.zip', CI_THEME_NAME ),
		'https://www.cssigniter.com/sample_content/',
		CI_THEME_NAME
	);

	if ( empty( $sample_content_url ) ) {
		return;
	}

	?>
	<div class="notice notice-info is-dismissible ci-theme-sample-content-notice">
		<p>
			<?php echo wp_kses( sprintf( __( 'It looks like the theme was just installed. <a href="%s" target="_blank">Download the sample content</a> to get things moving.', 'ci-theme' ),
				esc_url( $sample_content_url )
			), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?>
		</p>
	</div>
	<?php

	$theme = wp_get_theme();

	wp_enqueue_script( 'ci-theme-sample-content', get_template_directory_uri() . '/inc/js/sample-content.js', array(), $theme->get( 'Version' ), true );

	$settings = array(
		'ajaxurl'       => admin_url( 'admin-ajax.php' ),
		'dismiss_nonce' => wp_create_nonce( 'ci-theme-dismiss-sample-content' ),
	);
	wp_localize_script( 'ci-theme-sample-content', 'ci_theme_SampleContent', $settings );
}

function ci_theme_ajax_dismiss_sample_content() {
	check_ajax_referer( 'ci-theme-dismiss-sample-content', 'nonce' );

	if ( current_user_can( 'manage_options' ) && ! empty( $_POST['dismissed'] ) && $_POST['dismissed'] == true ) {
		set_theme_mod( 'dismissed_sample_content', true );
		wp_send_json_success( 'OK' );
	} else {
		wp_send_json_error( 'BAD' );
	}
}


function ci_theme_wrap_archive_widget_post_counts_in_span( $output ) {
	$output = preg_replace_callback( '#(<li>.*?<a.*?>.*?</a>.*&nbsp;)(\(.*?\))(.*?</li>)#', 'ci_theme_replace_archive_widget_post_counts_in_span', $output );

	return $output;
}

function ci_theme_replace_archive_widget_post_counts_in_span( $matches ) {
	return sprintf( '%s<span class="ci-count">%s</span>%s',
		$matches[1],
		$matches[2],
		$matches[3]
	);
}

function ci_theme_wrap_category_widget_post_counts_in_span( $output, $args ) {
	if ( ! isset( $args['show_count'] ) || $args['show_count'] == 0 ) {
		return $output;
	}
	$output = preg_replace_callback( '#(<a.*?>\s*)(\(.*?\))#', 'ci_theme_replace_category_widget_post_counts_in_span', $output );

	return $output;
}

function ci_theme_replace_category_widget_post_counts_in_span( $matches ) {
	return sprintf( '%s<span class="ci-count">%s</span>',
		$matches[1],
		$matches[2]
	);
}


/**
 * Returns the appropriate page(d) query variable to use in custom loops (needed for pagination).
 *
 * @uses get_query_var()
 *
 * @param int $default_return The default page number to return, if no query vars are set.
 * @return int The appropriate paged value if found, else 0.
 */
function ci_theme_get_page_var( $default_return = 0 ) {
	$paged = get_query_var( 'paged', false );
	$page  = get_query_var( 'page', false );

	if ( $paged === false && $page === false ) {
		return $default_return;
	}

	return max( $paged, $page );
}

/**
 * Returns just the URL of an image attachment.
 *
 * @param int $image_id The Attachment ID of the desired image.
 * @param string $size The size of the image to return.
 * @return bool|string False on failure, image URL on success.
 */
function ci_theme_get_image_src( $image_id, $size = 'full' ) {
	$img_attr = wp_get_attachment_image_src( intval( $image_id ), $size );
	if ( ! empty( $img_attr[0] ) ) {
		return $img_attr[0];
	}
}

/**
 * Returns the n-th first characters of a string.
 * Uses substr() so return values are the same.
 *
 * @param string $string The string to get the characters from.
 * @param string $length The number of characters to return.
 * @return string
 */
function ci_theme_substr_left( $string, $length ) {
	return substr( $string, 0, $length );
}

/**
 * Returns the n-th last characters of a string.
 * Uses substr() so return values are the same.
 *
 * @param string $string The string to get the characters from.
 * @param string $length The number of characters to return.
 * @return string
 */
function ci_theme_substr_right( $string, $length ) {
	return substr( $string, - $length, $length );
}

if ( ! function_exists( 'ci_get_related_posts' ) ):
/**
 * Returns a set of related posts, or the arguments needed for such a query.
 *
 * @uses wp_parse_args()
 * @uses get_post_type()
 * @uses get_post()
 * @uses get_object_taxonomies()
 * @uses get_the_terms()
 * @uses wp_list_pluck()
 *
 * @param int $post_id A post ID to get related posts for.
 * @param int $related_count The number of related posts to return.
 * @param array $args Array of arguments to change the default behavior.
 * @return object|array A WP_Query object with the results, or an array with the query arguments.
 */
function ci_get_related_posts( $post_id, $related_count, $args = array() ) {
	$args = wp_parse_args( (array) $args, array(
		'orderby' => 'rand',
		'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array)
	) );

	$post_type = get_post_type( $post_id );
	$post      = get_post( $post_id );

	$term_list  = array();
	$query_args = array();
	$tax_query  = array();
	$taxonomies = get_object_taxonomies( $post, 'names' );

	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( is_array( $terms ) and count( $terms ) > 0 ) {
			$term_list = wp_list_pluck( $terms, 'slug' );
			$term_list = array_values( $term_list );
			if ( ! empty( $term_list ) ) {
				$tax_query['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term_list
				);
			}
		}
	}

	if ( count( $taxonomies ) > 1 ) {
		$tax_query['tax_query']['relation'] = 'OR';
	}

	$query_args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $related_count,
		'post_status'    => 'publish',
		'post__not_in'   => array( $post_id ),
		'orderby'        => $args['orderby']
	);

	if ( $args['return'] == 'query' ) {
		return new WP_Query( array_merge( $query_args, $tax_query ) );
	} else {
		return array_merge( $query_args, $tax_query );
	}
}
endif;



$ci_theme_glob_inline_js = array();
if ( ! function_exists( 'ci_add_inline_js' ) ):
/**
 * Registers an inline JS script.
 * The script will be printed on the footer of the current request's page, either on the front or the back end.
 * Inline scripts are printed inside a jQuery's ready() event handler, and $ is available.
 * Passing a $handle allows to reference and/or overwrite specific inline scripts.
 *
 * @param string $script A JS script to be printed.
 * @param string $handle An optional handle by which the script is referenced.
 */
function ci_theme_add_inline_js( $script, $handle = false ) {
	global $ci_theme_glob_inline_js;

	$handle = sanitize_key( $handle );

	if ( ( $handle !== false ) and ( $handle != '' ) ) {
		$ci_theme_glob_inline_js[ $handle ] = "\n" . $script . "\n";
	} else {
		$ci_theme_glob_inline_js[] = "\n" . $script . "\n";
	}
}
endif;

if ( ! function_exists( 'ci_get_inline_js' ) ):
/**
 * Retrieves the inline JS scripts that are registered for printing.
 *
 * @return array The inline JS scripts queued for printing.
 */
function ci_theme_get_inline_js() {
	global $ci_theme_glob_inline_js;

	return $ci_theme_glob_inline_js;
}
endif;

if ( ! function_exists( 'ci_print_inline_js' ) ):
/**
 * Prints the inline JS scripts that are registered for printing, and removes them from the queue.
 */
function ci_theme_print_inline_js() {
	global $ci_theme_glob_inline_js;

	if ( empty( $ci_theme_glob_inline_js ) ) {
		return;
	}

	$sanitized = array();

	foreach ( $ci_theme_glob_inline_js as $handle => $script ) {
		$sanitized[ $handle ] = wp_check_invalid_utf8( $script );
	}

	echo '<script type="text/javascript">' . "\n";
	echo "\t" . 'jQuery(document).ready(function($){' . "\n";

	foreach ( $sanitized as $handle => $script ) {
		echo "\n/* --- CI Theme Inline script ($handle) --- */\n";
		echo $script;
	}

	echo "\t" . '});' . "\n";
	echo '</script>' . "\n";

	$ci_theme_glob_inline_js = array();
}
endif;

if ( ! function_exists( 'ci_theme_inflect' ) ):
	/**
	 * Returns a string depending on the value of $num.
	 *
	 * When $num equals zero, string $none is returned.
	 * When $num equals one, string $one is returned.
	 * When $num is any other number, string $many is returned.
	 *
	 * @access public
	 *
	 * @param int $num
	 * @param string $none
	 * @param string $one
	 * @param string $many
	 *
	 * @return string
	 */
	function ci_theme_inflect( $num, $none, $one, $many ) {
		if ( $num == 0 ) {
			return $none;
		} elseif ( $num == 1 ) {
			return $one;
		} else {
			return $many;
		}
	}
endif;

if ( ! function_exists( 'ci_theme_e_inflect' ) ):
	/**
	 * Echoes a string depending on the value of $num.
	 *
	 * When $num equals zero, string $none is echoed.
	 * When $num equals one, string $one is echoed.
	 * When $num is any other number, string $many is echoed.
	 *
	 * @access public
	 *
	 * @param int $num
	 * @param string $none
	 * @param string $one
	 * @param string $many
	 *
	 * @return void
	 */
	function ci_theme_e_inflect( $num, $none, $one, $many ) {
		echo ci_theme_inflect( $num, $none, $one, $many );
	}
endif;

if ( ! function_exists( 'ci_theme_merge_wp_queries' ) ):
/**
 * Merges multiple WP_Queries by accepting any number of valid, discreet parameter arrays.
 * It runs each query individually, merges the (unique) post IDs, and re-queries the DB for those IDs, respecting their order.
 * Uses WP_Query() so parameters and return values are the same.
 *
 * @param array ... Unlimited WP_Query() parameter arrays.
 * @return WP_Query object
 */
function ci_theme_merge_wp_queries() {
	$args = func_get_args();

	if ( $args < 2 ) {
		return new WP_Query();
	}

	$merged         = array();
	$post_types     = array();
	$all_post_types = array(); // Will not be reset on iterations, so that there is a record of all post types needed.

	// Let's handle each query.
	foreach ( $args as $arg ) {
		// How many posts to get
		$numberposts = - 1;
		if ( ! empty( $arg['posts_per_page'] ) ) {
			$numberposts = $arg['posts_per_page'];
		} elseif ( ! empty( $arg['numberposts'] ) ) {
			$numberposts = $arg['numberposts'];
		} elseif ( ! empty( $arg['showposts'] ) ) {
			$numberposts = $arg['showposts'];
		}

		$arg['posts_per_page'] = $numberposts;

		// Make sure only IDs will be returned. We want the query to be lightweight.
		$arg['fields'] = 'ids';

		// What post types to retrieve
		if ( ! empty( $arg['post_type'] ) ) {
			$post_types = $arg['post_type'];

			// Keep the post type(s) for later use.
			if ( is_array( $post_types ) ) {
				$all_post_types = array_merge( $all_post_types, $post_types );
			} else {
				$all_post_types[] = $post_types;
			}
		}

		$this_posts = new WP_Query( $arg );

		foreach ( $this_posts->posts as $p ) {
			$merged[] = $p;
		}

		wp_reset_postdata();
	}

	$all_post_types = array_unique( $all_post_types );

	$merged = array_unique( $merged );

	if ( count( $merged == 0 ) ) {
		$merged[] = 0;
	}

	$params = array(
		'post__in'        => $merged,
		'post_type'       => $all_post_types,
		'posts_per_page'  => - 1,
		'suppress_filter' => false,
		'orderby'         => 'post__in'
	);

	$params = apply_filters( 'ci_theme_merge_wp_queries', $params, $args );

	$merged_query = new WP_Query( $params );

	return $merged_query;
}
endif;

if ( ! function_exists( 'ci_theme_dropdown_posts' ) ):
/**
 * Retrieve or display list of posts as a dropdown (select list).
 *
 * @since 2.1.0
 *
 * @param array|string $args Optional. Override default arguments.
 * @param string $name Optional. Name of the select box.
 * @return string HTML content, if not displaying.
 */
function ci_theme_dropdown_posts( $args = '', $name = 'post_id' ) {
	$defaults = array(
		'depth'                 => 0,
		'post_parent'           => 0,
		'selected'              => 0,
		'echo'                  => 1,
		//'name'                  => 'page_id', // With this line, get_posts() doesn't work properly.
		'id'                    => '',
		'class'                 => '',
		'show_option_none'      => '',
		'show_option_no_change' => '',
		'option_none_value'     => '',
		'post_type'             => 'post',
		'post_status'           => 'publish',
		'suppress_filters'      => false,
		'numberposts'           => -1,
		'select_even_if_empty'  => false, // If no posts are found, an empty <select> will be returned/echoed.
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$hierarchical_post_types = get_post_types( array( 'hierarchical' => true ) );
	if ( in_array( $r['post_type'], $hierarchical_post_types ) ) {
		$pages = get_pages($r);
	} else {
		$pages = get_posts($r);
	}

	$output = '';
	// Back-compat with old system where both id and name were based on $name argument
	if ( empty($id) )
		$id = $name;

	if ( ! empty($pages) || $select_even_if_empty == true ) {
		$output = "<select name='" . esc_attr( $name ) . "' id='" . esc_attr( $id ) . "' class='" . esc_attr( $class ) . "'>\n";
		if ( $show_option_no_change ) {
			$output .= "\t<option value=\"-1\">$show_option_no_change</option>";
		}
		if ( $show_option_none ) {
			$output .= "\t<option value=\"" . esc_attr( $option_none_value ) . "\">$show_option_none</option>\n";
		}
		if ( ! empty($pages) ) {
			$output .= walk_page_dropdown_tree($pages, $depth, $r);
		}
		$output .= "</select>\n";
	}

	$output = apply_filters( 'ci_theme_dropdown_posts', $output, $name, $r );

	if ( $echo )
		echo $output;

	return $output;
}
endif;

/**
 * Determine whether a plugin is active.
 *
 * @param string $plugin The path to the plugin file, relative to the plugins directory.
 * @return bool True if plugin is active, false otherwise.
 */
function ci_theme_can_use_plugin( $plugin ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	return is_plugin_active( $plugin );
}
