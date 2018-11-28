<?php
#-----------------------------------------------------------------#
# Create condidate
#-----------------------------------------------------------------# 

// Register Custom Post Type
function Condidate() {

	$labels = array(
		'name'                => _x( 'Condidate', 'Post Type General Name', 'weskhaled' ),
		'singular_name'       => _x( 'Condidate', 'Post Type Singular Name', 'weskhaled' ),
		'menu_name'           => __( 'Condidate', 'weskhaled' ),
		'all_items'           => __( 'Condidates', 'weskhaled' ),
		'view_item'           => __( 'View Condidate', 'weskhaled' ),
		'add_new_item'        => __( 'Add New Condidate', 'weskhaled' ),
		'add_new'             => __( 'Add New Condidate', 'weskhaled' ),
		'edit_item'           => __( 'Edit Condidate', 'weskhaled' ),
		'update_item'         => __( 'Update Partner', 'weskhaled' ),
		'search_items'        => __( 'Search Partner', 'weskhaled' ),
		'not_found'           => __( 'Not found', 'weskhaled' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'weskhaled' ),
		'parent_item_colon' => ''
	);
	$args = array(
		'label'               => __( 'condidate', 'weskhaled' ),
		'description'         => __( 'Dynamix partner', 'weskhaled' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => false,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'condidate', $args );

}

// Hook into the 'init' action
add_action( 'init', 'Condidate', 1 ); 

add_action( 'init', 'my_custom_post_type_rest_support', 25 );
 
function my_custom_post_type_rest_support() {
	global $wp_post_types;
	
	//be sure to set this to the name of your post type!
	$post_type_name = 'condidate';
	
	if( isset( $wp_post_types[ $post_type_name ] ) ) {
	
		$wp_post_types[$post_type_name]->show_in_rest = true;
		// Optionally customize the rest_base or controller class
		$wp_post_types[$post_type_name]->rest_base = $post_type_name;
		$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
	}
}