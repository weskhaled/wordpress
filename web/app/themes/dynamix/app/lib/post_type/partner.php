<?php
#-----------------------------------------------------------------#
# Create partner
#-----------------------------------------------------------------# 

// Register Custom Post Type
function Partner() {

	$labels = array(
		'name'                => _x( 'Partner', 'Post Type General Name', 'weskhaled' ),
		'singular_name'       => _x( 'Partner', 'Post Type Singular Name', 'weskhaled' ),
		'menu_name'           => __( 'Partner', 'weskhaled' ),
		'parent_item_colon'   => __( 'Post:', 'weskhaled' ),
		'all_items'           => __( 'Partners', 'weskhaled' ),
		'view_item'           => __( 'View Partner', 'weskhaled' ),
		'add_new_item'        => __( 'Add New Partner', 'weskhaled' ),
		'add_new'             => __( 'Add New Partner', 'weskhaled' ),
		'edit_item'           => __( 'Edit Partner', 'weskhaled' ),
		'update_item'         => __( 'Update Partner', 'weskhaled' ),
		'search_items'        => __( 'Search Partner', 'weskhaled' ),
		'not_found'           => __( 'Not found', 'weskhaled' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'weskhaled' ),
	);
	$args = array(
		'label'               => __( 'partner', 'weskhaled' ),
		'description'         => __( 'Dynamix Partner', 'weskhaled' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'partner', $args );

}

// Hook into the 'init' action
add_action( 'init', 'Partner', 1 ); 



function partner_columns($columns) {

	$new_columns = array(
		"cb" => "<input type=\"checkbox\" />",  
		'image_slider' => __('Image', 'weskhaled'),
	);
    return array_merge( $new_columns,$columns);
}
add_filter('manage_partner_posts_columns' , 'partner_columns');

add_action('manage_posts_custom_column', 'columns_image', 11, 3);
