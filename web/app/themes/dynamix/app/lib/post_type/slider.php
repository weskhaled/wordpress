<?php
#-----------------------------------------------------------------#
# Create slider
#-----------------------------------------------------------------# 
// Register Custom Taxonomy
// Register Custom Taxonomy
function Location() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'weskhaled' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'weskhaled' ),
		'menu_name'                  => __( 'Locations', 'weskhaled' ),
		'all_items'                  => __( 'All Location', 'weskhaled' ),
		'parent_item'                => __( 'Slide', 'weskhaled' ),
		'parent_item_colon'          => __( 'Slider:', 'weskhaled' ),
		'new_item_name'              => __( 'New Location', 'weskhaled' ),
		'add_new_item'               => __( 'Add New Location', 'weskhaled' ),
		'edit_item'                  => __( 'Edit Location', 'weskhaled' ),
		'update_item'                => __( 'Update Location', 'weskhaled' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'weskhaled' ),
		'search_items'               => __( 'Search Location', 'weskhaled' ),
		'add_or_remove_items'        => __( 'Add or remove Location', 'weskhaled' ),
		'choose_from_most_used'      => __( 'Choose from the most used Location', 'weskhaled' ),
		'not_found'                  => __( 'Not Found location', 'weskhaled' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'slide_location', array( 'slider' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'Location', 0 );

// Register Custom Post Type
function Slider() {

	$labels = array(
		'name'                => _x( 'Sliders', 'Post Type General Name', 'weskhaled' ),
		'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'weskhaled' ),
		'menu_name'           => __( 'Slider', 'weskhaled' ),
		'parent_item_colon'   => __( 'Post:', 'weskhaled' ),
		'all_items'           => __( 'Slides', 'weskhaled' ),
		'view_item'           => __( 'View slide', 'weskhaled' ),
		'add_new_item'        => __( 'Add New slide', 'weskhaled' ),
		'add_new'             => __( 'Add New slide', 'weskhaled' ),
		'edit_item'           => __( 'Edit slide', 'weskhaled' ),
		'update_item'         => __( 'Update slide', 'weskhaled' ),
		'search_items'        => __( 'Search slide', 'weskhaled' ),
		'not_found'           => __( 'Not found', 'weskhaled' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'weskhaled' ),
	);
	$args = array(
		'label'               => __( 'slider', 'weskhaled' ),
		'description'         => __( 'Dynamix Slider', 'weskhaled' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array( 'slide_location' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-images-alt',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'slider', $args );

}

// Hook into the 'init' action
add_action( 'init', 'Slider', 0 ); 



function slider_columns($columns) {

	$new_columns = array(
		"cb" => "<input type=\"checkbox\" />",  
		'image_slider' => __('Image', 'weskhaled'),
	);
    return array_merge( $new_columns,$columns);
}
add_filter('manage_slider_posts_columns' , 'slider_columns');


// GET FEATURED IMAGE
function get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'slider_img_preview');
        return $post_thumbnail_img[0];
    }
}

// SHOW THE FEATURED IMAGE
function columns_image($column_name, $post_ID) {
    if ($column_name == 'image_slider') {
        $post_featured_image = get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img src="' . $post_featured_image . '" width="210px" height="120px" />';
        }
        else {

        	echo __( 'Please don\'t forget to insert Featured Image for this slide', 'weskhaled' );
        }
    }
}

// add_action('manage_posts_custom_column', 'columns_image', 10, 2);

  /**
  * Add REST API support to an already registered post type.
  */
  add_action( 'init', 'my_custom_post_type_rest_support', 25 );
  function my_custom_post_type_rest_support() {
  	global $wp_post_types;
  
  	//be sure to set this to the name of your post type!
  	$post_type_name = 'slider';
  	if( isset( $wp_post_types[ $post_type_name ] ) ) {
  		$wp_post_types[$post_type_name]->show_in_rest = true;
  		$wp_post_types[$post_type_name]->rest_base = $post_type_name;
  		$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
  	}
  
  }

    /**
  * Add REST API support to an already registered taxonomy.
  */
  add_action( 'init', 'my_custom_taxonomy_rest_support', 25 );
  function my_custom_taxonomy_rest_support() {
  	global $wp_taxonomies;
  
  	//be sure to set this to the name of your taxonomy!
  	$taxonomy_name = 'slider_class';
  
  	if ( isset( $wp_taxonomies[ $taxonomy_name ] ) ) {
  		$wp_taxonomies[ $taxonomy_name ]->show_in_rest = true;
  		$wp_taxonomies[ $taxonomy_name ]->rest_base = $taxonomy_name;
  		$wp_taxonomies[ $taxonomy_name ]->rest_controller_class = 'WP_REST_Terms_Controller';
  	}
  }
	add_filter('rest_query_vars', 'custom_rest_query_vars');
	function custom_rest_query_vars($query_vars) {
	$query_vars = array_merge( $query_vars,    array('media','media__in','type','id') );
	return $query_vars;
	}

	add_action( 'rest_api_init', 'add_thumbnail_to_JSON' );
	function add_thumbnail_to_JSON() {
	//Add featured image
	register_rest_field(
	'slider', // Where to add the field (Here, blog posts. Could be an array)
	'featured_image_src', // Name of new field (You can call this anything)
	array(
		'get_callback'    => 'get_image_src',
		'update_callback' => null,
		'schema'          => null,
		)
	);
	}

	function get_image_src( $object, $field_name, $request ) {
		$feat_img_array = wp_get_attachment_image_src(
			$object['featured_media'], // Image attachment ID
			'large',  // Size.  Ex. "thumbnail", "large", "full", etc..
			true // Whether the image should be treated as an icon.
		);
		return $feat_img_array[0];
	}