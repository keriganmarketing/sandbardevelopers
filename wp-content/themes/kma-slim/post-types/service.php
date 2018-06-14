<?php

/**
 * Registers the `service` post type.
 */
function service_init() {
	register_post_type( 'service', array(
		'labels'                => array(
			'name'                  => __( 'Services', 'kma-slim' ),
			'singular_name'         => __( 'Service', 'kma-slim' ),
			'all_items'             => __( 'All Services', 'kma-slim' ),
			'archives'              => __( 'Service Archives', 'kma-slim' ),
			'attributes'            => __( 'Service Attributes', 'kma-slim' ),
			'insert_into_item'      => __( 'Insert into Service', 'kma-slim' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Service', 'kma-slim' ),
			'featured_image'        => _x( 'Featured Image', 'service', 'kma-slim' ),
			'set_featured_image'    => _x( 'Set featured image', 'service', 'kma-slim' ),
			'remove_featured_image' => _x( 'Remove featured image', 'service', 'kma-slim' ),
			'use_featured_image'    => _x( 'Use as featured image', 'service', 'kma-slim' ),
			'filter_items_list'     => __( 'Filter Services list', 'kma-slim' ),
			'items_list_navigation' => __( 'Services list navigation', 'kma-slim' ),
			'items_list'            => __( 'Services list', 'kma-slim' ),
			'new_item'              => __( 'New Service', 'kma-slim' ),
			'add_new'               => __( 'Add New', 'kma-slim' ),
			'add_new_item'          => __( 'Add New Service', 'kma-slim' ),
			'edit_item'             => __( 'Edit Service', 'kma-slim' ),
			'view_item'             => __( 'View Service', 'kma-slim' ),
			'view_items'            => __( 'View Services', 'kma-slim' ),
			'search_items'          => __( 'Search Services', 'kma-slim' ),
			'not_found'             => __( 'No Services found', 'kma-slim' ),
			'not_found_in_trash'    => __( 'No Services found in trash', 'kma-slim' ),
			'parent_item_colon'     => __( 'Parent Service:', 'kma-slim' ),
			'menu_name'             => __( 'Services', 'kma-slim' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'service',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'service_init' );

/**
 * Sets the post updated messages for the `service` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `service` post type.
 */
function service_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['service'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Service updated. <a target="_blank" href="%s">View Service</a>', 'kma-slim' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'kma-slim' ),
		3  => __( 'Custom field deleted.', 'kma-slim' ),
		4  => __( 'Service updated.', 'kma-slim' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Service restored to revision from %s', 'kma-slim' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Service published. <a href="%s">View Service</a>', 'kma-slim' ), esc_url( $permalink ) ),
		7  => __( 'Service saved.', 'kma-slim' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Service submitted. <a target="_blank" href="%s">Preview Service</a>', 'kma-slim' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Service scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Service</a>', 'kma-slim' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Service draft updated. <a target="_blank" href="%s">Preview Service</a>', 'kma-slim' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'service_updated_messages' );

function getServices($limit = -1)
{
    $request = [
        'posts_per_page' => $limit,
        'offset'         => 0,
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'post_type'      => 'service',
        'post_status'    => 'publish',
    ];

    $serviceArray = [];
    foreach (get_posts($request) as $service) {
        array_push($serviceArray, $service);
    }

    return $serviceArray;
}