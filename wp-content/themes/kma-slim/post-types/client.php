<?php

/**
 * Registers the `client` taxonomy,
 * for use with 'project'.
 */
function client_init() {
	register_taxonomy( 'client', array( 'project' ), array(
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
			'name'                       => __( 'Clients'),
			'singular_name'              => _x( 'Client', 'taxonomy general name'),
			'search_items'               => __( 'Search Clients'),
			'popular_items'              => __( 'Popular Clients'),
			'all_items'                  => __( 'All Clients'),
			'parent_item'                => __( 'Parent Client'),
			'parent_item_colon'          => __( 'Parent Client:'),
			'edit_item'                  => __( 'Edit Client'),
			'update_item'                => __( 'Update Client'),
			'view_item'                  => __( 'View Client'),
			'add_new_item'               => __( 'New Client'),
			'new_item_name'              => __( 'New Client'),
			'separate_items_with_commas' => __( 'Separate clients with commas'),
			'add_or_remove_items'        => __( 'Add or remove clients'),
			'choose_from_most_used'      => __( 'Choose from the most used clients'),
			'not_found'                  => __( 'No clients found.'),
			'no_terms'                   => __( 'No clients'),
			'menu_name'                  => __( 'Clients'),
			'items_list_navigation'      => __( 'Clients list navigation'),
			'items_list'                 => __( 'Clients list'),
			'most_used'                  => _x( 'Most Used', 'client'),
			'back_to_items'              => __( '&larr; Back to Clients'),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'client',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'client_init' );

/**
 * Sets the post updated messages for the `client` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `client` taxonomy.
 */
function client_updated_messages( $messages ) {

	$messages['client'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Client added.'),
		2 => __( 'Client deleted.'),
		3 => __( 'Client updated.'),
		4 => __( 'Client not added.'),
		5 => __( 'Client not updated.'),
		6 => __( 'Clients deleted.'),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'client_updated_messages' );

function getClients($hideEmpty = false, $limit = 0){
	$clients = get_terms([
		'taxonomy'   => 'client', 
		'hide_empty' => $hideEmpty
	]);

	return ($limit > 0 && $limit < count($clients) ? array_slice($clients, 0, $limit) : $clients);
}