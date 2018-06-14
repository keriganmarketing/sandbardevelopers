<?php

/**
 * Registers the `company` taxonomy,
 * for use with 'project'.
 */
function company_init() {
	register_taxonomy( 'company', array( 'project' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Companies', 'YOUR-TEXTDOMAIN' ),
			'singular_name'              => _x( 'Company', 'taxonomy general name', 'YOUR-TEXTDOMAIN' ),
			'search_items'               => __( 'Search Companies', 'YOUR-TEXTDOMAIN' ),
			'popular_items'              => __( 'Popular Companies', 'YOUR-TEXTDOMAIN' ),
			'all_items'                  => __( 'All Companies', 'YOUR-TEXTDOMAIN' ),
			'parent_item'                => __( 'Parent Company', 'YOUR-TEXTDOMAIN' ),
			'parent_item_colon'          => __( 'Parent Company:', 'YOUR-TEXTDOMAIN' ),
			'edit_item'                  => __( 'Edit Company', 'YOUR-TEXTDOMAIN' ),
			'update_item'                => __( 'Update Company', 'YOUR-TEXTDOMAIN' ),
			'view_item'                  => __( 'View Company', 'YOUR-TEXTDOMAIN' ),
			'add_new_item'               => __( 'New Company', 'YOUR-TEXTDOMAIN' ),
			'new_item_name'              => __( 'New Company', 'YOUR-TEXTDOMAIN' ),
			'separate_items_with_commas' => __( 'Separate companies with commas', 'YOUR-TEXTDOMAIN' ),
			'add_or_remove_items'        => __( 'Add or remove companies', 'YOUR-TEXTDOMAIN' ),
			'choose_from_most_used'      => __( 'Choose from the most used companies', 'YOUR-TEXTDOMAIN' ),
			'not_found'                  => __( 'No companies found.', 'YOUR-TEXTDOMAIN' ),
			'no_terms'                   => __( 'No companies', 'YOUR-TEXTDOMAIN' ),
			'menu_name'                  => __( 'Companies', 'YOUR-TEXTDOMAIN' ),
			'items_list_navigation'      => __( 'Companies list navigation', 'YOUR-TEXTDOMAIN' ),
			'items_list'                 => __( 'Companies list', 'YOUR-TEXTDOMAIN' ),
			'most_used'                  => _x( 'Most Used', 'company', 'YOUR-TEXTDOMAIN' ),
			'back_to_items'              => __( '&larr; Back to Companies', 'YOUR-TEXTDOMAIN' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'company',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'company_init' );

/**
 * Sets the post updated messages for the `company` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `company` taxonomy.
 */
function company_updated_messages( $messages ) {

	$messages['company'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Company added.', 'YOUR-TEXTDOMAIN' ),
		2 => __( 'Company deleted.', 'YOUR-TEXTDOMAIN' ),
		3 => __( 'Company updated.', 'YOUR-TEXTDOMAIN' ),
		4 => __( 'Company not added.', 'YOUR-TEXTDOMAIN' ),
		5 => __( 'Company not updated.', 'YOUR-TEXTDOMAIN' ),
		6 => __( 'Companies deleted.', 'YOUR-TEXTDOMAIN' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'company_updated_messages' );
