<?php
if ( ! function_exists( 'ci_theme_color_luminance' ) ) :
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.
	 *
	 * @see https://gist.github.com/stephenharris/5532899
	 *
	 * @param string $color Hexadecimal color value. May be 3 or 6 digits, with an optional leading # sign.
	 * @param float $percent Decimal (0.2 = lighten by 20%, -0.4 = darken by 40%)
	 *
	 * @return string Lightened/Darkened colour as hexadecimal (with hash)
	 */
	function ci_theme_color_luminance( $color, $percent ) {
		// Remove # if provided
		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		// Validate hex string.
		$hex     = preg_replace( '/[^0-9a-f]/i', '', $color );
		$new_hex = '#';

		$percent = floatval( $percent );

		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}

		// Convert to decimal and change luminosity.
		for ( $i = 0; $i < 3; $i ++ ) {
			$dec = hexdec( substr( $hex, $i * 2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 );
			$new_hex .= str_pad( dechex( $dec ), 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}
endif;

if ( ! function_exists( 'ci_theme_hex2rgba' ) ) :
	/**
	 * Converts hexadecimal color value to rgb(a) format.
	 *
	 * @param string $color Hexadecimal color value. May be 3 or 6 digits, with an optional leading # sign.
	 * @param float|bool $opacity Opacity level 0-1 (decimal) or false to disable.
	 *
	 * @return string
	 */
	function ci_theme_hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		// Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		// Remove # if provided
		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) === 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) === 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb = array_map( 'hexdec', $hex );

		if ( false === $opacity ) {
			$opacity = abs( floatval( $opacity ) );
			if ( $opacity > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		return $output;
	}
endif;

if ( ! function_exists( 'ci_theme_pagination' ) ) :
	/**
	 * Echoes pagination links if applicable. Output depends on pagination method selected from the customizer.
	 *
	 * @param array $args An array of arguments to change default behavior.
	 * @param object|bool $query A WP_Query object to paginate. Defaults to boolean false and uses the global $wp_query
	 *
	 * @return void
	 */
	function ci_theme_pagination( $args = array(), $query = false ) {
		$args = wp_parse_args( $args, apply_filters( 'ci_theme_pagination_default_args', array(
			'container_id'        => 'paging',
			'container_class'     => 'group',
			'prev_text'           => __( 'Previous page', 'ci-theme' ),
			'next_text'           => __( 'Next page', 'ci-theme' ),
			'paginate_links_args' => array()
		) ) );

		if ( 'object' != gettype( $query ) || 'WP_Query' != get_class( $query ) ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set things up for paginate_links()
		$unreal_pagenum = 999999999;
		$permastruct    = get_option( 'permalink_structure' );

		$paginate_links_args = wp_parse_args( $args['paginate_links_args'], array(
			'base'    => str_replace( $unreal_pagenum, '%#%', esc_url( get_pagenum_link( $unreal_pagenum ) ) ),
			'format'  => empty( $permastruct ) ? '&page=%#%' : 'page/%#%/',
			'total'   => $query->max_num_pages,
			'current' => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
		) );

		$method = get_theme_mod( 'pagination_method', 'numbers' );

		if ( $query->max_num_pages > 1 ) {
			?>
			<div
			<?php echo empty( $args['container_id'] ) ? '' : 'id="' . esc_attr( $args['container_id'] ) . '"'; ?>
			<?php echo empty( $args['container_class'] ) ? '' : 'class="' . esc_attr( $args['container_class'] ) . '"'; ?>
			><?php

			switch ( $method ) {
				case 'text':
					previous_posts_link( $args['prev_text'] );
					next_posts_link( $args['next_text'], $query->max_num_pages );
					break;
				case 'numbers':
				default:
					echo paginate_links( $paginate_links_args );
					break;
			}

			?></div><?php
		}

	}
endif;
