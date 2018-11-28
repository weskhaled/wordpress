<?php
#-----------------------------------------------------------------#
# Create partner
#-----------------------------------------------------------------# 

// Register Custom Post Type
function Quote() {

	$labels = array(
		'name'                => _x( 'Quote', 'Post Type General Name', 'weskhaled' ),
		'singular_name'       => _x( 'Quote', 'Post Type Singular Name', 'weskhaled' ),
		'menu_name'           => __( 'Quote', 'weskhaled' ),
		'parent_item_colon'   => __( 'Post:', 'weskhaled' ),
		'all_items'           => __( 'Quotes', 'weskhaled' ),
		'view_item'           => __( 'View Quote', 'weskhaled' ),
		'add_new_item'        => __( 'Add New Quote', 'weskhaled' ),
		'add_new'             => __( 'Add New Quote', 'weskhaled' ),
		'edit_item'           => __( 'Edit Quote', 'weskhaled' ),
		'update_item'         => __( 'Update Quote', 'weskhaled' ),
		'search_items'        => __( 'Search Quote', 'weskhaled' ),
		'not_found'           => __( 'Not found', 'weskhaled' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'weskhaled' ),
	);
	$args = array(
		'label'               => __( 'quote', 'weskhaled' ),
		'description'         => __( 'Dynamix quote', 'weskhaled' ),
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
		'menu_icon'           => 'dashicons-format-status',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'quote', $args );

}

// Hook into the 'init' action
add_action( 'init', 'Quote', 1 ); 


function quote_columns($columns) {

	$new_columns = array(
		"cb" => "<input type=\"checkbox\" />",  
		'image_slider' => __('Image', 'weskhaled'),
	);
    return array_merge( $new_columns,$columns);
}
add_filter('manage_quote_posts_columns' , 'quote_columns');

// add_action('manage_posts_custom_column', 'columns_image', 11, 3);
