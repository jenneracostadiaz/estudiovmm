<?php
	add_action( 'init', 'ci_theme_create_brands_taxonomy', 0 );

	function ci_theme_create_brands_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Brands', 'taxonomy general name', 'ci-theme' ),
			'singular_name'              => _x( 'Brand', 'taxonomy singular name', 'ci-theme' ),
			'search_items'               => __( 'Search Brands', 'ci-theme' ),
			'popular_items'              => __( 'Popular Brands', 'ci-theme' ),
			'all_items'                  => __( 'All Brands', 'ci-theme' ),
			'parent_item'                => __( 'Parent Brand', 'ci-theme' ),
			'parent_item_colon'          => __( 'Parent Brand:', 'ci-theme' ),
			'edit_item'                  => __( 'Edit Brand', 'ci-theme' ),
			'update_item'                => __( 'Update Brand', 'ci-theme' ),
			'add_new_item'               => __( 'Add New Brand', 'ci-theme' ),
			'new_item_name'              => __( 'New Brand Name', 'ci-theme' ),
			'separate_items_with_commas' => __( 'Separate brands with commas', 'ci-theme' ),
			'add_or_remove_items'        => __( 'Add or remove brands', 'ci-theme' ),
			'choose_from_most_used'      => __( 'Choose from the most used brands', 'ci-theme' ),
			'not_found'                  => __( 'No brands found.', 'ci-theme' ),
			'menu_name'                  => __( 'Brands', 'ci-theme' ),
			'view_name'                  => __( 'View Brand', 'ci-theme' ),
		);

		register_taxonomy( 'brand', 'post', array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => _x( 'brands', 'taxonomy slug', 'ci-theme' ) ),
		) );
	}
